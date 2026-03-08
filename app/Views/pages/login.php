<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - <?= $_ENV['COMPANY_NAME'] ?></title>
    

    <link rel="stylesheet" href="/assets/css/tabler.min.css?<?= $_ENV['APP_VERSAO'] ?>">
    <link rel="stylesheet" href="/assets/css/toastr.min.css?<?= $_ENV['APP_VERSAO'] ?>" />
    <link rel="stylesheet" href="/assets/css/fonts-custom.css?<?= $_ENV['APP_VERSAO'] ?>" />

    <link rel="icon" type="image/png" sizes="32x32" href="/assets/img/favicon.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/img/favicon.png">

    <link rel="stylesheet" href="/assets/css_app/login.css?<?= $_ENV['APP_VERSAO'] ?>" />
    
</head>
<body data-bs-theme="dark">
    
    <div id="gamer-loader" class="loader-overlay" style="display: none;">
        <div class="loader-content">
            <div class="scanner-line"></div>
            <div class="mb-3">
                <img src="/assets/img/logos/powerliffe-preta.svg" class="logo-light navbar-brand-image" style="max-width: 200px;">
                <img src="/assets/img/logos/powerliffe-branca.svg" class="logo-dark navbar-brand-image" style="max-width: 200px;">
            </div>
            <div class="glitch-text" style="color: var(--brand-green); font-family: 'Orbitron'; font-size: 12px; letter-spacing: 2px;">
                SINCRONIZANDO DADOS...
            </div>
            <div class="progress-bar-container">
                <div class="progress-bar-fill"></div>
            </div>
            <div class="status-tags">
                <span class="badge">Acesso Autorizado</span>
            </div>
        </div>
    </div>
    
    <div class="neon-aura"></div>

    <div class="theme-toggle">
        <button class="btn btn-icon rounded-circle bg-surface shadow-sm" onclick="toggleTheme()" id="themeBtn"></button>
    </div>

    <div class="page page-center">
        <div class="container container-tight py-4">
            <div class="text-center mb-5 logo-card">
                <div class="">
                  <img src="/assets/img/logos/<?= $_ENV['COMPANY_LOGO_DARK'] ?>" class="logo-light navbar-brand-image" alt="Claro">
                  <img src="/assets/img/logos/<?= $_ENV['COMPANY_LOGO_LIGHT'] ?>" class="logo-dark navbar-brand-image" alt="Escuro">
                </div>
                <p class="text-muted small text-uppercase" style="letter-spacing: 3px;">Portal do Aluno</p>
            </div>
            
            <div class="card card-md login-card">
                
                <div id="card-loader" class="card-loader-overlay d-none">
                    <div class="text-center">
                        <div class="spinner-border text-green mb-2" role="status"></div>
                        <div class="loading-text">VALIDANDO ACESSO...</div>
                    </div>
                </div>

                <div class="card-body py-5">
                    <form autocomplete="off" id="formLogin">
                        <div class="mb-4">
                            <label class="form-label">CPF</label>
                            <input type="text" class="form-control enbdsbcon" placeholder="CPF" name="cpf" id="cpf" inputmode="numeric" autofocus required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Senha</label>
                            <input type="password" class="form-control enbdsbcon" placeholder="••••••••"  name="password" id="password" required>
                        </div>
                        <div class="form-footer mt-5">
                            <button type="submit" class="btn btn-brand w-100 py-3 enbdsbcon">
                                Acessar Portal ➔
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="text-center mt-3 system-version">
              <?= $_ENV['APP_VERSAO'] ?> <span class="ms-1 border-start ps-2">Build <?= $_ENV['APP_BUILD'] ?></span>
            </div>

        </div>
    </div>

    <script src="/assets/js/tabler.min.js?<?= $_ENV['APP_VERSAO'] ?>"></script>
    <script src="/assets/js/jquery-3.7.1.min.js?<?= $_ENV['APP_VERSAO'] ?>" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="/assets/js/toastr.min.js?<?= $_ENV['APP_VERSAO'] ?>"></script>
    <script src="/assets/js/jquery.mask.min.js?<?= $_ENV['APP_VERSAO'] ?>"></script>

    <script src="/assets/js_app/login.js?<?= $_ENV['APP_VERSAO'] ?>"></script>
    <script src="/assets/js_app/theme.js?<?= $_ENV['APP_VERSAO'] ?>"></script>

</body>
</html>