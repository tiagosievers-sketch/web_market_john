<?php

namespace App\Http\Controllers;

use App\Actions\AdditionalInformationActions;
use App\Http\Requests\StoreAdditionalInformationRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AdditionalInformationController extends Controller
{
    /** Fill the tax information of a previous registered Household Member and can register new non applicant members to
     * the household.
     * @throws \Exception
     */
    public function fillAdditionalInformation(StoreAdditionalInformationRequest $request): JsonResponse
    {
        try{
            $response = AdditionalInformationActions::storeAdditionalInformation($request);
            if($response){
                return response()->json([
                    'status' => 'success',
                    'message' => 'Additional information registered with success.',
                ]);
            }
            return response()->json([
                'status' => 'failure',
                'message' => 'Could not find the main Household Member'
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
                'message' => 'It was not possible to send additional information data.'.$e->getMessage()
            ], 500);
        }
    }


    public function deleteAdditionalInformation(int $applicationId): JsonResponse
    {
        try {
            // Log de entrada: verifique se o applicationId está correto
            \Log::info("Iniciando exclusão de informações adicionais para a aplicação ID: {$applicationId}");

            $success = AdditionalInformationActions::deleteAdditionalInformationData($applicationId);

            // Log após a tentativa de exclusão
            \Log::info("Resultado da exclusão de dados: " . ($success ? 'Sucesso' : 'Falha'));

            if ($success) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Dados relacionados a Additional information excluídos com sucesso.',
                ]);
            }

            \Log::warning("Falha ao excluir dados de Additional information para a aplicação ID: {$applicationId}");

            return response()->json([
                'status' => 'error',
                'message' => 'Não foi possível excluir os dados de Additional information.',
            ]);
        } catch (\Exception $e) {
            // Log de erro: para capturar detalhes da exceção
            \Log::error("Erro ao excluir dados de Additional information para aplicação ID {$applicationId}: " . $e->getMessage());

            // Retornar o erro detalhado para análise
            return response()->json([
                'status' => 'error',
                'message' => 'Erro ao processar a solicitação.',
                'details' => $e->getMessage(), // Detalhes da exceção
            ], 500);
        }
    }

}
