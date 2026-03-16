<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreIncomeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Permitir que o request seja autorizado
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'application_id' => 'required|exists:applications,id',
            'household_member_id' => 'required|exists:household_members,id',
            'income_data' => 'array',

            // Ajuste para validar cada item no array `income_data` // tabela household_members
            'income_data.*.has_deduction_current_year' => 'nullable|boolean',
            'income_data.*.has_income' => 'nullable|boolean',
            'income_data.*.income_confirmed' => 'nullable|boolean',
            'income_data.*.income_predictable' => 'nullable|boolean',
            'income_data.*.income_predicted_amount' => 'nullable|numeric|min:0',

            // Regras para cada campo em `incomeData` dentro de `income_data`
            'income_data.*.type' => 'nullable|boolean',
            'income_data.*.income_deduction_type' => 'nullable|string|max:255',
            'income_data.*.amount' => 'sometimes|numeric|min:0|max:999999999999.99',
            'income_data.*.educational_amount' => 'nullable|numeric|min:0|max:999999999999.99',
            'income_data.*.non_educational_amount' => 'nullable|numeric|min:0|max:999999999999.99',
            'income_data.*.frequency' => 'nullable|integer|exists:domain_values,id',
            'income_data.*.other_type' => 'nullable|string|max:255',
            'income_data.*.employer_name' => 'nullable|string|max:255',
            'income_data.*.employer_former_state' => 'nullable|string|max:255',
            'income_data.*.employer_phone_number' => 'nullable|string|max:20',
            'income_data.*.unemployment_date' => 'nullable|date',
            'income_data.*.type_of_work' => 'nullable|string|max:255',

        ];
    }
}
