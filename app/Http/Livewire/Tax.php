<?php

namespace App\Http\Livewire;

use App\Actions\ApplicationActions;
use App\Actions\DomainValueActions;
use Livewire\Component;

class Tax extends Component
{
    public int $application_id;
    public ?int $next_member_id = null;
    public bool $spouseOk = false;

    public function mount(int $application_id): void
    {
        // Pega o ID do membro da query string, se existir
        $this->application_id = $application_id;
        $this->next_member_id = request()->query('member_id', null);
    }

    /**
     * @throws \Exception
     */
    public function render()
    {
        $data = [];
        
        // Pega a aplicação
        $application = ApplicationActions::getApplicationByid($this->application_id);
        $data['householdMembers'] = $application['householdMembers'];
        $data['suffixes'] = DomainValueActions::domainValuesOptions('suffix', false);
        $data['application_id'] = $application['id'];
        $data['applicant_name'] = ApplicationActions::getApplicantNameByid($this->application_id);
        $data['sexes'] = DomainValueActions::domainValuesOptions('sex', true);
        $data['relationships'] = DomainValueActions::domainValuesOptions('relationship', true, 'relacaoEsposa');
        $spouseValue = DomainValueActions::getDomainValueByAlias('relacaoEsposa');
        $childValue = DomainValueActions::getDomainValueByAlias('relacaoCrianca');
        $data['spouse_id'] = $spouseValue->id ?? 0;
        $data['child_id'] = $childValue->id ?? 0;

        // Verifica se temos um next_member_id da URL
        if ($this->next_member_id) {
            $member = collect($application['householdMembers'])->firstWhere('id', $this->next_member_id);
        } else {
            // Se não tiver um membro na URL, pega o primeiro membro da lista
            $member = $application['householdMembers'][0] ?? null;
        }
        $data['current_member'] = $member;

        if ($member && $member['id'] == $data['householdMembers'][0]['id']) {
            $this->spouseOk = true;  
        } else {
            $this->spouseOk = false;
        }

        // Pegando o cônjuge, se houver
        foreach ($application['householdMembers'] as $member) {
            if ($member->field_type == 1) {
                $spouse = $member;
                break;
            }
        }
        $data['spouse'] = $spouse ?? null;


        
        return view('livewire.tax', $data);
    }
}
