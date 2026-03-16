<?php

namespace App\Actions;

use App\Http\Requests\CreateOrUpdateRelationshipsRequest;
use App\Libraries\GatewayHttpLibrary;
use App\Models\Address;
use App\Models\DomainValue;
use App\Models\HouseholdMember;
use App\Models\Relationship;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use function PHPUnit\Framework\matches;

class RelationshipActions
{
    /**
     * @throws Exception
     */
    public static function getOtherMembersRelationshipsByApplication(int $application_id): array
    {
        $householdMembers = HouseholdMember::where('application_id', '=', $application_id)->where('field_type', '!=', 0)->get();
        if ($householdMembers) {
            $relationships = [];
            $members = $householdMembers->toArray();
            return self::generateRelationShipArray($members, $relationships);
        }
        return [];
    }

    private static function generateRelationShipArray(array &$members, array &$relationshipsArray): array
    {
        if (count($members) > 1) {
            $mainMember = reset($members);
            $key = key($members);
            $relationships = [
                'name' => $mainMember['firstname'] . ' ' . $mainMember['lastname'],
                'relationships' => []
            ];
            $id = $mainMember['id'];
            unset($members[$key]);
            foreach ($members as $member) {
                $relation = Relationship::where('member_from_id', $id)->where('member_to_id', $member['id'])->first();
                if ($relation) {
                    $relationships['relationships'][] = [
                        'member_from_name' => $mainMember['firstname'] . ' ' . $mainMember['lastname'],
                        'member_from_id' => $relation->member_from_id,
                        'relationship' => $relation->relationship,
                        'relationship_detail' => $relation->relationship_detail,
                        'member_to_name' => $member['firstname'] . ' ' . $member['lastname'],
                        'member_to_id' => $relation->member_to_id,
                    ];
                } else {
                    $relationships['relationships'][] = [
                        'member_from_name' => $mainMember['firstname'] . ' ' . $mainMember['lastname'],
                        'member_from_id' => $id,
                        'relationship' => null,
                        'relationship_detail' => null,
                        'member_to_name' => $member['firstname'] . ' ' . $member['lastname'],
                        'member_to_id' => $member['id'],
                    ];
                }
            }
            $relationshipsArray[] = $relationships;
            self::generateRelationShipArray($members, $relationshipsArray);
        }
        return $relationshipsArray;
    }

    /**
     * @throws Exception
     */
    public static function createOrUpdateRelationships(CreateOrUpdateRelationshipsRequest $request): array
    {
        $userId = Auth::id();
        $requestArData = $request->validated();
        $application_id = $requestArData['application_id'];
        $householdRelationships = $requestArData['household_relatioships'];
        foreach ($householdRelationships as $householdRelationship) {
            $relationships = $householdRelationship['relationships'];
            foreach ($relationships as $relationship) {
                $relationshipModel = Relationship::where('member_from_id', '=', $relationship['member_from_id'])
                    ->where('member_to_id', '=', $relationship['member_to_id'])
                    ->where('application_id', '=', $application_id)
                    ->first();
                    if ($relationshipModel) {                   
                        $relationshipModel->update([
                            'relationship' => $relationship['relationship'],
                            'relationship_detail' => $relationship['relationship_detail'], 
                        ]);
                    } else {
                        // Criação de novo relacionamento
                        $relationshipData = [
                            'member_from_id' => $relationship['member_from_id'],
                            'relationship' => $relationship['relationship'],
                            'relationship_detail' => $relationship['relationship_detail'], 
                            'member_to_id' => $relationship['member_to_id'],
                            'application_id' => $application_id,
                            'created_by' => $userId,
                        ];
                    
                        $result = Relationship::create($relationshipData);
                    }
                    
            }
        }
        return self::getOtherMembersRelationshipsByApplication($application_id);
    }

    public static function listRelationshipsHaveDetail(int $id)
    {
        return DomainValue::whereNotIn('alias', [
            'relacaoEsposa',
            'relacaoCrianca',
            'relacionamentoCunhadoCunhada',
            'relacionamentoGenroNora'
        ])
            ->where('id', '=', $id)
            ->whereHas('domain', function ($query) {
                $query->where('alias', '=', 'relationship');
            })
            ->exists()
        ;
    }

    public static function makeComboForRelationshipDetail(int $id): array
    {
        $domain = DomainValue::find($id);
        $combo = [];
        if($domain){
           $values = match($domain->alias) {
               'relacaoEsposa',
               'relacaoCrianca',
               'relacaoEnteado',
               'relacaoPai',
               'relacaoPadastro',
               'relacaoDomestico' => "'NONE'",
               'relacionamentoParente' => "'otherFormerSpouse','otherFosterChild','noLegalRelationship','collateralDependent','courtAppointedGuardian','guardian','ward','sponsoredDependent'",
               'relacionamentoDomesticoFilho' => "'otherFosterChild','noLegalRelationship','collateralDependent','courtAppointedGuardian','guardian','ward','sponsoredDependent'",
               default => "'noLegalRelationship','collateralDependent','courtAppointedGuardian','guardian','ward','sponsoredDependent'"
           };
           $comboObjects = DomainValue::select('id','name')->whereRaw('domain_values.alias in ('.$values.')')->orderBy('name')->get();
            if(count($comboObjects) > 0) {
                foreach ($comboObjects as $domainValue) {
                    $combo[] = [$domainValue->id => $domainValue->name];
                }
            }
        }
        return $combo;
    }

    
    public static function deleteRelationshipdata(int $application_id): bool
    {
        DB::beginTransaction();

        try {

            $membersToDelete = HouseholdMember::where(function ($query) {
                $query->where('applying_coverage', '=', 0)
                      ->where('field_type', '<>', 0);
            })
            ->pluck('id')
            ->toArray();

            \Log::info("Membros para deletar na aplicação {$application_id}: " . json_encode($membersToDelete));

                // Atualizar referências de `tax_claimant` que apontam para os membros a serem excluídos
                HouseholdMember::whereIn('tax_claimant', $membersToDelete)->update(['tax_claimant' => null]);
                HouseholdMember::whereIn('taking_care_of', $membersToDelete)->update(['taking_care_of' => null]);
                HouseholdMember::whereIn('lives_with', $membersToDelete)->update(['lives_with' => null]);


            //Address
            if (Address::whereIn('household_member_id', $membersToDelete)->exists()) {
                $addresses = Address::whereIn('household_member_id', $membersToDelete)->delete();
                \Log::info("Entradas excluídas de Address: {$addresses}");
            } else {
                \Log::info("Nenhuma entrada encontrada para exclusão em Address.");
            }


            // Excluir relacionamentos na tabela `relationships`
            if (Relationship::where('application_id', $application_id)
                ->orWhereIn('member_from_id', $membersToDelete)
                ->orWhereIn('member_to_id', $membersToDelete)
                ->exists()
            ) {
                $relationshipsDeleted = Relationship::where('application_id', $application_id)
                    ->orWhereIn('member_from_id', $membersToDelete)
                    ->orWhereIn('member_to_id', $membersToDelete)
                    ->delete();
                \Log::info("Relacionamentos excluídos: {$relationshipsDeleted}");
            } else {
                \Log::info("Nenhuma entrada encontrada para exclusão em Relationships.");
            }

            // Excluir membros encontrados
            if (HouseholdMember::whereIn('id', $membersToDelete)->exists()) {
                $membersDeleted = HouseholdMember::whereIn('id', $membersToDelete)->delete();
                \Log::info("Membros excluídos de HouseholdMember: {$membersDeleted}");
            } else {
                \Log::info("Nenhuma entrada encontrada para exclusão em HouseholdMember.");
            }

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error("Erro ao apagar dados relacionados à Tax para aplicação ID {$application_id}: " . $e->getMessage());
            throw $e;
        }
    }
}
