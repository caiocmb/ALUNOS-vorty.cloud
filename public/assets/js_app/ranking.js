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
        return codeEl ? codeEl.innerText.trim() : 'ERRO';
    };

    // --- LÓGICA DO MODAL DE DESCOBERTA (Aluno A - Mostra QR) ---
    const modalDisc = document.getElementById('modal-discovery');
    
    // Evento disparado QUANDO O MODAL TERMINA DE ABRIR
    modalDisc.addEventListener('shown.bs.modal', function () {
        const myCode = getMyCode();
        console.log(`Iniciando Modo Visível para o código: ${myCode}`);

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
            console.log(`[API POLLING]: Verificando se alguém conectou com ${myCode}...`);
            // Exemplo de sucesso:
            // fetch(`/api/check-connection/${myCode}`).then(r => r.json()).then(data => {
            //    if(data.success) window.location.reload(); // Atualiza para mostrar amigo
            // });
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
        console.log("Iniciando Câmera para Escanear Rival...");
        
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

        // Inicia a câmera traseira ("environment")
        html5QrCodeScanner.start(
            { facingMode: "environment" }, 
            config,
            (decodedText) => {
                // SUCESSO NA LEITURA
                console.log(`[QR SCAN SUCESSO]: Código Rival Lido: ${decodedText}`);
                
                // 1. Fecha o modal do leitor
                if(window.bootstrap) {
                    window.bootstrap.Modal.getInstance(modalScan).hide();
                }

                // 2. Feedback e Ação
                // Aqui você enviaria o código lido para conectar
                // Exemplo: window.location.href = `/conectar-rival/${getMyCode()}/${decodedText}`;
                alert(`CONECTANDO COM O RIVAL: ${decodedText}\n\nEnviando solicitação de conexão...`);
            }
        ).catch(err => {
            console.error("Erro ao iniciar câmera (Verifique permissões HTTPS):", err);
            // Mostra erro amigável no container da câmera
            document.getElementById('reader').innerHTML = '<div class="text-danger p-3 extra-small">Erro ao acessar câmera. Verifique se o site possui permissão de câmera e está rodando em HTTPS.</div>';
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