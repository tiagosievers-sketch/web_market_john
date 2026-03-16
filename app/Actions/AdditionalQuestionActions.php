<?php

namespace App\Actions;

use App\Http\Requests\StoreAdditionalInformationRequest;
use App\Http\Requests\StoreAdditionalQuestionRequest;
use App\Models\HouseholdMember;
use App\Models\Relationship;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdditionalQuestionActions
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

    /**
     * Atualiza as informa es adicionais de cada membro da household
     *
     * @param array $householdMembersData
     * @return boolean
     */

    public static function updateAdditionalQuestions(StoreAdditionalQuestionRequest $request)
    {
        foreach ($request->household_members as $memberData) {
            // Encontra o membro da household pelo ID
            $householdMember = HouseholdMember::find($memberData['member_id']);

            if ($householdMember) {

                $updateData = [
                    'has_disability_or_mental_condition' => $memberData['has_disability_or_mental_condition'] ?? 0,
                    'needs_help_with_daily_activities' => $memberData['needs_help_with_daily_activities'] ?? 0,
                    'chip_coverage_ends_between' => $memberData['chip_coverage_ends_between'] ?? 0,
                    'change_income_or_household_size' => $memberData['change_income_or_household_size'] ?? 0,
                    'last_date_coverage' => isset($memberData['last_date_coverage']) 
                        ? Carbon::createFromFormat('m/d/Y', $memberData['last_date_coverage'])->format('Y-m-d') 
                        : null,
                    'ineligible_for_medicaid_or_chip_last_90_days' => $memberData['ineligible_for_medicaid_or_chip_last_90_days'] ?? 0,
                    'date_dented_coverage' => isset($memberData['date_dented_coverage']) 
                        ? Carbon::createFromFormat('m/d/Y', $memberData['date_dented_coverage'])->format('Y-m-d') 
                        : null,
                    'coverage_between' => $memberData['coverage_between'] ?? 0,
                    'apply_marketplace_qualifying_life_event' => $memberData['apply_marketplace_qualifying_life_event'] ?? 0,
                ];

                $householdMember->update($updateData);
            }
        }

        return true;
    }
}
