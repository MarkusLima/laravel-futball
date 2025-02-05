<?php

namespace App\Services;

use Exception;

class FootballApiService
{
    protected $apiUrl = 'https://v3.football.api-sports.io/';
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = env('API_FOOTBALL_KEY');
    }

    private function request($endpoint, $params = [])
    {
        $url = $this->apiUrl . $endpoint; // Concatena a URL base com o endpoint
    
        // Se houver parâmetros, adiciona-os à URL como query string
        if (!empty($params)) $url .= '?' . http_build_query($params);
    
        $curl = curl_init();
    
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                "x-apisports-key: {$this->apiKey}" // ✅ Corrigido o nome do header
            ],
        ]);
    
        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE); // Obtém o código HTTP da resposta
    
        if (curl_errno($curl)) {
            $error = curl_error($curl);
            curl_close($curl);
            throw new Exception("Erro na requisição cURL: $error");
        }
    
        curl_close($curl);
    
        // Decodifica a resposta JSON
        $decodedResponse = json_decode($response, true);
    
        // Se houver erro de autenticação
        if ($httpCode === 401 || empty($decodedResponse)) throw new Exception("Erro de autenticação: verifique sua chave API.");

        // Caso ocorra de ter erros na API
        if ($httpCode != 200) throw new Exception("Houve um erro de conexão com a API!");

        // Se houver msg de erro, exibe a primeira
        if (!empty($decodedResponse['errors']) && count($decodedResponse['errors']) > 0) {
            //dd($decodedResponse['errors']);
            foreach ($decodedResponse['errors'] as $value)  throw new Exception($value);
        }
    
        return $decodedResponse;
    }

    public function getLeagues()
    {
        return $this->request('leagues');
    }

    public function getResults($leagueId, $season, $last = 5)
    {
        return $this->request('fixtures', [
            'league' => $leagueId,
            'season' => $season,
        ]);
    }
}
