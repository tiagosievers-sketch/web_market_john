<?php

namespace App\Http\Controllers;

use App\Actions\HouseholdActions;
use App\Http\Requests\StoreHouseholdQuotationRequest;
use App\Http\Requests\StoreHouseholdRequest;
use App\Models\HouseholdMember;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class HouseholdController extends Controller
{
    /**
     * @throws \Exception
     */
    public function ajaxCreate(StoreHouseholdRequest $request): JsonResponse
    {
        try{
            $household = HouseholdActions::createHousehold($request);
            return response()->json([
                'status' => 'success',
                'data' => $household,
            ]);
        } catch (ValidationException $e) {
//           dd($e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        } catch (\Exception $e) {
//           dd($e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'It was not possible to send household data.'.$e->getMessage()
            ], 500);
        }
    }

    /**
     * @throws \Exception
     */
    public function ajaxCreateQuotation(StoreHouseholdQuotationRequest $request): JsonResponse
    {
        try{
            // dd($request);
            $householdMembers = HouseholdActions::createHouseholdForQuotation($request);
          
            return response()->json([
                'status' => 'success',
                'data' => $householdMembers,
            ]);
        } catch (ValidationException $e) {
            dd($e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        } catch (\Exception $e) {
//           dd($e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'It was not possible to send household data.'.$e->getMessage()
            ], 500);
        }
    }

    /**
     * @throws \Exception
     */
    public function ajaxDelete(int $household_member_id): JsonResponse
    {
        try{
            $return = HouseholdActions::deleteHouseholdMember($household_member_id);
            if($return){
                return response()->json([
                    'status' => 'success',
                    'message' => 'Household Member and related tables where removed successfully',
                ]);
            }
            return response()->json([
                'status' => 'failed',
                'message' => 'Household Member and related tables where not removed successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }


    public function deleteHouseHoldData(Request $request, int $applicationId): JsonResponse
    {
        try {
            // Chama a lógica de exclusão
            $success = HouseholdActions::deleteHouseHold($applicationId);
    
            if ($success) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Dados relacionados a Tax excluídos com sucesso.',
                ]);
            }
    
            return response()->json([
                'status' => 'error',
                'message' => 'Não foi possível excluir os dados de Tax.',
            ]);
        } catch (\Exception $e) {
           
    
            // Retornar o erro detalhado para análise
            return response()->json([
                'status' => 'error',
                'message' => 'Erro ao processar a solicitação.',
                'details' => $e->getMessage(), // Detalhes da exceção
            ], 500);
        }
    }

}
