<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactRequest extends FormRequest
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
            'email' => "string|max:255|nullable",
            'phone' => "string|max:255|required",
            'extension' => "string|max:255|required",
            'type' => 'integer|nullable|exists:domain_values,id',
            'second_phone' => "string|max:255|nullable",
            'second_extension' => "string|max:255|nullable",
            'second_type' => 'integer|nullable|exists:domain_values,id',
            'written_lang' => "integer|required|exists:domain_values,id",
            'spoken_lang' => "integer|required|exists:domain_values,id",
            'notices_mail_or_email' => "boolean|required",
            'send_email' => "boolean|nullable",
            'send_text' => "boolean|nullable",
        ];
    }

//     protected function failedValidation(Validator|\Illuminate\Contracts\Validation\Validator $validator)
//     {
//         dd($validator->errors());
//
//         // Or, if you prefer a specific error message:
//         // dd($validator->errors()->first('field_name'));
//
//         // You can also handle the error differently, such as returning a JSON response
//         // return response()->json(['errors' => $validator->errors()], 422);
//     }
}
