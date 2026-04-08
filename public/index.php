<?php
require __DIR__ . '/../vendor/autoload.php';

use App\Core\Env;
use App\Core\Router;

$dominio_atual = $_SERVER['HTTP_HOST'];

$config_file = __DIR__ . '/../companies/'.$dominio_atual.'.cfg';

if (!file_exists($config_file)) {
    // Define o código de erro HTTP (opcional, mas recomendado)
    http_response_code(404);
    
    // Imprime a mensagem solicitada e para a execução
    ?>
    <!DOCTYPE html>
    <html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Domínio Inválido</title>
        <style>
            body { font-family: sans-serif; background: #f4f7f6; display: flex; align-items: center; justify-content: center; height: 100vh; margin: 0; }
            .card { background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); border-top: 5px solid #1f53e0ff; text-align: center; max-width: 400px; }
            h1 { color: #2c3e50; font-size: 1.5rem; margin-bottom: 1rem; }
            p { color: #7f8c8d; line-height: 1.5; }
            .icon { font-size: 3rem; color: #1f53e0ff; margin-bottom: 10px; }
        </style>
    </head>
    <body>
        <div class="card">
            <div class="icon">⚠️</div>
            <h1>Acesso Restrito</h1>
            <p>É necessário acessar com um <strong>domínio válido!</strong></p>
        </div>
    </body>
    </html>
    <?php
    exit;
}

Env::load(__DIR__ . '/../.env'); // carrega as variaveis do sistema
Env::load($config_file); // carrega as variaveis da academia

if($_ENV['APP_DEBUG'] === 'true') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
}

// define o timezone para evitar erros relacionados a data/hora
date_default_timezone_set('America/Sao_Paulo');

Router::dispatch();
