<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuickQuotationRequest extends FormRequest
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
            'mainUser.firstname' => 'required|string|max:255',
            'mainUser.lastname' => 'required|string|max:255',
            'mainUser.birthdate' => 'required|date_format:m/d/Y',
            'mainUser.sex' => 'integer|nullable|exists:domain_values,id',
            'mainUser.zipcode' => 'string|max:255|required',
            'mainUser.use_tobacco' => 'boolean|required',
            'mainUser.income_predicted_amount' => 'numeric|min:0|max:999999999999.99|required',
            'mainUser.county' => 'required|string',
            'mainUser.notices_mail_or_email' => 'required|boolean',
            'mainUser.parent_of_child_under_19' => 'boolean|nullable',
            'mainUser.pregnant' => 'boolean|nullable',
            'mainUser.year' => 'nullable|integer',
            'dependents.*.birthdate'=> 'nullable|date_format:m/d/Y',
            'dependents.*.sex' => 'integer|nullable|exists:domain_values,id',
            'dependents.*.use_tobacco' => 'boolean|nullable',
            'dependents.*.relationship' => 'nullable|string',
            'dependents.*.pregnant' => 'boolean|nullable',
            'dependents.*.parent_of_child_under_19' => 'boolean|nullable',
            'spouse.birthdate'=> 'nullable|date_format:m/d/Y',
            'spouse.sex' => 'integer|nullable|exists:domain_values,id',
            'spouse.use_tobacco' => 'boolean|nullable'
        ];
    }
}

