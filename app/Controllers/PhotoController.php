<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Middleware\Authenticator;

class PhotoController extends Controller {

    public function __construct() {
        Authenticator::handle();

    }

    public function profile() {
        // Configurações
        $pasta_segura = __DIR__.'/../../storage/';

        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = trim($uri, '/');

        $parts = explode('/', $uri);

        if(!isset($parts[2]) or empty($parts[2]) or !isset($parts[1]) or empty($parts[1]))
        {
            header("HTTP/1.1 404 Not Found");
            exit("Informe o ID da foto");
        }

        // O arquivo agora é obrigatoriamente .webp
        $arquivo = $pasta_segura . $parts[1] . '/'. $parts[2];
        $caminho_final = realpath($arquivo);

        // Validação: existe e está dentro da pasta permitida?
        if ($caminho_final && strpos($caminho_final, realpath($pasta_segura)) === 0 && file_exists($caminho_final)) {
            
            ob_clean(); // Limpa lixo de memória para não corromper o binário
            
            header('Content-Type: image/webp');
            header('Content-Length: ' . filesize($caminho_final));
            header('Cache-Control: public, max-age=86400'); // Cache de 1 dia para o navegador
            
            readfile($caminho_final);
            exit;
        } else {
            // Se não achar a foto, pode retornar uma imagem padrão "sem-foto.webp"
            header("HTTP/1.1 404 Not Found");
            exit("Foto não encontrada.");
        }
    }
    
}
