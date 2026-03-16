<?php
namespace App\Http\Livewire;

use Livewire\Component;
use App\Actions\DomainValueActions;
use App\Actions\RelationshipActions;
use App\Http\Requests\CreateOrUpdateRelationshipsRequest;

class Relationship extends Component
{
    public $application_id;
    public $relationships = [];
    public $relationshipOptions = [];
    public $relationshipDetail = [];

    
    public function mount($application_id)
    {
        $this->application_id = $application_id;
        $this->loadRelationships(); // Carrega os relacionamentos

        $this->relationshipOptions = DomainValueActions::domainValuesOptions('relationship', false);
        //$this->relationshipDetail = DomainValueActions::domainValuesOptions('relationshipDetail', false);



    }

    public function loadRelationships()
    {
        try {
            $this->relationships = RelationshipActions::getOtherMembersRelationshipsByApplication($this->application_id);

            foreach ($this->relationships as &$relationshipGroup) {
                foreach ($relationshipGroup['relationships'] as &$relation) {
                    $relation['relationship_detail'] = $relation['relationship_detail'] ?? null; // Garante que tenha o detalhe
                }
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Erro ao carregar os relacionamentos.');
        }
    }

    public function render()
    {
        return view('livewire.relationship');
    }


    public function save()
{
    try {
        $requestData = [
            'application_id' => $this->applicationId,
            'household_relatioships' => $this->relationships
        ];

        RelationshipActions::createOrUpdateRelationships(new CreateOrUpdateRelationshipsRequest($requestData));

        session()->flash('success', 'Relações salvas com sucesso.');
    } catch (\Exception $e) {
        session()->flash('error', 'Erro ao salvar as relações: ' . $e->getMessage());
    }

    $this->loadRelationships();
}

}
