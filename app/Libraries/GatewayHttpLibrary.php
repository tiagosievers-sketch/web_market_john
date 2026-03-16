<?php

namespace App\Libraries;


use Exception;
use GuzzleHttp\Client;
use Carbon\Carbon;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;


class GatewayHttpLibrary
{
//    config("cmsmarketplace.CMS_MARKETPLACE_TOKEN");
//    config("cmsmarketplace.CMS_MARKETPLACE_BASE_URL");
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
        $endpoint = 'auth/login-email';
        $email = config("gateway.GATEWAY_LOGIN");
        $password = config("gateway.GATEWAY_PASSWORD");
        $url = config("gateway.GATEWAY_BASEURL").$endpoint;
        $params = [
            'json' => [
                'email' => $email,
                'password' => $password
            ]
        ];

        return self::doRequest('POST', $url, $params);
    }

    public static function retriveSessionToken(): string
    {
        if(Session::exists('token_gateway')){
            return Session::get('token_gateway');
        }
        $tokenResponse =  self::getToken();
        if(isset($tokenResponse->access_token)){
            Session::put('token_gateway',$tokenResponse->access_token);
            Session::save();
            return $tokenResponse->access_token;
        }
        return config("gateway.GATEWAY_TOKEN");
    }

    public static function refreshSessionToken(): void
    {
        $tokenResponse =  self::getToken();
        if(isset($tokenResponse->access_token)){
            Session::put('token_gateway',$tokenResponse->access_token);
            Session::save();
        }
    }

    /**
     * @throws Exception
     */
    public static function getStates(){
        $endpoint = 'geography/states';
//        $tokenResponse =  self::getToken();
//        $token = config("gateway.GATEWAY_TOKEN");
//        if(isset($tokenResponse->access_token)){
//            $token = $tokenResponse->access_token;
//        }
        $token = self::retriveSessionToken();
        $url = config("gateway.GATEWAY_BASEURL").$endpoint;
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
    public static function getStatesMedicaid(string $stateLetters, int $year, int $quarter){
        $endpoint = 'geography/states/medicaid?abbrev='.$stateLetters.'&year='.$year.'&quarter='.$quarter;
//        $tokenResponse =  self::getToken();
//        $token = config("gateway.GATEWAY_TOKEN");
//        if(isset($tokenResponse->access_token)){
//            $token = $tokenResponse->access_token;
//        }
        $token = self::retriveSessionToken();
        $url = config("gateway.GATEWAY_BASEURL").$endpoint;
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
    public static function getCountyByZipcode(string $zipcode,string $year){
        $endpoint = 'geography/counties/zipcode/{zipcode}';
//        $tokenResponse =  self::getToken();
//        $token = config("gateway.GATEWAY_TOKEN");
//        if(isset($tokenResponse->access_token)){
//            $token = $tokenResponse->access_token;
//        }
        $token = self::retriveSessionToken();
        $url = config("gateway.GATEWAY_BASEURL").$endpoint;
        $url = str_replace('{zipcode}',$zipcode,$url);
        $params = [
            'headers' => [
                'accept' => 'application/json',
                'Authorization' => 'Bearer '.$token
            ]
        ];
        $params['query']['year'] = $year;

        return self::doRequest('GET',$url, $params);
    }

    /**
     * @throws Exception
     */
    public static function getIDMConnection(){
        $endpoint = 'idm/connection';
//        $tokenResponse =  self::getToken();
//        $token = config("gateway.GATEWAY_TOKEN");
//        if(isset($tokenResponse->access_token)){
//            $token = $tokenResponse->access_token;
//        }
        $token = self::retriveSessionToken();
        $url = config("gateway.GATEWAY_BASEURL").$endpoint;
        $params = [
            'headers' => [
                'accept' => 'application/json',
                'Authorization' => 'Bearer '.$token
            ]
        ];

        return self::doRequest('GET', $url, $params);
    }

    /**
     * @throws Exception
     */
    public static function getIDMCallback($data){
        $endpoint = 'idm/callback';
//        $tokenResponse =  self::getToken();
//        $token = config("gateway.GATEWAY_TOKEN");
//        if(isset($tokenResponse->access_token)){
//            $token = $tokenResponse->access_token;
//        }
        $token = self::retriveSessionToken();
        $url = config("gateway.GATEWAY_BASEURL").$endpoint;
        $params = [
            'headers' => [
                'accept' => 'application/json',
                'Authorization' => 'Bearer '.$token
            ],
            'json' => $data
        ];

        return self::doRequest('POST', $url, $params);
    }

    /**
     * @throws Exception
     */
    public static function searchPlans($data, $year){
        // dd($data);
        $endpoint = 'plans/search?year='.$year;
//        $tokenResponse =  self::getToken();
//        $token = config("gateway.GATEWAY_TOKEN");
//        if(isset($tokenResponse->access_token)){
//            $token = $tokenResponse->access_token;
//        }
        $token = self::retriveSessionToken();
        $url = config("gateway.GATEWAY_BASEURL").$endpoint;
        $params = [
            'headers' => [
                'Content-type' => 'application/json',
                'Authorization' => 'Bearer '.$token
            ],
            // 'json' => $data->all()
            'json' => $data
        ];
        Log::info(print_r($params, true));
        return self::doRequest('POST', $url, $params);
    }

    /**
     * @throws Exception
     */
    public static function searchPlansByIds($data, $year) {
        $endpoint = 'plans?year='.$year;
        $token = self::retriveSessionToken();
        $url = config("gateway.GATEWAY_BASEURL").$endpoint;
        $params = [
            'headers' => [
                'Content-type' => 'application/json',
                'Authorization' => 'Bearer '.$token
            ],
            'json' => $data
        ];
        Log::info('Search Plans By IDs',['data' => $data]);
        return self::doRequest('POST', $url, $params);
    }

    /**
     * @throws Exception
     */
    public static function searchPlanByIdPost($data, $year,$hios_plan_id){
        // dd($data);
        $endpoint = 'plans/'.$hios_plan_id.'/?year='.$year;
//        $tokenResponse =  self::getToken();
//        $token = config("gateway.GATEWAY_TOKEN");
//        if(isset($tokenResponse->access_token)){
//            $token = $tokenResponse->access_token;
//        }
        $token = self::retriveSessionToken();
        $url = config("gateway.GATEWAY_BASEURL").$endpoint;
        $params = [
            'headers' => [
                'Content-type' => 'application/json',
                'Authorization' => 'Bearer '.$token
            ],
            // 'json' => $data->all()
            'json' => $data
        ];
        Log::info(print_r($params, true));
        return self::doRequest('POST', $url, $params);
    }

    /**
     * @throws Exception
     */
    public static function searchHouseElegibilityEstimates($data, $year){
        // dd($data);
        $endpoint = 'households-elegibility/estimates?year='.$year;
//        $tokenResponse =  self::getToken();
//        $token = config("gateway.GATEWAY_TOKEN");
//        if(isset($tokenResponse->access_token)){
//            $token = $tokenResponse->access_token;
//        }
        $token = self::retriveSessionToken();
        $url = config("gateway.GATEWAY_BASEURL").$endpoint;
        $params = [
            'headers' => [
                'Content-type' => 'application/json',
                'Authorization' => 'Bearer '.$token
            ],
            // 'json' => $data->all()
            'json' => $data
        ];
//        dd($url,json_encode($data));
        Log::info(print_r($params, true));
        return self::doRequest('POST', $url, $params);
    }

    /**
     * @throws Exception
     */
    public static function searchHouseElegibilitySlcsp($data, $year){
        // dd($data);
        $endpoint = 'households-elegibility/slcsp/?year='.$year;
//        $tokenResponse =  self::getToken();
//        $token = config("gateway.GATEWAY_TOKEN");
//        if(isset($tokenResponse->access_token)){
//            $token = $tokenResponse->access_token;
//        }
        $token = self::retriveSessionToken();
        $url = config("gateway.GATEWAY_BASEURL").$endpoint;
        $params = [
            'headers' => [
                'Content-type' => 'application/json',
                'Authorization' => 'Bearer '.$token
            ],
            // 'json' => $data->all()
            'json' => $data
        ];
        Log::info(print_r($params, true));
        return self::doRequest('POST', $url, $params);
    }

    /**
     * @param string $type Type of Request (ex.: 'GET', 'POST', 'PUT', etc)
     * @param Client $client
     * @param string $url
     * @param array $params
     * @return false|mixed
     */
    private static function doRequest(string $type, string $url, array $params, int &$countToStop=0): mixed
    {
        try {

            $client = new Client();
            //TODO retirar abaixo a verificação = falso assim q o problema do ssl for resolvido.
            $params['verify'] = false;
            $response = $client->request($type, $url, $params);
            $statusCode = $response->getStatusCode();
            $body = $response->getBody();
            if ($statusCode >= 200 && $statusCode < 300) {
                Log::info('Success: status ' . $statusCode,['body'=> $body, 'Full Response' => $response]);
                return json_decode($body);
            } else {
                Log::error('Request failed: ' . $statusCode . ' - ' . $body);
                return false;
            }
        } catch (GuzzleException|Exception $e) {
            if ( method_exists($e, 'getResponse') ) {
                if ($e->getResponse()) {
                    $response = json_decode($e->getResponse()->getBody());
                    if (isset($response->message)) {
                        if ($response->message == 'Unauthenticated.') {
                            if ($countToStop <= 3) {
                                $countToStop++;
                                Log::error('Request try n ' . $countToStop);
                                self::refreshSessionToken();
                                $token = self::retriveSessionToken();
                                if (isset($params['headers'])) {
                                    $params['headers'] = [
                                        'Content-type' => 'application/json',
                                        'Authorization' => 'Bearer ' . $token
                                    ];
                                }
                                return self::doRequest($type, $url, $params, $countToStop);
                            } else {
                                Log::error('Request limit reached.');
                                return false;
                            }
                        }
                    }
                }
            }
            Log::error('Request failed: ' . $e->getMessage());
            return false;
        }
    }

}
