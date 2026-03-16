<?php

namespace App\Http\Controllers;

use App\Actions\FinalizeActions;
use App\Http\Requests\StoreFinalizeRequest;
use App\Http\Requests\UpdateHouseHoldMemberFinalizeRequest;
use App\Http\Requests\UpdateIncomeRequest;
use App\Http\Requests\UpdateMemberFinalizeRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class FinalizeController extends Controller
{
    // public function store(StoreFinalizeRequest $request)
    // {
    //     $data = $request->validated();
    //     Finalize::create($data);

    //     return response()->json(['message' => 'Judicial message created successfully!'], 201);
    // }

    public function store(StoreFinalizeRequest $request): JsonResponse
    {
        try {
            $finalizeId = FinalizeActions::storeFinalize($request);

            if ($finalizeId) {
                return response()->json([
                    'status' => 'success',
                    'data' => ['id' => $finalizeId], // Retorna o ID do registro inserido
                ], 200); // Status HTTP 200 para sucesso
            }

            return response()->json([
                'status' => 'failure',
                'message' => 'Finalize not found.',
                'data' => [],
            ], 404); // Use status 404 para "não encontrado"
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error: ' . $e->getMessage(),
            ], 422); // Status 422 para erro de validação
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred: ' . $e->getMessage(),
                'line' => $e->getLine(), // Inclui a linha do erro para depuração
            ], 500);
        }
    }
    public function updateMember(UpdateMemberFinalizeRequest $request): JsonResponse
    {
        try {
            $finalizeId = FinalizeActions::updateMemberFinalize($request);

            if ($finalizeId) {
                return response()->json([
                    'status' => 'success',
                    'data' => ['id' => $finalizeId],
                ], 200);
            }

            return response()->json([
                'status' => 'failure',
                'message' => 'Finalize not found.',
                'data' => [],
            ], 404);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error: ' . $e->getMessage(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred: ' . $e->getMessage(),
                'line' => $e->getLine(),
            ], 500);
        }
    }



    
    public function updateHouseholdMember(UpdateHouseHoldMemberFinalizeRequest $request): JsonResponse
    {
        try {

            FinalizeActions::updateHouseHoldMemberFinalize($request);
        

            return response()->json([
                'status' => 'success',
                'message' => __('labels.dadosAtualizados')
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateIncome(UpdateIncomeRequest $request)
    {
        try {
            $income = FinalizeActions::updateIncome($request);

            return response()->json([
                'status' => 'success',
                'message' => 'Income updated successfully!',
                'data' => $income
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
