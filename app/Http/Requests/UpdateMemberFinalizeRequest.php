<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMemberFinalizeRequest extends FormRequest
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
            'firstname' => 'required|string|max:255',
            'middlename' => 'nullable|string|max:255',
            'lastname' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'send_email' => 'required|boolean',
            'written_lang' => 'integer|required|exists:domain_values,id',
            'spoken_lang' => 'integer|required|exists:domain_values,id',
            'street_address' => "string|max:255|required",
            'apte_ste' => "string|max:255|nullable",
            'city' => "string|max:255|required",
            'state' => "string|max:255|required",
            'zipcode' => "string|max:255|required",
            'county' => "string|max:255|required",
        ];
    }
}
