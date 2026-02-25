<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\HomeModel;
use App\Middleware\Authenticator;

class ProfileController extends Controller {

    public $model;

    public function __construct() {
        Authenticator::handle();
        $this->model = new HomeModel;
    }

    public function index() {        
        $this->view('profile', []);
    }
    
}
