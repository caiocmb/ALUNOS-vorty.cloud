<?php
namespace App\Controllers;

use App\Core\Controller;

class LogoutController extends Controller {

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function index() {
        $_SESSION = [];
        session_destroy();

        // redireciona para login
        header('Location: /home/');
        exit;
    }
    
    
}
