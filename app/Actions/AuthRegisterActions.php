<?php

namespace App\Actions;

use App\Models\User;
use App\Models\UserProfile;
use App\Models\AgentReferral;
use Illuminate\Support\Facades\Hash;

class AuthRegisterActions
{
    public static function registerAgent(array $data): User
    {
        // Criar o usuário agente
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => Hash::make($data['password']),
            'is_admin' => $data['is_admin'] ?? false,
        ]);
        
        // Verifica se o perfil de usuário já existe
        $userProfile = UserProfile::where('user_id', $user->id)->first();

         // Gerar código único easy_id após o agente ter sido criado
        $uniqueCode = md5($user->id . now());
        $user->update(['easy_id' => $uniqueCode]);

        
        // Gerar código único easy_id
        $user->update(['easy_id' => md5($user->id . now())]);

        // Dados do perfil de agente
        $profileData = [
            'user_id' => $user->id,
            'domain_value_id' => DomainValueActions::getDomainValueByAlias('agent')->id,
        ];

        // Se o perfil já existe, faz update, caso contrário, cria um novo
        if ($userProfile) {
            $userProfile->update($profileData);
        } else {
            $userProfile = UserProfile::create($profileData);
        }

      
        // dd($user);
        return $user;
    }


    public static function registerClient(array $data): User
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        // Verifica se o perfil de usuário já existe
        $userProfile = UserProfile::where('user_id', $user->id)->first();

        // Dados do perfil de cliente
        $profileData = [
            'user_id' => $user->id,
            'domain_value_id' => DomainValueActions::getDomainValueByAlias('client')->id,
        ];

        // Se o perfil existe, faz update, caso contrário, cria um novo
        if ($userProfile) {
            $userProfile->update($profileData);
        } else {
            $userProfile = UserProfile::create($profileData);
        }

        // Vincular ao agente se o código for fornecido
        if (!empty($data['agent_code'])) {
            $agent = User::where('easy_id', $data['agent_code'])->first();
            if ($agent) {
                AgentReferral::create([
                    'agent_id' => $agent->id,
                    'client_id' => $user->id,
                    'referred_at' => now(),
                ]);
            }
        }

        return $user;
    }
}
