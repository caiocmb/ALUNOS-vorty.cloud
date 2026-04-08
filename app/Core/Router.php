<?php
namespace App\Core;

class Router {
    public static function dispatch() {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = trim($uri, '/');

        $parts = explode('/', $uri);

        // 🔥 NOVA LÓGICA
        $controller = ucfirst($parts[0] ?? 'home');



        $class = "App\\Controllers\\{$controller}Controller";

        if (!class_exists($class)) {
            http_response_code(404);
            header('Location: /home/');
            exit;
        }

        $obj = new $class;

         if (isset($parts[1]) &&  method_exists($obj, $parts[1])) {
            $action = $parts[1];
            $params = array_slice($parts, 2);
        } else {
            $action = 'index';
            $params = array_slice($parts, 1);
        }

        if (!method_exists($obj, $action)) {
            http_response_code(404);
            exit('Método não encontrado');
        }

        // 🔥 importante: passar parâmetros
        call_user_func_array([$obj, $action], $params);
    }
}
