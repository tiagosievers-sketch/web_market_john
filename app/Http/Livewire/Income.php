<?php

namespace App\Http\Livewire;

use App\Actions\ApplicationActions;
use App\Actions\DomainValueActions;
use App\Models\HouseholdMember;
use Livewire\Component;

class Income extends Component
{
    public  $application_id;

    
    public function mount($application_id)
    {
        $this->application_id = $application_id;
    }
    public function render()
    {

        $data = [];
        $application = ApplicationActions::getApplicationByid($this->application_id);
        $application->load(['householdMembers.incomesAndDeductions']);
        $data['incomesAndDeductions'] = collect($application->householdMembers->first()->incomesAndDeductions);


        $data['applicant_name'] = ApplicationActions::getApplicantNameByid($this->application_id);
        $data['deductionType'] = DomainValueActions::domainValuesOptions('deductionType', true);

        $data['incomeType'] = DomainValueActions::domainValuesOptions('incomeType', true);

        $data['frequency'] = DomainValueActions::domainValuesOptions('frequency', true);

        $data['householdMembers'] = $application['householdMembers'];

        $data['firstMainMember'] = $data['householdMembers']->first() ?? null;

        $data['member_id'] = $data['firstMainMember']->id ?? null;


        // $data['netIncome'] = $application->householdMembers[$data['member_id']]->net_income;
        $member = HouseholdMember::find($data['member_id']);

        $data['netIncome'] = $member->net_income;

        return view('livewire.income', $data);
    }
}
