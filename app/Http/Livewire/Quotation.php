<?php
namespace App\Http\Livewire;

use App\Models\Application;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Livewire\Component;
use App\Actions\ApplicationActions;
use App\Actions\DomainValueActions;
use App\Actions\InsurancePlansActions;
use stdClass;

class Quotation extends Component
{
    public int $application_id;
    public array $data = [];
    public array $application = [];
    /**
     * @throws \Exception
     */
    public function mount(int $application_id): void
    {
        $this->application_id = $application_id;

        $application = Application::find($this->application_id);
        $application->load(['householdMembers']);

        $memberCount = $application->householdMembers()->count();
      
        $placeData = InsurancePlansActions::buildPlaceData($application);
        $medicaidData = InsurancePlansActions::buildMedicaidData($placeData);
        $hasMec = [];
        $hasMecAffordability = [];
        $estimateData = InsurancePlansActions::buildHouseEstimatesData($application,$placeData,$medicaidData,$hasMec);
        $estimates = InsurancePlansActions::getMembersEstimates($estimateData);
        $csrOverride = InsurancePlansActions::getEstimateCsrOverride($estimates);
        $aptcOverride = InsurancePlansActions::calculateApcOverride($application,$medicaidData,$placeData);
        $estimateSub = 0;
        if(isset($estimates[0]->aptc)) {
            $estimateSub = $estimates[0]->aptc;
        }
        $chips = [];
        foreach($estimates as $key => $value) {
            if($value->is_medicaid_chip==true){
                $chips[] = 1;
            }else {
                $chips[] = 0;
            }
        } trans();
        $estimate2Data = InsurancePlansActions::buildHouseEstimates2Data($application,$placeData,$chips,$hasMec,$hasMecAffordability,$medicaidData);
        if(count($estimate2Data) > 0){
            $estimate2 = InsurancePlansActions::getMembersEstimates($estimate2Data);
            if(count($estimate2) > 0){
                $estimates = $estimate2;
                if(isset($estimates[0]->aptc)) {
                    $estimateSub = $estimates[0]->aptc;
                }
            }
        } else {
            InsurancePlansActions::organizeMecArrays($application,$hasMec,$hasMecAffordability,$medicaidData,$estimateSub);
        }
        //        dd($application);
        //Gera o filtro se baseando no request
        $filterMA = [
            "issuers" => [],
            "metal_levels" => [],
            "deductible" => null,
            "premium" => null
        ];
        $searchAffordableData = InsurancePlansActions::buildSearchPlansData($application, $hasMecAffordability,1, $filterMA,'total_costs',10,$csrOverride,$aptcOverride);
        //O primeiro do array é o mais acessível
        $mostAffordablePlans = InsurancePlansActions::SearchPlans($searchAffordableData);
        if(isset($mostAffordablePlans['plans'])) {
            InsurancePlansActions::createMedicalDeductionAndMoopsAttributes($mostAffordablePlans['plans'],$memberCount);
        }
        $this->data['mostAccessible'] = $mostAffordablePlans;
        //para filtrar apenas
        $filter = [
            "issuers" => [],
            "metal_levels" => [],
            "deductible" => 0,
            "premium" => null
        ];
        $searchPlansData = InsurancePlansActions::buildSearchPlansData($application, $hasMec,1, $filter,'premium',10,$csrOverride,$aptcOverride);
        
        $plans = InsurancePlansActions::searchPlans($searchPlansData);
        //O primeiro do plans é o menor valor (menor premium)
        if(isset($plans['plans'])){
            InsurancePlansActions::createMedicalDeductionAndMoopsAttributes($plans['plans'],$memberCount);
            $this->data['plans'] = $plans['plans'];
        }
        if(count($aptcOverride) > 0){
            $this->data['estimateSub'] = $aptcOverride['aptc_override'];
            $estimateObj = new StdClass();
            $estimateObj->aptc = $aptcOverride['aptc_override'];
            $this->data['estimate'] = [$estimateObj];
        } else {
            $this->data['estimateSub'] = $estimateSub;
            $this->data['estimate'] = $estimates ?? [];
        }
        $this->data['hasMec'] = $hasMec;
        //O array todos os planos está contido em 'plans'
        $this->data['application'] = $application;
        //         dd($this->data);

        $this->data['year'] = $application->year ?? now()->year;
    }


    /**
     * @throws \Exception
     */
    public function render()
    {

        $dataForm = [];
        $dataForm['sexes'] = DomainValueActions::domainValuesOptions('sex', true);
        $dataForm['relationships'] = DomainValueActions::domainValuesOptions('relationship', true, 'relacaoEsposa');
        $dataForm['years'] = array_map('intval', config('years.available_years'));


        return view('livewire.quotation', $this->data, $dataForm);
    }
}
