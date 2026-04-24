<div class="container-tight py-4" style="max-width: 450px; margin: 0 auto;">
<?php 
if($_SESSION['user_id'] <> 'd22ae9b7-d776-11ef-86f6-c1bd71fda12e')
{ 
    // redirecionar para a index
    header('Location: /home');
 }
?>
    
    <div class="d-flex align-items-center justify-content-between mb-4 px-2">
        <a href="/home/" class="btn btn-icon btn-ghost-secondary rounded-circle pulse-hover">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"/></svg>
        </a>
        <span class="brand-orbitron h4 m-0 text-uppercase" style="letter-spacing: 2px;">Ranking</span>
        <div style="width: 40px;"></div>
    </div>

    <div class="card mb-4 border-0 shadow-sm user-position-card">
        <div class="card-body p-3">
            <div class="row align-items-center g-3">
                <div class="col-auto">
                    <div class="user-avatar-parent">
                        <img src="https://i.pravatar.cc/150?u=me" class="rounded-circle border border-2 border-success" width="60">
                        <div class="user-rank-badge shadow">24º</div>
                    </div>
                </div>
                <div class="col">
                    <div class="brand-rajdhani text-uppercase fw-bold text-muted small mb-1" style="letter-spacing: 1px;">Sua Performance</div>
                    <div class="brand-orbitron h3 mb-0 text-truncate">Caio Barros</div>
                    <div class="d-flex align-items-center gap-2 mt-1">
                        <span class="badge bg-success-lt brand-rajdhani">TOP 15%</span>
                        <span class="text-success fw-bold brand-rajdhani small">🔥 4.820 XP</span>
                    </div>
                </div>
                <div class="col-auto text-end">
                    <div class="brand-rajdhani small text-muted">Faltam <b class="text-white">180 XP</b></div>
                    <div class="brand-rajdhani small text-muted">para 23º</div>
                </div>
            </div>
        </div>
    </div>

    <div class="ranking-tabs-wrapper mb-4">
        <ul class="nav nav-pills custom-capsule" role="tablist">
            <li class="nav-item">
                <a class="nav-link active tab-item" data-bs-toggle="tab" href="#xp">RANKING GERAL</a>
            </li>
            <li class="nav-item">
                <a class="nav-link tab-item" data-bs-toggle="tab" href="#amigos">RANKING AMIGOS</a>
            </li>
        </ul>
    </div>

    <div class="tab-content">
        <div class="tab-pane fade show active" id="xp">
            <div class="space-y-3">
                <div class="ranking-card champion-card p-3">
                    <div class="row align-items-center g-0">
                        <div class="col-auto">
                            <div class="rank-badge-main rank-1">1º</div>
                        </div>
                        <div class="col px-3">
                            <div class="brand-orbitron text-white h4 mb-0">Lucas Silva</div>
                            <div class="text-success small fw-bold">🔥 12.450 XP</div>
                        </div>
                        <div class="col-auto">
                            <div class="avatar-wrapper-gold">
                                <img src="https://i.pravatar.cc/150?u=1" class="rounded-circle" width="48">
                            </div>
                        </div>
                    </div>
                </div>

                <?php 
                $destaques = [
                    2 => ['nome' => 'Mariana Costa', 'val' => '9.800 XP', 'class' => 'rank-2'],
                    3 => ['nome' => 'Ricardo Monstro', 'val' => '8.150 XP', 'class' => 'rank-3']
                ];
                foreach($destaques as $pos => $d): ?>
                <div class="ranking-card podio-card p-3">
                    <div class="row align-items-center g-0">
                        <div class="col-auto"><div class="rank-badge-main <?= $d['class'] ?>"><?= $pos ?>º</div></div>
                        <div class="col px-3">
                            <div class="brand-orbitron text-white small"><?= $d['nome'] ?></div>
                            <div class="text-muted extra-small"><?= $d['val'] ?></div>
                        </div>
                        <div class="col-auto">
                            <img src="https://i.pravatar.cc/150?u=<?= $pos ?>" class="rounded-circle border border-white-10" width="36">
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>

                <div class="mt-4 bg-dark-card rounded-3 overflow-hidden border border-white-10 shadow-sm">
                    <?php for($i=4; $i<=10; $i++): ?>
                    <div class="d-flex align-items-center p-2 border-bottom border-white-10 ranking-item-mini">
                        <div class="text-muted brand-orbitron extra-small px-3" style="min-width: 55px;"><?= $i ?>º</div>
                        <div class="flex-fill brand-orbitron text-white-50" style="font-size: 0.75rem;">Atleta Exemplo #<?= $i ?></div>
                        <div class="text-success extra-small fw-bold px-3"><?= 5000 - ($i * 400) ?> XP</div>
                    </div>
                    <?php endfor; ?>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="amigos">
           
            <div class="text-center mb-4">
                <div class="badge bg-primary-lt brand-orbitron px-3 py-2 mb-2" style="letter-spacing: 2px;">
                    TEMPORADA DE ABRIL
                </div>
                <p class="text-muted small brand-rajdhani">A temporada encerra em: <b class="text-white">04d 12h 30m</b></p>
            </div>

            <div class="row g-2 align-items-end justify-content-center mb-4" style="min-height: 160px;">
                <div class="col-4 text-center">
                    <div class="avatar-podium silver mb-2">
                        <img src="https://i.pravatar.cc/150?u=8" class="rounded-circle" width="50">
                        <div class="podium-rank">2</div>
                    </div>
                    <div class="brand-rajdhani text-white small fw-bold text-truncate">Mariana</div>
                    <div class="text-muted extra-small">9.2k XP</div>
                </div>
                <div class="col-4 text-center">
                    <div class="avatar-podium gold mb-2">
                        <img src="https://i.pravatar.cc/150?u=12" class="rounded-circle" width="70">
                        <div class="podium-rank">1</div>
                        <div class="crown-icon">👑</div>
                    </div>
                    <div class="brand-orbitron text-success small fw-bold text-truncate">Ricardo</div>
                    <div class="text-success extra-small fw-bold">12.1k XP</div>
                </div>
                <div class="col-4 text-center">
                    <div class="avatar-podium bronze mb-2">
                        <img src="https://i.pravatar.cc/150?u=5" class="rounded-circle" width="50">
                        <div class="podium-rank">3</div>
                    </div>
                    <div class="brand-rajdhani text-white small fw-bold text-truncate">Felipe</div>
                    <div class="text-muted extra-small">8.8k XP</div>
                </div>
            </div>

            <div class="space-y-2 mb-4">
                <div class="ranking-card p-3 bg-dark-card border-0">
                    <div class="row align-items-center g-0">
                        <div class="col-auto me-3"><span class="text-muted fw-bold brand-orbitron">4º</span></div>
                        <div class="col-auto"><img src="https://i.pravatar.cc/150?u=22" class="rounded-circle" width="35"></div>
                        <div class="col px-3">
                            <div class="brand-rajdhani text-white fw-bold">Você</div>
                            <div class="text-success extra-small">▲ 2 posições esta semana</div>
                        </div>
                        <div class="col-auto text-end">
                            <div class="brand-orbitron text-white small">7.420</div>
                            <div class="text-muted extra-small">XP</div>
                        </div>
                    </div>
                </div>
                <div class="ranking-card p-3 bg-dark-card border-0 opacity-75">
                    <div class="row align-items-center g-0">
                        <div class="col-auto me-3"><span class="text-muted fw-bold brand-orbitron">5º</span></div>
                        <div class="col-auto"><img src="https://i.pravatar.cc/150?u=33" class="rounded-circle" width="35"></div>
                        <div class="col px-3">
                            <div class="brand-rajdhani text-white fw-bold">Beatriz Silva</div>
                            <div class="text-danger extra-small">▼ 1 posição</div>
                        </div>
                        <div class="col-auto text-end">
                            <div class="brand-orbitron text-white small">6.100</div>
                            <div class="text-muted extra-small">XP</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm overflow-hidden mb-4" style="border-radius: 20px;">
                <div class="card-body p-4 text-center">
                    <div class="brand-rajdhani text-success fw-bold small mb-2" style="letter-spacing: 2px;">CONECTE-SE AOS SEUS AMIGOS</div>
                    

                    <div class="row g-2">
                        <div class="col-6">
                            <button class="btn btn-outline-success w-100 brand-rajdhani fw-bold py-3" data-bs-toggle="modal" data-bs-target="#modal-discovery">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-users-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
  <path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" /><path d="M2 21v-2a4 4 0 0 1 4 -4h4c.96 0 1.84 .338 2.53 .901" /><path d="M16 3.13a4 4 0 0 1 0 7.75" /><path d="M16 19h6" /><path d="M19 16v6" />
</svg>
                                CONECTAR
                            </button>
                        </div>
                        <div class="col-6">
                            <button class="btn btn-success w-100 brand-rajdhani fw-bold py-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#modal-scanner">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-qrcode me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 4m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" /><path d="M7 17l0 .01" /><path d="M14 4m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" /><path d="M7 7l0 .01" /><path d="M4 14m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" /><path d="M17 7l0 .01" /><path d="M14 14l3 0" /><path d="M20 14l0 .01" /><path d="M14 14l0 3" /><path d="M14 20l7 0" /><path d="M17 17l3 0" /><path d="M20 17l0 3" /></svg>
                                ESCANEAR QR
                            </button>
                        </div>
                    </div>

         
                </div>
            </div>

            <div class="modal modal-blur fade" id="modal-discovery" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="static">
                <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                    <div class="modal-content bg-dark text-white border-success">
                        <div class="modal-body text-center py-4">
                            
                            <div class="radar-container mb-3">
                                <div class="radar-ping"></div>
                                <img src="https://i.pravatar.cc/150?u=me" class="rounded-circle position-relative" width="80" style="z-index: 2; border: 3px solid var(--brand-green);">
                            </div>

                            <h3 class="brand-orbitron text-success mb-1">MODO VISÍVEL</h3>
                            <div class="text-muted brand-rajdhani small mb-3">Peça para seu amigo escanear o código abaixo:</div>

                            <div id="qrcode-container" class="bg-white p-2 rounded-3 d-inline-block mb-3 border border-success border-2 shadow-glow"></div>

                            <div class="h2 brand-orbitron mb-1" id="discovery-timer">01:00</div>
                            <div class="text-muted extra-small brand-rajdhani">Aguardando conexão...</div>
                            
                            <button type="button" class="btn btn-link link-secondary mt-3" data-bs-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal modal-blur fade" id="modal-scanner" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                    <div class="modal-content bg-dark text-white">
                        <div class="modal-header border-white-10">
                            <h5 class="modal-title brand-orbitron text-success">ESCANEAR</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-0 overflow-hidden position-relative" style="min-height: 300px;">
                            <div id="reader" style="width: 100%; height: 100%;"></div>
                            <div class="scanner-overlay"></div>
                        </div>
                        <div class="modal-footer border-white-10 py-2 justify-content-center">
                            <p class="text-muted extra-small brand-rajdhani mb-0">Aponte a câmera para o QR Code do seu amigo.</p>
                        </div>
                    </div>
                </div>
            </div>
        
        </div>
    </div>
</div>

