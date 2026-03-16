<?php

namespace App\Http\Controllers;

use App\Actions\MemberInformationActions;
use App\Http\Requests\StoreMemberHouseholdRequest;
use App\Http\Requests\StoreTaxHouseholdRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class MemberInformationController extends Controller
{
    public function recoverMemberInformationList(): JsonResponse
    {
        try{
            $data = array();
            if(count($data) > 0){
                return response()->json([
                    'status' => 'success',
                    'data' => $data,
                    'message' => 'Successfully recover members list.',
                ]);
            }
            return response()->json([
                'status' => 'failure',
                'message' => 'Could not successfully recover members list.',
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
                'message' => 'Could not successfully organize members addresses.'.$e->getMessage()
            ], 500);
        }
    }

      /** Fill the tax information of a previous registered Household Member and can register new non applicant members to
     * the household.
     * @throws \Exception
     */
    public function storeMemberInformation(StoreMemberHouseholdRequest $request): JsonResponse
    {
        try {
            $member = MemberInformationActions::storeMemberInformationAction($request);
            
            // Verifica se o próximo membro foi encontrado e define o status apropriado
            if (!empty($member['id'])) {
                return response()->json([
                    'status' => 'success',
                    'data' => $member,
                ], 200); // Retorna status 200 com conteúdo
            }
    
            // Retorna resposta com status 200 e mensagem se não houver próximo membro
            return response()->json([
                'status' => 'completed',
                'message' => 'Nenhum próximo membro encontrado. Todos os membros foram completados.',
                'data' => $member,
            ], 200); // Mude de 204 para 200
        } catch (ValidationException $e) {
            \Log::error('Validation error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Erro de validação: ' . $e->getMessage(),
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Exception: ' . $e->getMessage() . ' at Line ' . $e->getLine());
            return response()->json([
                'status' => 'error',
                'message' => 'Erro ao processar dados: ' . $e->getMessage(),
            ], 500);
        }
    }
    
    
}
