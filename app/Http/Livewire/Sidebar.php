<?php

namespace App\Http\Livewire;

use App\Actions\MemberInformationActions;
use Livewire\Component;
use Illuminate\Support\Facades\Route;

class Sidebar extends Component
{
    public $application_id;

    public function mount()
    {
        // Captura o application_id da URL se ele estiver presente
        $this->application_id = request()->route('application_id');
    }

    public function render()
    {
        $data = [];


        $data['currentRoute'] = Route::currentRouteName(); 
        

        // Exibe a informação somente quando estiver em uma rota específica
        if (Route::currentRouteName() === 'livewire.members') {
            $data['membersInfo'] = MemberInformationActions::returnMemberList($this->application_id);
        
            // Passa todos os membros, mas vamos verificar o campo `answer_member_information` no Blade
            $data['membersInfo'] = collect($data['membersInfo'])->map(function($member) {
                $member['answered'] = $member['answer_member_information'] == 1; 
                return $member;
            });
        }

        $currentRoutePrimaryContact = request()->routeIs([
            'index',
        ]);
        $data['showMenuPrimaryContact'] = !$currentRoutePrimaryContact;

        $currentRouteHouseHold = request()->routeIs([
            'index',
            'livewire.primary-contact',
        ]);
        $data['showMenuHouseHold'] = !$currentRouteHouseHold;

        $currentRouteRelationship = request()->routeIs([
            'livewire.household',
            'index',
            'livewire.primary-contact',
        ]);
        $data['showMenuRelationship'] = !$currentRouteRelationship;
    


        $currentRouteTax = request()->routeIs([
            'livewire.household',
            'index',
            'livewire.primary-contact',
            'livewire.relationship',
        ]);
        $data['showTaxMenuTax'] = !$currentRouteTax;
       


        $currentRouteAdditioanlInformation = request()->routeIs([
            'livewire.household',
            'index',
            'livewire.primary-contact',
            'livewire.relationship',
            'tax',
        ]);
        $data['showMenuAdditioanlInformation'] = !$currentRouteAdditioanlInformation;


        $currentRouteAddress = request()->routeIs([
            'index',
            'livewire.primary-contact',
            'livewire.household',
            'livewire.relationship',
            'livewire.tax',
            'livewire.additional-information',
        ]);
        $data['showMenuAdress'] = !$currentRouteAddress;


        $currentRouteMembers = request()->routeIs([
            'index',
            'livewire.primary-contact',
            'livewire.household',
            'livewire.relationship',
            'livewire.tax',
            'livewire.additional-information',
            'livewire.address-applicant',
        ]);
        $data['showMenuMembers'] = !$currentRouteMembers;


        $currentRouteIncome = request()->routeIs([
            'index',
            'livewire.primary-contact',
            'livewire.household',
            'livewire.relationship',
            'livewire.tax',
            'livewire.additional-information',
            'livewire.address-applicant',
            'livewire.members',
        ]);
        $data['showMenuIncome'] = !$currentRouteIncome;

        $currentRouteAdditionalQuestion = request()->routeIs([
            'index',
            'livewire.primary-contact',
            'livewire.household',
            'livewire.relationship',
            'livewire.tax',
            'livewire.additional-information',
            'livewire.address-applicant',
            'livewire.members',
            'livewire.income',
        ]);
        $data['showMenuAdditionalQuestion'] = !$currentRouteAdditionalQuestion;

        $currentRouteFinalize = request()->routeIs([
            'index',
            'livewire.primary-contact',
            'livewire.household',
            'livewire.relationship',
            'livewire.tax',
            'livewire.additional-information',
            'livewire.address-applicant',
            'livewire.members',
            'livewire.income',
            'livewire.additional-question',
        ]);
        $data['showMenuFinalize'] = !$currentRouteFinalize;




        $currentRouteAll = request()->routeIs([
            'index',
            'livewire.primary-contact',
            'livewire.primary-contact-edit',
            'livewire.household',
            'livewire.household-edit',
            'livewire.relationship',
            'livewire.tax',
            'livewire.additional-information',
            'livewire.address-applicant',
            'livewire.address-applicant-edit',
            'livewire.members',
            'livewire.members-edit',
            'livewire.income',
            'livewire.additional-question',
            'livewire.additional-question-edit',
            'livewire.finalizeMember',
            'livewire.view-data-quotation',
            

        ]);
        
        $data['showMenuAll'] = $currentRouteAll;




        
        return view('livewire.sidebar', $data);
    }
}
