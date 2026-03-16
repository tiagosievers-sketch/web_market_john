<?php

namespace App\Http\Controllers;

use App\Actions\RelationshipActions;
use App\Http\Requests\CreateOrUpdateRelationshipsRequest;
use App\Models\Relationship;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RelationshipController extends Controller
{
    public function returnOtherMembersRelationshipsByApplication(int $application_id): JsonResponse
    {
        try{
            $relationships = RelationshipActions::getOtherMembersRelationshipsByApplication($application_id);
            return response()->json([
                'status' => 'success',
                'data' => $relationships,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
//                'message' => 'It was not possible to recover relationship data.'
                'message' => $e->getMessage()
            ], 500);
        }
    }

        public function createOrUpdateRelationships(CreateOrUpdateRelationshipsRequest $request): JsonResponse
        {
            try{
                $relationships = RelationshipActions::createOrUpdateRelationships($request);
                return response()->json([
                    'status' => 'success',
                    'data' => $relationships,
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'error',
    //                'message' => 'It was not possible to recover relationship data.'
                    'message' => $e->getMessage()
                ], 500);
            }
        }

    public function listRelationshipsHaveDetail(int $domain_value_id): JsonResponse
    {
        try{
            $exists = RelationshipActions::listRelationshipsHaveDetail($domain_value_id);
            return response()->json([
                'status' => 'success',
                'data' => $exists,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
//                'message' => 'It was not possible to recover relationship data.'
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function comboForRelationshipDetail(int $domain_value_id): JsonResponse
    {
        try{
            $combo = RelationshipActions::makeComboForRelationshipDetail($domain_value_id);

            if(count($combo) > 0){
                return response()->json([
                    'status' => 'success',
                    'data' => $combo,
                ]);
            }

            return response()->json([
                'status' => 'failure',
                'message' => 'There is no combo for this object.',
                'data' => $combo
            ],204);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function deleteRelationship(int $applicationId): JsonResponse
    {
        try {
            // Chama a lógica de exclusão
            $success = RelationshipActions::deleteRelationshipdata($applicationId);
    
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
