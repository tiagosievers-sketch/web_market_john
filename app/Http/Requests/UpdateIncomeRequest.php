<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateIncomeRequest extends FormRequest
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
            'income_id' => 'required|exists:income_deductions,id',
            'income_deduction_type' => 'required|integer|exists:domain_values,id',
            'amountIncome' => 'nullable|numeric|min:0|max:999999999999.99',
            'frequency' => 'required|integer|exists:domain_values,id',
            'employer_name' => 'nullable|string|max:255',
            'employer_former_state' => 'nullable|string|max:255',
            'educational_amount' => 'nullable|numeric|min:0|max:999999999999.99',
            'non_educational_amount' => 'nullable|numeric|min:0|max:999999999999.99',
            'other_type' => 'nullable|string|max:255',
            'employer_phone_number' => 'nullable|string|max:20',
            'unemployment_date' => 'nullable|date_format:m/d/Y',
            'type_of_work' => 'nullable|string|max:255',
            

        ];

    }
}
