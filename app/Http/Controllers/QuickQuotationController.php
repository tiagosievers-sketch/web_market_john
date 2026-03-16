<?php

namespace App\Http\Controllers;

use App\Actions\QuickQuotationActions;
use App\Http\Requests\StoreQuickQuotationRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class QuickQuotationController extends Controller
{
    public function storeQuickQuotation(StoreQuickQuotationRequest $request): JsonResponse
    {
        try {
            // Chama a função storeQuotationData e obtém o ID da aplicação
            $applicationId = QuickQuotationActions::storeQuotationData($request);

            if ($applicationId) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Dados salvos com sucesso!',
                    'application_id' => $applicationId
                ]);
            }

            return response()->json([
                'status' => 'failure',
                'message' => 'Falha ao salvar os dados.'
            ], 204);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Erro ao salvar os dados: ' . $e->getMessage() . ' Line: ' . $e->getLine()
            ], 500);
        }
    }



    public function addMember(Request $request, $applicationId): JsonResponse
    {
        try {
            $response = QuickQuotationActions::addMember($request, $applicationId);
            return response()->json($response);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Erro ao adicionar membro: ' . $e->getMessage()], 500);
        }
    }

    // Método para remover um membro (dependent ou spouse)
    public function removeMember($applicationId, $memberId): JsonResponse
    {
        try {
            $response = QuickQuotationActions::removeMember($applicationId, $memberId);
            return response()->json($response);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Erro ao remover membro: ' . $e->getMessage()], 500);
        }
    }
}
