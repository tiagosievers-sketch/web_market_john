<?php

namespace App\Http\Livewire;

use App\Actions\ApplicationActions;
use App\Actions\DomainValueActions;
use App\Actions\GeographyActions;
use App\Models\Application;
use Livewire\Component;

class HouseholdEdit extends Component
{
    public int $application_id;
    public array $data = [];
    public array $dataLabel = [];
    public array $houseHold = [];

    public function mount(int $application_id): void
    {
        $this->application_id = $application_id;

        $data = [];
        $application = ApplicationActions::getApplicationByid($this->application_id);
        // $data['household'] = $application['household'];
        $dataLabel['suffixes'] = DomainValueActions::domainValuesOptions('suffix', false); // sr, jr, ii, iii
        
        // $data['application_id'] = $application['id'];
        $dataLabel['applicant_name'] = ApplicationActions::getApplicantNameByid($this->application_id);
        $dataLabel['sexes'] = DomainValueActions::domainValuesOptions('sex', true);
        $dataLabel['relationships'] = DomainValueActions::domainValuesOptions('relationship', true, 'relacaoEsposa');
        $spouseValue = DomainValueActions::getDomainValueByAlias('relacaoEsposa');
        $dataLabel['spouse_id'] = $spouseValue->id ?? 0;
        $this->data = $data;
        $this->dataLabel = $dataLabel;
        
        // $houseHold[] = ApplicationActions::getHouseholdsByAppId($this->application_id);
        // $this->houseHold = $houseHold;
        // dd($dataLabel['relationships'] );


    }

    /**
     * @throws \Exception
     */
    public function render()
    {
      
        return view('livewire.household-edit');
    }

}
