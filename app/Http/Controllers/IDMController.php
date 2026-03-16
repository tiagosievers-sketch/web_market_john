<?php

namespace App\Http\Controllers;

use App\Actions\IDMActions;
use App\Libraries\SecureAccessTokenLibrary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IDMController extends Controller
{
    public function connect(Request $request) {
        
        return \Redirect::to(IDMActions::generateAuthorizeUrl('openid profile email offline_access'));

    }

    public function callback(Request $request)
    {
        try {
            $inputs = $request->all();
            $code = $inputs["code"];
            $state = $inputs["state"];
    
            if ($request->session()->has('code_verifier')) {
                $tokenData = IDMActions::exchangeAuthorizationCode(session('code_verifier'), $code);
                if (isset($tokenData["access_token"])) {
                    \Log::debug(print_r($tokenData, true));
    
                    $accessToken = SecureAccessTokenLibrary::encryptToken($tokenData["access_token"], env("IDM_CLIENT_ID"));
                    $refreshToken = SecureAccessTokenLibrary::encryptToken($tokenData["refresh_token"], env("IDM_CLIENT_ID"));
                    $idToken = SecureAccessTokenLibrary::encryptToken($tokenData["id_token"], env("IDM_CLIENT_ID"));
    
                    $user = Auth::user();
                    $user->update([
                        "idm_expires_in" => $tokenData["expires_in"],
                        "idm_access_token" => $accessToken,
                        "idm_refresh_token" => $refreshToken,
                        "idm_id_token" => $idToken
                    ]);
    
                    \Log::debug("Token data");
                    \Log::debug("Access Token: ".$tokenData["access_token"]);
                    \Log::debug("Refresh Token: ".$tokenData["refresh_token"]);
                    \Log::debug("ID Token: ".$tokenData["id_token"]);
    
                    \Log::debug("Decrypt test");
                    \Log::debug("Access Token: ".SecureAccessTokenLibrary::decryptToken($accessToken, env("IDM_CLIENT_ID")));
                    \Log::debug("Refresh Token: ".SecureAccessTokenLibrary::decryptToken($refreshToken, env("IDM_CLIENT_ID")));
                    \Log::debug("ID Token: ".SecureAccessTokenLibrary::decryptToken($idToken, env("IDM_CLIENT_ID")));
    
                    // Adiciona mensagem de sucesso
                    return \Redirect::route('index')->with('success', 'EDE Integration successful!');
                } else {
                    throw new \Exception("Access token is missing");
                }
            } else {
                throw new \Exception("Code verifier is not defined");
            }
        } catch (\Exception $e) {
            // Captura e exibe a mensagem de erro
            return \Redirect::route('index')->with('error', 'EDE Integration failed: ' . $e->getMessage());
        }
    }
    

    public function logout(Request $request) {
        /*
        work with return from IDM
        */
        return null;
    }

    public function refreshToken(Request $request) {
        $user = Auth::user();

        try{
            $tokenData = IDMActions::refreshToken($user);
            if(isset($tokenData["access_token"])) {
                \Log::debug(print_r($tokenData, true));
    
                $accessToken = SecureAccessTokenLibrary::encryptToken($tokenData["access_token"], env("IDM_CLIENT_ID"));
                $refreshToken = SecureAccessTokenLibrary::encryptToken($tokenData["refresh_token"], env("IDM_CLIENT_ID"));
                $idToken = SecureAccessTokenLibrary::encryptToken($tokenData["id_token"], env("IDM_CLIENT_ID"));
    
                $user->update(
                    array(
                        "idm_expires_in" => $tokenData["expires_in"],
                        "idm_access_token" => $accessToken,
                        "idm_refresh_token" => $refreshToken,
                        "idm_id_token" => $idToken
                    )
                );
    
                \Log::debug("Token data");
                \Log::debug("Access Token: ".$tokenData["access_token"]);
                \Log::debug("Refresh Token".$tokenData["refresh_token"]);
                \Log::debug("ID Token".$tokenData["id_token"]);
    
                \Log::debug("Decrypt test");
                \Log::debug("Access Token: ".SecureAccessTokenLibrary::decryptToken($accessToken, env("IDM_CLIENT_ID")));
                \Log::debug("Refresh Token".SecureAccessTokenLibrary::decryptToken($refreshToken, env("IDM_CLIENT_ID")));
                \Log::debug("ID Token".SecureAccessTokenLibrary::decryptToken($idToken, env("IDM_CLIENT_ID")));
            }    
        } catch(\Exception $e) {
            \Log::error($e->getMessage());
            return \Redirect::route('index')->with('error', $e->getMessage());
        }

        return \Redirect::route('index');
    }

}
