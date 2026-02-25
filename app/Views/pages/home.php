                    <div class="row align-items-center mb-5">
                        <div class="col-auto">
                            <span class="avatar avatar-xl rounded-circle avatar-glow" style="background-image: url('/photo/profile/<?= $_SESSION['user_photo']; ?>')"></span>
                        </div>
                        <div class="col">
                            <h1 class="mb-1 brand-orbitron" style="font-size: 1.5rem;">Olá, <?= $_SESSION['user_name']; ?>!</h1>
                            <div class="d-flex align-items-center gap-2">
                                <span class="<?php if($_SESSION['user_status'] == 'Ativo'){ echo 'status-badge'; } else { echo 'status-badge-inactive'; } ?>">Status: <?= $_SESSION['user_status']; ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="row row-cards">
                        
                        <?php if($_SESSION['user_status'] == 'Ativo'){ ?>
                        <div class="col-12 col-md-8">
                            <a href="/training/" class="portal-card card-main shimmer">
                                <svg xmlns="http://www.w3.org/2000/svg" class="text-success mb-3" width="60" height="60" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 7h-1a1 1 0 0 0 -1 1v8a1 1 0 0 0 1 1h1" /><path d="M19 17h1a1 1 0 0 0 1 -1v-8a1 1 0 0 0 -1 -1h-1" /><path d="M18 6h-1a1 1 0 0 0 -1 1v10a1 1 0 0 0 1 1h1" /><path d="M6 18h1a1 1 0 0 0 1 -1v-10a1 1 0 0 0 -1 -1h-1" /><path d="M8 12h8" /></svg>
                                <h3 class="card-title" style="font-size: 1.4rem;">Área de Treino</h3>
                                <p class="text-muted mt-2">Sua rotina personalizada</p>
                            </a>
                        </div>                        

                        <div class="col-12 col-md-4">
                            <a href="/profile/" class="portal-card">
                                <svg xmlns="http://www.w3.org/2000/svg" class="text-secondary" width="40" height="40" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c.1 .06 .201 .115 .303 .164c.288 .14 .583 .23 1.037 .113c.454 -.118 .645 -.361 .645 -1.065z" /><path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" /></svg>
                                <h3 class="card-title mt-2">Ajustes</h3>
                                <span class="text-muted small">Perfil e Senha</span>
                            </a>
                        </div>

                        <div class="col-6 col-md-4">
                            <a href="/historical/" class="portal-card">
                                <svg xmlns="http://www.w3.org/2000/svg" class="text-blue" width="32" height="32" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 8l0 4l2 2" /><path d="M3.05 11a9 9 0 1 1 .5 4m-.5 5v-5h5" /></svg>
                                <h3 class="card-title mt-2">Histórico</h3>
                            </a>
                        </div>
                        <?php } ?>

                        <div class="col-6 col-md-4">
                            <a href="/monthlyfee/" class="portal-card">
                                <svg xmlns="http://www.w3.org/2000/svg" class="text-orange" width="32" height="32" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 5m0 3a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v8a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3z" /><path d="M3 10l18 0" /><path d="M7 15l.01 0" /><path d="M11 15l2 0" /></svg>
                                <h3 class="card-title mt-2">Mensalidades</h3>
                            </a>
                        </div>

                        <div class="col-12 col-md-4">
                            <a href="/logout/" class="portal-card">
                                <svg xmlns="http://www.w3.org/2000/svg" class="text-danger" width="32" height="32" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2" /><path d="M9 12h12l-3 -3" /><path d="M18 15l3 -3" /></svg>
                                <h3 class="card-title mt-2 text-danger">Sair</h3>
                            </a>
                        </div>

                    </div>