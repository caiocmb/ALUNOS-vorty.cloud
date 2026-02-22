<?php
namespace App\Core;

class Controller {
    protected function view($page, $data = [], $header = true, $footer = true) {
        extract($data);
        $configFile = __DIR__ . '/../Views/configs/' . $page . 'Config.php';

        if (file_exists($configFile)) {
            require $configFile;
        }
        if($header){ require __DIR__ . '/../Views/layout/header.php'; }
        require __DIR__ . '/../Views/pages/' . $page . '.php';
        if($footer){ require __DIR__ . '/../Views/layout/footer.php'; }
    }

    protected function partial($file, $data = []) {
        extract($data);
        require __DIR__ . '/../Views/partials/' . $file . '.php';
    }

    protected function json($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}
