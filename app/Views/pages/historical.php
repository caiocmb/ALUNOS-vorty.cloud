<div class="container-tight py-4" style="max-width: 550px; margin: 0 auto;">

    <div class="d-flex align-items-center justify-content-between mb-4 px-2">
        <a href="/home/" class="btn btn-icon btn-ghost-secondary rounded-circle pulse-hover">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"/></svg>
        </a>
        <span class="brand-orbitron h4 m-0 text-uppercase" style="letter-spacing: 2px; color: var(--brand-green);">Evolução</span>
        <div style="width: 40px;"></div>
    </div>

    <div class="card portal-card border-0 shadow-lg mb-4 overflow-hidden animate-in" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); position: relative;">
        <div style="position: absolute; top: -50px; right: -50px; width: 150px; height: 150px; background: rgba(var(--tblr-success-rgb), 0.15); filter: blur(40px); border-radius: 50%;"></div>
        
        <div class="card-body p-4 text-center position-relative">
            <div class="text-white-50 small text-uppercase mb-2 brand-orbitron" style="font-size: 0.7rem;">Pontuação Acumulada</div>
            <div class="display-4 font-weight-bold text-white mb-2 counter-up">2.450</div>
            
            <div class="d-flex align-items-end justify-content-center gap-1 mt-3" style="height: 40px;">
                <div class="bg-success rounded-top bar-anim" style="width: 6px; --h: 40%;"></div>
                <div class="bg-success rounded-top bar-anim" style="width: 6px; --h: 70%;"></div>
                <div class="bg-success rounded-top bar-anim" style="width: 6px; --h: 50%;"></div>
                <div class="bg-success rounded-top bar-anim" style="width: 6px; --h: 90%;"></div>
                <div class="bg-white-50 rounded-top bar-anim" style="width: 6px; --h: 30%;"></div>
                <div class="bg-success rounded-top bar-anim" style="width: 6px; --h: 100%;"></div>
                <div class="bg-success rounded-top bar-anim" style="width: 6px; --h: 80%;"></div>
            </div>
        </div>
    </div>

    <div class="space-y-3 px-1">
        <?php for ($i = 1; $i <= 3; $i++): ?>
        <div class="training-card shadow-sm animate-in-up" style="animation-delay: <?= $i * 0.1 ?>s;" onclick="this.classList.toggle('expanded')">
            <div class="card-body p-3">
                
                <div class="row align-items-center g-3">
                    <div class="col-auto">
                        <div class="text-center p-2 rounded-3 date-box">
                            <div class="small text-muted text-uppercase" style="font-size: 0.6rem;">Fev</div>
                            <div class="h3 m-0">2<?= $i ?></div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="font-weight-bold h4 mb-0 text-uppercase brand-orbitron">Treino <?= ['A', 'B', 'C'][$i % 3] ?></div>
                        <div class="text-success small font-weight-bold">🔥 +25 XP Conquistados</div>
                    </div>
                    <div class="col-auto text-muted">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="chevron-icon"><path d="M6 9l6 6 6-6"/></svg>
                    </div>
                </div>

                <div class="expandable-content mt-3 pt-3 border-top border-dashed">
                    
                    <div class="exercise-session p-2 rounded-3 mb-3" style="background: rgba(255,255,255,0.02);">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="d-flex align-items-center gap-2">
                                <div class="bg-success-lt p-1 rounded">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" class="text-success" fill="currentColor" viewBox="0 0 16 16"><path d="M1 8a7 7 0 1 1 14 0A7 7 0 0 1 1 8m10.354-3.646a.5.5 0 0 0-.708 0L7 8.293 5.354 6.646a.5.5 0 1 0-.708.708l2 2a.5.5 0 0 0 .708 0l4-4a.5.5 0 0 0 0-.708"/></svg>
                                </div>
                                <span class="font-weight-bold brand-orbitron" style="font-size: 0.8rem;">STIFF UNILATERAL</span>
                            </div>
                            <span class="text-muted extra-small">Meta: 3x 12 a 15</span>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-sm table-borderless mb-0">
                                <thead>
                                    <tr class="text-muted extra-small uppercase">
                                        <th style="width: 20%;">Série</th>
                                        <th class="text-center">Prescrito</th>
                                        <th class="text-end">Realizado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><span class="badge">S1</span></td>
                                        <td class="text-center text-muted small">12-15 reps</td>
                                        <td class="text-end">
                                            <span class="text-success font-weight-bold">10kg</span> / <strong>12 reps</strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge">S2</span></td>
                                        <td class="text-center text-muted small">12-15 reps</td>
                                        <td class="text-end">
                                            <span class="text-success font-weight-bold">12kg</span> / <strong>12 reps</strong>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-3 p-2 bg-dark-lt rounded-2">
                        <span class="extra-small text-muted">Esforço Total</span>
                        <span class="font-weight-bold text-success" style="font-size: 0.75rem;">1.420 kg Movimentados</span>
                    </div>
                </div>
            </div>
        </div>
        <?php endfor; ?>
    </div>
</div>

<style>
    /* Estilos Gerais de Animação e Identidade*/
    .brand-orbitron { font-family: 'Orbitron', sans-serif; }
    .animate-in { animation: scaleIn 0.5s ease-out; }
    .animate-in-up { opacity: 0; animation: slideUp 0.6s forwards; }
    @keyframes slideUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    
    .bar-anim { height: 0; animation: barGrow 1s forwards; animation-delay: 0.5s; }
    @keyframes barGrow { from { height: 0; } to { height: var(--h); } }

    .training-card { background: var(--tblr-bg-surface); border-radius: 16px; border: 1px solid var(--tblr-border-color); cursor: pointer; transition: 0.3s; }
    .training-card.expanded { border-color: var(--brand-green); }
    
    .expandable-content { display: none; animation: fadeIn 0.3s ease; }
    .training-card.expanded .expandable-content { display: block; }
    .training-card.expanded .chevron-icon { transform: rotate(180deg); color: var(--brand-green); }

    .bg-dark-lt { background: #1e293b !important; color: #fff; border: 1px solid rgba(255,255,255,0.05); }
    .date-box { background: rgba(var(--tblr-secondary-rgb), 0.05); border: 1px solid var(--tblr-border-color); min-width: 52px; }
    .extra-small { font-size: 0.6rem; text-transform: uppercase; letter-spacing: 0.5px; }
    
    .table-sm td { padding: 0.6rem 0; vertical-align: middle; }
    .chevron-icon { transition: transform 0.3s ease; }
</style>