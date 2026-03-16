<?php

namespace App\Http\Livewire;

use App\Actions\ApplicationActions;
use App\Actions\GeographyActions;
use Livewire\Component;

class AddressesApplicantEdit extends Component
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

        // Assegura que os endereços dos membros estão carregados
        $data['householdMembers'] = $application['householdMembers']->load('address');

        $data['mainMemberId'] = $application['mainMember']->id;
        
        $someoneLivesWithMain = $application['householdMembers']->contains(function ($member) {
            return $member->lives_with !== null;
        });

        $data['someoneLivesWithMain'] = $someoneLivesWithMain;

        $data['states'] = GeographyActions::statesOptions();

        $firstHouseholdMember = $application->householdMembers->first();
        $data['address'] = $firstHouseholdMember->address ?? null;

        return view('livewire.addresses-applicant-edit', $data);
    }
}
