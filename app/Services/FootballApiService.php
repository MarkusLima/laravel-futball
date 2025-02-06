<?php

namespace App\Services;

use Exception;

class FootballApiService
{
    protected $apiUrl = 'https://api.football-data.org/';
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
                "X-Auth-Token: {$this->apiKey}"
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
    
        return $decodedResponse;
    }

    public function getLeagues()
    {
        return $this->request('v4/competitions');
    }

    
    public function getTeams()
    {
        return $this->request('v4/teams', [
            'limit' => '100',
            'offset' => '100',
        ]);
    }

    public function getResults($request)
    {
        $url = 'v4/teams';

        if (!empty($request->leagueCode)) {
            $url = 'v4/teams/'.$request->leagueCode.'/matches';
        }

        if (!empty($request->teamCode)) {

        }

        return $this->request($url);
    }
}
