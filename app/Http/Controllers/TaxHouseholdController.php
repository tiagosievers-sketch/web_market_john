<?php

namespace App\Http\Controllers;

use App\Actions\TaxHouseholdActions;
use App\Http\Requests\StoreTaxHouseholdRequest;
use App\Models\Application;
use App\Models\HouseholdMember;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TaxHouseholdController extends Controller
{
    public function recoverNextMember(int $application_id): JsonResponse
    {
        try{
            $application = Application::find($application_id);
            if($application){
                $householdMember = TaxHouseholdActions::recoverNextMember($application->id);
                if($householdMember){
                    return response()->json([
                        'status' => 'success',
                        'data' => $householdMember->toArray(),
                    ]);
                } else {
                    return response()->json([
                        'status' => 'failure',
                        'message' => 'Could not find any member that do not have made TaxHousehold form.',
                        'data' => [],
                    ],204);
                }
            } else {
                throw new \Exception('Cannot find application with sent ID.');
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'It was not possible to retrieve member data '.$e->getMessage()
            ], 500);
        }
    }



    /** Fill the tax information of a previous registered Household Member and can register new non applicant members to
     * the household.
     * @throws \Exception
     */
    public function fillFirstHouseholdTaxForm(StoreTaxHouseholdRequest $request): JsonResponse
    {
        try{
            $nextMember = TaxHouseholdActions::storeTaxInformation($request);
            if(count($nextMember) > 0){
                return response()->json([
                    'status' => 'success',
                    'data' => $nextMember,
                ]);
            }
            return response()->json([
                'status' => 'failure',
                'message' => 'Could not find a next Household Member',
                'data' => [],
            ], 204);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        } catch (\Exception $e) {
//           dd($e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'It was not possible to send household data.'.$e->getMessage().'Line:'.$e->getLine()
            ], 500);
        }
    }

    public function deleteTaxData(Request $request, int $applicationId): JsonResponse
    {
        try {
            // Chama a lógica de exclusão
            $success = TaxHouseholdActions::deleteTaxData($applicationId);
    
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
            \Log::error("Erro ao excluir dados de Tax para aplicação ID {$applicationId}: " . $e->getMessage());
    
            // Retornar o erro detalhado para análise
            return response()->json([
                'status' => 'error',
                'message' => 'Erro ao processar a solicitação.',
                'details' => $e->getMessage(), // Detalhes da exceção
            ], 500);
        }
    }
    
    
}
