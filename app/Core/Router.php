<?php
namespace App\Core;

class Router {
    public static function dispatch() {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = trim($uri, '/');

        $parts = explode('/', $uri);

        $controller = ucfirst($parts[0] ?? 'home');
        $action     = $parts[1] ?? 'index';

        $class = "App\\Controllers\\{$controller}Controller";
        
        if (!class_exists($class)) {
            //http_response_code(404);
            //exit('Controller não encontrado');
            header('Location: /home');
            exit;
        }

        $obj = new $class;

        if (!method_exists($obj, $action)) {
            http_response_code(404);
            exit('Método não encontrado');
        }

        $obj->$action();
    }
}
