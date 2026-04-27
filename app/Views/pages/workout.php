<?php 
$url = $_SERVER['REQUEST_URI'];

preg_match('/workout\/([^\/]+)/', $url, $matches);
$treinoId = $matches[1] ?? null;
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title><?= $_ENV['COMPANY_NAME']; ?> - Workout - Portal do Aluno</title>
    
    <link rel="stylesheet" href="/assets/css/fonts-custom.css?<?= $_ENV['APP_VERSAO'] ?>" />
    <link rel="stylesheet" href="/assets/css/tabler.min.css?<?= $_ENV['APP_VERSAO'] ?>">    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="icon" type="image/png" href="/assets/img/<?= $_ENV['COMPANY_FAVICON'] ?>">  

    <!-- custom scripts -->
    <link rel="stylesheet" href="/assets/css_app/workout.css?<?= $_ENV['APP_VERSAO'] ?>" /> 

</head>
<body data-bs-theme="dark" data-workout-id="<?= $treinoId; ?>">

<!-- header customizado para o treino -->
<div class="top-fixed-bar">
    <div class="d-flex align-items-center gap-3">
        <a href="/training/" class="text-body">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="icon-back">
                <path d="M15 18l-6-6 6-6"/>
            </svg>
        </a>
        <div>
            <label class="text-muted d-block orbitron" style="font-size: 0.55rem; letter-spacing: 2px;">TREINO ATIVO</label>
            <span id="main-clock" class="orbitron fw-bold">00:00:00</span>
        </div>
    </div>
    <div class="d-flex gap-2">
        <button class="btn btn-danger btn-pill fw-bold orbitron px-3" onclick="app.finishWorkout()">CONCLUIR</button>
    </div>
</div>
<!-- header customizado para o treino -->

<!-- barra de XP fixa -->
<div class="xp-full-bar" id="xp-bar">
    <span class="xp-label-tech">PONTUAÇÃO DO TREINO</span>
    <div class="xp-counter-wrapper">
        <span id="current-xp-nav" class="xp-value-large">0</span>
        <span class="xp-unit">XP</span>
    </div>
</div>
<!-- barra de XP fixa -->

<!-- overlay de descanso -->
<div id="rest-overlay" onclick="app.minimizeRest()">
    <div class="timer-val-big" id="rest-timer-big">60</div>
    <span class="orbitron text-success" style="letter-spacing: 3px;">DESCANSO ATIVO</span>
    <p class="text-muted mt-3 small">Toque para minimizar</p>
</div>

<div id="mini-rest" onclick="app.maximizeRest()"> </div>
<!-- overlay de descanso -->

<!-- conteúdo principal do treino -->
<div class="container-xl" id="workout-content"></div>
<!-- conteúdo principal do treino -->
 
<!-- overlay de finalização de treino -->
<div id="finish-overlay" style="display:none;">
    <div class="summary-card" id="capture-area">
        <div class="text-center mb-3">
            <img src="/assets/img/logos/<?= $_ENV['COMPANY_LOGO_MINI_LIGHT'] ?>" height="50" width="212" style="height: 50px; width: 212px; filter: drop-shadow(0 0 5px var(--brand-green));">
        </div>

        <h1 class="orbitron text-success mb-1" style="font-size: 1.5rem;">MISSÃO CUMPRIDA</h1>
        <p class="orbitron text-muted small mb-4" id="summary-workout-name" style="letter-spacing: 2px;"></p>
        <p class="orbitron text-muted small mb-4" id="summary-user-name" style="letter-spacing: 2px;">AGENTE: <?= $_SESSION['user_name']; ?></p>
        
        <div class="row mb-4">
            <div class="col-4 border-end border-dark">
                <span class="d-block text-muted small orbitron">TEMPO</span>
                <span id="summary-time" class="orbitron h4 text-white" style="padding-left: -10px;">00:00</span>
            </div>
            <div class="col-4 border-end border-dark">
                <span class="d-block text-muted small orbitron">CARGA</span>
                <span id="summary-volume" class="orbitron h4 text-white">0 kg</span>
            </div>
            <div class="col-4">
                <span class="d-block text-muted small orbitron">CARDIO</span>
                <span id="summary-minutos" class="orbitron h4 text-white">0 min</span>
            </div>
        </div>

        <div class="mb-4">
            <span class="d-block orbitron text-muted" style="font-size: 0.7rem;">XP TOTAL ADQUIRIDO</span>
            <div class="d-flex align-items-center justify-content-center">
                <span id="total-xp-display" class="orbitron display-2" style="text-shadow: 0 0 20px var(--brand-green); color: #fff;">0</span>
                <span class="orbitron ms-2 text-success" style="font-size: 1.5rem;">XP</span>
            </div>
        </div>

        <div class="d-grid gap-2 no-export px-2"> 
            <button class="btn btn-success btn-lg orbitron" onclick="app.shareProgress()">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-2">
                    <circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/>
                </svg>
                COMPARTILHAR
            </button>
            
            <button class="btn btn-link text-muted orbitron btn-sm mt-2" onclick="location.href='/training/'">
                SAIR DA SESSÃO
            </button>
        </div>
    </div>
</div>
<!-- overlay de finalização de treino -->

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

<!-- scripts -->
<script src="/assets/js/jquery-3.7.1.min.js?<?= $_ENV['APP_VERSAO'] ?>"></script>
<script src="/assets/js/sweetalert2@11.js?<?= $_ENV['APP_VERSAO'] ?>"></script>
<script src="/assets/js/html2canvas.min.js?<?= $_ENV['APP_VERSAO'] ?>"></script>

<!-- custom scripts -->
<script src="/assets/js_app/workout.js?<?= $_ENV['APP_VERSAO'] ?>"></script>

</body>
</html>