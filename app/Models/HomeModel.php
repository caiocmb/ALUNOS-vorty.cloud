<?php 
namespace App\Models;

class HomeModel 
{
    public function informativos()
    {
        global $_ENV;
        $curl = curl_init();

        curl_setopt_array($curl, [
        CURLOPT_URL => $_ENV['API_URL']."/intranet_informativos/",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_POSTFIELDS => "",
        CURLOPT_HTTPHEADER => [
            "authorization: ". $_ENV['API_KEY'],
            "username: ". $_ENV['API_USER']
        ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            return $response;
        }
    }

    public function pegaCotacao($moeda = '')
    {
        global $_ENV;
        $curl = curl_init();

        curl_setopt_array($curl, [
        CURLOPT_URL => $_ENV['API_URL']."/intranet_cotacao/".$moeda,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_POSTFIELDS => "",
        CURLOPT_HTTPHEADER => [
            "authorization: ". $_ENV['API_KEY'],
            "username: ". $_ENV['API_USER']
        ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            return $response;
        }
    }

    public function pegaMoeda()
    {
        global $_ENV;
        $curl = curl_init();

        curl_setopt_array($curl, [
        CURLOPT_URL => $_ENV['API_URL']."/intranet_moeda/",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_POSTFIELDS => "",
        CURLOPT_HTTPHEADER => [
            "authorization: ". $_ENV['API_KEY'],
            "username: ". $_ENV['API_USER']
        ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            return $response;
        }
    }

    public function aniversariantes()
    {
        global $_ENV;
        $curl = curl_init();

        curl_setopt_array($curl, [
        CURLOPT_URL => $_ENV['API_URL']."/intranet_aniversarios/",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_POSTFIELDS => "",
        CURLOPT_HTTPHEADER => [
            "authorization: ". $_ENV['API_KEY'],
            "username: ". $_ENV['API_USER']
        ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            return $response;
        }

        exit();
    }

    public function registerLike($dados)
    {
        global $_ENV;

        $payload = [
            'nome' => $dados['nome'],
            'filial' => $dados['filial'],
            'data_aniversario' => $dados['data_aniversario']
        ];

        $curl = curl_init();

        curl_setopt_array($curl, [
        CURLOPT_URL => $_ENV['API_URL']."/intranet_aniversarios",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode($payload),
        CURLOPT_HTTPHEADER => [
            "Content-Type: application/json",
            "authorization: ". $_ENV['API_KEY'],
            "username: ". $_ENV['API_USER']
        ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            return $response;
        }

        exit();
    }

    public function pegaCardapio($filial = '',$data = '')
    {
        global $_ENV;
        $curl = curl_init();

        curl_setopt_array($curl, [
        CURLOPT_URL => $_ENV['API_URL']."/intranet_cardapio/".$filial."/".$data,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_POSTFIELDS => "",
        CURLOPT_HTTPHEADER => [
            "authorization: ". $_ENV['API_KEY'],
            "username: ". $_ENV['API_USER']
        ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            return $response;
        }
    }
}

?>