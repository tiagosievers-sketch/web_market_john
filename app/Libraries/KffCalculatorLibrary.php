<?php

namespace App\Libraries;


use Exception;
use GuzzleHttp\Client;
use Carbon\Carbon;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;


class KffCalculatorLibrary
{
    CONST BASE_ENVIRONMENT = 'production';
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
    }

    public static function recoverJsonData(string $zipcode): mixed
    {
        $endpoint = 'subsidy-calculator';
        $baseYear = config("kffcalculator.KFF_BASE_YEAR");
        $now = Carbon::now();
        $url = config("kffcalculator.KFF_BASE_URL").$endpoint;
        Log::info("URL KFF $url");
        $stateId = substr($zipcode,0,2);
        try {
            $response = Http::withUrlParameters([
                'url' => $url,
                'year' => $baseYear,
                'environment' => self::BASE_ENVIRONMENT,
                'stateid' => $stateId,
                'timestamp' => $now->unix(),
            ])->get('{+url}/{year}/{environment}/data/{stateid}.json');
            if ($response->successful()) {
                // Obtendo a resposta bruta em string
                $body = $response->body();
                $json = json_decode(trim(str_replace(');','',str_replace('merge_zip_data(','',$body))));
                Log::info('Request successful with status: ' . $response->status());
//                Log::info('Request successful with body: ',['json' => $json]);
                return $json->stdClass??$json;
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

    public static function generateSilverAndBronze(string $zipcode): array
    {
        $stateTable = self::recoverJsonData($zipcode);
        if (!$stateTable){
            Log::error('GenerateSilverAndBronze error');
            return [];
        }
        $countyObject = $stateTable->$zipcode;
        if (is_array($countyObject)){
            $returnAr = [
                'silver' => $countyObject[0]??false,
                'bronze' => $countyObject[1]??false
            ];
            Log::info('GenerateSilverAndBronze response:',$returnAr);
            return $returnAr;
        }
        Log::error('GenerateSilverAndBronze error');
        return [];
    }
}
