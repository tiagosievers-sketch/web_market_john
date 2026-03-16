<?php

namespace App\Http\Livewire;

use App\Actions\DomainValueActions;
use App\Actions\GeographyActions;
use Livewire\Component;

class FormStart extends Component
{
    /**
     * @throws \Exception
     */
    public function render()
    {
        $data = [];
        $data['states'] = GeographyActions::statesOptions();

        return view('livewire.form-start', $data);
    }
}
