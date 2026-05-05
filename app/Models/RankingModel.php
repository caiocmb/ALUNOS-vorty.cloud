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

    public function CheckConnection()
    {
        return $this->apiService->exec("GET", "/ranking/check_connection/");
    }

    public function ConnectFriend($campos)
    {
        return $this->apiService->exec("POST", "/ranking/", $campos);
    }

}

?>