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
        $this->view('workout', [], false,true);
    }

    public function api($id = null) {
        $action = $_REQUEST['action'] ?? '';

        switch ($action) {
            // lista o treino do dia
            case 'get_active_workout':
                $data = $this->model->GetActiveWorkout($id);
                if (isset($data['status']) && $data['status'] == 'error') {
                    return $this->json(['success' => false, 'message' => $data['message']], 500);
                }
                return $this->json($data['data']);
                break;
            // busca o historico de cada exercicio    
            case 'get_exercise_history':
                $data = $this->model->GetExerciseHistory($id);
                if (isset($data['status']) && $data['status'] == 'error') {
                    return $this->json(['success' => false, 'message' => $data['message']], 500);
                }
                return $this->json($data['data']);
                break;
            // busca o que foi feito no treino de hoje para cada exercicio
            case 'get_today_sets':
                $data = $this->model->GetTodaySets($id);
                if (isset($data['status']) && $data['status'] == 'error') {
                    return $this->json(['success' => false, 'message' => $data['message']], 500);
                }
                return $this->json($data['data']);
                break;
            // grava as series feitas no treino
            case 'save_set':
                $data = $this->model->SaveSet($id);
                if (isset($data['status']) && $data['status'] == 'error') {
                    return $this->json(['success' => false, 'message' => $data['message']], 500);
                }
                return $this->json($data['data']);
                break;
            // quando adiciona uma nova serie em branco, replica no banco para ser espelho da aplicação
            case 'add_set':
                // aqui tem que ser um post para criar a serie e pegar o id dela, para depois atualizar com peso e reps
                $data = $this->model->AddSet($id);
                if (isset($data['status']) && $data['status'] == 'error') {
                    return $this->json(['success' => false, 'message' => $data['message']], 500);
                }
                return $this->json($data['data']);
                break;
            case 'uncheck_set':
                // aqui tem que ser um post para criar a serie e pegar o id dela, para depois atualizar com peso e reps
                $data = $this->model->UncheckSet($id);
                if (isset($data['status']) && $data['status'] == 'error') {
                    return $this->json(['success' => false, 'message' => $data['message']], 500);
                }
                return $this->json($data['data']);
                break;
            case 'delete_set':
                // aqui tem que ser um post para criar a serie e pegar o id dela, para depois atualizar com peso e reps
                $data = $this->model->DeleteSet($id);
                if (isset($data['status']) && $data['status'] == 'error') {
                    return $this->json(['success' => false, 'message' => $data['message']], 500);
                }
                return $this->json($data['data']);
                break;
            case 'finish_workout':
                // aqui tem que ser um post para criar a serie e pegar o id dela, para depois atualizar com peso e reps
                $data = $this->model->FinishWorkout($id);
                if (isset($data['status']) && $data['status'] == 'error') {
                    return $this->json(['success' => false, 'message' => $data['message']], 500);
                }
                return $this->json($data['data']);
                break;
           /* case 'save_set':
                return $this->saveSet();

            case 'delete_set':
                return $this->deleteSet();

            case 'finish_workout':
                return $this->finishWorkout();*/

            default:
                return $this->json(['success' => false, 'message' => 'Ação inválida'], 400);
        }
    }


    /*
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
            101 => [['peso' => '200', 'und' => 'kg', 'reps' => '12'], ['peso' => '20', 'und' => 'kg', 'reps' => '12']],
            102 => [['peso' => '40', 'und' => 'kg', 'reps' => '10'], ['peso' => '42', 'und' => 'kg', 'reps' => '8']],
            103 => [['peso' => '32', 'und' => 'min', 'reps' => '1']]
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
                        [
                            'id' => 101, 
                            'nome' => "Stiff Unilateral", 
                            'protocolo' => "3x 12", 
                            'xp' => 10, 
                            'rest' => 45, 
                            'und' => 'kg',
                            'img' => 'https://gym.vorty.cloud/dist/img/exercises/678a90bce8d69.webp'
                        ],
                        [
                            'id' => 102, 
                            'nome' => "Mesa Flexora", 
                            'protocolo' => "4x 10", 
                            'xp' => 10, 
                            'rest' => 60, 
                            'und' => 'kg',
                            'img' => 'https://gym.vorty.cloud/dist/img/exercises/678a94ac0f573.webp'
                        ],
                        [
                            'id' => 103, 
                            'nome' => "Esteira", 
                            'protocolo' => "5x", 
                            'xp' => 2, 
                            'rest' => 60, 
                            'und' => 'min',
                            'img' => null
                        ]
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
                    'reps' => $_POST['reps'],
                    'und' => 'min' // aqui vou pegar do banco depois pra tratar no backend, por enquanto é fixo
                ];

                if (!$ja_pontuou) {
                    $storage['usuario_xp'] = ($storage['usuario_xp'] ?? 0) + $xp_exercicio;
                }

                saveStorage($storage);

                $this->json([
                    'success' => true, 
                    'novo_xp' => $storage['usuario_xp'],
                    'rest' => 45
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
                // 1. Calculamos os dados finais antes de limpar o storage
                $tonelagemTotal = 0;
                $minutosTotal = 0;
                $totalExercicios = 0;

                if (isset($storage['sets']) && is_array($storage['sets'])) {
                    foreach ($storage['sets'] as $ex_id => $series) {
                        if (!empty($series)) $totalExercicios++;
                        foreach ($series as $serie) {
                            $p = (float)($serie['peso'] ?? 0);
                            $r = (int)($serie['reps'] ?? 0);
                            if($serie['und'] == 'min') {
                                $minutosTotal += ($p * $r); // aqui o peso é na verdade os minutos
                            } else {
                                $tonelagemTotal += ($p * $r);
                            }
                        }
                    }
                }

                // 2. Preparamos o objeto de resposta para o compartilhamento
                $resumo = [
                    "nome_treino" => "TREINO A - POSTERIOR E GLÚTEO A", // Nome que vem do get_active_workout
                    "tempo"       => substr($_POST['tempo'], 0, 5) ?? '00:00',
                    "tonelagem"   => number_format($tonelagemTotal, 0, ',', '.'),
                    "minutos"   => number_format($minutosTotal, 0, ',', '.'),
                    "xp_final"    => $storage['usuario_xp'] ?? 0,
                    "usuario"     => "CAIO A", // Aqui você pode pegar da sua Session se tiver
                    "exercicios_concluidos" => $totalExercicios
                ];

                // 3. Persistência Final (Opcional)
                // Se você quiser que o XP acumule para o próximo treino, 
                // em vez de unlink, você faria:
                // $storage['sets'] = []; 
                // $storage['start_time'] = date('Y-m-d H:i:s');
                // saveStorage($storage);
                
                // Se preferir resetar tudo para o próximo teste:
                if (file_exists($storageFile)) unlink($storageFile);

                // 4. Retorno para o JavaScript
                $this->json([
                    'success' => true,
                    'resumo'  => $resumo
                ]);
                break;

            default:
                $this->json(['success' => false, 'message' => 'Action desconhecida']);
                break;
        }
    }

    */
    
}
