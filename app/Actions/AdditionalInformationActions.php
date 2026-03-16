<?php

namespace App\Actions;

use App\Http\Requests\StoreAdditionalInformationRequest;
use App\Models\Address;
use App\Models\Finalize;
use App\Models\HouseholdMember;
use App\Models\IncomeDeduction;
use App\Models\Relationship;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdditionalInformationActions
{

    const FIELD_TYPES = [
        //Applicant
        'applicant' => 0,
        //Household
        'Spouse' => 1,
        'OtherApplicant' => 2,
        'SpouseTax' => 3,
        'DependentTax' => 4,
        'OtherTax' => 5,
        //AdditionalInformation
        'OtherNonMember' => 6,
        'Child' => 7
    ];

    public static function storeAdditionalInformation(StoreAdditionalInformationRequest $request)
    {
        $userId = Auth::id();
        $validated = $request->validated();
        $mainMember = HouseholdMember::find($validated['this_household_member_id']);
        $lives_with = $mainMember->id;
        $taking_care_of = null;
        if ($mainMember) {
           // Gravando caso exista a criança que o membro principal é responsável por cuidar e não está descrita ainda
           $mainMemberData['live_someone_under_nineteen'] = $validated['this_household_member_id'];
           $mainMemberData['taking_care_under_nineteen'] = $validated['taking_care_under_nineteen'];
           if( $validated['taking_care_under_nineteen'] && count($validated['child_taking_care']) > 0){
               $childTakingCare = $validated['child_taking_care'];
               reset($childTakingCare);
               $childTakingCare = current($childTakingCare);
               $birthdate = Carbon::createFromFormat('m/d/Y', $childTakingCare['birthdate']);
               $birthdate = $birthdate->format('Y-m-d');
               $childTakingCareData = [
                   'firstname' => $childTakingCare['firstname'],
                   'middlename' => $childTakingCare['middlename']??null,
                   'lastname' => $childTakingCare['lastname'],
                   'suffix' => $childTakingCare['suffix']??null,
                   'birthdate' => $birthdate,
                   'sex' => $childTakingCare['sex'],
                   'field_type' => self::FIELD_TYPES['OtherNonMember'],
                   'lives_with' => $lives_with,
                   'is_dependent' => 0,
                   'tax_form' => 1,
                   'application_id' => $validated['application_id'],
                   'created_by' => $userId
               ];
               $newChildTakingCare = HouseholdMember::create($childTakingCareData);
               if($newChildTakingCare){
                   $taking_care_of = $newChildTakingCare->id;
                   $relatioshipData = [
                       'member_from_id' => $mainMember->id,
                       'relationship' => $childTakingCare['relationship'],
                       'relationship_detail' => $childTakingCare['relationship_detail']??null,
                       'member_to_id' => $newChildTakingCare->id,
                       'application_id' => $validated['application_id'],
                       'created_by' => $userId
                   ];
               }
               $relationship = Relationship::create($relatioshipData);
           }
           //Gravando outros filhos ou filhas ainda não descritos ainda.
           $mainMemberData['live_any_other_family'] = $validated['live_any_other_family'];
           $mainMemberData['live_son_daughter'] = $validated['live_son_daughter'];
            if($mainMemberData['live_son_daughter'] && count($validated['other_son_daughter']) > 0){
                foreach($validated['other_son_daughter'] as $sonOrDaughter) {
                    $birthdate = Carbon::createFromFormat('m/d/Y', $sonOrDaughter['birthdate']);
                    $birthdate = $birthdate->format('Y-m-d');
                    $sonOrDaughterData = [
                        'firstname' => $sonOrDaughter['firstname'],
                        'middlename' => $sonOrDaughter['middlename'] ?? null,
                        'lastname' => $sonOrDaughter['lastname'],
                        'suffix' => $sonOrDaughter['suffix'] ?? null,
                        'birthdate' => $birthdate,
                        'sex' => $sonOrDaughter['sex'],
                        'field_type' => self::FIELD_TYPES['OtherNonMember'],
                        'lives_with' => $lives_with,
                        'is_dependent' => 0,
                        'tax_form' => 1,
                        'application_id' => $validated['application_id'],
                        'created_by' => $userId
                    ];
                    $newSonOrDaughter = HouseholdMember::create($sonOrDaughterData);
                    if ($newSonOrDaughter) {
                        $relatioshipData = [
                            'member_from_id' => $mainMember->id,
                            'relationship' => $sonOrDaughter['relationship'],
                            'relationship_detail' => $sonOrDaughter['relationship_detail'] ?? null,
                            'member_to_id' => $newSonOrDaughter->id,
                            'application_id' => $validated['application_id'],
                            'created_by' => $userId
                        ];
                    }
                    $relationship = Relationship::create($relatioshipData);
                }
            }
           $mainMemberData['taking_care_of'] = $taking_care_of;
            return $mainMember->update($mainMemberData);
        }
        return false;
    }


    public static function deleteAdditionalInformationData(int $application_id)
    {
        DB::beginTransaction();

        try {

            $membersToDelete = HouseholdMember::where('application_id', $application_id)
                ->where('field_type', '=', self::FIELD_TYPES['OtherNonMember'])
                ->orWhere('field_type', '=', self::FIELD_TYPES['Child'])
                ->pluck('id')
                ->toArray();

            \Log::info("Membros para deletar na aplicação {$application_id}: " . json_encode($membersToDelete));

                HouseholdMember::whereIn('tax_claimant', $membersToDelete)->update(['tax_claimant' => null]);
                HouseholdMember::whereIn('taking_care_of', $membersToDelete)->update(['taking_care_of' => null]);


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
            \Log::error("Erro ao apagar dados relacionados à Additional information para aplicação ID {$application_id}: " . $e->getMessage());
            throw $e;
        }
    }
}
