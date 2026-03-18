<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\ProfileModel;
use App\Middleware\Authenticator;

class ProfileController extends Controller {

    public $model;

    public function __construct() {
        Authenticator::handle();
        $this->model = new ProfileModel;
    }

    public function index() {        
        $this->view('profile', []);
    }

   public function updateprofile() {
        if (empty($_POST['user_name'])) {
            $this->json(['status' => 'error', 'message' => 'O nome é obrigatório.']);
            return;
        }

        $userId = $_SESSION['user_id'];
        $storagePath = realpath(__DIR__ . '/../../storage/profile/') . DIRECTORY_SEPARATOR;
        
        // Guardamos o estado anterior para caso precise dar rollback
        $fotoAntigaSessao = $_SESSION['user_photo'];
        $novaFotoSubiu = false;
        $nomeArquivoFinal = $fotoAntigaSessao;

        // 1. Processamento da Imagem
        if (isset($_FILES['user_photo']) && $_FILES['user_photo']['error'] === UPLOAD_ERR_OK) {
            $file = $_FILES['user_photo'];
            $tmpPath = $file['tmp_name'];
            
            $info = getimagesize($tmpPath);
            if (!$info) {
                $this->json(['status' => 'error', 'message' => 'Arquivo inválido.']);
                return;
            }

            $img = match($info['mime']) {
                'image/jpeg' => imagecreatefromjpeg($tmpPath),
                'image/png'  => imagecreatefrompng($tmpPath),
                'image/webp' => imagecreatefromwebp($tmpPath),
                default      => null,
            };

            if (!$img) {
                $this->json(['status' => 'error', 'message' => 'Formato não suportado.']);
                return;
            }

            // --- NOVO: Lógica de Redimensionamento ---
            $larguraMaxima = 400; // Define o tamanho ideal para perfil
            $larguraOriginal = imagesx($img);
            $alturaOriginal = imagesy($img);

            // Só redimensiona se a foto for maior que o limite
            if ($larguraOriginal > $larguraMaxima) {
                // imagescale calcula a altura proporcional automaticamente
                $imgRedimensionada = imagescale($img, $larguraMaxima);
                if ($imgRedimensionada !== false) {
                    // No PHP 8+, não precisamos de imagedestroy, 
                    // basta substituir o objeto para liberar memória do original
                    $img = $imgRedimensionada; 
                }
            }
            // -----------------------------------------

            $novoNome = "profile_" . $userId . "_" . time() . ".webp";
            $destinoCompleto = $storagePath . $novoNome;

            imagepalettetotruecolor($img);
            imagealphablending($img, true);
            imagesavealpha($img, true);

            if (imagewebp($img, $destinoCompleto, 80)) {
                $nomeArquivoFinal = $novoNome;
                $novaFotoSubiu = true;
            } else {
                $this->json(['status' => 'error', 'message' => 'Falha ao salvar imagem.']);
                return;
            }
        }

        // 2. Chamada da API
        $nomeSanitizado = strip_tags($_POST['user_name']);
        $retorno = $this->model->profile([
            'user_name' => $nomeSanitizado,
            'photo' => $nomeArquivoFinal
        ]);

        // 3. Verificação de Sucesso da API
        if (isset($retorno['status']) && $retorno['status'] == 'success') {
            
            // SÓ AGORA apagamos a foto antiga de verdade, pois a nova já está garantida no DB
            if ($novaFotoSubiu && $fotoAntigaSessao !== 'no_picture.webp' && $fotoAntigaSessao !== $nomeArquivoFinal) {
                $caminhoAntigo = $storagePath . $fotoAntigaSessao;
                if (file_exists($caminhoAntigo)) { @unlink($caminhoAntigo); }
            }

            // Atualiza a sessão
            $_SESSION['user_name'] = $nomeSanitizado;
            $_SESSION['user_photo'] = $nomeArquivoFinal;

            $this->json($retorno);
        } else {
            // --- ROLLBACK FÍSICO ---
            // Se a API deu erro mas tínhamos subido uma foto nova, apagamos a nova 
            // para não deixar lixo no servidor, já que ela não foi registrada no DB.
            if ($novaFotoSubiu) {
                $caminhoFalho = $storagePath . $nomeArquivoFinal;
                if (file_exists($caminhoFalho)) { @unlink($caminhoFalho); }
            }

            // Retorna o erro da API (ou erro genérico)
            $msg = $retorno['message'] ?? 'Erro ao sincronizar dados com o servidor.';
            $this->json(['status' => 'error', 'message' => $msg]);
        }
    }

    public function updatepassword() {
        // Validação de senhas
        if (empty($_POST['current_password']) || empty($_POST['new_password'])) {
            $this->json(['status' => 'error', 'message' => 'Preencha todos os campos de senha.']);
            return;
        }

        $retorno = $this->model->password($_POST);
        $this->json($retorno);
    }
    
}
