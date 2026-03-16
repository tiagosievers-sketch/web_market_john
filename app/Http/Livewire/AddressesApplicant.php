<?php

namespace App\Http\Livewire;

use App\Actions\ApplicationActions;
use App\Actions\GeographyActions;
use Livewire\Component;

class AddressesApplicant extends Component
{

    public int $application_id;

    public function mount(int $application_id): void
    {
        // Pega o ID do membro da query string, se existir
        $this->application_id = $application_id;
    }

    public function render()
    {


        $data = [];
        $application = ApplicationActions::getApplicationByid($this->application_id);
        $data['householdMembers'] = $application['householdMembers'];
        $data['states'] = GeographyActions::statesOptions();

        $firstHouseholdMember = $application->householdMembers->first();
        $data['address'] = $firstHouseholdMember->address ?? null;

    
        // dd($data);
        return view('livewire.addresses-applicant', $data);
    }
}
