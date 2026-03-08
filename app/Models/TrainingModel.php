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

    public function profile($campos)
    {
        // chama a rota da API 
        return $this->apiService->exec("POST", "/profile/", $campos);
    }

    public function password($campos)
    {
        // chama a rota da API 
        return $this->apiService->exec("PUT", "/profile/", $campos);
    }

}

?>