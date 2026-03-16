<?php

namespace App\Actions;

use App\Http\Requests\StorePlansRequest;
use App\Models\Application;
use App\Models\HouseholdMember;
use App\Models\Plan;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class PlanActions
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
     * @throws Exception
     */
    public static function createPlansByApplication(StorePlansRequest $request): array
    {
        $userId = Auth::id();
        $plansReq = $request->validated();
        $application_id = $plansReq['application_id'];
        $plansAr = $plansReq['plans'];
        if (count($plansAr) > 0) {
            foreach ($plansAr as $plan) {
                $planData = [
                    'application_id' => $application_id,
                    'hios_plan_id' => $plan['hios_plan_id'],
                    'name' => $plan['name'],
                    'value' => $plan['value'],
                    'created_by' => $userId
                ];
                $result = Plan::create($planData);
            }
        }
        $application = Application::find($application_id);
        $application->load(['householdMembers']);
        return $application->toArray();
    }
}
