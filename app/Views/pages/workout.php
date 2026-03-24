<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Power Liffe - Pro Log</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Rajdhani:wght@300;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/css/tabler.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        :root {
            --brand-green: #32ba3c;
            --secondary-neon: #ff0055;
            --top-bar-h: 90px;
            --neon-shadow: 0 0 15px rgba(50, 186, 60, 0.5);
        }

        body,.page,.card,.nav-link {
            font-family: 'Rajdhani', sans-serif !important;
            padding-top: calc(var(--top-bar-h) + 52px);
            padding-bottom: 100px;    
            -webkit-user-select: none; /* Safari */
            -ms-user-select: none;     /* IE 10 e Edge */
            user-select: none;        
        }

        .orbitron { font-family: 'Orbitron', sans-serif !important; text-transform: uppercase; }

        .top-fixed-bar {
            position: fixed; top: 0; left: 0; width: 100%; height: var(--top-bar-h);
            background: rgba(15, 15, 15, 0.98); backdrop-filter: blur(15px);
            border-bottom: 2px solid var(--brand-green);
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 15px; z-index: 1000; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.8);
        }

        #main-clock { font-size: 1.5rem; color: var(--brand-green); text-shadow: var(--neon-shadow); }
        .paused-clock { color: #f1c40f !important; text-shadow: 0 0 10px rgba(241, 196, 15, 0.5) !important; }

        .exercise-block {
            /*background: linear-gradient(145deg, #111, #080808);*/
            border-radius: 20px; border: 1px solid #222;
            padding: 18px; margin-bottom: 25px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }

        .exercise-title { border-bottom: 1px solid #333; padding-bottom: 10px; margin-bottom: 15px; }

        .set-row {
            display: grid;
            grid-template-columns: 30px 1fr 1fr 1.2fr 45px; 
            gap: 10px;
            align-items: center;
            margin-bottom: 10px;
        }

        .input-gym {
            width: 100%; background: #000; border: 1px solid #333; color: var(--brand-green);
            padding: 10px; border-radius: 10px; text-align: center;
            font-family: 'Orbitron'; font-size: 0.85rem; outline: none; transition: 0.3s;
        }

        .input-gym:focus { border-color: var(--brand-green); box-shadow: var(--neon-shadow); }

        .history-col {
            font-size: 0.65rem; color: #888; text-align: center;
            font-family: 'Orbitron'; background: #111; padding: 5px; border-radius: 8px;
            border: 1px solid #222; line-height: 1.2;
        }
        .history-val { color: var(--brand-green); display: block; font-size: 0.63rem; }

        .btn-check {
            cursor: pointer !important;
            position: relative;
            z-index: 10;
            pointer-events: auto !important;
        }


        /* AJUSTE PARA O CLIQUE NÃO FALHAR */
        .btn-check svg, .btn-check path {
            pointer-events: none !important;
        }

        .btn-check:focus, .btn-check:active {
            background: #151515 !important;
            color: #444 !important;
            border-color: #333 !important;
            box-shadow: none !important;
            outline: none !important;
        }


        .btn-check.active {
            background: var(--brand-green) !important;
            color: #000 !important;
            border-color: var(--brand-green) !important;
            box-shadow: 0 0 15px rgba(50, 186, 60, 0.6) !important;
        }

        #pause-overlay {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.9); display: none; z-index: 2000;
            flex-direction: column; align-items: center; justify-content: center;
            backdrop-filter: blur(10px);
        }

        .btn-add-serie {
            width: 100%; background: rgba(50, 186, 60, 0.05); border: 1px dashed var(--brand-green);
            color: var(--brand-green); padding: 12px; border-radius: 12px;
            text-transform: uppercase; font-weight: bold; margin-top: 10px;
        }

        #rest-overlay {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.95);
            display: none; z-index: 3000;
            flex-direction: column; align-items: center; justify-content: center;
            backdrop-filter: blur(10px);
            border: 2px solid var(--brand-green);
        }

        .timer-val-big { font-family: 'Orbitron'; font-size: 6rem; color: var(--brand-green); text-shadow: var(--neon-shadow); }

        #mini-rest {
            position: fixed; bottom: 20px; right: 20px;
            width: 65px; height: 65px; background: #000;
            border: 2px solid var(--secondary-neon);
            border-radius: 50%; display: none; align-items: center; justify-content: center;
            font-family: 'Orbitron'; color: #fff; z-index: 3000; 
            box-shadow: 0 0 15px var(--secondary-neon); cursor: pointer;
        }

        .set-number {
            cursor: pointer;
            user-select: none;
            transition: all 0.2s;
        }
        .set-number:active {
            color: var(--secondary-neon) !important;
            transform: scale(1.1);
        }

        /* Barra de XP de fora a fora */
        .xp-full-bar {
            position: fixed;
            top: 90px; /* Ajuste exatamente para a altura da sua top-bar preta */
            left: 0;
            width: 100%;
            height: 35px;
            background: linear-gradient(90deg, rgba(0,0,0,1) 0%, rgba(10,10,10,0.9) 50%, rgba(0,0,0,1) 100%);
            border-bottom: 1px solid rgba(50, 186, 60, 0.4);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            z-index: 998; /* Logo abaixo da top-bar principal */
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
        }

        /* Detalhe da linha neon que atravessa a barra */
        .xp-full-bar::before {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            width: 0%; /* Isso pode ser animado via JS se você quiser uma barra de progresso real */
            height: 2px;
            background: var(--brand-green);
            box-shadow: 0 0 10px var(--brand-green);
            transition: width 0.5s ease;
        }

        .xp-label-tech {
            font-family: 'Orbitron', sans-serif !important;
            font-size: 0.6rem;
            color: var(--brand-green);
            letter-spacing: 2px;
            opacity: 0.7;
        }

        .xp-counter-wrapper {
            display: flex;
            align-items: baseline;
            gap: 5px;
        }

        .xp-value-large {
            font-family: 'Orbitron', sans-serif !important;
            font-size: 1.1rem;
            font-weight: 800;
            color: #fff;
            text-shadow: 0 0 8px var(--brand-green);
        }

        .xp-unit {
            font-family: 'Orbitron', sans-serif !important;
            font-size: 0.6rem;
            color: var(--brand-green);
        }

        /* Animação de "Flash" na barra toda quando ganha XP */
        .xp-flash {
            animation: barFlash 0.6s ease-out;
        }

        @keyframes barFlash {
            0% { background: rgba(50, 186, 60, 0.0); }
            50% { background: rgba(50, 186, 60, 0.15); }
            100% { background: rgba(50, 186, 60, 0.0); }
        }

        /* Overlay de Resumo Final */
        #finish-overlay {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.95); z-index: 4000;
            display: none; flex-direction: column; align-items: center; justify-content: center;
            backdrop-filter: blur(15px); text-align: center; padding: 20px;
        }

        .summary-card {
            border: 2px solid var(--brand-green); border-radius: 20px;
            padding: 40px; background: #0a0a0a; box-shadow: var(--neon-shadow);
        }

        /* Customização do SweetAlert para o Tema Dark/Neon */
        .swal2-popup.my-swal-custom {
            border: 2px solid var(--brand-green) !important;
            border-radius: 20px !important;
            box-shadow: 0 0 20px rgba(50, 186, 60, 0.2) !important;
            padding: 2rem !important;
        }

        .swal2-title.my-swal-title {
            font-family: 'Orbitron', sans-serif !important;
            letter-spacing: 2px;
            font-size: 1.5rem !important;
        }

        .swal2-html-container.my-swal-content {
            font-family: 'Inter', sans-serif !important;
            color: #a0a0a0 !important;
        }

        /* Ajuste nos botões do Modal */
        .swal2-confirm.btn-confirm-custom {
            font-family: 'Orbitron', sans-serif !important;
            border-radius: 10px !important;
            padding: 10px 25px !important;
            font-weight: bold !important;
        }

        .swal2-cancel.btn-cancel-custom {
            font-family: 'Orbitron', sans-serif !important;
            background: transparent !important;
            color: #6c757d !important;
            border: 1px solid #333 !important;
            border-radius: 10px !important;
        }

        .pulse-neon {
            animation: neonGlow 0.5s ease-in-out;
        }

        @keyframes neonGlow {
            0% { box-shadow: 0 0 10px rgba(50, 186, 60, 0.3); transform: scale(1); }
            50% { box-shadow: 0 0 25px rgba(50, 186, 60, 0.8); transform: scale(1.1); border-color: #fff; }
            100% { box-shadow: 0 0 10px rgba(50, 186, 60, 0.3); transform: scale(1); }
        }

        .exercise-shadow {
            background-color: rgba(255, 255, 255, 0.02) !important; 
            border: 1px solid rgba(var(--brand-green-rgb, 0, 255, 0), 0.2) !important; 
            backdrop-filter: blur(4px);
            box-shadow: 0 0 15px rgba(var(--brand-green-rgb, 0, 255, 0), 0.15);
        }
    </style>
</head>
<body data-bs-theme="dark">

<div class="xp-full-bar" id="xp-bar">
    <span class="xp-label-tech">PONTUAÇÃO DO TREINO</span>
    <div class="xp-counter-wrapper">
        <span id="current-xp-nav" class="xp-value-large">0</span>
        <span class="xp-unit">XP</span>
    </div>
</div>

<div class="top-fixed-bar">
    <div class="d-flex align-items-center gap-3">
        <a href="javascript:history.back()" class="text-white"><i class="fas fa-chevron-left fa-lg"></i></a>
        <div>
            <label class="text-muted d-block orbitron" style="font-size: 0.55rem; letter-spacing: 2px;">TREINO ATIVO</label>
            <span id="main-clock" class="orbitron fw-bold">00:00:00</span>
        </div>
    </div>
    <div class="d-flex gap-2">
        <button class="btn btn-danger btn-pill fw-bold orbitron px-3" onclick="app.finishWorkout()">CONCLUIR</button>
    </div>
</div>

<div id="rest-overlay" onclick="app.minimizeRest()">
    <div class="timer-val-big" id="rest-timer-big">60</div>
    <span class="orbitron text-success" style="letter-spacing: 3px;">DESCANSO ATIVO</span>
    <p class="text-muted mt-3 small">Toque para minimizar</p>
</div>

<div id="mini-rest" onclick="app.maximizeRest()">60</div>

<div class="container-xl" id="workout-content"></div>



<div id="finish-overlay">
    <div class="summary-card">
        <h1 class="orbitron text-success mb-0">MISSÃO CUMPRIDA</h1>
        <p class="text-muted small mb-4">Relatório de Desempenho</p>
        
        <div class="mb-4">
            <span class="text-muted d-block orbitron" style="font-size: 0.7rem;">XP TOTAL GANHO</span>
            <span id="total-xp-display" class="orbitron display-2 text-white" style="text-shadow: var(--neon-shadow);">0</span>
        </div>

        <div class="d-grid gap-3">
            <button class="btn btn-success btn-lg orbitron" onclick="app.shareProgress()">
                <i class="fas fa-share-alt me-2"></i>COMPARTILHAR
            </button>
            <button class="btn btn-outline-secondary" onclick="location.href='index.php'">VOLTAR AO INÍCIO</button>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="/assets/js_app/theme.js"></script>

<script>
const TreinoService = {
    // Busca o treino do dia para o usuário logado
    async fetchTreinoAtivo() {
        try {
            // Chamamos a API passando uma action de consulta
            const response = await $.get('/workout/api/', { 
                action: 'get_active_workout' 
            });
            return response; 
        } catch (e) {
            console.error("Erro ao buscar treino:", e);
            return null;
        }
    },

    // Busca o que foi feito no treino ANTERIOR (Histórico)
    async fetchHistorico(exercicioId) {
        try {
            const response = await $.get('/workout/api/', { 
                action: 'get_exercise_history', 
                ex_id: exercicioId 
            });
            return response.history || []; // Espera um array de {peso, reps}
        } catch (e) {
            return [];
        }
    },

    // Busca o que já foi preenchido HOJE (Sessão atual)
    async fetchSetsHoje(exercicioId) {
        try {
            const response = await $.get('/workout/api/', { 
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

    async callAPI(action, data = {}) {
        try {
            return await $.post('/workout/api/', { 
                action: action, 
                treino_id: this.currentTreinoId,
                ...data 
            });
        } catch (e) {
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
        container.html('<div class="text-center p-5"><div class="spinner-border text-success"></div><p class="orbitron mt-2">Sincronizando...</p></div>');

        try {
            const treino = await TreinoService.fetchTreinoAtivo();
            let html = `<h2 class="orbitron mb-4 text-center" style="font-size:1rem; color:var(--brand-green)">${treino.nome}</h2>`;

            for (const ex of treino.exercicios) {
                html += `
                <div class="exercise-block mb-4 exercise-shadow" data-ex-id="${ex.id}" data-xp="${ex.xp}" >
                    <div class="exercise-title d-flex justify-content-between align-items-center" >
                        <div>
                            <h3 class="mb-0 orbitron" style="font-size: 0.9rem;">${ex.nome}</h3>
                            <small class="text-muted">${ex.protocolo}</small>
                        </div>
                        <div class="text-success orbitron small">${ex.xp} XP</div>
                    </div>
                    <div class="sets-list"></div>
                    <button class="btn-add-serie orbitron" onclick="app.addSet(this, ${ex.id})">
                        <i class="fas fa-plus-circle me-2"></i>Nova Série
                    </button>
                </div>`;
            }
            container.html(html);

            for (const ex of treino.exercicios) {
                const $block = $(`.exercise-block[data-ex-id="${ex.id}"]`);
                const btnElement = $block.find('.btn-add-serie')[0];
                const hoje = await TreinoService.fetchSetsHoje(ex.id); 
                const passado = []; //await TreinoService.fetchHistorico(ex.id);
                const qtdSeriesMostrar = Math.max(hoje.length, passado.length, 1);

                for (let i = 0; i < qtdSeriesMostrar; i++) {
                    await this.addSet(btnElement, ex.id, hoje[i] || null);
                }
            }
        } catch (error) {
            container.html('<div class="alert alert-danger">Erro ao carregar treino.</div>');
        }
    },

    async addSet(btn, exId, dadosHoje = null) {
        const $block = $(btn).closest('.exercise-block');
        const $list = $block.find('.sets-list');
        const num = $list.find('.set-row').length + 1;
        const historico = await TreinoService.fetchHistorico(exId);
        const hPassado = historico[num - 1]; 
        const dadoAnterior = hPassado ? `${hPassado.peso}kg x ${hPassado.reps}` : '--';

        const peso = dadosHoje ? dadosHoje.peso : '';
        const reps = dadosHoje ? dadosHoje.reps : '';
        const isChecked = dadosHoje ? 'active' : '';
        const isReadOnly = dadosHoje ? 'readonly' : '';

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
            <input type="number" class="input-gym" placeholder="Kg" value="${peso}" ${isReadOnly}>
            <input type="number" class="input-gym" placeholder="Reps" value="${reps}" ${isReadOnly}>
            <div class="history-col">
                <span style="font-size: 0.4rem; color: #666; display: block;">ANTERIOR</span>
                <span class="history-val">${dadoAnterior}</span>
            </div>
            <button class="btn btn-icon btn-outline-success btn-check ${isChecked}" onclick="app.checkSet(this, event)">
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
        const peso = $row.find('input').eq(0).val();
        const reps = $row.find('input').eq(1).val();
        const exId = $exBlock.data('ex-id');
        const numSerie = $row.find('.set-number').text().replace('S', '').trim();
        const xpValor = parseInt($exBlock.data('xp')) || 0;

        if (!$btn.hasClass('active')) {
            // SALVAR
            if (!peso || !reps || peso <= 0 || reps <= 0) {
                this.showToast("Preencha Peso e Repetições!", "warning");
                return;
            }
            const res = await this.callAPI('save_set', { ex_id: exId, serie: numSerie, peso: peso, reps: reps, xp_valor: xpValor });
            if (res.success) {
                this.totalXP = parseInt(res.novo_total || res.novo_xp) || this.totalXP;
                this.updateXPDisplay();
                $btn.addClass('active');
                $row.find('input').prop('readonly', true);
                if (navigator.vibrate) navigator.vibrate(40);
                this.startRest(60); 
            }
        } else {
            // DESMARCAR
            const res = await this.callAPI('delete_set', { ex_id: exId, serie: numSerie, xp_valor: xpValor });
            if (res.success) {
                this.totalXP = parseInt(res.novo_total || res.novo_xp) || this.totalXP;
                this.updateXPDisplay();
                $btn.removeClass('active');
                $row.find('input').prop('readonly', false);
                this.stopRest();
            }
        }
        btn.blur();
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

            const res = await this.callAPI('delete_set', { ex_id: exId, serie: numSerie, xp_valor: xpValor });
            
            if (res.success) {
                // Usando a Coalescência Nula para aceitar o ZERO
                const novoXP = res.novo_total ?? res.novo_xp;
                if (novoXP !== undefined) {
                    this.totalXP = parseInt(novoXP);
                    this.updateXPDisplay();
                }

                $row.fadeOut(300, async () => {
                    $row.remove();
                    const historico = await TreinoService.fetchHistorico(exId);
                    $list.find('.set-row').each((index, rowElement) => {
                        const novoNum = index + 1;
                        const h = historico[index];
                        const $currentRow = $(rowElement);
                        $currentRow.find('.set-number').text(`S${novoNum}`);
                        $currentRow.find('.history-val').text(h ? `${h.peso}kg x ${h.reps}` : '--');
                    });
                    this.showToast("Série removida", "info");
                });
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
        $('#xp-bar').addClass('xp-flash');
        setTimeout(() => $('#xp-bar').removeClass('xp-flash'), 600);
    },

    

    finishWorkout() {
        Swal.fire({
            title: 'FINALIZAR TREINO?',
            text: "O progresso será salvo e este log será fechado.",
            icon: 'warning',
            iconColor: '#32ba3c',
            showCancelButton: true,
            confirmButtonText: 'CONCLUIR MISSÃO',
            cancelButtonText: 'AINDA NÃO',
            background: '#0a0a0a',
            color: '#ffffff',
            customClass: {
                popup: 'my-swal-custom',
                confirmButton: 'swal2-confirm btn-confirm-custom',
                cancelButton: 'swal2-cancel btn-cancel-custom'
            },
            buttonsStyling: false,
        }).then((result) => {
            if (result.isConfirmed) {
                const tempoFinal = $('#main-clock').text();
                this.callAPI('finish_workout', { 
                    total_xp: this.totalXP, 
                    tempo: tempoFinal 
                });

                if (navigator.vibrate) navigator.vibrate([50, 30, 50]);
                $('#total-xp-display').text(this.totalXP);
                $('#finish-overlay').css('display', 'flex').hide().fadeIn(500);
            }
        });
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
</script>
</body>
</html>