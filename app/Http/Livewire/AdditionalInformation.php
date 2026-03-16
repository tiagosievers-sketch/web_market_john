<?php

namespace App\Http\Livewire;


use Livewire\Component;
use App\Models\DomainValue;
use App\Actions\ApplicationActions;
use App\Actions\DomainValueActions;
use Illuminate\Database\Eloquent\Builder;


class AdditionalInformation extends Component
{
    public $application_id;

    public function mount($application_id)
    {
        $this->application_id = $application_id;
    }

    public function render()
    {
        $data = [];
        $application = ApplicationActions::getApplicationByid($this->application_id);
        //dd($application['mainMember']->id);
        $data['household'] = $application['household'];
 
        
        $data['suffixes'] = DomainValueActions::domainValuesOptions('suffix', false);
        $data['application_id'] = $application['id'];
        $data['applicant_name'] = ApplicationActions::getApplicantNameByid($this->application_id);

        $data['member_id'] = $application['mainMember']->id;

        $data['applicant_addresses'] = ApplicationActions::getAddressesByMemberId($data['member_id']);
        //dd($data['applicant_addresses']);

        $data['sexes'] = DomainValueActions::domainValuesOptions('sex', true);
        $data['relationships'] = DomainValueActions::domainValuesOptions('relationship', true, 'relacaoEsposa');


        $data['relationshipChild'] = DomainValue::whereHas('domain', function (Builder $query) {
            $query->where('alias', 'relationship');
        })
        ->where('alias', 'relacionamentoDomesticoFilho')
        ->get(['id', 'alias', 'name'])
        ->toArray(); // Retorna um array contendo tanto o alias quanto o nome
                
        $spouseValue = DomainValueActions::getDomainValueByAlias('relacionamentoParente');
        $data['spouse_id'] = $spouseValue->id ?? 0;

        $childValue = DomainValueActions::getDomainValueByAlias('relacionamentoCrianca');
        $data['child_id'] = $childValue->id ?? 0;

        // dd($application);
        return view('livewire.additional-information', $data);
    }
}
