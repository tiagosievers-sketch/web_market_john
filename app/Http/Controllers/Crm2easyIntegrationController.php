<?php

namespace App\Http\Controllers;

use App\Libraries\Crm2easyApiLibrary;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class Crm2easyIntegrationController extends Controller
{
    public function availableStati(string $language): JsonResponse
    {
        try{
            if (!in_array($language, ['portuguese', 'english', 'spanish'])) {
                return response()->json([
                    'status' => 'failure',
                    'message' => 'Could not find any available status in that language.',
                    'data' => [],
                ],400);
            }
            $stati = Crm2easyApiLibrary::getAvailableStati($language);
            if(isset($stati->status)){
                return response()->json([
                    'status' => 'success',
                    'data' => $stati->status,
                ]);
            } else {
                return response()->json([
                    'status' => 'failure',
                    'message' => 'Could not find any available status.',
                    'data' => [],
                ],204);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'It was not possible to retrieve member data '.$e->getMessage()
            ], 500);
        }
    }

    public function clientData(int $client_id): JsonResponse
    {
        try{
            $clientData = Crm2easyApiLibrary::getClientData($client_id);
            if(isset($clientData->client)){
                return response()->json([
                    'status' => 'success',
                    'data' => $clientData->client,
                ]);
            } else {
                return response()->json([
                    'status' => 'failure',
                    'message' => 'Could not find any available status.',
                    'data' => [],
                ],204);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'It was not possible to retrieve member data '.$e->getMessage()
            ], 500);
        }
    }
}
