<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreHouseholdRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'application_id' => 'integer|required|exists:applications,id|exists:household_members,application_id',
            'household_members' => 'array|nullable',
            'household_members.*.firstname' => 'string|max:255|required_unless:household_members.*.field_type,0',
            'household_members.*.middlename' => 'string|max:255|nullable',
            'household_members.*.lastname' => 'string|max:255|required_unless:household_members.*.field_type,0',
            'household_members.*.suffix' => 'integer|nullable|exists:domain_values,id',
            'household_members.*.birthdate' => 'date|required_unless:household_members.*.field_type,0',
            'household_members.*.sex' => "integer|exists:domain_values,id",
            'household_members.*.relationship' => "integer|exists:domain_values,id|required_unless:household_members.*.field_type,0",
            'household_members.*.relationship_detail' => "integer|exists:domain_values,id|nullable",
            'household_members.*.field_type' => "integer|required",
            'household_members.*.eligible_cost_saving' => "boolean|nullable"
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
