<div class="container-tight py-4" style="max-width: 450px; margin: 0 auto;">
<?php 
if($_SESSION['user_id'] <> 'd22ae9b7-d776-11ef-86f6-c1bd71fda12e' && $_SESSION['user_id'] <> '0b0c0487-162a-11f1-a114-c22b8d44ac94' && $_SESSION['user_id'] <> '266e7bb6-cf92-11ef-86f6-c1bd71fda12e' && $_SESSION['user_id'] <> 'eb863e42-1a2b-11f1-a114-c22b8d44ac94')
{ 
    // redirecionar para a index
    header('Location: /home');
}

if(!isset($rankings['data']) && empty($rankings['data'])){
    echo "<div class='alert alert-danger '>Nenhum dado disponível. <a href='/home' class='alert-link'>Voltar</a></div>";
    return;
}

?>
    
    <div class="d-flex align-items-center justify-content-between mb-4 px-2">
        <a href="/home/" class="btn btn-icon btn-ghost-secondary rounded-circle pulse-hover">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"/></svg>
        </a>
        <span class="brand-orbitron h4 m-0 text-uppercase" style="letter-spacing: 2px;">Ranking</span>
        <div style="width: 40px;"></div>
    </div>

   

    <div class="ranking-tabs-wrapper mb-4">
        <ul class="nav nav-pills custom-capsule" role="tablist">
            <li class="nav-item">
                <a class="nav-link active tab-item" data-bs-toggle="tab" href="#xp">GERAL</a>
            </li>
            <li class="nav-item">
                <a class="nav-link tab-item" data-bs-toggle="tab" href="#amigos">MEUS AMIGOS</a>
            </li>
        </ul>
    </div>



    <div class="tab-content">
        <div class="tab-pane fade show active" id="xp">
            <div class="space-y-3">

                <!-- CARD DE DESTAQUE COM POSIÇÃO DO USUÁRIO -->
                <?php 
                if(isset($rankings['data']['posicao_usuario']) && $rankings['data']['posicao_usuario'] <> null )
                {
                ?>
                <div class="card mb-4 border-0 shadow-lg overflow-hidden meu-ranking-card" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); position: relative; border-left: 4px solid #32ba3c !important;">
                    <div style="position: absolute; top: -40px; right: -40px; width: 140px; height: 140px; background: rgba(50, 186, 60, 0.12); filter: blur(40px); border-radius: 50%;"></div>
                    
                    <div class="card-body p-4 position-relative">
                        <div class="row align-items-center g-0">
                            
                            <div class="col-auto pe-4 border-end border-white-10 text-center rank-section" style="min-width: 100px;">
                                <div class="text-white-50 extra-small text-uppercase mb-1 brand-orbitron" style="letter-spacing: 1px;">Sua Posição</div>
                                <div class="brand-orbitron h1 mb-0 text-success" style="line-height: 1; font-size: 2.5rem;"><?= $rankings['data']['posicao_usuario']; ?>º</div>
                            </div>

                            <div class="col-auto text-end border-start border-white-10 ps-4 stats-section">
                                <div class="brand-orbitron h2 mb-1" style="line-height: 1; color:#fff;">
                                    <?= number_format($rankings['data']['xp_total_usuario'], 0, ',', '.') ?> <span class="text-success fs-5">XP</span>
                                </div>
                                <div class="mt-2 brand-rajdhani">
                                    <?php if($rankings['data']['posicao_usuario'] <> 1): ?>
                                        <div class="progress-wrapper">
                                            <div class="d-flex justify-content-between align-items-center mb-1 small">
                                                <span class="text-muted">Meta para <b class="text-white"><?= $rankings['data']['proxima_posicao'] ?>º</b></span>
                                                <span class="fw-bold text-success"><?= number_format($rankings['data']['percentual_progresso'], 0, ',', '.') ?>%</span>
                                            </div>
                                            <div class="progress bg-dark shadow-sm" style="height: 6px; width: 180px; border-radius: 3px;">
                                                <div class="progress-bar bg-success" style="width: <?= $rankings['data']['percentual_progresso'] ?>%; box-shadow: 0 0 10px rgba(50, 186, 60, 0.4);"></div>
                                            </div>
                                            <div class="extra-small mt-1 text-uppercase fw-bold text-muted" style="font-size: 0.6rem;">
                                                Faltam <span class="text-white"><?= number_format($rankings['data']['proxima_posicao_xp_faltando'], 0, ',', '.') ?> XP</span> para subir
                                            </div>
                                        </div>

                                    <?php else: ?>
                                        <div class="d-flex align-items-center gap-2 py-1">
                                            <div class="d-flex align-items-center justify-content-center bg-success-lt rounded-circle" style="width: 32px; height: 32px; box-shadow: 0 0 15px rgba(50, 186, 60, 0.3);">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="text-success" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" style="filter: drop-shadow(0 0 3px rgba(50, 186, 60, 0.5));">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M8 21l8 0"></path>
                <path d="M12 17l0 4"></path>
                <path d="M7 4l10 0"></path>
                <path d="M17 4v8a5 5 0 0 1 -10 0v-8"></path>
                <path d="M5 9m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                <path d="M7 9a2 2 0 1 0 -4 0"></path>
                <path d="M19 9m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                <path d="M21 9a2 2 0 1 0 -4 0"></path>
            </svg>
                                            </div>
                                            <div>
                                                <div class="fw-bold text-success text-uppercase lh-1" style="letter-spacing: 1px; font-size: 0.8rem;">Você é o #1!</div>
                                                <div class="extra-small text-muted text-uppercase" style="font-size: 0.6rem;">O topo da montanha é seu.</div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <?php } ?>

                <!-- RANKING GERAL -->
                <?php 
                foreach ($rankings['data']['ranking'] as $key => $value) 
                {
                    // primeira posicao
                    if($value['posicao'] == 1)
                    {
                ?>  
                    <div class="ranking-card champion-card p-3">
                        <div class="row align-items-center g-0">
                            <div class="col-auto">
                                <div class="rank-badge-main rank-1">1º</div>
                            </div>
                            <div class="col px-3">
                                <div class="brand-orbitron  h4 mb-0" style="color:#fff;"><?= $value['nickname'] ?></div>
                                <div class="text-success small fw-bold">🔥 <?= number_format($value['xp_total'], 0, ',', '.') ?> XP</div>
                            </div>
                            <div class="col-auto">
                                <div class="avatar-wrapper-gold">
                                    <span class="avatar avatar-lg rounded-circle avatar-glow" style="background-image: url('/photo/profile/<?= $value['foto']; ?>')"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php 
                    }                    
                    // segunda posicao
                    else if($value['posicao'] == 2)
                    {
                ?>
                    <div class="ranking-card podio-card p-3">
                        <div class="row align-items-center g-0">
                            <div class="col-auto"><div class="rank-badge-main rank-2">2º</div></div>
                            <div class="col px-3">
                                <div class="brand-orbitron text-white small"><?= $value['nickname'] ?></div>
                                <div class="text-muted extra-small"><?= number_format($value['xp_total'], 0, ',', '.') ?> XP</div>
                            </div>
                            <div class="col-auto">                               
                                <span class="avatar avatar-md rounded-circle avatar-glow" style="background-image: url('/photo/profile/<?= $value['foto']; ?>')"></span>
                            </div>
                        </div>
                    </div>
                <?php
                    }   
                    // terceira posicao
                    else if($value['posicao'] == 3)
                    {
                ?>
                    <div class="ranking-card podio-card p-3">
                        <div class="row align-items-center g-0">
                            <div class="col-auto"><div class="rank-badge-main rank-3">3º</div></div>
                            <div class="col px-3">
                                <div class="brand-orbitron text-white small"><?= $value['nickname'] ?></div>
                                <div class="text-muted extra-small"><?= number_format($value['xp_total'], 0, ',', '.') ?> XP</div>
                            </div>
                            <div class="col-auto">
                                <span class="avatar avatar-md rounded-circle avatar-glow" style="background-image: url('/photo/profile/<?= $value['foto']; ?>')"></span>
                            </div>
                        </div>
                    </div>
                <?php
                    }
                    //restante
                    else
                    {
                ?>
                    <div class="mt-0 bg-dark-card rounded-3 overflow-hidden border border-white-10 shadow-sm">
                        <div class="d-flex align-items-center p-2 border-bottom border-white-10 ranking-item-mini">
                            <div class="text-muted brand-orbitron extra-small px-3" style="min-width: 55px;"><?= $value['posicao'] ?>º</div>
                            <div class="flex-fill brand-orbitron text-white-50" style="font-size: 0.75rem;"><?= $value['nickname'] ?></div>
                            <div class="text-success extra-small fw-bold px-3"><?= number_format($value['xp_total'], 0, ',', '.') ?> XP</div>
                        </div>
                    </div>
                <?php
                    }
                }   
                ?>
 
            </div>
        </div>

        <div class="tab-pane fade" id="amigos">
           
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
            
            <!-- modais QR -->            
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

