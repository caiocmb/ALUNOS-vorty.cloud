<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\TrainingModel;
use App\Middleware\Authenticator;

class TrainingController extends Controller {

    public $model;

    public function __construct() {
        Authenticator::handle();
        $this->model = new TrainingModel;
    }

    public function index() {        
        $this->view('training', []);
    }

    
}
