<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHouseHoldMemberFinalizeRequest extends FormRequest
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
            'household_member_id' => 'required|exists:household_members,id', // ID do membro a ser atualizado
            'application_id' => 'required|exists:applications,id',
            'firstnameHousehold' => 'required|string|max:255',
            'middlenameHousehold' => 'nullable|string|max:255',
            'lastnameHousehold' => 'required|string|max:255',
            'birthdate' => 'required|date',
            'sex' => 'required|exists:domain_values,id',
            'relationshipHousehold' => 'nullable|exists:domain_values,id',
            'use_tobacco' => 'required|boolean',
            'applying_coverage' => 'required|boolean',
            'has_ssn' => 'boolean|required',
            'ssn' => 'string|max:255|nullable',
        ];
    }
}
