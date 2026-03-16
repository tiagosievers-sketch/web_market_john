<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class FilterPlansRequest extends FormRequest
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
            'issuers' => 'nullable|array',
            'issuers.*' => 'nullable|string',
            'metal_level' => 'nullable|array',
            'metal_level.*' => 'nullable|string',
            'deductible' => 'nullable|numeric',
            'premium' => 'nullable|numeric',
            'ranges' => 'required_with:premium|array:premiums,deductibles',
            'ranges.premiums' => 'required_with:ranges|array:min,max',
            'ranges.premiums.min' => 'required_with:ranges.premiums|numeric',
            'ranges.premiums.max' => 'nullable|numeric',
            'ranges.deductibles' => 'nullable|array:min,max',
            'ranges.deductibles.min' => 'nullable|numeric',
            'ranges.deductibles.max' => 'nullable|numeric',
            'has_mec' => 'array|nullable',
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
