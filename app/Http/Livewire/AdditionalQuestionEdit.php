<?php

namespace App\Http\Livewire;

use App\Actions\ApplicationActions;
use Livewire\Component;

class AdditionalQuestionEdit extends Component
{
    public $application_id;
    public $householdMembers = [];
    public $responses = [];

    public function mount($application_id)
    {

        $this->application_id = $application_id;

        // Buscar os membros da aplicação
        $application = ApplicationActions::getApplicationByid($this->application_id);
        $this->householdMembers = $application['householdMembers'];
        // Buscar respostas existentes para preencher os campos
        //$this->responses = ApplicationActions::($this->application_id);

    }

    public function render()
    {
        return view('livewire.additional-question-edit', [
            'householdMembers' => $this->householdMembers,
            'responses' => $this->responses,
        ]);
    }
}
