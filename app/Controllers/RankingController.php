<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\RankingModel;
use App\Middleware\Authenticator;

class RankingController extends Controller {

    public $model;

    public function __construct() {
        Authenticator::handle();
        $this->model = new RankingModel;
    }

    public function index() {        
        $this->view('ranking', ['rankings' => $this->model->ListRanking()]);
    }

    public function checkconn(){
        $this->json($this->model->CheckConnection());
    }

    public function connect(){
        $this->json($this->model->ConnectFriend($_POST['codigo'] ?? null));
    }
    
}
