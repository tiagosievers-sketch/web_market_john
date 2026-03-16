<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Application;
use App\Actions\GeographyActions;
use App\Actions\ApplicationActions;
use App\Actions\DomainValueActions;
use Illuminate\Support\Facades\Auth;

class HouseholdQuotation extends Component
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

        $user = Auth::user();

        $data['isClient'] = !$user->is_admin && !$user->easy_id; 
        
        $application = ApplicationActions::getApplicationByid($this->application_id);
//        dd($application);
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
        return view('livewire.household-quotation', $data);
    }
}
