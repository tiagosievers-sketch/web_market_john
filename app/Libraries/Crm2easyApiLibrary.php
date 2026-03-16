<?php

namespace App\Libraries;


use Exception;
use GuzzleHttp\Client;
use Carbon\Carbon;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;


class Crm2easyApiLibrary
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
    }

    /**
     * @throws Exception
     */
    public static function getToken(){
        $endpoint = 'token';
        $email = config("crm.CRM_LOGIN");
        $password = config("crm.CRM_PASSWORD");
        $url = config("crm.CRM_BASEURL").$endpoint;
        $data = [
            "email" => $email,
            "secret_api" => $password
        ];
        try {
            $response = Http::acceptJson()->post($url, $data);
            if ($response->successful()) {
                // Obtendo a resposta bruta em string
                $responseBody = $response->body();
                $jsonResponse = json_decode($responseBody);
                if ($jsonResponse == null){
                    // 1. Remover as quebras de linha e espaços extras
                    $cleanResponse = str_replace(["\r", "\n", "\t", " ", "}", "} "], '', $responseBody);

                    // 2. Remover a vírgula extra após o último campo do JSON
                    $cleanResponse = preg_replace('/,\s*}/', '}', $cleanResponse);

                    // 3. Remover chaves adicionais no final
                    $cleanResponse = preg_replace('/}\s*}$/', '}', $cleanResponse);

                    // 4. Remover a ultima virgula
                    $cleanResponse = preg_replace('/,\s*$/', '}', $cleanResponse);

                    // 5. Decodificar a string limpa em JSON
                    $jsonResponse = json_decode($cleanResponse, true);
                }
                if (json_last_error() === JSON_ERROR_NONE) {
                    if(isset($jsonResponse['token'])){
                        return $jsonResponse['token'];
                    }
                    Log::error('Request failed: No token found');
                    return false;
                } else {
                    // Tratamento de erro
                    Log::error('Request failed: ' . json_last_error_msg());
                    return false;
                }
            } else {
                // Tratamento de erro
                Log::error('Request failed: ' . $response->status());
                return false;
            }
        } catch (Exception $e) {
            Log::error('Request failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * @throws Exception
     */
    public static function getAvailableStati($language='english'){
        $endpoint = 'get/AvailableStatus/'.$language;
        $token = self::getToken();
        $url = config("crm.CRM_BASEURL").$endpoint;
        $params = [
           'headers' => [
               'accept' => 'application/json',
               'Authorization' => 'Bearer '.$token
           ]
        ];

        return self::doRequest('GET',$url, $params);
    }


    /**
     * @throws Exception
     */
    public static function getClientData(int $client_id, string $language='english', string $status='all'){
        $endpoint = 'get/client/'.$client_id.'/'.$language.'/1';
        $token = self::getToken();
        $url = config("crm.CRM_BASEURL").$endpoint;
        try {
            $response = Http::withToken($token)->get($url);
            if ($response->successful()) {
                // Obtendo a resposta bruta em string
                $responseBody = $response->body();
                $jsonResponse = json_decode($responseBody);
                if ($jsonResponse != null) {
                    return $jsonResponse;
                } else {
                    // Tratamento de erro
                    Log::error('Request failed: ' . json_last_error_msg());
                    return false;
                }
            } else {
                // Tratamento de erro
                Log::error('Request failed: ' . $response->status());
                return false;
            }
        } catch (Exception $e) {
            Log::error('Request failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * @throws Exception
     */
    public static function postDocument(string $documentName, int $id, string $documentUrl,int $isPublic = 1){
        $endpoint = 'post/document';
        $token = self::getToken();
        $url = config("crm.CRM_BASEURL").$endpoint;
        \Log::info("URL 2easy $url");
        $data = [
            'parameters' => [
                'document_name' => $documentName,
                'insurance_id' => $id,
                'is_public' => $isPublic,
                'document_url' => $documentUrl
            ]
        ];
        \Log::info(print_r($data, true));
        try {
            $response = Http::withToken($token)->post($url,$data);
            if ($response->successful()) {
                // Obtendo a resposta bruta em string
                return true;
            } else {
                // Tratamento de erro
                Log::error('Request failed with status: ' . $response->status());
                Log::error('Request failed with body: ' . $response->body());
                return false;
            }
        } catch (Exception $e) {
            Log::error('Request failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * @param string $type Type of Request (ex.: 'GET', 'POST', 'PUT', etc)
     * @param string $url
     * @param array $params
     * @param int $countToStop
     * @return false|mixed
     */
    private static function doRequest(string $type, string $url, array $params, int &$countToStop=0): mixed
    {
        try {
            $client = new Client();
            $response = $client->request($type, $url, $params);
            $statusCode = $response->getStatusCode();
            $body = $response->getBody();
            if ($statusCode >= 200 && $statusCode < 300) {
                return json_decode($body);
            } else {
                Log::error('Request failed: ' . $statusCode . ' - ' . $body);
                return false;
            }
        } catch (GuzzleException|Exception $e) {
            Log::error('Request failed: ' . $e->getMessage());
            return false;
        }
    }

}
