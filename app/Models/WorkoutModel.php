<?php 
namespace App\Models;

use App\Services\ApiServices;

class WorkoutModel 
{
    public $apiService;

    public function __construct()
    {
        $this->apiService = new ApiServices();
    }

    public function GetActiveWorkout($id)
    {       
        // chama a rota da API 
        return $this->apiService->exec("GET", "/workout/active_workout/".$id);
    }

    public function GetExerciseHistory($id)
    {
        // chama a rota da API 
        return $this->apiService->exec("GET", "/workout/exercise_history/".$id,$_GET);
    }

    public function GetTodaySets($id)
    {
        // chama a rota da API 
        return $this->apiService->exec("GET", "/workout/today_sets/".$id,$_GET);
    }

    public function AddSet($id)
    {
        // chama a rota da API 
        return $this->apiService->exec("POST", "/workout/add_set/".$id,$_POST);
    }

    public function SaveSet($id)
    {
        // chama a rota da API 
        return $this->apiService->exec("PUT", "/workout/save_set/".$id,$_POST);
    }    

    public function UncheckSet($id)
    {
        // chama a rota da API 
        return $this->apiService->exec("PUT", "/workout/uncheck_set/".$id,$_POST);
    }

    public function DeleteSet($id)
    {
        // chama a rota da API 
        return $this->apiService->exec("DELETE", "/workout/delete_set/".$id,$_POST);
    }

    public function FinishWorkout($id)
    {
        // chama a rota da API 
        return $this->apiService->exec("POST", "/workout/finish_workout/".$id);
    }

}

?>