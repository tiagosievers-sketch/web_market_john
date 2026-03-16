<?php

namespace App\Actions;

use App\Http\Requests\StoreHouseholdQuotationRequest;
use App\Http\Requests\StoreHouseholdRequest;
use App\Http\Requests\StoreTaxHouseholdRequest;
use App\Models\Address;
use App\Models\Application;
use App\Models\Finalize;
use App\Models\Household;
use App\Models\HouseholdMember;
use App\Models\IncomeDeduction;
use App\Models\Relationship;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TaxHouseholdActions
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
        'OtherNonMember' => 6
    ];

    public static function recoverNextMember(int $application_id)
    {
        return HouseholdMember::where('application_id', '=', $application_id)
            ->where('tax_form', '=', 0)
            ->orderBy('id')
            ->first()
        ;
    }

    public static function storeTaxInformation(StoreTaxHouseholdRequest $request)
    {
        $userId = Auth::id();
        $validated = $request->validated();
        $mainMember = HouseholdMember::find($validated['this_household_member_id']);
        if ($mainMember) {
            $tax_claimant = $mainMember->tax_claimant;
            $tax_filler = $validated['tax_filler'];
            $tax_filler_spouse = 0;
            $tax_form_spouse = 0;
            if (isset($validated['tax_claimant'])) {
                $tax_claimant = $validated['tax_claimant'];
            }
            if (($tax_claimant == null) && $tax_filler) {
                $tax_claimant = $mainMember->id;
            }
            if ($validated['jointly_taxed_spouse']) {
                $tax_filler_spouse = 1;
            }
            if (isset($validated['new_household_members'])) {
                if (count($validated['new_household_members']) > 0) {
                    foreach ($validated['new_household_members'] as $newHouseholdMember) {
                        $lives_with = null;
                        if ($newHouseholdMember['lives_with_you']) {
                            $lives_with = $mainMember->id;
                        }
                        $birthdate = Carbon::createFromFormat('m/d/Y', $newHouseholdMember['birthdate']);
                        $birthdate = $birthdate->format('Y-m-d');
                        $newMemberData = [
                            'firstname' => $newHouseholdMember['firstname'],
                            'middlename' => $newHouseholdMember['middlename'] ?? null,
                            'lastname' => $newHouseholdMember['lastname'],
                            'suffix' => $newHouseholdMember['suffix'] ?? null,
                            'birthdate' => $birthdate,
                            'married' => ($newHouseholdMember['field_type'] == self::FIELD_TYPES['SpouseTax']) ? 1 : 0,
                            'sex' => $newHouseholdMember['sex'],
                            'field_type' => $newHouseholdMember['field_type'],
                            'lives_with' => $lives_with,
                            'is_dependent' => $newHouseholdMember['is_dependent'],
                            'tax_filler' => ($newHouseholdMember['field_type'] == self::FIELD_TYPES['SpouseTax']) ? $tax_filler_spouse : ($newHouseholdMember['tax_filler'] ?? null),
                            'tax_form' => ($newHouseholdMember['field_type'] == self::FIELD_TYPES['SpouseTax']) ? $tax_form_spouse : 0,
                            'jointly_taxed_spouse' => ($newHouseholdMember['field_type'] == self::FIELD_TYPES['SpouseTax']) ? $validated['jointly_taxed_spouse'] : 0,
                            'application_id' => $validated['application_id'],
                            'created_by' => $userId
                        ];
                        $newMember = HouseholdMember::create($newMemberData);
                        if ($newMember) {
                            $relatioshipData = [
                                'member_from_id' => $mainMember->id,
                                'relationship' => $newHouseholdMember['relationship'],
                                'relationship_detail' => $newHouseholdMember['relationship_detail'] ?? null,
                                'member_to_id' => $newMember->id,
                                'application_id' => $validated['application_id'],
                                'created_by' => $userId
                            ];
                        }
                        $relationship = Relationship::create($relatioshipData);
                        if ($newMember->taxfiller && $newMember->field_type == self::FIELD_TYPES['OtherTax']) {
                            $tax_claimant = $newMember->id;
                        }
                    }
                }
            }
            if (isset($validated['dependents'])) {
                if (count($validated['dependents']) > 0) {
                    foreach ($validated['dependents'] as $dependent) {
                        $memberDependents = HouseholdMember::find($dependent['id']);
                        $lives_with = null;
                        if ($dependent['lives_with_you']) {
                            $lives_with = $mainMember->id;
                        }
                        $memberDependentData = [
                            'lives_with' => $lives_with,
                            'tax_claimant' => $tax_claimant,
                            'created_by' => $userId
                        ];
                        $memberDependents->update($memberDependentData);
                    }
                }
            }
            if (isset($validated['spouse'])) {
                if (count($validated['spouse']) > 0) {
                    $memberSpouse = HouseholdMember::find($validated['spouse'][0]['id']);
                    $lives_with = null;
                    if ($validated['spouse'][0]['lives_with_you']) {
                        $lives_with = $mainMember->id;
                    }
                    $memberSpouseData = [
                        'tax_filler' => $tax_filler_spouse,
                        'lives_with' => $lives_with,
                        'tax_claimant' => $tax_claimant,
                        'jointly_taxed_spouse' => $validated['jointly_taxed_spouse'],
                        'tax_form' => $validated['jointly_taxed_spouse'] ?: $memberSpouse->tax_form,
                        'created_by' => $userId
                    ];
                    $memberSpouse->update($memberSpouseData);
                }
            }
            $mainMemberData = [
                'married' => $validated['married'],
                'fed_tax_income_return' => $validated['fed_tax_income_return'],
                'tax_filler' => $tax_filler,
                'tax_claimant' => $tax_claimant,
                'is_dependent' => ($tax_claimant == $mainMember->id),
                'provide_tax_filler_information' => $validated['provide_tax_filler_information'],
                'tax_form' => 1,
                'created_by' => $userId
            ];
            $mainMember->update($mainMemberData);
        }
        $nextMember = self::recoverNextMember($validated['application_id']);
        if ($nextMember) {
            return $nextMember->toArray();
        }
        return [];
    }




    public static function deleteTaxData(int $application_id): bool
    {
        DB::beginTransaction();

        try {

            // Buscar membros que não são applicants
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
