(function() {
    // Variáveis de escopo fechado para os intervalos e instâncias
    let discoveryInterval;
    let timerInterval;
    let html5QrCodeScanner; // Instância do leitor
    let qrcodeGenerator;   // Instância do gerador

    // --- CONFIGURAÇÃO ---
    // Puxa o código real do elemento HTML (garante consistência)
    const getMyCode = () => {
        const codeEl = document.getElementById('userCode');
        console.log(`Obtendo código do usuário: ${codeEl ? codeEl.value : 'ERRO'}`);
        return codeEl ? codeEl.innerText.trim() : 'ERRO';
    };

    // --- LÓGICA DO MODAL DE DESCOBERTA (Aluno A - Mostra QR) ---
    const modalDisc = document.getElementById('modal-discovery');
    
    // Evento disparado QUANDO O MODAL TERMINA DE ABRIR
    modalDisc.addEventListener('shown.bs.modal', function () {
        const myCode = getMyCode();
        //console.log(`Iniciando Modo Visível para o código: ${myCode}`);

        // 1. GERAR O QR CODE DENTRO DO MODAL
        const qrcodeContainer = document.getElementById('qrcode-container');
        qrcodeContainer.innerHTML = ''; // Limpa geração anterior

        qrcodeGenerator = new QRCode(qrcodeContainer, {
            text: myCode, // O conteúdo do QR é o código do aluno
            width: 128,
            height: 128,
            colorDark : "#000000",
            colorLight : "#ffffff",
            correctLevel : QRCode.CorrectLevel.H // Alta tolerância a erros
        });

        // 2. INICIAR O CONTADOR REGRESSIVO DE 1 MINUTOS
        let timeLeft = 60; // segundos
        const timerDisplay = document.getElementById('discovery-timer');
        
        // Zera o display antes de começar
        if(timerDisplay) timerDisplay.innerText = "01:00";

        timerInterval = setInterval(() => {
            timeLeft--;
            
            // Formatação MM:SS
            let mins = Math.floor(timeLeft / 60);
            let secs = timeLeft % 60;
            if(timerDisplay) {
                timerDisplay.innerText = `${mins.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
            }
            
            // Se o tempo acabar, fecha o modal automaticamente
            if (timeLeft <= 0) {
                // Para tudo primeiro
                stopDiscovery(); 
                fecharModalSeguro();             
            }
        }, 1000);

        // 3. INICIAR POLLING DA API (MOCKUP)
        // No real, esta rota verifica se alguém conectou com você
        discoveryInterval = setInterval(() => {
            console.log(`[API POLLING]: Verificando se alguém conectou`);
            // Exemplo de sucesso:
            fetch(`/ranking/checkconn/`).then(r => r.json()).then(data => {
               if(data.status == 'success')
                {
                    window.location.hash = 'amigos';
                    location.reload();
                }
            });
        }, 5000); // A cada 5 segundos
    });

    // Evento disparado QUANDO O MODAL COMEÇA A FECHAR
    modalDisc.addEventListener('hidden.bs.modal', stopDiscovery);

    function stopDiscovery() {
        console.log("Limpando processos...");
        clearInterval(discoveryInterval);
        clearInterval(timerInterval);
        
        // Limpa o QR Code para não acumular na memória
        if(qrcodeGenerator) {
            qrcodeGenerator.clear();
            qrcodeGenerator = null;
        }
    }

    function fecharModalSeguro() {
        const modalElement = document.getElementById('modal-discovery');
        if (modalElement) {
            // Buscamos o botão que o Tabler já configurou com data-bs-dismiss
            const btnFechar = modalElement.querySelector('[data-bs-dismiss="modal"]');
            if (btnFechar) {
                btnFechar.click(); // Isso funciona independente do bootstrap estar pronto
            }
        }
    }


    // --- LÓGICA DO MODAL SCANNER (Aluno B - Lê QR) ---
    const modalScan = document.getElementById('modal-scanner');

    // Evento disparado QUANDO O MODAL TERMINA DE ABRIR
    modalScan.addEventListener('shown.bs.modal', function () {
        console.log("Iniciando Câmera para Escanear amigo...");
        
        // Verifica se a lib de leitura carregou
        if (typeof Html5Qrcode === 'undefined') {
            console.error("Biblioteca html5-qrcode não encontrada no footer.");
            return;
        }

        html5QrCodeScanner = new Html5Qrcode("reader");
        
        // Configuração otimizada para performance em PWA móvel
        const config = { 
            fps: 15, // Mais frames por segundo para leitura rápida
            qrbox: { width: 200, height: 200 }, // Área útil de leitura batendo com o CSS overlay
            aspectRatio: 1.0 // Quadrado
        };

        // Criamos uma variável de controle FORA do escopo do start
        let isScanning = false; 

        html5QrCodeScanner.start(
            { facingMode: "environment" }, 
            config,
            (decodedText) => {
                // SE já estiver processando, ignora as próximas leituras
                if (isScanning) return;
                
                // Bloqueia novas leituras
                isScanning = true;
                
                console.log(`[QR SCAN SUCESSO]: Código detectado`);
                
                // 1. Fecha o modal do leitor
                    const btnFechar = modalScan.querySelector('[data-bs-dismiss="modal"]');
                    if (btnFechar) btnFechar.click();   

                
                // parar a câmera para economizar bateria/recursos
                html5QrCodeScanner.stop().then(() => { console.log("Câmera parada."); });

                // 2. Envio para a API
                $.post('/ranking/connect/', { codigo: decodedText }, function(data) {                   
                    if (data.status === 'success' || data.success) {
                        toastr.success("Conexão realizada!"); // Feedback visual imediato
                        setTimeout(() => { 
                            window.location.hash = 'amigos'; 
                            window.location.reload();
                        }, 1500);
                    }
                    else {
                        let errorMsg = data.message || "Erro desconhecido.";
                        toastr.error(errorMsg);
                        // Como deu erro, liberamos para o usuário tentar ler novamente
                        isScanning = false;
                    }
                }, 'json')
                .fail(function(xhr) {
                    let errorMsg = "Erro na requisição. Tente novamente.";
                    if(xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }
                    toastr.error(errorMsg);
                    
                    // Liberamos a trava para permitir nova tentativa após o erro
                    isScanning = false;
                });
            }
        ).catch(err => {
            console.error("Erro ao iniciar câmera:", err);
            toastr.error('Erro ao acessar câmera. Verifique as permissões.');
            // Fecha o modal para evitar ficar preso sem câmera, mas da um timeou para não fechar de uma vez.
            setTimeout(() => {
                const btnFechar = modalScan.querySelector('[data-bs-dismiss="modal"]');
                if (btnFechar) btnFechar.click();
            }, 1000);
        });
    });

    // Evento disparado QUANDO O MODAL COMEÇA A FECHAR
    modalScan.addEventListener('hidden.bs.modal', function () {
        console.log("Parando Câmera e limpando recursos do scanner.");
        if (html5QrCodeScanner) {
            html5QrCodeScanner.stop().catch(err => {
                console.warn("Erro ao parar câmera (normalmente ignorável):", err);
            }).then(() => {
                html5QrCodeScanner.clear(); // Remove elementos HTML criados pela lib
                html5QrCodeScanner = null;
            });
        }
    });

})();

/// exclusao

$('.long-press-delete').on('touchstart', function(e) {
    const _this = $(this);
    const friendUid = _this.data('uid');
    
    // Inicia o contador para o Long Press
    _this.data('timer', setTimeout(function() {
        
        // Feedback tátil (vibração curta)
        if (navigator.vibrate) navigator.vibrate(60);

        // Efeito visual imediato (Optimistic UI)
        _this.css({
            'transition': 'all 0.4s cubic-bezier(0.6, -0.28, 0.735, 0.045)',
            'transform': 'scale(0.2) translateX(200%)',
            'opacity': '0'
        });

        // Chamada API
        $.post('/ranking/disconnect', { 
            codigo: friendUid 
        }, function(data) {
            if (data.status == 'success') {
                // Remove do DOM definitivamente
                setTimeout(() => _this.remove(), 400);
                toastr.success('Conexão removida com sucesso!');
            } else {
                // Se a API retornar erro, volta o card e avisa
                _this.css({'transform': 'none', 'opacity': '1', 'scale': '1'});
                toastr.error(data.message || 'Não foi possível remover o amigo.');
            }
        }, 'json').fail(function() {
            // Em caso de erro de rede, restaura o card
            _this.css({'transform': 'none', 'opacity': '1', 'scale': '1'});
            toastr.warning('Erro de conexão com o servidor.');
        });

    }, 800));

}).on('touchend touchmove', function() {
    // Se o usuário soltar ou rolar a tela antes dos 800ms, cancela tudo
    clearTimeout($(this).data('timer'));
});


///------------------------------
    (function() {
        const handleTabs = () => {
            if (typeof bootstrap !== 'undefined') {
                // 1. Ao carregar: Se tiver # na URL, abre a aba certa
                const hash = window.location.hash;
                if (hash) {
                    const btn = document.querySelector(`a[data-bs-toggle="tab"][href="${hash}"]`);
                    if (btn) new bootstrap.Tab(btn).show();
                }

                // 2. Ao clicar: Força a atualização da URL
                const links = document.querySelectorAll('a[data-bs-toggle="tab"]');
                links.forEach(link => {
                    link.addEventListener('shown.bs.tab', function(e) {
                        const targetHash = e.target.getAttribute('href');
                        // Altera a URL sem recarregar
                        history.replaceState(null, null, targetHash);
                    });
                });
            } else {
                setTimeout(handleTabs, 50);
            }
        };

        handleTabs();
    })();


