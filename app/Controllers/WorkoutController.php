<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\WorkoutModel;
use App\Middleware\Authenticator;

class WorkoutController extends Controller {

    public $model,$listar;

    public function __construct() {
        Authenticator::handle();
        $this->model = new WorkoutModel;
    }

    public function index() { 
        $listar = $this->model->ListTraining();       
        $this->view('training', ['listar' => $listar]);
    }
    
}
