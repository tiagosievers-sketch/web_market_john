<?php

namespace App\Http\Controllers;

use App\Actions\AgentReferralActions;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AgentReferralController extends Controller
{
    public function getClientsByAgentId(Request $request, int $agent_id): JsonResponse
    {
        try {
            $clients = AgentReferralActions::getClientsByAgentId($agent_id);

            return response()->json([
                'status' => 'success',
                'data' => $clients,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'It was not possible to retrieve clients.',
            ], 500);
        }
    }
}


