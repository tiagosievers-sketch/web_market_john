<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmailLoginRequest;
use App\Http\Requests\EmailRegisterRequest;
use App\Libraries\GatewayHttpLibrary;
use App\Models\DomainValue;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Kreait\Firebase\Contract\Auth as FirebaseAuth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Exception\Auth\RevokedIdToken;
use Kreait\Firebase\Exception\Auth\FailedToVerifyToken;
use Kreait\Firebase\Exception\InvalidArgumentException;

class AuthController extends Controller
{
    public function register(EmailRegisterRequest $request)
    {
        $user = User::create([
            'name'      => $request->input('name'),
            'email'     => $request->input('email'),
            'password'  => Hash::make($request->input('password'))
        ]);

        if ($request->input('agent')) {
            $agent = $request->input('agent');
            if ($agent) {
                UserProfile::create([
                    'user_id' => $user->id,
                    'domain_value_id' => DomainValue::where('alias', 'agent')->first()->id,
                ]);
            } else {
                UserProfile::create([
                    'user_id' => $user->id,
                    'domain_value_id' => DomainValue::where('alias', 'client')->first()->id,
                ]);
            }
        } else {
            UserProfile::create([
                'user_id' => $user->id,
                'domain_value_id' => DomainValue::where('alias', 'client')->first()->id,
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'data'          => $user,
            'access_token'  => $token,
            'token_type'    => 'Bearer'
        ]);
    }

    public function login(EmailLoginRequest $request)
    {
        Session::flush();
        GatewayHttpLibrary::retriveSessionToken();
        $credentials    =   $request->only('email', 'password');

        if (! Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'User not found'
            ], 401);
        }

        $user   = User::where('email', $request->input('email'))->firstOrFail();
        $token  = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message'       => 'Login success',
            'access_token'  => $token,
            'token_type'    => 'Bearer'
        ]);
    }

    public function logout()
    {
        Session::flush();
        Auth::user()->tokens()->delete();
        return response()->json([
            'message' => 'Logout successfull'
        ]);
    }



    public function handleGoogleCallback(Request $request)
    {
        try {
            $user = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'User not found'
            ], 401);
        }

        // Verifica se já existe um usuário com o ID do Google
        $existingUser = User::where('google_id', $user->id)->first();

        if ($existingUser) {
            $token  = $existingUser->createToken('auth_token')->plainTextToken;
        } else {
            // Cria um novo usuário com os detalhes do Google
            $newUser = new User();
            $newUser->name = $user->name;
            $newUser->email = $user->email;
            $newUser->google_id = $user->id;
            $newUser->password = bcrypt(Str::random(16));
            $newUser->save();

            UserProfile::create([
                'user_id' => $newUser->id,
                'domain_value_id' => DomainValue::where('alias', 'client')->first()->id,
            ]);

            $token  = $newUser->createToken('auth_token')->plainTextToken;
        }

        return response()->json([
            'message'       => 'Login success',
            'access_token'  => $token,
            'token_type'    => 'Bearer'
        ]);
    }

    public function handleMetaCallback(Request $request)
    {
        try {
            $user = Socialite::driver('facebook')->user();
        } catch (\Laravel\Socialite\Two\InvalidStateException | \Exception $e) {
            return response()->json([
                'message' => 'User not found'
            ], 401);
        }

        $existingUser = User::where('facebook_id', $user->id)->first();

        if ($existingUser) {
            $token  = $existingUser->createToken('auth_token')->plainTextToken;
        } else {
            $newUser = new User();
            $newUser->name = $user->name;
            $newUser->email = $user->email;
            $newUser->facebook_id = $user->id;
            $newUser->password = bcrypt(Str::random()); // Set a random password
            $newUser->save();

            UserProfile::create([
                'user_id' => $newUser->id,
                'domain_value_id' => DomainValue::where('alias', 'client')->first()->id,
            ]);

            $token  = $newUser->createToken('auth_token')->plainTextToken;
        }

        return response()->json([
            'message'       => 'Login success',
            'access_token'  => $token,
            'token_type'    => 'Bearer'
        ]);
    }

    public function __construct(private FirebaseAuth $firebaseAuth) {}

    public function firebaseLogin(Request $request)
    {
        $idToken  = $request->string('idToken')->trim();
        $provider = strtolower((string) $request->input('provider', '')); 

        if ($idToken->isEmpty()) {
            Log::warning('firebaseLogin: Missing idToken');
            return response()->json(['message' => 'Missing idToken'], 401);
        }

        try {
            Log::info('firebaseLogin: verifying token');

            $verified = $this->firebaseAuth->verifyIdToken($idToken);
            $claims   = $verified->claims();

            $uid           = $claims->get('sub'); // não será salvo (sem coluna)
            $email         = $claims->get('email');
            $name          = $claims->get('name');
            $picture       = $claims->get('picture');
            $emailVerified = (bool) $claims->get('email_verified');

            // Identidades do provedor
            $googleId      = null;
            $facebookId    = null;
            $firebaseClaim = $claims->get('firebase') ?? [];

            if (isset($firebaseClaim['identities']['google.com'][0])) {
                $googleId = $firebaseClaim['identities']['google.com'][0];
            }
            if (isset($firebaseClaim['identities']['facebook.com'][0])) {
                $facebookId = $firebaseClaim['identities']['facebook.com'][0];
            }

            // Se o front não informou provider, deduz pelo id que veio do Firebase
            if ($provider === '') {
                $provider = $googleId ? 'google' : ($facebookId ? 'facebook' : '');
            }

            Log::info('firebaseLogin: provider identities', [
                'provider'    => $provider,
                'google_id'   => $googleId,
                'facebook_id' => $facebookId,
                'email'       => $email,
                'identities'  => $firebaseClaim['identities'] ?? []
            ]);

            DB::beginTransaction();

            // 1) Tenta por Google ID
            $user = $googleId ? User::where('google_id', $googleId)->first() : null;

            // 2) Tenta por Facebook ID
            if (!$user && $facebookId) {
                $user = User::where('facebook_id', $facebookId)->first();
            }

            // 3) Tenta por e-mail
            if (!$user && $email) {
                $user = User::where('email', $email)->first();

                if ($user) {
                    // Preenche IDs sociais AUSENTES (não sobrescreve IDs diferentes já gravados)
                    if ($googleId && empty($user->google_id)) {
                        $user->google_id = $googleId;
                    } elseif ($googleId && !empty($user->google_id) && $user->google_id !== $googleId) {
                        Log::warning('firebaseLogin: tentativa de vincular google_id diferente', [
                            'user_id'           => $user->id,
                            'existing_google_id' => $user->google_id,
                            'incoming_google_id' => $googleId,
                        ]);
                    }

                    if ($facebookId && empty($user->facebook_id)) {
                        $user->facebook_id = $facebookId;
                    } elseif ($facebookId && !empty($user->facebook_id) && $user->facebook_id !== $facebookId) {
                        Log::warning('firebaseLogin: tentativa de vincular facebook_id diferente', [
                            'user_id'              => $user->id,
                            'existing_facebook_id' => $user->facebook_id,
                            'incoming_facebook_id' => $facebookId,
                        ]);
                    }
                }
            }

            if (!$user && empty($email)) {
                DB::rollBack();
                Log::warning('firebaseLogin: provider did not return an email and user not found');
                return response()->json(['message' => 'Email not provided by provider'], 422);
            }

            if (!$user) {
                $user = new User();
                $user->password = Hash::make(Str::random(40)); // senha aleatória
            }

            // Atualiza dados básicos
            if (!empty($name))   $user->name  = $name;
            if (!empty($email))  $user->email = $email;


            $sameEmail = !empty($email) && strcasecmp((string) $user->email, (string) $email) === 0;

            if ($sameEmail && in_array($provider, ['google', 'facebook'], true)) {
                if ($provider === 'google') {
                    if (!empty($googleId)) {
                        // garante google_id
                        if (empty($user->google_id)) {
                            $user->google_id = $googleId;
                        }
                    }
                    // limpa facebook_id
                    if (!empty($user->facebook_id)) {
                        Log::info('firebaseLogin: preferindo google -> limpando facebook_id', [
                            'user_id' => $user->id,
                            'old_facebook_id' => $user->facebook_id
                        ]);
                        $user->facebook_id = null;
                    }
                } elseif ($provider === 'facebook') {
                    if (!empty($facebookId)) {
                        // garante facebook_id
                        if (empty($user->facebook_id)) {
                            $user->facebook_id = $facebookId;
                        }
                    }
                    // limpa google_id
                    if (!empty($user->google_id)) {
                        Log::info('firebaseLogin: preferindo facebook -> limpando google_id', [
                            'user_id' => $user->id,
                            'old_google_id' => $user->google_id
                        ]);
                        $user->google_id = null;
                    }
                }
            } else {
                // Fallback seguro: apenas preenche IDs vazios sem limpar o outro
                if (!empty($googleId) && empty($user->google_id))     $user->google_id   = $googleId;
                if (!empty($facebookId) && empty($user->facebook_id)) $user->facebook_id = $facebookId;
            }
            // ------------------------------------------------------------

            // Verificação de e-mail
            if ($emailVerified && is_null($user->email_verified_at)) {
                $user->email_verified_at = now();
            }

            // easy_id
            if (empty($user->easy_id)) {
                $user->easy_id = (string) Str::uuid();
            }

            // Foto
            if (!empty($picture)) {
                $user->profile_photo_path = $picture;
            }

            $user->save();

            // Cria perfil padrão se necessário
            if (!UserProfile::where('user_id', $user->id)->exists()) {
                $clientDomain = DomainValue::where('alias', 'client')->first();
                UserProfile::create([
                    'user_id' => $user->id,
                    'domain_value_id' => $clientDomain?->id, // evita erro se não existir
                ]);
            }

            $token = $user->createToken('auth_token')->plainTextToken;

            DB::commit();

            Log::info('firebaseLogin: success', [
                'user_id'  => $user->id,
                'provider' => $googleId ? 'google' : ($facebookId ? 'facebook' : 'email')
            ]);

            return response()->json([
                'message'      => 'Login success',
                'access_token' => $token,
                'token_type'   => 'Bearer',
                'easy_id'      => $user->easy_id,
                'name'         => $user->name,
                'email'        => $user->email,
            ]);
        } catch (RevokedIdToken $e) {
            DB::rollBack();
            Log::warning('firebaseLogin: revoked token', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Revoked token'], 401);
        } catch (FailedToVerifyToken | InvalidArgumentException $e) {
            DB::rollBack();
            Log::warning('firebaseLogin: invalid token', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Invalid token'], 401);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('firebaseLogin: server error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['message' => 'Server error'], 500);
        }
    }

    

    
}
