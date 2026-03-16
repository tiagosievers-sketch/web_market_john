<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdditionalQuestionRequest extends FormRequest
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
            'application_id' => 'required|exists:applications,id',
            'household_members' => 'required|array',
            
            // Validação para cada membro no array household_members
            'household_members.*.member_id' => 'required|exists:household_members,id',
            'household_members.*.firstQuestion' => 'nullable|boolean',
            'household_members.*.secondQuestion' => 'nullable|boolean',
            'household_members.*.thirdQuestion' => 'nullable|boolean',
            'household_members.*.additionalCheck' => 'nullable|integer|in:0,1',
            'household_members.*.lastDayCoverage' => 'nullable|date_format:m/d/Y',
            'household_members.*.fourthQuestion' => 'nullable|boolean',
            'household_members.*.coverageBetweenAdicional' => 'nullable|boolean',
            'household_members.*.applyMarketplaceAdicional' => 'nullable|boolean',
            'household_members.*.dentedCoverageAdditionalDate' => 'nullable|date_format:m/d/Y',
        ];
    }
}
