<?php 

namespace App\Services;

class ApiServices {

    private $baseUrl;

    public function __construct() {
        $this->baseUrl = $_ENV['API_URL'];
        if (session_status() === PHP_SESSION_NONE) session_start();
    }

    /**
     * O Único método público que as outras classes vão usar
     */
    public function exec($method, $endpoint, $body = null)
    {
        return $this->request($method, $endpoint, $body);
    }

    private function request($method, $endpoint, $body = null) {
        $curl = curl_init();
        $token = $_SESSION['user_token'] ?? '';

        $options = [
            CURLOPT_URL => $this->baseUrl . $endpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => strtoupper($method),
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer " . $token,
                "Content-Type: application/json",
                "User-Agent: AppAlunos/".$_ENV['APP_VERSAO']
            ],
        ];

        if ($body) {
            $options[CURLOPT_POSTFIELDS] = json_encode($body);
        }

        curl_setopt_array($curl, $options);
        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        $data = json_decode($response, true);

        // Interceptador de Expiração
        if ($httpCode === 401 || (isset($data['message']) && strpos($data['message'], 'Expired token') !== false)) {
            if ($this->refreshToken()) {
                // Tenta novamente com o novo token que agora está na $_SESSION
                return $this->request($method, $endpoint, $body);
            } else {
                $this->logout();
            }
        }

        return $data;
    }

    private function refreshToken() {
        $refreshToken = $_SESSION['refresh_token'] ?? null;
        if (!$refreshToken) return false;

        $dados = [
            "refresh_token" => $refreshToken,
            "company" => $_ENV['COMPANY_CNPJ'],
            "uid" => $_SESSION['user_id'],
            "application" => $_ENV['APP_APPLICATION']
        ];

        $ch = curl_init($this->baseUrl . "/refresh");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($dados));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
            "User-Agent: AppAlunos/".$_ENV['APP_VERSAO']
        ]);

        $res = curl_exec($ch);
        $data = json_decode($res, true);
        curl_close($ch);

        if (isset($data['data']['token'])) {
            $_SESSION['user_token'] = $data['data']['token'];
            $_SESSION['user_id'] = $data['data']['uid'];
            $_SESSION['user_name'] = ($data['data']['social_name']) ?? (strtok($data['data']['name'], " "));
            $_SESSION['user_status'] = $data['data']['status'];
            $_SESSION['user_photo'] = $data['data']['photo'];
            $_SESSION['user_token'] = $data['data']['token'];
            $_SESSION['refresh_token'] = $data['data']['refresh_token'];

            return true;
        }
        return false;
    }

    private function logout() {
        session_destroy();
        header("Location: /login?error=expired");
        exit;
    }
}