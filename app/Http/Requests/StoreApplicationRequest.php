<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Carbon\Carbon;


class StoreApplicationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Converte DD/MM/YYYY para MM/DD/YYYY antes da validação
     */
    protected function prepareForValidation(): void
    {
        $raw = $this->input('birthdate');

        if ($raw && preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $raw)) {
            // Tenta converter BR -> US
            try {
                $date = Carbon::createFromFormat('d/m/Y', $raw);
                $this->merge([
                    'birthdate' => $date->format('m/d/Y'),
                ]);
            } catch (\Throwable $e) {
                // deixa como está, vai falhar na regra 'date'
            }
        }
    }

    public function rules(): array
    {
        return [
            'firstname' => 'string|max:255|required',
            'middlename' => 'string|max:255|nullable',
            'lastname' => 'string|max:255|required',
            'suffix' => 'integer|nullable|exists:domain_values,id',
            'birthdate' => 'date|required',
            'sex' => "integer|required|exists:domain_values,id",
            'has_ssn' => 'boolean|required',
            'ssn' => 'string|max:255|nullable',
            'has_perm_address' => "boolean|required",
            'mailing' => "boolean|required",
            'street_address' => "string|max:255|required",
            'apte_ste' => "string|max:255|nullable",
            'city' => "string|max:255|required",
            'state' => "string|max:255|required",
            'zipcode' => "string|max:255|required",
            'county' => "string|max:255|required",
            'mail_street_address' => "string|max:255|nullable",
            'mail_apte_ste' => "string|max:255|nullable",
            'mail_city' => "string|max:255|nullable",
            'mail_state' => "string|max:255|nullable",
            'mail_zipcode' => "string|max:255|nullable",
            'mail_county' => "string|max:255|nullable",
            'email' => "string|max:255|nullable",
            'phone' => "string|max:255|required",
            'extension' => "string|max:255|nullable",
            'type' => 'integer|nullable|exists:domain_values,id',
            'second_phone' => "string|max:255|nullable",
            'second_extension' => "string|max:255|nullable",
            'second_type' => 'integer|nullable|exists:domain_values,id',
            'written_lang' => "integer|required|exists:domain_values,id",
            'spoken_lang' => "integer|required|exists:domain_values,id",
            'notices_mail_or_email' => "boolean|required",
            'send_email' => "boolean|nullable",
            'send_text' => "boolean|nullable",
            'year' => 'nullable|integer',
        ];
    }


    protected function failedValidation(Validator $validator)
    {
        $firstError = $validator->errors()->first();
        $field = key($validator->errors()->toArray());
        dd("O campo $field deu erro: $firstError");
    }
}
