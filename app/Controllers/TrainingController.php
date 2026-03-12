<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\TrainingModel;
use App\Middleware\Authenticator;

class TrainingController extends Controller {

    public $model,$listar;

    public function __construct() {
        Authenticator::handle();
        $this->model = new TrainingModel;
    }

    public function index() { 
        $listar = $this->model->ListTraining();       
        $this->view('training', ['listar' => $listar]);
    }

    
}
