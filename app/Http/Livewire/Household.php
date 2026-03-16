<?php

namespace App\Http\Livewire;

use App\Actions\ApplicationActions;
use App\Actions\DomainValueActions;
use App\Actions\GeographyActions;
use App\Models\Application;
use Livewire\Component;

class Household extends Component
{
    public int $application_id;
    public function mount(int $application_id): void
    {
        $this->application_id = $application_id;
        
    }

    /**
     * @throws \Exception
     */
    public function render()
    {
        $data = [];
        $application = ApplicationActions::getApplicationByid($this->application_id);
     
        $data['householdMembers'] = $application['householdMembers'];
        $data['suffixes'] = DomainValueActions::domainValuesOptions('suffix', false);
        $data['application_id'] = $application['id'];
        $data['applicant_name'] = ApplicationActions::getApplicantNameByid($this->application_id);
        $data['sexes'] = DomainValueActions::domainValuesOptions('sex', true);
        $data['relationships'] = DomainValueActions::domainValuesOptions('relationship', true, 'relacaoEsposa');
        $spouseValue = DomainValueActions::getDomainValueByAlias('relacaoEsposa');
        $childValue = DomainValueActions::getDomainValueByAlias('relacaoCrianca');
        $data['spouse_id'] = $spouseValue->id ?? 0;
        $data['child_id'] = $childValue->id ?? 0;
        return view('livewire.household', $data);
    }
}
