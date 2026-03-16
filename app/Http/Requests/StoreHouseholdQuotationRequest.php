<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class StoreHouseholdQuotationRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'application_id' => 'integer|required|exists:applications,id|exists:household_members,application_id',
            'household_members' => 'array|required',
            'household_members.*.firstname' => 'string|max:255',
            'household_members.*.middlename' => 'string|max:255|nullable',
            'household_members.*.lastname' => 'string|max:255',
            'household_members.*.suffix' => 'integer|nullable|exists:domain_values,id',
            'household_members.*.birthdate' => 'date',
            'household_members.*.sex' => 'integer|exists:domain_values,id',
            'household_members.*.relationship' => 'integer|exists:domain_values,id',
            'household_members.*.field_type' => 'integer|nullable',
            'household_members.*.tax_claimant' => 'boolean|nullable',
            'household_members.*.eligible_cost_saving' => 'boolean|nullable',
            'household_members.*.use_tobacco' => 'boolean|nullable',
            'household_members.*.income_predicted_amount' => 'numeric|min:0|max:999999999999.99|required'
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param Validator $validator
     * @return void
     */
    protected function failedValidation(Validator $validator)
    {
        // Dump validation errors for debugging
        dd($validator->errors());

        // Or, if you prefer a specific error message:
        // dd($validator->errors()->first('field_name'));

        // You can also handle the error differently, such as returning a JSON response
        // return response()->json(['errors' => $validator->errors()], 422);
    }
}
