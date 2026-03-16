<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdditionalQuestionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'application_id' => 'required|integer|exists:applications,id',
            'household_members' => 'required|array',
            'household_members.*.member_id' => 'required|integer|exists:household_members,id',
            'household_members.*.has_disability_or_mental_condition' => 'nullable|boolean',
            'household_members.*.needs_help_with_daily_activities' => 'nullable|boolean',
            'household_members.*.chip_coverage_ends_between' => 'nullable|boolean',
            'household_members.*.change_income_or_household_size' => 'nullable|boolean',
            'household_members.*.last_date_coverage' => 'nullable|date',
            'household_members.*.ineligible_for_medicaid_or_chip_last_90_days' => 'nullable|boolean',
            'household_members.*.date_dented_coverage' => 'nullable|date',
            'household_members.*.coverage_between' => 'nullable|boolean',
            'household_members.*.apply_marketplace_qualifying_life_event' => 'nullable|boolean',
        ];
    }
}
