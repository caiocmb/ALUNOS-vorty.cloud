<?php
namespace App\Middleware;

class Authenticator {
    public static function handle() {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if (!isset($_SESSION['user_id']) or !isset($_SESSION['user_token']) or !isset($_SESSION['user_name'])) 
        {       
            header("Location: /login/");
            exit;
        }
    }
}