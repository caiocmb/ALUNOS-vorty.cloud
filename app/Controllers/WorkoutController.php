<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\WorkoutModel;
use App\Middleware\Authenticator;

class WorkoutController extends Controller {

    public $model,$listar;

    public function __construct() {
        Authenticator::handle();
        $this->model = new WorkoutModel;
    }

    public function index() { 
        $listar = $this->model->ListTraining();       
        $this->view('workout', ['listar' => $listar],false,true);
    }

    public function api() {

        $action = $_REQUEST['action'] ?? '';
        $storageFile = __DIR__.'/teste/storage.json';

        // Lógica de Persistência ajustada
        function getStorage() {
            $storageFile = __DIR__.'/teste/storage.json';

            if (!is_string($storageFile) || $storageFile === '' || !file_exists($storageFile)) {
                // Inicializa o arquivo com valores padrão caso não exista
                return [
                    'sets' => [], 
                    'start_time' => date('Y-m-d H:i:s'), 
                    'usuario_xp' => 0 // Inicia com 0 ou o valor base do banco
                ];
            }
            return json_decode(file_get_contents($storageFile), true);
        }

   
     
        

        function saveStorage($data) {
            $storageFile = __DIR__.'/teste/storage.json';
            file_put_contents($storageFile, json_encode($data, JSON_PRETTY_PRINT));
        }

        $storage = getStorage();

        // MOCK de Histórico Anterior
        $mockHistoricoDB = [
            101 => [['peso' => '200', 'reps' => '12'], ['peso' => '20', 'reps' => '12']],
            102 => [['peso' => '40', 'reps' => '10'], ['peso' => '42', 'reps' => '8']]
        ];

        switch ($action) {
            case 'get_active_workout':
                // Garantimos que o XP do storage seja respeitado
                // Se o storage acabou de ser criado, saveStorage para persistir o estado inicial
                if (!file_exists($storageFile)) {
                    saveStorage($storage);
                }

                $this->json([
                    'id_treino' => 42,
                    'nome' => "TREINO A - POSTERIOR E GLÚTEO",
                    'data_inicio' => $storage['start_time'], 
                    'usuario_xp' => $storage['usuario_xp'], // PUXA DO JSON
                    'exercicios' => [
                        ['id' => 101, 'nome' => "Stiff Unilateral", 'protocolo' => "3x 12", 'xp' => 10],
                        ['id' => 102, 'nome' => "Mesa Flexora", 'protocolo' => "4x 10", 'xp' => 10]
                    ]
                ]);
                break;

            case 'get_exercise_history':
                $ex_id = $_REQUEST['ex_id'] ?? 0;
                $this->json([
                    'history' => $mockHistoricoDB[$ex_id] ?? []
                ]);
                break;

            case 'get_today_sets':
                $ex_id = $_REQUEST['ex_id'] ?? 0;
                $sets = $storage['sets'][$ex_id] ?? [];
                $this->json(['sets' => $sets]);
                break;

            case 'save_set':
                $ex_id = $_POST['ex_id'];
                $xp_exercicio = (int)$_POST['xp_valor'];

                $ja_pontuou = !empty($storage['sets'][$ex_id]);

                $storage['sets'][$ex_id][] = [
                    'peso' => $_POST['peso'],
                    'reps' => $_POST['reps']
                ];

                if (!$ja_pontuou) {
                    $storage['usuario_xp'] = ($storage['usuario_xp'] ?? 0) + $xp_exercicio;
                }

                saveStorage($storage);

                $this->json([
                    'success' => true, 
                    'novo_xp' => $storage['usuario_xp']
                ]);
                break;

            case 'delete_set':
                $ex_id = $_POST['ex_id'];
                $xp_exercicio = (int)$_POST['xp_valor'];
                $indice = (int)$_POST['serie'] - 1;

                if (isset($storage['sets'][$ex_id][$indice])) {
                    array_splice($storage['sets'][$ex_id], $indice, 1);

                    if (empty($storage['sets'][$ex_id])) {
                        $storage['usuario_xp'] -= $xp_exercicio;
                        if ($storage['usuario_xp'] < 0) $storage['usuario_xp'] = 0;
                    }
                    saveStorage($storage);
                }

                $this->json([
                    'success' => true, 
                    'novo_xp' => $storage['usuario_xp']
                ]);
                break;

            case 'finish_workout':
                // No finish, você pode optar por deletar o arquivo ou apenas limpar os sets
                // Se deletar o arquivo, o XP volta a 0 no próximo treino (conforme getStorage)
                // Se quiser manter o XP acumulado, apenas limpe ['sets'] e ['start_time']
                if (file_exists($storageFile)) unlink($storageFile);
                $this->json(['success' => true]);
                break;

            default:
                $this->json(['success' => false, 'message' => 'Action desconhecida']);
                break;
        }
    }
    
}
