<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFinalizeRequest extends FormRequest
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
            'application_id' => 'required|exists:applications,id',
            'allow_marketplace_income_data' => 'required|boolean',
            'years_renewal_of_eligibility' => 'integer|nullable|exists:domain_values,id',
            'attestation_statement' => 'required|boolean',
            'marketplace_permission' => 'required|boolean',
            'penalty_of_perjury_agreement' => 'required|boolean',
            'full_name' => 'nullable|string|max:255',
        ];
    }
}
