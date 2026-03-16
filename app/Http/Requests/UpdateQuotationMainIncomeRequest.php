<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class UpdateQuotationMainIncomeRequest extends FormRequest
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
            'income_predicted_amount' => 'numeric|required',
        ];
    }

     protected function failedValidation(Validator|\Illuminate\Contracts\Validation\Validator $validator)
     {
         $firstError = $validator->errors()->first();
         $field = key($validator->errors()->toArray());
         throw new ValidationException($validator);
         // Or, if you prefer a specific error message:
         // dd($validator->errors()->first('field_name'));

         // You can also handle the error differently, such as returning a JSON response
         // return response()->json(['errors' => $validator->errors()], 422);
     }
}
