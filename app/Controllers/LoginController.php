<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\LoginModel;


class LoginController extends Controller {

    public $model;

    public function __construct() {
        $this->model = new LoginModel;
 
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function index() {
        $this->view('login', [], false, false);
    }
    
    public function logar() {
        
        if(!isset($_POST) OR empty($_POST))
        {
            $this->json(['status'=>'error','message'=>'Os dados devem ser enviados via POST']);
            exit;
        }

        if(!isset($_POST['cpf']) OR empty(trim($_POST['cpf'])))
        {
            $this->json(['status'=>'error','message'=>'O campo CPF deve ser informado']);
            exit;
        }

        if(!isset($_POST['password']) OR empty(trim($_POST['password'])))
        {
            $this->json(['status'=>'error','message'=>'O campo SENHA deve ser informado']);
            exit;
        }

        $data = json_decode($this->model->login($_POST));

        if($data->status <> 'success')
        {
            $this->json($data);
            exit;
        }

        //grava as sessões necessarias       
        $_SESSION['user_id'] = $data->data->uid;
        $_SESSION['user_name'] = $data->data->name;
        $_SESSION['user_token'] = $data->data->token;

        $this->json($data);
        exit;
    }

    
}
