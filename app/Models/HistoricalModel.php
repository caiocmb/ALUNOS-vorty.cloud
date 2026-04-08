<?php 
namespace App\Models;

use App\Services\ApiServices;

class HistoricalModel 
{
    public $apiService;

    public function __construct()
    {
        $this->apiService = new ApiServices();
    }

    public function ListHistorical()
    {
        // chama a rota da API 
        return $this->apiService->exec("GET", "/historical/");
    }

}

?>