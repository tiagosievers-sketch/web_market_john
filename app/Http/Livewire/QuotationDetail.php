<?php

namespace App\Http\Livewire;

use App\Models\Application;
use Carbon\Carbon;
use Livewire\Component;
use App\Actions\ApplicationActions;
use App\Actions\InsurancePlansActions;

class QuotationDetail extends Component
{
    public int $application_id;
    public string $plan_id;
    public string $premium;
    public array $data = [];
    public array $application = [];
    public array $hasMec = [];
    /**
     * @throws \Exception
     */
    public function mount(int $application_id, string $plan_id, string $premium): void
    {
        $this->application_id = $application_id;
        $this->plan_id = $plan_id;
        $this->premium = $premium;

        $application = Application::find($this->application_id);
        $application->load(['householdMembers']);
        //        dd($application);
        $this->hasMec = [];
        $plans_ids = [$this->plan_id];
        $memberCount = $application->override_household_number??$application->householdMembers()->count();

        $placeData = InsurancePlansActions::buildPlaceData($application);
        $medicaidData = InsurancePlansActions::buildMedicaidData($placeData);
        $hasMec = [];
        $estimateData = InsurancePlansActions::buildHouseEstimatesData($application, $placeData, $medicaidData, $hasMec);

        $estimates = InsurancePlansActions::getMembersEstimates($estimateData);
        $aptcOverride = InsurancePlansActions::calculateApcOverride($application, $medicaidData, $placeData);

        $csrOverride = InsurancePlansActions::getEstimateCsrOverride($estimates);

            $searchPlansByIdsData = InsurancePlansActions::buildSearchPlansByIdsData($application, $plans_ids, $csrOverride, $aptcOverride);
        // dd($searchPlansByIdsData);

        $plansComplete = InsurancePlansActions::searchPlansByIds($searchPlansByIdsData);

        InsurancePlansActions::createMedicalDeductionAndMoopsAttributes($plansComplete,$memberCount);

        $this->data['planComplete'] = $plansComplete[0];

        $searchPlansData = InsurancePlansActions::buildSearchPlansData($application, $this->hasMec);

        $this->data['plansDetails'] = InsurancePlansActions::SearchPlansDetails($searchPlansData,  $this->plan_id);
        //  dd($this->data['plansDetails']);
        $this->data['application'] = $application;
    }


    /**
     * @throws \Exception
     */
    public function render()
    {
        return view('livewire.quotation-detail', $this->data);
    }
}
