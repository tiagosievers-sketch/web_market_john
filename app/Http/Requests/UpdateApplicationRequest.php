<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateApplicationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'firstname' => 'string|max:255|required',
            'middlename' => 'string|max:255|nullable',
            'lastname' => 'string|max:255|required',
            'suffix' => 'integer|nullable|exists:domain_values,id',
            'birthdate' => 'date|required',
            'sex' => 'integer|required|exists:domain_values,id',
            'has_ssn' => 'boolean|required',
            'ssn' => 'string|max:255|nullable',
            'has_perm_address' => 'boolean|required',
            'notices_mail_or_email' => 'boolean|required',
            'send_email' => 'boolean|nullable',
            'send_text' => 'boolean|nullable',
        ];
    }

     protected function failedValidation(Validator|\Illuminate\Contracts\Validation\Validator $validator)
     {
         $firstError = $validator->errors()->first();
         $field = key($validator->errors()->toArray());
         dd("O campo $field deu erro: $firstError");
         // Or, if you prefer a specific error message:
         // dd($validator->errors()->first('field_name'));

         // You can also handle the error differently, such as returning a JSON response
         // return response()->json(['errors' => $validator->errors()], 422);
     }
}
