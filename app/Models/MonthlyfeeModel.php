<?php 
namespace App\Models;

use App\Services\ApiServices;

class MonthlyfeeModel 
{
    public $apiService;

    public function __construct()
    {
        $this->apiService = new ApiServices();
    }

    public function mensalidades()
    {
        // chama a rota da API 
        return $this->apiService->exec("GET", "/monthlyfee/");
    }

}

?>