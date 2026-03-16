<?php

namespace App\Http\Livewire;

use App\Actions\ApplicationActions;
use App\Actions\DomainValueActions;
use App\Actions\GeographyActions;
use App\Models\DomainValue;
use Livewire\Component;

class Finalize extends Component
{

    public  $application_id;


    public function mount($application_id)
    {
        $this->application_id = $application_id;
    }


    public function render()
    {
        $data = [];
        $application = ApplicationActions::getApplicationByid($this->application_id)
            ->load(['householdMembers.incomesAndDeductions', 'householdRelationships']);

        $relationships = $application->householdRelationships;

        $data['mail'] = $application->send_email;

        $data['years'] = DomainValueActions::domainValuesOptions('year', false);



        // Define o ID do membro principal
        $mainMemberId = $application['mainMember']['id'] ;
        $data['mainMemberId'] = $mainMemberId;

        // Filtra os relacionamentos com base no `member_from_id` do `mainMember`
        $filteredRelationships = $application->householdRelationships->filter(function ($relationship) use ($mainMemberId) {
            return $relationship->member_from_id === $mainMemberId;
        });

        // Pega os IDs únicos de `relationship` para buscar os valores de domínio
        $relationshipIds = $filteredRelationships->pluck('relationship')->unique()->toArray();
        $data['relationshipIds'] = $relationshipIds;

        // Busca todos os nomes dos `DomainValue` associados aos IDs dos relacionamentos diretamente com `DomainValue`
        $domainValues = DomainValue::whereIn('id', $relationshipIds)->pluck('name', 'id');
        // Associa o nome do relacionamento a cada `member_to_id`
        $domainValuesByRelationship = [];
        foreach ($filteredRelationships as $relationship) {
            $memberId = $relationship->member_to_id;
            $relationshipId = $relationship->relationship;

            // Adiciona o nome do relacionamento baseado no ID do relacionamento
            $domainValuesByRelationship[$memberId] = $domainValues[$relationshipId] ?? 'N/A';
        }

        // Mapear os nomes para os relacionamentos
        $relationshipsWithNames = $relationships->map(function ($relationship) use ($domainValues) {
            return [
                'id' => $relationship->id,
                'member_from_id' => $relationship->member_from_id,
                'member_to_id' => $relationship->member_to_id,
                'relationship_name' => $domainValues[$relationship->relationship] ?? 'N/A',
            ];
        });

        $data['relationshipsWithNames'] = $relationshipsWithNames;







        // IDs de linguagem do contato
        $languageId = $application['contact']['written_lang'];
        $data['languageId'] = $languageId;
        $spokenLanguageId = $application['contact']['spoken_lang'];
        $data['spokenLanguageId'] = $spokenLanguageId;

        // Busca os nomes de linguagem com base nos IDs de `written_lang` e `spoken_lang`
        $languages = DomainValue::whereIn('id', [$languageId, $spokenLanguageId])->pluck('name', 'id');

        // Armazena os nomes das linguagens no array `$data`
        $data['writtenLanguage'] = $languages[$languageId] ?? '';
        $data['spokenLanguage'] = $languages[$spokenLanguageId] ?? '';
        $data['languages'] = DomainValueActions::domainValuesOptions('language', true);

        // dd($data['languages']);
        $data['states'] = GeographyActions::statesOptions();
        $data['sexes'] = DomainValueActions::domainValuesOptions('sex', true);
        $data['relationships'] = DomainValueActions::domainValuesOptions('relationship', false);

        $currentRelationship = $application->householdRelationships
            ->where('member_from_id', $mainMemberId)
            ->first();

        $data['currentRelationship'] = $currentRelationship->relationship ?? null;
        //income
        // Obtém todos os IDs únicos de `income_deduction_type`
        $incomeTypeIds = $application->householdMembers
            ->flatMap(function ($member) {
                return $member->incomesAndDeductions
                    ->where('type', '=', 0)
                    ->pluck('income_deduction_type');
            })
            ->unique()
            ->toArray();
        $data['incomeTypeIds'] = $incomeTypeIds;


        $deductionTypeIds = $application->householdMembers
            ->flatMap(function ($member) {
                return $member->incomesAndDeductions
                    ->where('type', '=', 1)
                    ->pluck('income_deduction_type');
            })
            ->unique()
            ->toArray();

        // Busca os nomes dos `DomainValue` associados aos `income_deduction_type`
        $incomeTypes = DomainValue::whereIn('id', $incomeTypeIds)->pluck('name', 'id');
        $deductionTypes = DomainValue::whereIn('id', $deductionTypeIds)->pluck('name', 'id');
        $data['incomeTypes'] = $incomeTypes;
        $data['deductionTypes'] = $deductionTypes;



        $incomeTypeMap = [];
        foreach ($application->householdMembers as $member) {
            foreach ($member->incomesAndDeductions->where('type', '=', 0) as $income) {
                if (isset($income->income_deduction_type)) {
                    $incomeTypeMap[$income->id] = $incomeTypes[$income->income_deduction_type] ?? 'N/A';
                }
            }
        }
        $data['incomeTypeMap'] = $incomeTypeMap;

        //frequencia
        // $frequencyIds = $application->householdMembers
        //     ->flatMap(function ($member) {
        //         return $member->incomesAndDeductions->pluck('frequency');
        //     })
        //     ->unique()
        //     ->toArray();
        // $frequencies = DomainValue::whereIn('id', $frequencyIds)->pluck('name', 'id');
        $data['frequencies'] = DomainValueActions::domainValuesOptions('frequency', true);

        $data['relationshipsByMember'] = $domainValuesByRelationship;
        $data['application'] = $application;
        $data['householdMembers'] = $application['householdMembers'];
        $data['mainMember'] = $application['mainMember'];
        $data['application_id'] = $application['id'];

        return view('livewire.finalize', $data);
    }
}
