<?php

namespace App\Http\Livewire;

use App\Actions\DomainValueActions;
use App\Actions\GeographyActions;
use Livewire\Component;

class PrimaryContact extends Component
{
    /**
     * @throws \Exception
     */
    public function render()
    {
        $data = [];
        $data['states'] = GeographyActions::statesOptions();
        // $data['states'] = ['estadoteste'=>'Estado Teste'];
        $data['types'] = DomainValueActions::domainValuesOptions('type', true);
        $data['suffixes'] = DomainValueActions::domainValuesOptions('suffix', false);
        $data['sexes'] = DomainValueActions::domainValuesOptions('sex', true);
        $data['languages'] = DomainValueActions::domainValuesOptions('language', true);
        return view('livewire.primary-contact', $data);
    }
}
