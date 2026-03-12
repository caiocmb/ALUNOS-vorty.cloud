<div id="toast">Ação realizada</div>

<div class="mb-4">
    <a href="/home/" class="d-inline-flex align-items-center text-decoration-none mb-2 hover-glow" style="transition: 0.3s;">
        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-left" width="20" height="20" viewBox="0 0 24 24" stroke-width="2.5" stroke="var(--brand-green)" fill="none" stroke-linecap="round" stroke-linejoin="round">
          <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
          <path d="M15 6l-6 6l6 6" />
        </svg>
        <span class="meta ms-1" style="letter-spacing: 1px; font-size: 0.65rem; text-transform: uppercase;">Painel Principal</span>
    </a>

    <h1 class="display-6 page-title-glow">Seu treino, <?= $_SESSION['user_name']; ?>!</h1>
    <p class="text-muted" style="font-size: 0.9rem;">Selecione o protocolo de hoje para iniciar.</p>
</div>
                    <div class="row row-cards">

                        <?php 
                        if(empty($listar['data']['treinos'])){ ?>
                            <div class="col-12">
                                <div class="card border-0 rounded-3 overflow-hidden training-table">                            
                                    <div class="card-header border-0 d-flex align-items-center justify-content-between p-3" style="background: rgba(0, 0, 0, 0.1);">
                                        <h2 class="fw-bold mb-0 text-uppercase border-start border-4 ps-3 training-title">
                                            Nenhum treino encontrado
                                        </h2>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="list-group
                                            list-group-flush">     
                                            <div class="list-group      
                                            
                                            item bg-transparent d-flex justify-content-between align-items-center border-0 py-3 px-3 training-list-group">
                                                <span class="training-exercise-list">
                                                    Parece que você ainda não tem um treino atribuído. Entre em contato com a administração para obter seu plano de treino personalizado.
                                                </span>

                                            </div>
                                        </div>  
                                    </div>
                                </div>
                            </div>
                        <?php 
                        } 
                        else { 

                        //listando os treinos 
                        foreach($listar['data']['treinos'] as $treino){ 
                          
                        if(empty($treino['exercicios']) && $treino['acao'] == null){ ?>                   

                        <!-- bloco de titulo sem treino -->
                        <div class="col-12 mt-5 mb-4">
                            <div class="d-flex align-items-center">
                                <h2 class="fw-bold mb-0 text-uppercase border-start border-5 ps-3" 
                                    style="letter-spacing: 0.1em;  font-size: 1.2rem; line-height: 1; border-color: var(--brand-green) !important;">
                                    <?= $treino['titulo']; ?>
                                </h2>
                                
                                <div class="ms-3 flex-fill" style="border-bottom: 3px solid var(--brand-green);"></div>
                            </div>
                        </div>
                        <!-- fim do bloco de titulo sem treino -->

                        <?php 
                        }

                        if(!empty($treino['exercicios']) && $treino['acao'] <> null){ 
                        ?>
                        <!-- bloco do treino -->
                        <div class="col-12 col-md-6 mb-4">
                            <div class="card border-0 rounded-3 overflow-hidden training-table">                            
                                <div class="card-header border-0 d-flex align-items-center justify-content-between p-3" style="background: rgba(0, 0, 0, 0.1);">
                                    <h2 class="fw-bold mb-0 text-uppercase border-start border-4 ps-3 training-title">
                                        <?= $treino['titulo']; ?>
                                    </h2>
                                    <a href="/workout/" class="btn btn-sm fw-bold shimmer-effect training-button-iniciar">
                                        <?= $treino['acao']; ?>
                                    </a>
                                </div>
                                <div class="card-body p-0">
                                    <div class="list-group list-group-flush">     
                                        <?php 
                                        foreach($treino['exercicios'] as $exercicio){     ?>
                                        <div 
                                            class="list-group-item bg-transparent d-flex justify-content-between align-items-center border-0 py-3 px-3 training-list-group"
                                            <?php if(!empty($exercicio['exemplo'])){ ?>    
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modal-exercicio" 
                                            data-bs-title="<?= $exercicio['nome']; ?>" 
                                            data-bs-img="<?= $exercicio['exemplo']; ?>"                                             
                                            <?php } else { echo 'onclick="notify(\'Exercício sem exemplo disponível.\')"'; } ?> 
                                            style="cursor: pointer;">
                                            <span class="training-exercise-list">
                                                <?= $exercicio['nome']; ?>
                                            </span>
                                            <span class="badge training-exercise-badge">
                                                <?= $exercicio['repeticoes']; ?>
                                            </span>
                                        </div>  
                                        <?php } ?>                                     

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- fim do bloco do treino -->
                        <?php 
                        } // if treino

                        } // fim do loop de exercicios

                        if(!empty($listar['data']['observacao'])){ 
                        ?>
                        <!-- bloco da observação -->
                        <div class="col-12 mt-5 mb-4">
                            <div class="d-flex align-items-center mb-3">
                                <h2 class="fw-bold mb-0 text-uppercase border-start border-5 ps-3" 
                                    style="letter-spacing: 0.1em; font-size: 1.2rem; line-height: 1; border-color: var(--brand-green) !important;">
                                    OBSERVAÇÕES
                                </h2>
                                
                                <div class="ms-3 flex-fill" style="border-bottom: 3px solid var(--brand-green);"></div>
                            </div>

                            <div class="card bg-transparent border-0 shadow-none">
                                <div class="card-body p-0 ps-3">
                                    <p class="mb-0" style="font-size: 1.1rem; line-height: 1.5; font-style: italic; opacity: 0.9;">
                                        <?= nl2br($listar['data']['observacao']); ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <!-- fim do bloco da observação -->
                        <?php 
                        }// if observação
                        
                        }
                        ?>

                    </div> 

<!-- Modal de exemplo de exercício -->
<div class="modal modal-blur fade" id="modal-exercicio" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
    <div class="modal-content">
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      <div class="modal-status bg-success"></div>
      <div class="modal-body text-center py-4">
        <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-green icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" /><path d="M9 12l2 2l4 -4" /></svg>
        
        <h3 id="modal-exercicio-title">Exemplo</h3>
        
        <div class="text-secondary">
            <img src="" id="modal-exercicio-img" width="100%" style="border-radius: 10px;">
        </div>
      </div>
      <div class="modal-footer">
        <div class="w-100">
          <div class="row">
            <div class="col">
                <a href="#" class="btn btn-success w-100" data-bs-dismiss="modal">Voltar ao treino</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Fim do Modal de exemplo de exercício -->
