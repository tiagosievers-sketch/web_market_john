<?php

namespace App\Actions;

use App\Http\Requests\StoreHouseholdQuotationRequest;
use App\Http\Requests\StoreHouseholdRequest;
use App\Models\Address;
use App\Models\Application;
use App\Models\Household;
use App\Models\HouseholdMember;
use App\Models\Relationship;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class HouseholdActions
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

    /**
     * @throws Exception
     */
    public static function createHouseholdForQuotation(StoreHouseholdQuotationRequest $request): array
    {
    
        $userId = Auth::id();
        $householdReq = $request->validated();
            // dd($householdReq);
        $mainApplicant = HouseholdMember::where('application_id', $householdReq['application_id'])->where('field_type',self::FIELD_TYPES['applicant'])->first();
        $householdMembersReq = $householdReq['household_members'];
        if (count($householdMembersReq) > 0) {
            $householdMemberData = [];
            $birthdate = '';
            $householdApplicant = null;
            $mainMarried = self::isMarried($householdMembersReq);
            foreach ($householdMembersReq as $member) {
                switch ($member['field_type']) {
                    case (self::FIELD_TYPES['applicant']):
                        $mainApplicant->update([
                            'applying_coverage' => 1,
                            'eligible_cost_saving' => $member['eligible_cost_saving']??0,
                            'married' => $mainMarried??0,
                            'is_dependent' => 0,
                            'use_tobacco' => $member['use_tobacco']??0,
                            'income_predicted_amount' => $member['income_predicted_amount']??0,
                        ]);
                        break;
                    case (self::FIELD_TYPES['Spouse']):
                        $birthdate = Carbon::createFromFormat('m/d/Y', $member['birthdate']);
                        $birthdate = $birthdate->format('Y-m-d');
                        $householdMemberData = [
                            'application_id' => $householdReq['application_id'],
                            'firstname' => $member['firstname'],
                            'middlename' => $member['middlename'],
                            'lastname' => $member['lastname'],
                            'suffix' => $member['suffix'],
                            'birthdate' => $birthdate,
                            'sex' => $member['sex'],
                            'has_perm_address' => $member['has_perm_address']??0,
                            'applying_coverage' => 1,
                            'eligible_cost_saving' => $member['eligible_cost_saving']??0,
                            'married' => 1,
                            'field_type' => self::FIELD_TYPES['Spouse'],
                            'is_dependent' => 0,
                            'use_tobacco' => $member['use_tobacco']??0,
                            'created_by' => $userId
                        ];
                        $householdApplicant = HouseholdMember::create($householdMemberData);
                        break;
                    default:
                        $birthdate = Carbon::createFromFormat('m/d/Y', $member['birthdate']);
                        $birthdate = $birthdate->format('Y-m-d');
                        $householdMemberData = [
                            'application_id' => $householdReq['application_id'],
                            'firstname' => $member['firstname'],
                            'middlename' => $member['middlename'],
                            'lastname' => $member['lastname'],
                            'suffix' => $member['suffix'],
                            'birthdate' => $birthdate,
                            'sex' => $member['sex'],
                            'has_perm_address' => $member['has_perm_address']??0,
                            'applying_coverage' => 1,
                            'eligible_cost_saving' => $member['eligible_cost_saving']??0,
                            'married' => $member['married']??0,
                            'field_type' => $member['field_type']??self::FIELD_TYPES['OtherApplicant'],
                            'is_dependent' => 1,
                            'use_tobacco' => $member['use_tobacco']??0,
                            'created_by' => $userId
                        ];
                        $householdApplicant = HouseholdMember::create($householdMemberData);
                }
            }
        }
        $application = Application::find($householdReq['application_id']);
        $application->load(['householdMembers']);
        return $application->householdMembers->toArray();
    }



    /**
     * @throws Exception
     */
    public static function createHousehold(StoreHouseholdRequest $request): array
    {
        $userId = Auth::id();
        $householdReq = $request->validated();
        $mainApplicant = HouseholdMember::where('application_id', $householdReq['application_id'])->where('field_type',self::FIELD_TYPES['applicant'])->first();
        $mainApplicantData = [];
        $mainMarried = 0;
        $householdMembersReq = $householdReq['household_members'];
        if (count($householdMembersReq) > 0) {
            foreach ($householdMembersReq as $member) {
                switch ($member['field_type']) {
                    case (self::FIELD_TYPES['applicant']):
                        $mainApplicantData = [
                            'applying_coverage' => 1,
                            'eligible_cost_saving' => $member['eligible_cost_saving']??0,
                            'is_dependent' => 0,
                            'created_by' => $userId
                        ];
                        break;
                    case (self::FIELD_TYPES['Spouse']):
                        $birthdate = Carbon::createFromFormat('m/d/Y', $member['birthdate']);
                        $birthdate = $birthdate->format('Y-m-d');
                        $householdMemberData = [
                            'application_id' => $householdReq['application_id'],
                            'firstname' => $member['firstname'],
                            'middlename' => $member['middlename'],
                            'lastname' => $member['lastname'],
                            'suffix' => $member['suffix'],
                            'birthdate' => $birthdate,
                            'sex' => $member['sex'],
                            'applying_coverage' => 1,
                            'eligible_cost_saving' => $member['eligible_cost_saving']??0,
                            'married' => 1,
                            'field_type' => self::FIELD_TYPES['Spouse'],
                            'is_dependent' => 0,
                            'created_by' => $userId
                        ];
                        $householdApplicant = HouseholdMember::create($householdMemberData);
                        if($householdApplicant){
                            $relatioshipData = [
                                'member_from_id' => $mainApplicant->id,
                                'relationship' => $member['relationship'],
                                'relationship_detail' => $member['relationship_detail']??null,
                                'member_to_id' => $householdApplicant->id,
                                'application_id' => $householdReq['application_id'],
                                'created_by' => $userId
                            ];
                        }
                        $relationship = Relationship::create($relatioshipData);
                        $mainMarried = 1;
                        break;
                    default:
                        $birthdate = Carbon::createFromFormat('m/d/Y', $member['birthdate']);
                        $birthdate = $birthdate->format('Y-m-d');
                        $householdMemberData = [
                            'application_id' => $householdReq['application_id'],
                            'firstname' => $member['firstname'],
                            'middlename' => $member['middlename'],
                            'lastname' => $member['lastname'],
                            'suffix' => $member['suffix'],
                            'birthdate' => $birthdate,
                            'sex' => $member['sex'],
                            'applying_coverage' => 1,
                            'eligible_cost_saving' => $member['eligible_cost_saving']??0,
                            'married' => $member['married']??0,
                            'field_type' => $member['field_type']??self::FIELD_TYPES['OtherApplicant'],
                            'is_dependent' => 0,
                            'created_by' => $userId
                        ];
                        $householdApplicant = HouseholdMember::create($householdMemberData);
                        if($householdApplicant){
                            $relatioshipData = [
                                'member_from_id' => $mainApplicant->id,
                                'relationship' => $member['relationship'],
                                'relationship_detail' => $member['relationship_detail']??null,
                                'member_to_id' => $householdApplicant->id,
                                'application_id' => $householdReq['application_id'],
                                'created_by' => $userId
                            ];
                        }
                        $relationship = Relationship::create($relatioshipData);
                }
            }
            $mainApplicantData['married'] = $mainMarried;
            $mainApplicant->update($mainApplicantData);
        }
        $application = Application::find($householdReq['application_id'])->first();
        $application->load(['householdMembers']);
        return $application->householdMembers->toArray();
    }

    /**
     * @throws Exception
     */
    public static function createOrUpdateHousehold(StoreHouseholdRequest $request): array
    {
        $userId = Auth::id();
        $householdReq = $request->validated();
        $household = Household::where('application_id', $householdReq['application_id'])->first();
        $householdData = [
            'application_id' => $householdReq['application_id'],
            'applying_coverage' => $householdReq['applying_coverage'],
            'eligible_cost_saving' => $householdReq['eligible_cost_saving'],
            'married' => $householdReq['married'],
            'fed_tax_income_return' => $householdReq['fed_tax_income_return'],
            'jointly_taxed_spouse' => $householdReq['jointly_taxed_spouse'],
            'is_dependent' => $householdReq['is_dependent'],
            'created_by' => $userId
        ];
        if ($household) {
            $household->update($householdData);
        } else {
            $household = Household::create($householdData);
        }
        if ($household) {
            $household->load(['householdMembers', 'taxHouseholdMembers']);
            if (count($household->householdMembers) > 0) {
                foreach ($household->householdMembers as $member) {
                    $member->delete();
                }
            }
            if (count($household->taxHouseholdMembers) > 0) {
                foreach ($household->taxHouseholdMembers as $member) {
                    $member->delete();
                }
            }
            if (isset($householdReq['household_members'])) {

                if (count($householdReq['household_members']) > 0) {
                    foreach ($householdReq['household_members'] as $member) {
                        $birthdate = Carbon::createFromFormat('m/d/Y', $member['birthdate']);
                        $birthdate = $birthdate->format('Y-m-d');
                        $householdMemberData = [
                            'household_id' => $household->id,
                            'firstname' => $member['firstname'] ,
                            'middlename' => $member['middlename'] ?? null,
                            'lastname' => $member['lastname'] ,
                            'suffix' => $member['suffix'] ?? null,
                            'birthdate' => $birthdate,
                            'sex' => $member['sex'] ,
                            'relationship' => $member['relationship'] ?? null,
                            'tax_form' => $member['tax_form'],
                            'lives_with_you' => $member['lives_with_you'] ?? null,
                            'tax_claimant' => $member['tax_claimant'] ?? null,
                            'field_type' => $member['field_type'] ?? null,
                            'eligible_cost_saving' => $member['eligible_cost_saving'] ?? null,
                            // 'ssn_number' => $member['ssn_number'] ?? null ,
                            // 'live_someone_under_nineteen' => $member['live_someone_under_nineteen'] ?? false,
                            // 'taking_care_under_nineteen' => $member['taking_care_under_nineteen'] ?? false,
                            // 'live_any_other_family' => $member['live_any_other_family'] ?? false,
                            // 'live_son_daughter' => $member['live_son_daughter'] ?? false,
                            // 'has_ssn' => $member['has_ssn'] ?? true,
                            // 'use_tobacco' => $member['use_tobacco'] ?? false,
                            // 'last_tobacco_usage' => $member['last_tobacco_usage'] ?? null,
                            // 'is_us_citizen' => $member['is_us_citizen'] ?? null,
                            // 'eligible_immigration_status' => $member['eligible_immigration_status'] ?? null,
                            // 'document_type' => $member['document_type'] ?? null ,
                            // 'document_number' => $member['document_number'] ?? null,
                            // 'document_number_type' => $member['document_number_type'] ?? null,
                            // 'document_complement_number' => $member['document_complement_number'] ?? null ,
                            // 'document_expiration_date' => $member['document_expiration_date'] ?? null,
                            // 'document_country_issuance' => $member['document_country_issuance'] ?? null,
                            // 'document_category_code' => $member['document_category_code'] ?? null ,
                            // 'has_sevis' => $member['has_sevis'] ?? false,
                            // 'sevis_number' => $member['sevis_number'] ?? null ,
                            // 'is_federally_recognized_indian_tribe' => $member['is_federally_recognized_indian_tribe'] ?? false,
                            // 'has_hhs_or_refugee_resettlement_cert' => $member['has_hhs_or_refugee_resettlement_cert'] ?? false,
                            // 'has_orr_eligibility_letter' => $member['has_orr_eligibility_letter'] ?? true,
                            // 'is_cuban_haitian_entrant' => $member['is_cuban_haitian_entrant'] ?? false,
                            // 'is_lawfully_present_american_samoa' => $member['is_lawfully_present_american_samoa'] ?? false,
                            // 'is_battered_spouse_child_parent_vawa' => $member['is_battered_spouse_child_parent_vawa'] ?? false,
                            // 'has_another_document_or_alien_number' => $member['has_another_document_or_alien_number'] ?? false,
                            // 'none_of_these_document' => $member['none_of_these_document'] ?? false,
                            // 'is_incarcerated' => $member['is_incarcerated'] ?? false,
                            // 'is_ai_aln' => $member['is_ai_aln'] ?? false,
                            // 'is_hip_lat_spanish' => $member['is_hip_lat_spanish'] ?? false,
                            // 'hip_lat_spanish_specific' => $member['hip_lat_spanish_specific'] ?? null,
                            // 'race' => $member['race'] ?? null ,
                            // 'declined_race' => $member['declined_race'] ?? false,
                            // 'birth_sex' => $member['birth_sex'] ?? null,
                            // 'gender_identity' => $member['gender_identity'] ?? null,
                            // 'sexual_orientation' => $member['sexual_orientation'] ?? null ,
                            // 'same_document_name' => $member['same_document_name'] ?? false,
                            // 'document_first_name' => $member['document_first_name'] ?? null,
                            // 'document_middle_name' => $member['document_middle_name'] ?? null,
                            // 'document_last_name' => $member['document_last_name'] ?? null ,
                            // 'document_suffix' => $member['document_suffix'] ?? null,
                            // 'is_pregnant' => $member['is_pregnant'] ?? false,
                            // 'babies_expected' => $member['babies_expected'] ?? null,
                            'created_by' => $userId
                        ];
                        HouseholdMember::create($householdMemberData);
                    }
                }
            }
        }
        return $household->load(['application', 'householdMembers', 'taxHouseholdMembers'])->toArray();
    }

    public static function isMarried(array $members){
        foreach ($members as $member){
            if(isset($member['field_type'])){
                if($member['field_type']==self::FIELD_TYPES['Spouse']){
                    return true;
                }
            }
        }
        return false;
    }

    public static function deleteHouseholdMember(int $idHouseholdMember): bool
    {
        $householdMember = HouseholdMember::find($idHouseholdMember);
        if($householdMember){
            $householdMember->load([
                'address',
                'mailAddress',
                'relatedFrom',
                'relatedTo',
                'incomesAndDeductions',
            ]);
            if(isset($householdMember->address)) $householdMember->address->delete();
            if(isset($householdMember->mailAddress)) $householdMember->mailAddress->delete();
            foreach ($householdMember->relatedFrom as $relationship) {
                $relationship->delete();
            }
            foreach ($householdMember->relatedTo as $relationship) {
                $relationship->delete();
            }
            foreach ($householdMember->incomesAndDeductions as $incomesAndDeduction) {
                $incomesAndDeduction->delete();
            }
            return $householdMember->delete();
        }
        return false;
    }


    public static function deleteHouseHold(int $application_id): bool
    {
        DB::beginTransaction();

        try {

            // Buscar membros que não são applicants
            $membersToDelete = HouseholdMember::where(function ($query) {
                $query->where('field_type', '<>', 0);
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
