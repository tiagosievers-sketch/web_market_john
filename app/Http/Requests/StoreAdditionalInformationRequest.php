<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class StoreAdditionalInformationRequest extends FormRequest
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
            //Parte essencial
            'application_id' => 'integer|required|exists:applications,id|exists:household_members,application_id',
            'this_household_member_id' => 'integer|exists:household_members,id|required',
            //Outros Relacionamentos Familiares
            'live_someone_under_nineteen' => 'boolean|required',
            'taking_care_under_nineteen' => 'boolean|required',
            'child_taking_care' => 'array|nullable',
            'child_taking_care.*.firstname' => 'string|max:255|required',
            'child_taking_care.*.middlename' => 'string|max:255|nullable',
            'child_taking_care.*.lastname' => 'string|max:255|required',
            'child_taking_care.*.suffix' => 'integer|nullable|exists:domain_values,id',
            'child_taking_care.*.birthdate' => 'date|required',
            'child_taking_care.*.sex' => "integer|exists:domain_values,id",
            'child_taking_care.*.relationship' => "integer|exists:domain_values,id|required",
            'child_taking_care.*.relationship_detail' => "integer|exists:domain_values,id|nullable",
            // Outros membros da família não declarados
            'live_any_other_family' => 'boolean|required',
            'live_son_daughter' => 'boolean|required',
            'other_son_daughter' => 'array|nullable',
            'other_son_daughter.*.firstname' => 'string|max:255|required',
            'other_son_daughter.*.middlename' => 'string|max:255|nullable',
            'other_son_daughter.*.lastname' => 'string|max:255|required',
            'other_son_daughter.*.suffix' => 'integer|nullable|exists:domain_values,id',
            'other_son_daughter.*.birthdate' => 'date|required',
            'other_son_daughter.*.sex' => "integer|exists:domain_values,id",
            'other_son_daughter.*.relationship' => "integer|exists:domain_values,id|required",
            'other_son_daughter.*.relationship_detail' => "integer|exists:domain_values,id|nullable",
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
