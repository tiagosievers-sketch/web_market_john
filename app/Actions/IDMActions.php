<?php

namespace App\Actions;

use App\Libraries\SecureAccessTokenLibrary;
class IDMActions
{
    private static function generateCodeVerifier($length = 58) {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-._~';
        $charactersLength = strlen($characters);
        $randomString = '';
    
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
    
        //return "M25iVXpKU3puUjFaYWg3T1NDTDQtcW1ROUY5YXlwalNoc0hhakxifmZHag";
        return trim($randomString);
    }
    
    private static function generateCodeChallenge($codeVerifier) {
        // Hash the code verifier using SHA-256
        $hashed = hash('sha256', $codeVerifier, true);

        // Convert to hexadecimal format
        $hexadecimalHash = bin2hex($hashed);
    
        // Base64 URL-encode the result (URL safe)
        $codeChallenge = rtrim(strtr(base64_encode($hashed), '+/', '-_'), '=');
    
        return $codeChallenge;
    }

    // Function to generate a random state (for CSRF protection)
    private static function generateState($length = 16)
    {
        return bin2hex(random_bytes($length));
    }

    // Function to generate the full authorization URL
    public static function generateAuthorizeUrl($scope = '', $responseType = 'code')
    {
        // Generate the code_verifier
        $codeVerifier = trim(self::generateCodeVerifier());
        
        // Generate the code_challenge from the code_verifier
        $codeChallenge = trim(self::generateCodeChallenge($codeVerifier));

        // Generate the state
        $state = self::generateState();

        // Store code_verifier and state in session (to later use them in the token exchange and CSRF validation)
        session(['code_verifier'=>$codeVerifier]);
        session(['oauth2_state'=>$state]);

        // Build the authorization URL
        $params = [
            'client_id' => env("IDM_CLIENT_ID"),
            'redirect_uri' => env("IDM_EDE_CALLBACK_URL"),
            'response_type' => $responseType,
            'scope' => $scope,
            'state' => $state,
            'code_challenge' => $codeChallenge,
            'code_challenge_method' => 'S256',
        ];

        // Generate the URL query string
        return self::getIDMUrl().env("IDM_AUTHORIZATION_ENDPOINT") . '?' . http_build_query($params);

    }

    private static function getIDMUrl() {
        return env("IDM_BASE_URL")."/".env("IDM_ISSUER");
    }

    public static function exchangeAuthorizationCode($code_verifier, $authorizationCode)
    {
        // Prepare the POST request data
        $postData = [
            'grant_type' => 'authorization_code',
            'client_id' => env("IDM_CLIENT_ID"),
            'client_secret' => env("IDM_SECRET"),
            'secret' => env("IDM_SECRET"),
            'redirect_uri' => env("IDM_EDE_CALLBACK_URL"),
            'code' => $authorizationCode,
            'code_verifier' => $code_verifier,
        ];

        // Initialize cURL session
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, self::getIDMUrl().env("IDM_TOKEN_ENDPOINT"));
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'accept: application/json',
            'cache-control: no-cache',
            'content-type: application/x-www-form-urlencoded',
        ]);

        // Execute the cURL request
        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            throw new \Exception('cURL error: ' . curl_error($ch));
        }

        // Close the cURL session
        curl_close($ch);

        // Decode and return the JSON response
        $responseData = json_decode($response, true);

        if (isset($responseData['error'])) {
            \Log::error(print_r($responseData, true));
            throw new \Exception('Error: ' . $responseData['error_description']);
        }

        return $responseData; // Contains access_token, id_token, etc.
    }

    public static function refreshToken($user) {
        // Set your Okta domain and other required parameters
        $client_credentials = base64_encode(env("IDM_CLIENT_ID").":".env("IDM_SECRET")); // Base64-encoded client ID and client secret (authorization header)

        // Prepare the POST data for the token request
        $postData = [
            'grant_type' => 'refresh_token',
            'redirect_uri' => env("IDM_EDE_CALLBACK_URL"),
            'scope' => 'offline_access openid',
            'refresh_token' => SecureAccessTokenLibrary::decryptToken($user->idm_refresh_token, env("IDM_CLIENT_ID")),
        ];

        \Log::debug(print_r($postData, true));

        // Initialize cURL session
        $ch = curl_init();

        // Set cURL options
        curl_setopt($ch, CURLOPT_URL, self::getIDMUrl().env("IDM_TOKEN_ENDPOINT"));
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'accept: application/json',
            'authorization: Basic ' . $client_credentials, // Authorization header with client credentials
            'cache-control: no-cache',
            'content-type: application/x-www-form-urlencoded',
        ]);

        // Execute the cURL request
        $response = curl_exec($ch);

        // Check for errors
        if (curl_errno($ch)) {
            throw new \Exception('cURL error: ' . curl_error($ch));
        }

        // Close the cURL session
        curl_close($ch);

        // Decode and print the JSON response
        $responseData = json_decode($response, true);

        if (isset($responseData['error'])) {
            throw new \Exception('Error: ' . $responseData['error_description']);
        }

        return $responseData;
    }
        
}