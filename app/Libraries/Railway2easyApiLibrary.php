<?php

namespace App\Libraries;


use Exception;
use GuzzleHttp\Client;
use Carbon\Carbon;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;


class Railway2easyApiLibrary
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
    public static function postDocument(string $documentName, int $id, int $chatId, string $documentUrl, string $message = 'Success.', string $webhookOverwrite=null){
        $endpoint = 'webhook/proposta';
        $url = $webhookOverwrite??config("railway2easy.RAILWAY_2EASY_URL").$endpoint;
        Log::info("URL 2easy $url");
        $data = [
            'parameters' => [
                'document_name' => $documentName,
                'insurance_id' => $id,
                'client_id' => $chatId,
                'is_public' => 1,
                'document_url' => $documentUrl,
                'status' => 'success',
                'message' => $message

            ]
        ];
        Log::info(print_r($data, true));
        try {
            $response = Http::post($url,$data);
            if ($response->successful()) {
                // Obtendo a resposta bruta em string
                Log::error('Request successful with status: ' . $response->status());
                Log::error('Request successful with body: ' . $response->body());
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

    public static function sendError(int $applicationId, int $clientId, string $message = 'Error', string $webhookOverwrite=null): bool
    {
        $endpoint = 'webhook/proposta';
        $url = $webhookOverwrite??config("railway2easy.RAILWAY_2EASY_URL").$endpoint;
        Log::info("URL 2easy $url");
        $data = [
            'parameters' => [
                'status' => 'fail',
                'message' => $message,
                'application_id' => $applicationId,
                'client_id' => $clientId
            ]
        ];
        Log::info(print_r($data, true));
        try {
            $response = Http::post($url,$data);
            if ($response->successful()) {
                // Obtendo a resposta bruta em string
                Log::error('Request successful with status: ' . $response->status());
                Log::error('Request successful with body: ' . $response->body());
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

}
