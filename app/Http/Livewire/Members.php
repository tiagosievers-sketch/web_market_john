<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Actions\DomainValueActions;
use App\Actions\ApplicationActions;

class Members extends Component
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
        $data['applicant_name'] = ApplicationActions::getApplicantNameByid($this->application_id);
        // dd($application);
        $data['application_id'] = $application['id'];
        $data['sexes'] = DomainValueActions::domainValuesOptions('sex', true);
        $data['raceEthnicity'] = DomainValueActions::domainValuesOptions('raceEthnicity', true);
        $data['sexAtBirth'] = DomainValueActions::domainValuesOptions('sexAtBirth', true);
        $data['genderIdentity'] = DomainValueActions::domainValuesOptions('genderIdentity', true);
        $data['sexualOrientation'] = DomainValueActions::domainValuesOptions('sexualOrientation', true);
        $data['suffixes'] = DomainValueActions::domainValuesOptions('suffix', false);

        $data['relationship'] = DomainValueActions::domainValuesOptions('relationship', true);
        $data['originLatino'] = DomainValueActions::domainValuesOptions('originLatino', true);
        $data['documentType'] = DomainValueActions::domainValuesOptions('documentType', true);
        $data['documentOrStatusType'] = DomainValueActions::domainValuesOptions('documentOrStatusType', true);
        $data['country'] = DomainValueActions::domainValuesOptions('country', true);
        $data['householdMembers'] = $application['householdMembers'];

        $data['member_id'] = request()->query('member_id');

        // Se não houver `member_id`, buscar o membro com `field_type = 0`
        if ($data['member_id'] === null) {
            $data['currentMember'] = $data['householdMembers']->where('field_type', 0)->first();
            $data['member_id'] = $data['currentMember']['id'] ?? null;  // Definir o `member_id` como o primeiro encontrado
        } else {
            // Definir o currentMember pelo member_id da URL
            $data['currentMember'] = $data['householdMembers']->where('id', $data['member_id'])->first();
        }
        
        $currentSexId = $data['currentMember']['sex'];

        if (isset($data['sexes'][$currentSexId]) && strcasecmp($data['sexes'][$currentSexId], 'Masculino') === 0) {
            $data['female'] = false;
        } else {
            $data['female'] = true;  
        }        

        return view('livewire.members', $data);
    }
}
