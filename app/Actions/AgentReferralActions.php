<?php

namespace App\Actions;

use App\Models\AgentReferral;
use Illuminate\Support\Facades\Auth;

class AgentReferralActions
{
    public static function getClientsByAgentId(int $agent_id): array
    {
        $user = Auth::user();

        if ($user->is_admin || $user->id == $agent_id) {
            $clients = AgentReferral::where('agent_id', $agent_id)
                ->with('client')
                ->get()
                ->pluck('client')
                ->toArray();

            return $clients;
        } else {
            throw new \Exception('Unauthorized');
        }
    }
}
