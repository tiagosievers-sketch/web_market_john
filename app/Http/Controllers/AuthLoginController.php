<?php

namespace App\Http\Controllers;

use App\Libraries\GatewayHttpLibrary;
use App\Models\DomainValue;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Mockery\Exception;
use phpseclib3\Crypt\Random;

class AuthLoginController extends Controller
{
    public function index()
    {
        // Se o usuário já estiver autenticado, redireciona para index
        if (Auth::check()) {
            return redirect()->route('index');
        }
        return view('login.login');
    }

    public function login(Request $request)
    {
        try {
            // Validação dos campos do formulário
            $validated = $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            // Limpa a sessão antes de iniciar novo login
            Session::flush();

            // Obtém o token do Gateway
            $gatewayToken = GatewayHttpLibrary::retriveSessionToken();
            if (!$gatewayToken) {
                throw new Exception('Falha ao obter token do gateway');
            }

            // Tenta autenticar o usuário
            if (Auth::attempt($validated)) {
                /** @var User $user */
                $user = Auth::user();

                // Gerencia a preferência de idioma
                $language = $request->input('language') ?? $user->preferred_language;
                if ($language) {
                    session(['my_locale' => $language]);
                }

                return redirect()->route('index');
            }

            return redirect()->route('login')
                ->with('error', 'Credenciais inválidas. Verifique seu e-mail e senha.');
        } catch (ValidationException $e) {


            return redirect()->route('login')
                ->withErrors($e->errors())
                ->withInput($request->except('password'));
        } catch (Exception $e) {


            return redirect()->route('login')
                ->with('error', 'Ocorreu um erro durante o login. Tente novamente.');
        }
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $user = Socialite::driver('google')->user();

        $existingUser = User::where('email', $user->email)->first();

        if ($existingUser) {
            Session::flush();
            GatewayHttpLibrary::retriveSessionToken();
            Auth::login($existingUser);
        } else {

            $newUser = new User();
            $newUser->name = $user->name;
            $newUser->email = $user->email;
            $newUser->password = bcrypt(Str::random());
            $newUser->save();

            UserProfile::create([
                'user_id' => $newUser->id,
                'domain_value_id' => DomainValue::where('alias', 'client')->first()->id,
            ]);
            Auth::login($newUser);
        }

        return redirect('/');
    }

    public function logout()
    {
        Session::flush();
        Auth::user()->tokens()->delete();
        return redirect()->route('login');
    }
}
