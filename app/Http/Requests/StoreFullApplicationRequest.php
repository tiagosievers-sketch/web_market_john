<?php

namespace App\Http\Requests;

use App\Models\Domain;
use App\Models\DomainValue;
use Illuminate\Foundation\Http\FormRequest;

class StoreFullApplicationRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        $this->merge([
            'application' => $this->mapApplicationAliases($this->application),
            'household' => $this->mapHouseholdAliases($this->household),
            'quotation' => $this->mapQuotationAliases($this->quotation),
        ]);
    }

    // Mapeia os aliases de application
    private function mapApplicationAliases($application)
    {
        return [
            'sex' => $this->mapAliasToId($application['sex']??null, 'sex'),
            'written_lang' => $this->mapAliasToId($application['written_lang']??null, 'language'),
            'spoken_lang' => $this->mapAliasToId($application['spoken_lang']??null, 'language'),
            // Passa os outros campos normalmente
            'firstname' => $application['firstname']??null,
            'lastname' => $application['lastname']??null,
            'birthdate' => $application['birthdate']??null,
            'has_ssn' => $application['has_ssn']??null,
            'use_tobacco' => $application['use_tobacco']??false,
            'street_address' => $application['street_address']??null,
            'city' => $application['city']??null,
            'state' => $application['state']??null,
            'zipcode' => $application['zipcode']??null,
            'county' => $application['county']??null,
            'phone' => $application['phone']??null,
            'email' => $application['email']??null,
            'notices_mail_or_email' => $application['notices_mail_or_email']??null,
            'send_email' => $application['send_email']??null,
            'send_text' => $application['send_text']??null,
            'type' => $application['type']??null,
            'external_id' => $application['external_id']??null,
            'additional_external_id' => $application['client_id']??null,
            'external_agent' => $application['external_agent']??null,
            'webhook' => $application['webhook']??null,
            'married' => $application['married']??false,
            'year' => $application['year']??null
        ];
    }

    // Mapeia os aliases de household
    private function mapHouseholdAliases($household)
    {
        $mappedMembers = [];

        foreach ($household['household_members'] as $member) {
            $mappedMembers[] = [
                'sex' => $this->mapAliasToId($member['sex'], 'sex'),
                'relationship' => $this->mapAliasToId($member['relationship']??null, 'relationship'),
                'firstname' => $member['firstname']??null,
                'lastname' => $member['lastname']??null,
                'birthdate' => $member['birthdate']??null,
                'field_type' => $member['field_type']??null,
                'use_tobacco' => $member['use_tobacco']??null,
                'married' => $application['married']??false
            ];
        }

        return ['household_members' => $mappedMembers];
    }

    // Mapeia os aliases de quotation
    private function mapQuotationAliases($quotation)
    {
        return [
            'income_predicted_amount' => $quotation['income_predicted_amount']
        ];
    }

    private static function mapAliasToId(string $alias, string $type): ?int
    {
        switch ($type) {
            case 'sex':
                $domain = Domain::select('id')->where('alias', '=', 'sex')->first();
                $domainValue = match (mb_strtolower($alias)) {
                    'male' =>   DomainValue::select('id')->where('alias', '=', 'masculino')
                        ->where('domain_id','=',$domain->id)->first(),
                    'female' => DomainValue::select('id')->where('alias', '=', 'feminino')
                        ->where('domain_id','=',$domain->id)->first()
                };
                return $domainValue->id;
            case 'language':
                $domain = Domain::select('id')->where('alias', '=', 'language')->first();
                $domainValue = match (mb_strtolower($alias)) {
                    'english' =>   DomainValue::select('id')->where('alias', '=', 'english')
                        ->where('domain_id','=',$domain->id)->first(),
                    'spanish' => DomainValue::select('id')->where('alias', '=', 'spanish')
                        ->where('domain_id','=',$domain->id)->first(),
                    'portuguese' => DomainValue::select('id')->where('alias', '=', 'portuguese')
                        ->where('domain_id','=',$domain->id)->first()
                };
                return $domainValue->id;
            case 'relationship':
                $domain = Domain::select('id')->where('alias', '=', 'relationship')->first();
                $domainValue = match (mb_strtolower($alias)) {
                    'spouse' =>   DomainValue::select('id')->where('alias', '=', 'relacaoEsposa')
                        ->where('domain_id','=',$domain->id)->first(),
                    'child' => DomainValue::select('id')->where('alias', '=', 'relacaoCrianca')
                        ->where('domain_id','=',$domain->id)->first(),
                    'stepchild' => DomainValue::select('id')->where('alias', '=', 'relacaoEnteado')
                        ->where('domain_id','=',$domain->id)->first()
                };
                return $domainValue->id;
            default:
                $map = [
                    'sex' => [
                        'Male' => 8,
                        'Female' => 9
                    ],
                    'language' => [
                        'English' => 33,
                        'Spanish' => 34,
                        'Portuguese' => 32
                    ],
                    'relationship' => [
                        'Spouse' => 1,
                        'Child' => 11,
                        'Stepchild' => 3
                    ]
                ];
                return $map[$type][$alias] ?? null;
        }
    }

    public function rules()
    {
        return [
            'application.firstname' => 'required|string|max:255',
            'application.lastname' => 'required|string|max:255',
            'application.birthdate' => 'required|date',
            'application.sex' => 'required|integer',
            'application.written_lang' => 'required|integer',
            'application.spoken_lang' => 'required|integer',
            'application.external_id' => 'required|integer',
            'application.additional_external_id' => 'required|integer',
            'application.street_address' => 'nullable|string|max:255',
            'application.city' => 'nullable|string|max:255',
            'application.state' => 'nullable|string|max:255',
            'application.zipcode' => 'required|string|max:255',
            'application.county' => 'required|string|max:255',
            'application.phone' => 'nullable|string|max:255',
            'application.type' => 'nullable|integer',
            'application.notices_mail_or_email' => 'required|boolean',
            'application.has_ssn' => 'required|boolean',
            'application.webhook' => 'nullable|string|max:255',
            'household.household_members' => 'required|array',
            'household.household_members.*.firstname' => 'required|string|max:255',
            'household.household_members.*.lastname' => 'required|string|max:255',
            'household.household_members.*.birthdate' => 'required|date',
            'household.household_members.*.sex' => 'required|integer',
            'household.household_members.*.relationship' => 'required|integer',
            'quotation.income_predicted_amount' => 'required|numeric'
        ];
    }

    public function messages(): array
    {
        return [
            'application.additional_external_id.required'    => 'É necessário enviar um client_id',
        ];
    }
}
