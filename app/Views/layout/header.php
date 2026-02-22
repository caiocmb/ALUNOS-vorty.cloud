<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Power Liffe - Portal do Aluno</title>
    
    <!-- CSS files -->
    <link rel="stylesheet" href="/assets/css/tabler.min.css?<?= $_ENV['APP_VERSAO'] ?>">
    <link rel="stylesheet" href="/assets/css/toastr.min.css?<?= $_ENV['APP_VERSAO'] ?>" />
    <link rel="stylesheet" href="/assets/css/fonts-custom.css?<?= $_ENV['APP_VERSAO'] ?>" />
    <link rel="stylesheet" href="/assets/css/driver.css?<?= $_ENV['APP_VERSAO'] ?>" />

    <link rel="icon" type="image/png" href="<?= $_ENV['APP_URL']; ?>/assets/img/favicon.png">  
    <?php 
      $cssPath = __DIR__ . '/../../../public/assets/css_app/';
      if(isset($css_config))
      {
        foreach ($css_config as $file) {
            if (file_exists($cssPath . $file)) {
                echo '<link href="/assets/css_app/' . $file . '?'.$_ENV['APP_VERSAO'].'" rel="stylesheet">' . PHP_EOL .'    ';
            }
        }
      }
    ?>
</head>
<body data-bs-theme="dark">
    <div class="page">
        <header class="navbar navbar-expand-md d-print-none">
            <div class="container-xl">
                <h1 class="navbar-brand ">
                    <a href="/home/">
                        <img src="/assets/img/logos/powerliffe-preta.svg" alt="Power Liffe" class="navbar-brand-image logo-light">                        
                        <img src="/assets/img/logos/powerliffe-branca.svg" alt="Power Liffe" class="navbar-brand-image logo-dark">
                    </a>
                </h1>
                <div class="navbar-nav flex-row order-md-last">
                    <div class="nav-item">                    
                        <button class="btn btn-icon rounded-circle bg-surface shadow-sm nav-link px-2" onclick="toggleTheme()" id="themeBtn"></button>
                    </div>
                </div>
            </div>
        </header>

        <div class="page-wrapper">
            <div class="page-body">
                <div class="container-xl">