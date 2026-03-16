<?php

namespace App\Http\Livewire;

use App\Actions\ApplicationActions;
use Livewire\Component;

class AdditionalQuestion extends Component
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
        $data['application_id'] = $application['id'];
        $data['householdMembers'] = $application['householdMembers'];

        return view('livewire.additional-question', $data);
    }
}
