<?php

namespace App\Http\Livewire;

use App\Actions\ApplicationActions;
use App\Actions\MemberInformationActions;
use App\Libraries\GatewayHttpLibrary;
use App\Models\Application;
use App\Models\DomainValue;
use App\Models\UserProfile;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

class Index extends Component
{

    public $isClient;
    public $application_id = null;

    public function mount()
    {

        // $this->application_id = $application_id;


    }

    public function render()
    {
        $data = [];
        $user = Auth::user();

        if ($user->is_admin) {
            $data['application'] = ApplicationActions::listApplicationsPaginate(true);
            $data['isClient'] = false; // Admin 
        } elseif ($user->easy_id) {
            $data['application'] = $this->getAgentApplications($user->id);
            $data['isClient'] = false; // Agente 
        } else {
            $data['application'] = $this->getClientApplications($user->id);
            $data['isClient'] = true; // Esse é o cliente
        }
        
        //dd($data);
        return view('livewire.index', $data);
    }

    private function getAllApplications()
    {
        return Application::with(['agent', 'client', 'plans', 'householdMembers'])->get();
    }

    private function getAgentApplications($userId)
    {
        return Application::with(['agent', 'client', 'plans', 'householdMembers'])
            ->where('agent_id', $userId)
            ->orWhereHas('agentReferrals', function ($query) use ($userId) {
                $query->where('agent_id', $userId);
            })
            ->paginate(10);
    }

    private function getClientApplications($clientId)
    {
        return Application::with(['agent', 'client', 'plans', 'householdMembers'])
            ->where('client_id', $clientId)
            ->paginate(10);
    }

    // Redirecionamento para Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Callback do Google
    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Falha ao autenticar com o Google.');
        }

        $existingUser = User::where('google_id', $user->id)->first();

        if ($existingUser) {
            Session::flush();
            GatewayHttpLibrary::retriveSessionToken();
            Auth::login($existingUser);
        } else {
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

            Session::flush();
            GatewayHttpLibrary::retriveSessionToken();
            Auth::login($newUser);
        }

        return redirect()->route('index');
    }

    // Redirecionamento para Facebook
    public function redirectToMeta()
    {
        return Socialite::driver('facebook')->redirect();
    }

    // Callback do Facebook
    public function handleMetaCallback(Request $request)
    {
        try {
            $user = Socialite::driver('facebook')->user();
        } catch (\Laravel\Socialite\Two\InvalidStateException $e) {
            return redirect()->route('login')->withErrors(['message' => 'Erro de autenticação com Facebook.']);
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors(['message' => 'Erro desconhecido ao autenticar com Facebook.']);
        }

        $existingUser = User::where('facebook_id', $user->id)->first();

        if ($existingUser) {
            Session::flush();
            GatewayHttpLibrary::retriveSessionToken();
            Auth::login($existingUser);
        } else {
            $newUser = new User();
            $newUser->name = $user->name;
            $newUser->email = $user->email;
            $newUser->facebook_id = $user->id;
            $newUser->password = bcrypt(Str::random());
            $newUser->save();

            UserProfile::create([
                'user_id' => $newUser->id,
                'domain_value_id' => DomainValue::where('alias', 'client')->first()->id,
            ]);

            Session::flush();
            GatewayHttpLibrary::retriveSessionToken();
            Auth::login($newUser);
        }

        return redirect()->route('index');
    }
}
