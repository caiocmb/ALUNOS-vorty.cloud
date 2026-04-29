<?php 
namespace App\Models;

use App\Services\ApiServices;

class RankingModel 
{
    public $apiService;

    public function __construct()
    {
        $this->apiService = new ApiServices();
    }

    public function ListRanking()
    {
        // chama a rota da API 
        return $this->apiService->exec("GET", "/ranking/");
    }

}

?>