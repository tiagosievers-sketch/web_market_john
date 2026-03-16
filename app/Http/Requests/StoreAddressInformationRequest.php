<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreAddressInformationRequest extends FormRequest
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
            'application_id' => 'integer|required|exists:applications,id|exists:household_members,application_id',
            'everyone_lives_main_member' => 'boolean|required',
            'other_addresses' => 'nullable|array',
            'other_addresses.*.household_member_id' => 'integer|exists:household_members,id|required',
            'other_addresses.*.street_address' => 'string|max:255|required',
            'other_addresses.*.apte_ste' => 'string|max:255|nullable',
            'other_addresses.*.city' => 'string|max:255|required',
            'other_addresses.*.state' => 'string|max:255|required',
            'other_addresses.*.zipcode' => 'string|max:255|required',
            'other_addresses.*.county' => 'string|max:255|required',
        ];
    }

     protected function failedValidation(Validator|\Illuminate\Contracts\Validation\Validator $validator)
     {
        $firstError = $validator->errors()->first();
        $field = key($validator->errors()->toArray());
        dd("O campo $field deu erro: $firstError");

         // You can also handle the error differently, such as returning a JSON response
         // return response()->json(['errors' => $validator->errors()], 422);
     }
}
