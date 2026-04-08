const modalExercicio = document.getElementById('modal-exercicio');

if (modalExercicio) {
    modalExercicio.addEventListener('show.bs.modal', event => {
        // Botão que acionou o modal
        const button = event.relatedTarget;
        
        // Extrai as informações dos atributos data-bs-*
        const title = button.getAttribute('data-bs-title');
        const imgUrl = button.getAttribute('data-bs-img');
        
        // Atualiza os elementos internos do modal
        const modalTitle = modalExercicio.querySelector('#modal-exercicio-title');
        const modalImg = modalExercicio.querySelector('#modal-exercicio-img');

        modalTitle.textContent = title;
        modalImg.src = imgUrl;
    });
}

function printError(msg, icon = 'error') {
  Swal.fire({ toast: true, position: 'bottom', showConfirmButton: false, timer: 2000, background: '#1a1a1a', color: '#fff', icon: icon, title: msg }); 
}

const TreinoService = {
    //pga o ID do treino 
    workoutId: $('body').data('workout-id'),

    // Busca o treino do dia para o usuário logado
    async fetchTreinoAtivo() {
        try {
            
            // Chamamos a API passando uma action de consulta
            const response = await $.get(`/workout/api/${this.workoutId}`, { 
                action: 'get_active_workout' 
            });
            return response; 
        } catch (e) {
            console.error("Erro ao buscar treino:", e);
            return null;
        }
    },

    // Busca o que foi feito no treino ANTERIOR (Histórico)
    async fetchHistorico(exercicioId,numSerie) {
        try {
            const response = await $.get(`/workout/api/${this.workoutId}`, { 
                action: 'get_exercise_history', 
                ex_id: exercicioId,
                serie: numSerie
            });
            return response.history || []; // Espera um array de {peso, reps}
        } catch (e) {
            return [];
        }
    },

    // Busca o que já foi preenchido HOJE (Sessão atual)
    async fetchSetsHoje(exercicioId) {
        try {
            const response = await $.get(`/workout/api/${this.workoutId}`, { 
                action: 'get_today_sets', 
                ex_id: exercicioId 
            });
            return response.sets || []; // Espera um array de {peso, reps}
        } catch (e) {
            return [];
        }
    }
};

const app = {
    seconds: 0,
    isPaused: false,
    timer: null,
    restSeconds: 0,
    restTimer: null,
    startTime: null,
    totalXP: 0,
    currentTreinoId: null,

    workoutId: $('body').data('workout-id'),

    sleep(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
    },

    async callAPI(action, data = {}) {
        try {        
            return await $.post(`/workout/api/${this.workoutId}`, { 
                action: action, 
                treino_id: this.currentTreinoId,
                ...data 
            });
        } catch (e) {
            this.showToast("Servidor offline ou sem internet!", "error");
            console.warn(`Erro na Action ${action}: Servidor Offline.`);
            return { success: false };
        }
    },

    async init() {
        try {
            const treino = await TreinoService.fetchTreinoAtivo();
            this.currentTreinoId = treino.id_treino;
            this.totalXP = parseInt(treino.usuario_xp) || 0;
            this.updateXPDisplay();
            
            if (treino.data_inicio) {
                this.startTime = new Date(treino.data_inicio).getTime();
            } else {
                this.startTime = Date.now();
                this.callAPI('iniciar_treino');
            }

            this.startTimer();
            await this.renderWorkout(); 
        } catch (e) {
            this.showToast("Erro ao carregar treino!", "error");
            console.error("Erro ao iniciar", e);
        }
    },

    startTimer() {
        if (this.timer) clearInterval(this.timer);
        this.timer = setInterval(() => {
            const now = Date.now();
            const diffInSeconds = Math.floor((now - this.startTime) / 1000);
            this.updateClock(diffInSeconds > 0 ? diffInSeconds : 0);
        }, 1000);
    },

    updateClock(totalSeconds) {
        let h = Math.floor(totalSeconds / 3600).toString().padStart(2, '0');
        let m = Math.floor((totalSeconds % 3600) / 60).toString().padStart(2, '0');
        let s = (totalSeconds % 60).toString().padStart(2, '0');
        $('#main-clock').text(`${h}:${m}:${s}`);
    },

    async renderWorkout() {
        const container = $('#workout-content');      

        container.html(`
            <div class="text-center p-5 animate__animated animate__fadeIn">
                <div class="spinner-grow text-success" style="width: 3rem; height: 3rem;"></div>
                <h4 class="orbitron mt-3 text-success shadow-neon" style="letter-spacing: 2px;">SINCRONIZANDO SISTEMA...</h4>
                <p class="text-muted small">Carregando protocolo de treinamento</p>
            </div>
        `);    
        
        

        try {
            const treino = await TreinoService.fetchTreinoAtivo();
            let html = `<h2 class="orbitron mb-4 text-center" style="font-size:1rem; color:var(--brand-green)">${treino.nome}</h2>`;

            this.nomeTreinoAtivo = treino.nome;

            for (const ex of treino.exercicios) {
                html += `
                <div class="exercise-block mb-4 exercise-shadow" data-ex-id="${ex.id}" data-xp="${ex.xp}" data-ex-und="${ex.und}">
                    <div class="exercise-title d-flex justify-content-between align-items-center" >
                        <div>
                            <h3 class="mb-0 orbitron" style="font-size: 0.9rem;"`;
                               if (ex.img) {
                                    html += `
                                        data-bs-toggle="modal"
                                        data-bs-target="#modal-exercicio"
                                        data-bs-title="${ex.nome}"
                                        data-bs-img="${ex.img}"
                                    `;
                                } else {
                                    html += `
                                        onclick="printError('Nenhum exemplo encontrado!', 'warning')"
                                    `;
                                }
                           html += `>${ex.nome}</h3>
                            <small class="text-muted">${ex.protocolo}</small>
                        </div>
                        <div class="text-success orbitron small">${ex.xp} XP</div>
                    </div>
                    <div class="sets-list"></div>
                    <button class="btn-add-serie orbitron" onclick="app.addSet(this, ${ex.id}, null, '${ex.und}')">
                        <i class="fas fa-plus-circle me-2"></i>Nova Série
                    </button>
                </div>`;
            }

            await this.sleep(500); 

            container.html(html);

            for (const ex of treino.exercicios) {
                const $block = $(`.exercise-block[data-ex-id="${ex.id}"]`);
                const btnElement = $block.find('.btn-add-serie')[0];
                const hoje = await TreinoService.fetchSetsHoje(ex.id); 
                const passado = []; //await TreinoService.fetchHistorico(ex.id);
                const qtdSeriesMostrar = Math.max(hoje.length, passado.length, 1);
                const unidade = $block.data('ex-und');

                for (let i = 0; i < qtdSeriesMostrar; i++) {
                    await this.addSet(btnElement, ex.id, hoje[i] || null, unidade);
                }
            }
        } catch (error) {
            container.html('<div class="alert alert-danger">Erro ao carregar treino.</div>');
        }
    },

    async addSet(btn, exId, dadosHoje = null, unidade) {
        // aqui precisa bloquear o botao de adicionar nova serie e descloquear depois que a serie for adicionada, para evitar que o usuario clique varias vezes e adicione 5 series de uma vez.
        
        
        const $block = $(btn).closest('.exercise-block');
        const $list = $block.find('.sets-list');
        const num = $list.find('.set-row').length + 1;
        const historico = await TreinoService.fetchHistorico(exId,num);
        //const hPassado = historico[num - 1]; 
        const hPassado = historico; 
        const dadoAnterior = (hPassado?.peso && hPassado?.reps)
                            ? `${hPassado.peso}${hPassado.und ?? ''} x ${hPassado.reps}`
                            : '--';

        const peso = dadosHoje && dadosHoje.peso !== null ? dadosHoje.peso : '';
        const reps = dadosHoje && dadosHoje.reps !== null ? dadosHoje.reps : ''; 
        const und = unidade ? unidade : '';
        const isChecked = dadosHoje && dadosHoje.checked ? 'active' : '';
        const isReadOnly = dadosHoje && dadosHoje.checked ? 'readonly' : '';
        
        // aqui verifica se ja existe treino, se nao, adiciona a serie ao banco.
        if (!dadosHoje) {
            const originalHtmlBtn = $(btn).html();
            $(btn).prop('disabled', true);        
            $(btn).html('<span class="spinner-border spinner-border-sm text-success"></span>');

            const res = await this.callAPI('add_set', { ex_id: exId });
            console.log(res);
            if (res.success) {
                setTimeout(() => {  
                    $(btn).html(originalHtmlBtn);   
                    $(btn).prop('disabled', false);
                }, 300);               
            }   
            else
            {
                this.showToast("Erro ao adicionar série, tente novamente!", "error");  
                setTimeout(() => {  
                    $(btn).html(originalHtmlBtn);   
                    $(btn).prop('disabled', false);
                }, 300);             
                return;
            }
            
        }
        

        const row = `
        <div class="set-row">
            <div class="orbitron text-muted small set-number" 
                onmousedown="app.startLongPress(this, ${exId})" 
                onmouseup="app.cancelLongPress()" 
                onmouseleave="app.cancelLongPress()"
                ontouchstart="app.startLongPress(this, ${exId})" 
                ontouchend="app.cancelLongPress()"
                ontouchmove="app.cancelLongPress()">
                S${num}
            </div>
            <input type="number" class="input-gym" placeholder="${und}" value="${peso}" ${isReadOnly}>
            <input type="number" class="input-gym" placeholder="Reps" value="${reps}" ${isReadOnly}>
            <div class="history-col">
                <span style="font-size: 0.4rem; color: #666; display: block;">ANTERIOR</span>
                <span class="history-val">${dadoAnterior}</span>
            </div>
            <button class="btn btn-icon btn-outline-success  ${isChecked}" onclick="app.checkSet(this, event)">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12l5 5l10 -10" /></svg>
            </button>
        </div>`;
        $list.append(row);
    },

    async checkSet(btn, event) {
        if (event) { event.preventDefault(); event.stopPropagation(); }
        const $btn = $(btn);
        const $row = $btn.closest('.set-row');
        const $exBlock = $btn.closest('.exercise-block');

        const inputPeso = $row.find('input').eq(0);
        const inputReps = $row.find('input').eq(1);

        const peso = inputPeso.val();
        const reps = inputReps.val();
        const exId = $exBlock.data('ex-id');
        const numSerie = $row.find('.set-number').text().replace('S', '').trim();
        const xpValor = parseInt($exBlock.data('xp')) || 0;

        const originalHtml = $btn.html();
        $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm text-success"></span>');

        if (!$btn.hasClass('active')) {
            // SALVAR
            if (!peso || !reps || peso <= 0 || reps <= 0) {
                this.showToast("Preencha Peso e Repetições!", "warning");
                $btn.prop('disabled', false).html(originalHtml);
                await this.sleep(200); 
                inputPeso.focus();
                return;
            }
            const res = await this.callAPI('save_set', { ex_id: exId, serie: numSerie, peso: peso, reps: reps, xp_valor: xpValor });
            console.log(res);
            if (res.success) {
                this.totalXP = parseInt(res.novo_total || res.novo_xp) || this.totalXP;
                this.updateXPDisplay();
                $btn.addClass('active');
                $row.find('input').prop('readonly', true);
                if (navigator.vibrate) navigator.vibrate(40);
                $('#mini-rest').text(res.rest);
                this.startRest(res.rest); 
                await this.sleep(200); 
                $btn.addClass('active').prop('disabled', false).html(originalHtml);
            }
            else
            {
                this.showToast("Erro ao gravar série, tente novamente!", "error");
                await this.sleep(200); 
                inputPeso.focus();
                $btn.prop('disabled', false).html(originalHtml);
            }
        } else {
            // DESMARCAR
            const res = await this.callAPI('uncheck_set', { ex_id: exId, serie: numSerie });
            console.log(res);
            if (res.success) {
                this.totalXP = parseInt(res.novo_xp) || this.totalXP;
                this.updateXPDisplay();
                $btn.removeClass('active');
                $row.find('input').prop('readonly', false);
                this.stopRest();
                
                await this.sleep(200); 
                $btn.prop('disabled', false).html(originalHtml);
                inputPeso.focus();
            }
            else
            {
                this.showToast("Erro ao desmarcar série, tente novamente", "error");
                await this.sleep(200); 
                inputPeso.focus();
                $btn.prop('disabled', false).html(originalHtml);
            }
        }
       
    },
    

    startLongPress(element, exId) {
        // 1. Limpa qualquer timer residual por segurança
        this.cancelLongPress();

        this.longPressTimer = setTimeout(async () => {
            if (navigator.vibrate) navigator.vibrate(100);
            
            const $row = $(element).closest('.set-row');
            const $exBlock = $row.closest('.exercise-block');
            const $list = $exBlock.find('.sets-list');
            const numSerie = $row.find('.set-number').text().replace('S', '').trim();
            const xpValor = parseInt($exBlock.data('xp')) || 0;

            const res = await this.callAPI('delete_set', { ex_id: exId, serie: numSerie });
            
            if (res.success) {
                // Usando a Coalescência Nula para aceitar o ZERO
                const novoXP = res.novo_xp;
                if (novoXP !== undefined) {
                    this.totalXP = parseInt(novoXP);
                    this.updateXPDisplay();
                }

                $row.fadeOut(300, async () => {
                    $row.remove();
                    //const historico = await TreinoService.fetchHistorico(exId);
                    $list.find('.set-row').each(async (index, rowElement) => {
                        const novoNum = index + 1;
                        const h = await TreinoService.fetchHistorico(exId,novoNum);//historico[index];
                        const $currentRow = $(rowElement);
                        $currentRow.find('.set-number').text(`S${novoNum}`);
                        $currentRow.find('.history-val').text(h ? `${h.peso}${h.und} x ${h.reps}` : '--');
                    });
                    this.showToast("Série removida", "info");
                });
            }
            else
            {
                this.showToast("Erro ao excluir série, tente novamente", "error");
            }
        }, 1000); // 1 segundo segurando
    },

    cancelLongPress() {
        if (this.longPressTimer) {
            clearTimeout(this.longPressTimer);
            this.longPressTimer = null;
        }
    },

    updateXPDisplay() {
        $('#current-xp-nav').text(this.totalXP);
        //$('#xp-bar').addClass('xp-flash');
        setTimeout(() => $('#xp-bar').removeClass('xp-flash'), 600);
    },

    finishWorkout() {
        Swal.fire({
            title: 'FINALIZAR TREINO?',
            text: "O progresso será salvo e este treino será finalizado.",
            icon: 'warning',
            iconColor: '#00ff9d', // Cor verde neon para o ícone
            showCancelButton: true,
            confirmButtonText: 'CONCLUIR MISSÃO',
            cancelButtonText: 'AINDA NÃO',
            background: '#0a0a0a', // Fundo reserva caso o CSS demore
            customClass: {
                popup: 'my-swal-custom',
                title: 'my-swal-title',
                htmlContainer: 'my-swal-content',
                confirmButton: 'btn-confirm-custom',
                cancelButton: 'btn-cancel-custom'
            },
            buttonsStyling: false // Obrigatório para usar seu CSS
        }).then(async (result) => {
            if (result.isConfirmed) {
                const tempoFinal = $('#main-clock').text();

                // Chamada para a API
                const res = await this.callAPI('finish_workout');
                console.log(res);
                if (res.success) {
                    // USANDO DADOS DIRETOS DA API
                    const resumo = res.resumo; 

                    // Converte para número para garantir a comparação (remove pontos e espaços se houver)
                    const tonelagemLimpa = parseFloat(resumo.tonelagem.toString().replace(/\./g, '').replace(',', '.')) || 0;
                    const minutosLimpa = parseFloat(resumo.minutos.toString().replace(/\./g, '').replace(',', '.')) || 0;

                    // Se não houve volume de treino (tonelagem 0), redireciona direto
                    if (tonelagemLimpa === 0 && minutosLimpa === 0) {
                        this.showToast("Nenhum exercício registrado. Voltando ao início...", "info");
                        setTimeout(() => {
                            window.location.href = '/training/';
                        }, 1500);
                        return; // Para a execução aqui e não abre o modal
                    }
                    
                    $('#summary-workout-name').text(resumo.nome_treino);
                    $('#summary-time').text(resumo.tempo);
                    $('#summary-volume').text(resumo.tonelagem + ' kg');
                    $('#summary-minutos').text(resumo.minutos + ' min');
                    $('#total-xp-display').text(resumo.xp_final);
                    $('#summary-user-name').text("AGENTE: " + resumo.usuario);

                    if (navigator.vibrate) navigator.vibrate([50, 30, 50]);
                    $('#finish-overlay').css('display', 'flex').hide().fadeIn(500);
                } else {
                    this.showToast("Erro ao salvar treino, tente novamente", "error");
                }
            }
        });
    },

    async shareProgress() {
        const element = document.querySelector("#capture-area");
        $(element).find('.no-export').hide();

        try {
            const canvas = await html2canvas(element, {
                scale: 2,
                backgroundColor: '#0a0a0a',
                logging: false,
                onclone: (clonedDoc) => {
                    // 1. Seleciona todos os elementos dentro do card clonado
                    const elementos = clonedDoc.querySelectorAll('#capture-area, #capture-area *');
                    
                    elementos.forEach(el => {
                        // Pegamos o estilo atual computado pelo navegador
                        const estilo = window.getComputedStyle(el);
                        
                        // Se a cor do texto for o srgb problemático, forçamos um HEX
                        if (estilo.color.includes('color(')) {
                            // Se tiver a classe success, usamos verde. Se não, branco ou cinza.
                            if (el.classList.contains('text-success')) {
                                el.style.setProperty('color', '#2fb344', 'important');
                            } else if (el.classList.contains('text-muted')) {
                                el.style.setProperty('color', '#6c7a91', 'important');
                            } else {
                                el.style.setProperty('color', '#ffffff', 'important');
                            }
                        }

                        // Se a borda for srgb, limpamos
                        if (estilo.borderColor.includes('color(')) {
                            el.style.setProperty('border-color', '#1f2937', 'important');
                        }

                        // Limpa outline e sombras que também usam srgb por padrão no Tabler
                        el.style.setProperty('outline-color', 'transparent', 'important');
                        el.style.setProperty('text-shadow', 'none', 'important');
                        el.style.setProperty('box-shadow', 'none', 'important');
                        el.style.setProperty('filter', 'none', 'important');
                    });

                    // Força o fundo do card para preto sólido
                    const card = clonedDoc.querySelector('.summary-card');
                    if (card) {
                        card.style.setProperty('background-color', '#0a0a0a', 'important');
                        card.style.setProperty('border-color', '#2fb344', 'important');
                    }

                    $(clonedDoc).find('.no-export').remove();
                }
            });

            $(element).find('.no-export').show();

            canvas.toBlob(async (blob) => {
                if (!blob) {
                    this.showToast("Erro ao processar imagem", "error");
                    return;
                }

                // 1. Criamos o arquivo a partir do Blob
                const file = new File([blob], 'treino-power-liffe.png', { type: 'image/png' });

                // 2. Montamos o objeto de compartilhamento
                const shareData = {
                    files: [file],
                    title: 'Power Liffe - Missão Cumprida',
                    text: `Mais um pra conta! Ganhei ${this.totalXP} XP hoje. 🚀 #PowerLiffe`,
                };

                // 3. Verificamos se o navegador suporta compartilhar ARQUIVOS
                if (navigator.canShare && navigator.canShare({ files: [file] })) {
                    try {
                        // Isso abre o menu nativo do Android/iOS
                        await navigator.share(shareData);

                        setTimeout(() => {
                            window.location.href = '/training/';
                        }, 20000);
                    } catch (err) {
                        // Se o usuário cancelar o compartilhamento, cai aqui
                        if (err.name !== 'AbortError') {
                            console.error("Erro ao compartilhar:", err);
                            this.showToast("Erro ao abrir compartilhamento", "error");
                        }
                    }
                } else {
                    // FALLBACK: Se o navegador for antigo ou desktop sem suporte a share de arquivos
                    const link = document.createElement('a');
                    link.download = 'meu-treino-powerliffe.png';
                    link.href = canvas.toDataURL();
                    link.click();
                    this.showToast("Compartilhamento não suportado. Imagem salva na galeria!", "info");

                    setTimeout(() => {
                            window.location.href = '/training/';
                    }, 20000);
                }
            }, 'image/png');

        } catch (err) {
            console.error("Erro fatal no print:", err);
            $('.no-export').show();
            alert("Ocorreu um erro ao gerar a imagem. Tente novamente.");
        }
    },

    showToast(msg, icon) { Swal.fire({ toast: true, position: 'bottom', showConfirmButton: false, timer: 2000, background: '#1a1a1a', color: '#fff', icon: icon, title: msg }); },
    startRest(d) { 
        this.stopRest(); this.restSeconds = d; 
        $('#rest-overlay').css('display', 'flex').hide().fadeIn(300); 
        this.updateRestDisplay();
        this.restTimer = setInterval(() => { 
            this.restSeconds--; this.updateRestDisplay();
            if (this.restSeconds <= 0) { 
                this.stopRest(); this.showToast("PRÓXIMA SÉRIE!", "success"); 
                if (navigator.vibrate) navigator.vibrate([100, 50, 100]); 
            } 
        }, 1000);
    },
    updateRestDisplay() { $('#rest-timer-big, #mini-rest').text(this.restSeconds); },
    stopRest() { clearInterval(this.restTimer); this.restTimer = null; $('#rest-overlay, #mini-rest').hide(); },
    minimizeRest() { $('#rest-overlay').fadeOut(200); $('#mini-rest').fadeIn(300).css('display', 'flex'); },
    maximizeRest() { $('#mini-rest').fadeOut(200); $('#rest-overlay').fadeIn(300).css('display', 'flex'); }
};

$(document).ready(() => app.init());
