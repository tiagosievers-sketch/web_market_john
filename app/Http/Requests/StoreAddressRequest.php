<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAddressRequest extends FormRequest
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
            'street_address' => "string|max:255|required",
            'apte_ste' => "string|max:255|nullable",
            'city' => "string|max:255|required",
            'state' => "string|max:255|required",
            'zipcode' => "string|max:255|required",
            'county' => "string|max:255|required",
            'mailing' => "boolean|required",
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
