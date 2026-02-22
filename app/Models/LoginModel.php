<?php 
namespace App\Models;

class LoginModel 
{
    public function login($dados)
    {
        global $_ENV;

        $data = [
            'cpf' => $dados['cpf'],
            'password' => $dados['password'],
            'company' => '48685431000165',
            'application' => 'alunos'
        ];

        $urlFinal = $_ENV['API_URL']."/login/";

        $curl = curl_init();

        curl_setopt_array($curl, [
        CURLOPT_URL => $urlFinal,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => [
            "Content-Type: application/json",
            "User-Agent: AppAlunos/".$_ENV['APP_VERSAO']
        ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return [
                'status' => 'Erro ao acessar API',
                'message' => $err
            ];
        } else {
            return $response;
        }

    }

}

?>