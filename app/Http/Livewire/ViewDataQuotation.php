<?php

namespace App\Http\Livewire;

use App\Models\Application;
use App\Models\Plan;
use Livewire\Component;

class ViewDataQuotation extends Component
{
    public $application_id;
    public $data = [];

    public function mount($application_id)
    {
        $application = Application::find($this->application_id);
        $application->load(['householdMembers', 'contact']);
        //$this->data['plans'] = $plans['plans'];
        // dd($application);
        $this->data['application'] = $application;
        // dd($this->data);

    }

    public function render()
    {
        return view('livewire.view-data-quotation', $this->data);
    }
}
