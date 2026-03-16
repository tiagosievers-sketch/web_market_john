<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StorePlansRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        // dd($this->route()->getName());
        return [
            'application_id' => 'integer|required|exists:applications,id|exists:household_members,application_id',
            'plans' => 'array|required',
            'plans.*.hios_plan_id' => 'string|max:255',
            'plans.*.name' => 'string|max:255',
            'plans.*.value' => 'numeric',
        ];
    }

    //    protected function failedValidation(Validator|\Illuminate\Contracts\Validation\Validator $validator)
    //    {
    //        dd($validator->errors());
    //
    //        // Or, if you prefer a specific error message:
    //        // dd($validator->errors()->first('field_name'));
    //
    //        // You can also handle the error differently, such as returning a JSON response
    //        // return response()->json(['errors' => $validator->errors()], 422);
    //    }
}
