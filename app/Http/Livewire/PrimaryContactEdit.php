<?php

namespace App\Http\Livewire;

use App\Actions\DomainValueActions;
use App\Actions\GeographyActions;
use App\Actions\ApplicationActions;
use App\Actions\AddressActions;
use App\Actions\ContactActions;
use Livewire\Component;

class PrimaryContactEdit extends Component
{
    public int $application_id;

    public function mount(int $application_id): void
    {
        $this->application_id = $application_id;
    }

    /**
     * Renderiza o componente Livewire.
     */
    public function render()
    {

        $data = [];
        
        $data['application_id'] = $this->application_id;

        // Ações relacionadas ao Application e outras
        $application = ApplicationActions::getApplicationByid($this->application_id);

        $data['application'] = $application;
        $data['mainMember'] = $application['mainMember'];
        $data['address'] = $application['mainMember']->address ?? null;

        $data['mainMemberContact'] = $application['contact'] ?? null;

        $data['addressMailing'] = false;

        if (isset($application['mainMember']->address)) {
            // Verifica se o campo 'mailing' do endereço é igual a 0
            if ($application['mainMember']->address->mailing == 0) {
                $data['addressMailing'] = true;
                $data['addressMailingData'] = $application['mainMember']->address->where('mailing', 0)->first();

            }
        }
        

        $data['states'] = GeographyActions::statesOptions();
        $data['types'] = DomainValueActions::domainValuesOptions('type', true);
        $data['suffixes'] = DomainValueActions::domainValuesOptions('suffix', false);
        $data['sexes'] = DomainValueActions::domainValuesOptions('sex', true);
        $data['languages'] = DomainValueActions::domainValuesOptions('language', true);
       // $data['address'] = AddressActions::getAddressByAplicationId($this->application_id);
        $data['contact'] = ContactActions::getContactByAplicationId($this->application_id);

        return view('livewire.primary-contact-edit', $data);
    }
}
