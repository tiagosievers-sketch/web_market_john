<?php 

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Actions\AuthRegisterActions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\RegisterAgentRequest;
use App\Http\Requests\RegisterClientRequest;

class AuthRegisterController extends Controller
{
    public function showAgentRegistrationForm()
    {
        return view('auth.register-agent');
    }

    public function registerAgent(RegisterAgentRequest $request): RedirectResponse
    {
        try {
            $user = AuthRegisterActions::registerAgent($request->validated());

            Auth::login($user);

            return redirect()->route('login')->with('success', 'Agente registrado com sucesso.');
 
        } catch (\Exception $e) {
            return redirect()->route('client.register')->with('error', 'Falha ao registrar o cliente.');
        }
    }

    public function showClientRegistrationForm()
    {
        return view('auth.register-client');
    }

    public function registerClient(RegisterClientRequest $request): RedirectResponse
    {
        try {
            $user = AuthRegisterActions::registerClient($request->validated());

            Auth::login($user);

            return redirect()->route('login')->with('success', 'Cliente registrado com sucesso.');

    
        } catch (\Exception $e) {
            return redirect()->route('client.register')->with('error', 'Falha ao registrar o cliente.');
        }
    }
}
