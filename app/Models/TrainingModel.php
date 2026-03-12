<?php 
namespace App\Models;

use App\Services\ApiServices;

class TrainingModel 
{
    public $apiService;

    public function __construct()
    {
        $this->apiService = new ApiServices();
    }

    public function ListTraining()
    {
        // chama a rota da API 
        return $this->apiService->exec("GET", "/training/");
    }

}

?>