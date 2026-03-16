<?php

namespace App\Http\Livewire;
use Livewire\Component;

class FormContactdetails extends Component
{
    /**
     * @throws \Exception
     */
    public function render()
    {
        $data = [];
        return view('livewire.form-contactdetails',$data);
    }
}
