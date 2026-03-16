<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;
#[OA\Schema(title: 'GetPlansRequest', required: [
    'place',
    'plan_ids'
], properties: [
    new OA\Property(
        property: "household",
        ref: '#/components/schemas/Household',
        nullable: true
    ),
    new OA\Property(
        property: "place",
        ref: '#/components/schemas/Place',
        nullable: false
    ),
    new OA\Property(property:"market", type:"string", enum: [ 'Individual', 'SHOP', 'Any'],nullable: true),
    new OA\Property(property:"plan_ids", type:"array", items: new OA\Items(
        description: '14-character HIOS IDs', type: 'string'
    ),nullable: false),
    new OA\Property(property:"year", type:"number", format:"integer",nullable: true),
    new OA\Property(property:"aptc_override", description: 'override the aptc calculation with a specific amount',type:"number", format:"float",nullable: true),
    new OA\Property(property:"csr_override", description: 'Cost-sharing reduction (CSR) override for requests', type:"string", enum: [ 'CSR73', 'CSR87', 'CSR94', 'LimitedCSR', 'ZeroCSR' ],nullable: true),
    new OA\Property(property:"catastrophic_override", description: 'Force the display (or suppression) of catastrophic plans',type:"boolean",nullable: true)
])]

class GetPlansRequest extends FormRequest
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
        return [
            'household' => 'array|nullable',
            'place' => 'array|required',
            'place.countyfips' => 'string|max:5|required',
            'place.state' => 'string|max:2|required',
            'place.zipcode' => 'string|max:5|required',
            'market' => "string|nullable",
            'plan_ids' => 'array|required',
            'year' => 'integer|nullable',
            'aptc_override' => 'numeric|nullable',
            'csr_override' => "string|nullable",
            'catastrophic_override' => 'boolean|nullable',
        ];
    }
}
