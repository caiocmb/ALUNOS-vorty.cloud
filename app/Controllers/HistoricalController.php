<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\HistoricalModel;
use App\Middleware\Authenticator;

class HistoricalController extends Controller {

    public $model;

    public function __construct() {
        Authenticator::handle();
        $this->model = new HistoricalModel;
    }

    public function index() {        
        $this->view('historical', ['resumo'=>$this->model->ListHistorical()]);
    }
    
}
