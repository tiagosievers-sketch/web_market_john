<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class StoreMemberHouseholdRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'application_id' => 'integer|required|exists:applications,id|exists:household_members,application_id',
            'this_household_member_id' => 'integer|exists:household_members,id|required',
            'household_members' => 'required|array',
            'household_members.*.ssn' => 'nullable|string|max:11',
            'household_members.*.has_ssn' => 'nullable|boolean',
            'household_members.*.use_tobacco' => 'nullable|boolean',
            'household_members.*.last_tobacco_usage' => 'nullable|date',
            'household_members.*.is_us_citizen' => 'nullable|boolean',
            'household_members.*.eligible_immigration_status' => 'nullable|boolean',
            'household_members.*.document_type' => 'nullable|integer',
            'household_members.*.document_number' => 'nullable|string|max:255',
            'household_members.*.document_number_type' => 'nullable|integer',
            'household_members.*.document_complement_number' => 'nullable|string|max:255',
            'household_members.*.document_expiration_date' => 'nullable|date',
            'household_members.*.document_country_issuance' => 'nullable|integer',
            'household_members.*.document_category_code' => 'nullable|string|max:255',
            'household_members.*.has_sevis' => 'nullable|boolean',
            'household_members.*.sevis_number' => 'nullable|string|max:255',
            'household_members.*.is_federally_recognized_indian_tribe' => 'nullable|boolean',
            'household_members.*.has_hhs_or_refugee_resettlement_cert' => 'nullable|boolean',
            'household_members.*.has_orr_eligibility_letter' => 'nullable|boolean',
            'household_members.*.is_cuban_haitian_entrant' => 'nullable|boolean',
            'household_members.*.is_lawfully_present_american_samoa' => 'nullable|boolean',
            'household_members.*.is_battered_spouse_child_parent_vawa' => 'nullable|boolean',
            'household_members.*.has_another_document_or_alien_number' => 'nullable|boolean',
            'household_members.*.none_of_these_document' => 'nullable|boolean',
            'household_members.*.is_incarcerated' => 'nullable|boolean',
            'household_members.*.is_ai_aln' => 'nullable|boolean',
            'household_members.*.is_hip_lat_spanish' => 'nullable|boolean',
            'household_members.*.hip_lat_spanish_specific' => 'nullable|integer',
            'household_members.*.race' => 'nullable|integer',
            'household_members.*.declined_race' => 'nullable|boolean',
            'household_members.*.birth_sex' => 'nullable|string|max:255',
            'household_members.*.gender_identity' => 'nullable|string|max:255',
            'household_members.*.sexual_orientation' => 'nullable|integer',
            'household_members.*.same_document_name' => 'nullable|boolean',
            'household_members.*.document_first_name' => 'nullable|string|max:255',
            'household_members.*.document_middle_name' => 'nullable|string|max:255',
            'household_members.*.document_last_name' => 'nullable|string|max:255',
            'household_members.*.document_suffix' => 'nullable|integer',
            'household_members.*.is_pregnant' => 'nullable|boolean',
            'household_members.*.babies_expected' => 'nullable|integer',
            'household_members.*.isAiAln' => 'integer|nullable',
            'household_members.*.is_incarcerated_pending' => 'integer|nullable',
            'household_members.*.live_in_eua' => 'nullable|integer',
            'household_members.*.ineligible_full_coverage' => 'boolean|nullable',
            'household_members.*.answer_member_information' => 'boolean|required',
        ];
    }

    protected function failedValidation(Validator|\Illuminate\Contracts\Validation\Validator $validator)
    {
        dd($validator->errors());

        // Or, if you prefer a specific error message:
        // dd($validator->errors()->first('field_name'));

        // You can also handle the error differently, such as returning a JSON response
        // return response()->json(['errors' => $validator->errors()], 422);
    }
}
