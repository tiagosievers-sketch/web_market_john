<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class StoreTaxHouseholdRequest extends FormRequest
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
            'fed_tax_income_return' => 'boolean|required',
            'married' => 'boolean|required',
            'spouse' => 'array|nullable',
            'spouse.*.id' => 'integer|exists:household_members,id|required',
            'spouse.*.lives_with_you' => 'boolean|required',
            'jointly_taxed_spouse' => 'boolean|required',
            'dependents' => 'array|nullable',
            'dependents.*.id' => 'integer|exists:household_members,id',
            'dependents.*.lives_with_you' => 'boolean|required',
            'tax_filler' => 'boolean|required',
            'tax_claimant' => 'nullable|integer|exists:household_members,id',
            'provide_tax_filler_information' => 'boolean|required',
            'new_household_members' => 'array|nullable',
            'new_household_members.*.firstname' => 'string|max:255|required',
            'new_household_members.*.middlename' => 'string|max:255|nullable',
            'new_household_members.*.lastname' => 'string|max:255|required',
            'new_household_members.*.suffix' => 'integer|nullable|exists:domain_values,id',
            'new_household_members.*.birthdate' => 'date|required',
            'new_household_members.*.sex' => "integer|exists:domain_values,id",
            'new_household_members.*.relationship' => "integer|exists:domain_values,id|required",
            'new_household_members.*.relationship_detail' => "integer|exists:domain_values,id|nullable",
            'new_household_members.*.field_type' => "integer|required",
            'new_household_members.*.lives_with_you' => "boolean|required",
            'new_household_members.*.is_dependent' => "boolean|required",
            'new_household_members.*.tax_filler' => 'boolean|nullable',
            'new_household_members.*.tax_claimant' => 'nullable|integer|exists:household_members,id',
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
