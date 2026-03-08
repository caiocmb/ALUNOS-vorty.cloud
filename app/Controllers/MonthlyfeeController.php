<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\MonthlyfeeModel;
use App\Middleware\Authenticator;

class MonthlyfeeController extends Controller {

    public $model;

    public function __construct() {
        Authenticator::handle();
        $this->model = new MonthlyfeeModel;
    }

    public function index() {       
        $mensalidades = $this->model->mensalidades(); 

        $this->view('monthlyfee', ['mensalidades' => $mensalidades]);
    }
    
}
