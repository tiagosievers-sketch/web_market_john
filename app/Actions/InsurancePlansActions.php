<?php

namespace App\Actions;

use App\Http\Requests\FilterPlansRequest;
use App\Libraries\KffCalculatorLibrary;
use App\Libraries\SubsidyCalculatorHelperLibrary;
use App\Models\Application;
use Exception;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use App\Libraries\GatewayHttpLibrary;
use App\Http\Requests\GetPlansSearchRequest;
use Illuminate\Support\Facades\Log;

class InsurancePlansActions
{

    const ACTUAL_YEAR = 2025;

    public static $json = '{}';

    /**
     * @throws Exception
     */
    public static function searchPlans(array $householdData): array
    {
        $now  = Carbon::now();
        // Fazendo a chamada para searchPlans, passando os dados montados
        $responsePlans = GatewayHttpLibrary::searchPlans($householdData, $now->year);
        // Processando a resposta e montando o array de planos
        $plans = [];
        if (isset($responsePlans->status)) {
            if ($responsePlans->status == 'success') {
                if (isset($responsePlans->data)) {
                    if (isset($responsePlans->data->plans)) {
                        return collect($responsePlans->data)->toArray();
                    }
                }
            }
        }

        return $plans; // Retornando os planos processados
    }

    /**
     * @throws Exception
     */
    public static function searchPlansDetails(array $householdData,string $hios_plan_id): array
    {
        $now  = Carbon::now();
        // Fazendo a chamada para searchPlans, passando os dados montados
        $responsePlans = GatewayHttpLibrary::searchPlanByIdPost($householdData, $now->year, $hios_plan_id);
        if (isset($responsePlans->status)) {
            if ($responsePlans->status == 'success') {
                if (isset($responsePlans->data)) {
                    if (isset($responsePlans->data->plan)) {
                        return collect($responsePlans->data->plan)->toArray();
                    }
                }
            }
        }

        return []; // Retornando os planos processados
    }

    /**
     * @throws Exception
     */
    public static function searchPlansByIds(array $plansByIdSearchData): array
    {
        $now  = Carbon::now();
        // Fazendo a chamada para searchPlans, passando os dados montados
        $responsePlans = GatewayHttpLibrary::searchPlansByIds($plansByIdSearchData, $now->year);
        // Processando a resposta e montando o array de planos
        $plans = [];
        if (isset($responsePlans->status)) {
            if ($responsePlans->status == 'success') {
                if (isset($responsePlans->data)) {
                    return collect($responsePlans->data)->toArray();
                }
            }
        }

        return $plans; // Retornando os planos processados
    }

    /**
     * @throws Exception
     */
    public static function buildSearchPlansData(Application $application, array $hasMec, int $page=1, array $arFilter = array(), string $sort = null, int $plansByPage = 10, array $csrOverride = array(), array $aptcOverride = array()): array
    {
        $year = $application->year ? $application->year : self::ACTUAL_YEAR;
        $now = Carbon::now();
        $members = [];
        $hasMarriedCouple = false;
        $income = 0;
        $market = "Individual";
        $zipcode = null;
        $offset = $plansByPage*($page-1);
        $countyFips = null;
        $stateLetters = null;
        foreach($application->householdMembers as $key=>$member){
            if((count($application->householdMembers) > 1) && $member->married && $member->field_type==1){
                $hasMarriedCouple = true;
            }
            if ($member->field_type == 0) {
                $income = (float)$member->income_predicted_amount;
                $zipcode = $member->address->zipcode;
                $countyName = $member->address->county;
                $county = GeographyActions::getCountyInfoByZip($zipcode,$countyName);
                if (!$county) {
                    throw new \Exception('No address found with this zipcode: '.$zipcode);
                }
                $countyFips = $county->fips;
                $stateLetters = $county->state;
            }
            $cDob = Carbon::parse($member->birthdate);
            $age = $now->diffInYears($cDob);
            $members[] = [
                'age' => $age,
                'aptc_eligible' => true,
                'gender' => $member->sexModel->name ?? "Male",
                'has_mec' => false/*isset($hasMec[$key])?$hasMec[$key]:0*/,
                'uses_tobacco' => filter_var($member->use_tobacco??0, FILTER_VALIDATE_BOOLEAN),
                'utilization_level' => "Medium"
            ];
        }
        $finalFilter = $arFilter;

        if(!empty($arFilter)) {
            if(!isset($arFilter['hsa'])){
                $finalFilter = array_merge($arFilter, ['hsa' => false]);
            }
        }

        $returnData =  [
            "filter" => $finalFilter,
            "household" => [
                "income" => $income,
                "people" => $members,
                "has_married_couple" => $hasMarriedCouple
            ],
            "market" => $market ?? "Individual",
            "place" => [
                "countyfips" => $countyFips,
                "state" => $stateLetters,
                "zipcode" => $zipcode
            ],
            "sort" => $sort ?? 'premium',
            "limit" => $plansByPage,
            "offset" => $offset,
            "order" => "asc",
            "year" => $year
        ];

        //Aplica um CSR Override dependendo da renda do usuário.
        Log::info("CSR Override");
        Log::info(print_r($csrOverride, true));
        Log::info("APTC Override");
        Log::info(print_r($aptcOverride, true));
        if(count($csrOverride) > 0){
            $returnData = array_merge($returnData,$csrOverride);
        }
        if(count($aptcOverride) > 0){
            $returnData = array_merge($returnData,$aptcOverride);
        }
        return $returnData;
    }



    /**
     * @throws Exception
     */
    public static function buildSearchPlansByIdsData(Application $application, array $planIds,array $csrOverride = array(), array $aptcOverride = array()): array
    {
        $year = $application->year ? $application->year : self::ACTUAL_YEAR;
        $now = Carbon::now();
        $members = [];
        $hasMarriedCouple = false;
        $income = 0;
        $market = "Individual";
        $zipcode = null;
        $countyFips = null;
        $stateLetters = null;
        foreach($application->householdMembers as $key=>$member){
            if((count($application->householdMembers) > 1) && $member->married && $member->field_type==1){
                $hasMarriedCouple = true;
            }
            if ($member->field_type == 0) {
                $income = (float)$member->income_predicted_amount;
                $zipcode = $member->address->zipcode;
                $countyName = $member->address->county;
                $county = GeographyActions::getCountyInfoByZip($zipcode,$countyName);
                if (!$county) {
                    throw new \Exception('No address found with this zipcode: '.$zipcode);
                }
                $countyFips = $county->fips;
                $stateLetters = $county->state;
            }
            $cDob = Carbon::parse($member->birthdate);
            $age = $now->diffInYears($cDob);
            $members[] = [
                'age' => $age,
                'aptc_eligible' => true,
                'gender' => $member->sexModel->name ?? "Male",
                'has_mec' => false/*isset($hasMec[$key])?$hasMec[$key]:0*/,
                'uses_tobacco' => filter_var($member->use_tobacco??0, FILTER_VALIDATE_BOOLEAN),
                'utilization_level' => "Medium"
            ];
        }

        $returnData =  [
            "household" => [
                "income" => $income,
                "people" => $members,
                "has_married_couple" => $hasMarriedCouple
            ],
            "place" => [
                "countyfips" => $countyFips,
                "state" => $stateLetters,
                "zipcode" => $zipcode
            ],
            "market" => $market ?? "Individual",
            "plan_ids" => $planIds,
            "year" => $year,
        ];

        //Aplica um CSR Override dependendo da renda do usuário.
        Log::info("CSR Override");
        Log::info(print_r($csrOverride, true));
        Log::info("APTC Override");
        Log::info(print_r($aptcOverride, true));
        if(count($csrOverride) > 0){
            $returnData = array_merge($returnData,$csrOverride);
        }
        if(count($aptcOverride) > 0){
            $returnData = array_merge($returnData,$aptcOverride);
        }
        return $returnData;
    }

    public static function buildFilter(FilterPlansRequest $request){
        $validated = $request->validated();

        $issuers = [];
        if(isset($validated['issuers'])) {
            $issuers = $validated['issuers'];
        }

        $metalLevels = [];
        if(isset($validated['metal_level'])) {
            $metalLevels = $validated['metal_level'];
        }

        $reqDeductible = isset($validated['deductible'])?intval($validated['deductible']):null;

        $reqPremium = null;
        if(isset($validated['premium'])&&isset($validated['ranges'])){
            if($validated['ranges']['premiums']['min'] > $validated['premium']) {
                $reqPremium = ($validated['ranges']['premiums']['min'] * 1.2);
            }else {
                $reqPremium = (floatval($validated['premium']) * 1.2);
            }
        }

        return [
            "issuers" => $issuers,
            "metal_levels" => $metalLevels,
            "deductible" => $reqDeductible,
            "premium" => $reqPremium,
            "hsa" => false
        ];
    }


    /**
     * @throws Exception
     */
    public static function buildMedicaidData(array $placeAr)
    {
        if(isset($placeAr['state'])){
            return GeographyActions::getStateMedicaid($placeAr['state']);
        }
        return false;
    }


    /**
     * @throws Exception
     */
    public static function buildPlaceData(Application $application)
    {
        $mainMember = $application->householdMembers()->where('field_type', '=', 0)->first();
        $zipcode = $mainMember->address->zipcode;
        $countyName = $mainMember->address->county ?? null;
        $county = GeographyActions::getCountyInfoByZip($zipcode,$countyName);
        if(!$county){
            throw new \Exception('No address found with this zipcode: '.$zipcode);
        }

        return [
            "countyName" => $county->name,
            "countyfips" => $county->fips,
            "state" => $county->state,
            "zipcode" => $county->zipcode
        ];
    }

    /**
     * @throws Exception
     */
    public static function buildHouseEstimatesData(Application $application, array $arPlace, $medicaid, array &$hasMec): array
    {
        $now = Carbon::now();
        $maxAgeChip = 18;
        $year = $application->year ? $application->year : self::ACTUAL_YEAR;
        $hasMarriedCouple = false;
        $income = 42000;
        $peopleEstimate = [];
        if($medicaid){
            if(isset($medicaid->chip)){
                if (count($medicaid->chip) > 0) {
                    $maxAgeChip = $medicaid->chip[0]->max_age;
                }
            }
        }
        foreach($application->householdMembers as $key=>$member){
            if((count($application->householdMembers) > 1) && $member->married && $member->field_type==1){
                $hasMarriedCouple = true;
            }
            if($member->field_type==0){
                $income = (float)$member->income_predicted_amount;
            }
            $cDob = Carbon::parse($member->birthdate);
            $age = $now->diffInYears($cDob);
            if($age <= $maxAgeChip) {
                $hasMec[$key] = true;

            }else{
                $hasMec[$key] = false;
            }
            $peopleEstimate[] = [
                'age' => $age,
                'aptc_eligible' => filter_var($member->eligible_cost_saving, FILTER_VALIDATE_BOOLEAN),
                'gender' => $member->sexModel->name ?? "Male",
                'has_mec' => $hasMec[$key],
                'uses_tobacco' => filter_var($member->use_tobacco, FILTER_VALIDATE_BOOLEAN),
                "utilization_level"=> "Medium"
            ];
        }

        return [
            "household" => [
                "income" => $income,
                "people" => $peopleEstimate,
                "has_married_couple" => $hasMarriedCouple
            ],
            "market" => "Individual",
            "place" => $arPlace,
            "year" => $year
        ];
    }



    /**
     * @throws Exception
     */
    public static function buildHouseEstimates2Data(Application $application, array $arPlace, array $chips, array &$hasMec, array &$hasMecAffordability, $medicaid): array
    {
        $now = Carbon::now();
        $year = $application->year ? $application->year : self::ACTUAL_YEAR;
        $peopleEstimate = [];
        $hasMarriedCouple = false;
        $income = 42000;
        $maxAgeChip = 18;
        $hasMec = [];
        if($medicaid){
            if(isset($medicaid->chip)){
                if (count($medicaid->chip) > 0) {
                    $maxAgeChip = $medicaid->chip[0]->max_age;
                }
            }
        }
        foreach($application->householdMembers as $key=>$member){
            if((count($application->householdMembers) > 1) && $member->married && $member->field_type==1){
                $hasMarriedCouple = true;
            }
            if($member->field_type==0){
                $income = (float)$member->income_predicted_amount;
            }
            $cDob = Carbon::parse($member->birthdate);
            $age = $now->diffInYears($cDob);
//            dd(in_array(1, $chips),in_array(0, $chips));
            if(in_array(1, $chips)==0 || in_array(0, $chips)==0){
                if(in_array(0, $chips)==1){
                    //recalculando subsídio com medicaid
                    $hasMec[$key] = false;
                    $hasMecAffordability[$key] = true;
                    $peopleEstimate[] = [
                        'age' => $age,
                        'aptc_eligible' => filter_var($member->eligible_cost_saving, FILTER_VALIDATE_BOOLEAN),
                        'gender' => $member->sexModel->name ?? "Male",
                        'has_mec' => $hasMec[$key],
                        'uses_tobacco' => filter_var($member->use_tobacco, FILTER_VALIDATE_BOOLEAN),
                        "utilization_level"=> "Medium"
                    ];
                } else {
                    if($age <= $maxAgeChip) {
                        $hasMec[$key] = false;
                        $hasMecAffordability[$key] = true;
                    }else{
                        $hasMec[$key] = false;
                        $hasMecAffordability[$key] = true;
                    }
                }
            }
        }
        if(count($peopleEstimate) > 0){
            return [
                "household" => [
                    "income" => $income,
                    "people" => $peopleEstimate,
                    "has_married_couple" => $hasMarriedCouple
                ],
                "market" => "Individual",
                "place" => $arPlace,
                "year" => $year
            ];
        }
        return $peopleEstimate;
    }

    public static function organizeMecArrays(Application $application,array &$hasMec, array &$hasMecAffordability, $medicaid, float $estimateSub){
        $now = Carbon::now();
        $maxAgeChip = 18;
        if($medicaid){
            if(isset($medicaid->chip)){
                if (count($medicaid->chip) > 0) {
                    $maxAgeChip = $medicaid->chip[0]->max_age;
                }
            }
        }
        foreach($application->householdMembers as $key=>$member){
            $cDob = Carbon::parse($member->birthdate);
            $age = $now->diffInYears($cDob);
            if($estimateSub!==0){
                if($age <= $maxAgeChip) {
                    $hasMec[$key] = true;
                    $hasMecAffordability[$key] = true;
                }else{
                    $hasMec[$key] = false;
                    $hasMecAffordability[$key] = false;
                }
            }else {
                if($age <= $maxAgeChip) {
                    $hasMec[$key] = false;
                    $hasMecAffordability[$key] = true;
                }else{
                    $hasMec[$key] = false;
                    $hasMecAffordability[$key] = true;
                }
            }
        }
    }


    /**
     * @throws Exception
     */
    public static function getMembersEstimates(array $estimatesData): array
    {
        $now  = Carbon::now();
        // Fazendo a chamada para searchPlans, passando os dados montados
        Log::info('Estimate Data:', ['data' => $estimatesData]);
        $responsePlans = GatewayHttpLibrary::searchHouseElegibilityEstimates($estimatesData, $now->year);
        if (isset($responsePlans->status)) {
            if ($responsePlans->status == 'success') {
                if (isset($responsePlans->data)) {
                    if (isset($responsePlans->data->estimates)) {
                        return $responsePlans->data->estimates;
                    }
                }
            }
        }

        return []; // Retornando os planos processados
    }

    /**
     * @throws Exception
     */
    public static function searchMostAccessiblePlanFiltered(int $application_id) {
        $application = Application::find($application_id);
        $application->load(['householdMembers']);
        $placeData = self::buildPlaceData($application);
        $medicaidData = self::buildMedicaidData($placeData);
        $hasMec = [];
        $hasMecAffordability = [];
        $estimateData = self::buildHouseEstimatesData($application, $placeData, $medicaidData, $hasMec);
        $estimates = self::getMembersEstimates($estimateData);
        $estimateSub = isset($estimates[0]->aptc) ? $estimates[0]->aptc : 0;

        // Chips logic
        $chips = [];
        foreach ($estimates as $value) {
            $chips[] = $value->is_medicaid_chip ? 1 : 0;
        }

        $estimate2Data = self::buildHouseEstimates2Data($application, $placeData, $chips, $hasMec, $hasMecAffordability, $medicaidData);
        if (count($estimate2Data) > 0) {
            $estimate2 = self::getMembersEstimates($estimate2Data);
            $estimates = count($estimate2) > 0 ? $estimate2 : $estimates;
            $estimateSub = isset($estimates[0]->aptc) ? $estimates[0]->aptc : $estimateSub;
        } else {
            self::organizeMecArrays($application, $hasMec, $hasMecAffordability, $medicaidData, $estimateSub);
        }
        $csrOverride = self::getEstimateCsrOverride($estimates);
        Log::info('CSR Override: ', $csrOverride);
        // 1. Filtrar e pegar o primeiro plano com o tipo 'HMO' ordenado por 'premium'
        $filterHMO = [
            'type' => 'HMO'
        ];
        $searchPlansDataHMO = InsurancePlansActions::buildSearchPlansData($application, $hasMec, 1, $filterHMO, 'premium',10,$csrOverride);
        $plansHMO = InsurancePlansActions::searchPlans($searchPlansDataHMO);
        Log::info('Plans HMO: ', $plansHMO['plans']);
        if(isset($plansHMO['plans'])) {
            $hmoPlan = $plansHMO['plans'][0] ?? null;
        } else {
            $hmoPlan = [];
        }

        // 2. Filtrar e pegar o plano com o menor 'OOPC'
        $filterOopc = [];
        $searchPlansDataOopc = InsurancePlansActions::buildSearchPlansData($application, $hasMec, 1, $filterOopc, 'oopc',10,$csrOverride);
        $plansOopc = InsurancePlansActions::searchPlans($searchPlansDataOopc);
        Log::info('Pesquisa de segunda coluna',$plansOopc);
        if(isset($plansOopc['plans'])) {
            $oopcPlan = $plansOopc['plans'][0] ?? null;
        } else {
            $oopcPlan = [];
        }
        // 3. Filtrar e pegar o primeiro plano com o tipo 'EPO' e issuer 'Oscar Insurance Company of Florida'
        $filterEPO = [
            'type' => 'EPO',
            'issuer' => 'Oscar Insurance Company of Florida'
        ];
        $searchPlansDataEPO = InsurancePlansActions::buildSearchPlansData($application, $hasMec, 1, $filterEPO, 'premium',10,$csrOverride);
        $plansEPO = InsurancePlansActions::searchPlans($searchPlansDataEPO);
        Log::info('Primeira pesquisa de terceira coluna',$plansEPO);
        if(isset($plansEPO['plans'])) {
            $epoPlan = $plansEPO['plans'][0] ?? null;
        } else {
            $epoPlan = [];
        }
        // Fallback se nenhum plano for encontrado com o issuer 'Oscar'
        if (!$epoPlan) {
            $filterEPOFallback = ['type' => 'EPO'];
            $searchPlansDataEPOFallback = InsurancePlansActions::buildSearchPlansData($application, $hasMec, 1, $filterEPOFallback, 'premium',10,$csrOverride);
            $plansEPOFallback = InsurancePlansActions::searchPlans($searchPlansDataEPOFallback);
            Log::info('Segunda pesquisa de terceira coluna',$plansEPOFallback);
            if(isset($plansEPOFallback['plans'])) {
                $epoPlan = $plansEPOFallback['plans'][0] ?? null;
            } else {
                $epoPlan = [];
            }
        }

        // Retornar os três planos
        return [
            'hmo_plan' => collect($hmoPlan)->toArray(),
            'oopc_plan' => collect($oopcPlan)->toArray(),
            'epo_plan' => collect($epoPlan)->toArray()
        ];
    }

    /**
     * @throws Exception
     */
    // public static function getEstimateCsrOverride($estimates): array
    // {
    //     Log::info('Inside CSR Override');
    //     if(is_array($estimates)){
    //         if(count($estimates) == 0) {
    //             throw new \Exception('Could no get estimates for this data.');
    //         }
    //         [$firstEstimate] = $estimates;
    //         if(isset($firstEstimate->csr)){
    //             $csr = match ($firstEstimate->csr) {
    //                 '73% AV Level Silver Plan CSR' => 'CSR73',
    //                 '87% AV Level Silver Plan CSR' => 'CSR87',
    //                 '94% AV Level Silver Plan CSR' => 'CSR94',
    //                 default => 'LimitedCSR',
    //             };
    //             return ['csr_override' => $csr];
    //         }
    //     }
    //     return [];
    // }

    public static function getEstimateCsrOverride($estimates): array
    {
        Log::info('Inside CSR Override');

        if (!is_array($estimates) || count($estimates) === 0) {
            // Sem estimates: só não aplica CSR override
            return [];
        }

        $firstEstimate = $estimates[0] ?? null;
        if ($firstEstimate && isset($firstEstimate->csr)) {
            $csr = match ($firstEstimate->csr) {
                '73% AV Level Silver Plan CSR' => 'CSR73',
                '87% AV Level Silver Plan CSR' => 'CSR87',
                '94% AV Level Silver Plan CSR' => 'CSR94',
                default => 'LimitedCSR',
            };
            return ['csr_override' => $csr];
        }

        return [];
    }


    public static function calculateApcOverride(Application $application, $medicaid, array $placeData): array
    {
        Log::info("Medicaid Data");
        Log::info(print_r($medicaid, true));
        $maxAgeChip = 18;
        $now = Carbon::now();
        if($medicaid){
            if(isset($medicaid->chip)){
                if (count($medicaid->chip) > 0) {
                    $maxAgeChip = $medicaid->chip[0]->max_age??18;
                }
            }
        }
        $zipcode = $placeData['zipcode'];
        $stateLetters = strtolower($placeData['state']);

        $children = [];
        $adults = [];
        $income = 0;
        foreach ($application->householdMembers as $member) {
            if($member->field_type==0){
                $income = (float)$member->income_predicted_amount;
            }
            $cDob = Carbon::parse($member->birthdate);
            $age = $now->diffInYears($cDob);
            if($age <= $maxAgeChip) {
                $children[] = [
                    'age' => $age,
                    'tobacco' => filter_var($member->use_tobacco, FILTER_VALIDATE_BOOLEAN)
                ];
            } else {
                $adults[] = [
                    'age' => $age,
                    'tobacco' => filter_var($member->use_tobacco, FILTER_VALIDATE_BOOLEAN)
                ];
            }
        }
//        if(count($children)){
            $silverBronze = KffCalculatorLibrary::generateSilverAndBronze($zipcode);
            if ($silverBronze != []) {
                $formData = [
                    "income_type" => "dollars",
                    "income" => $income,
                    "employer_coverage" => 0,
                    "people" => $application->override_household_number??(count($adults) + count($children)),
                    "adults" => $adults,
                    "adult_count" => count($adults),
                    "children" => $children,
                    "child_count" => count($children),
                    "small" => false,
                    "child_coverage" => null,
                    "silver" => $silverBronze['silver'],
                    "bronze" => $silverBronze['bronze'],
                    "state" => $stateLetters,
                    "state_has_no_data" => false,
                    "no_bronze_plans" => false,
                    "alternate_family_size" => "",
                    "received_unemployment" => null
                ];

                $object = new SubsidyCalculatorHelperLibrary($formData, $formData);
                $object->initialize_calculations();

                $taxCredit = $object->recoverTaxCredit();
                //TODO testando o arredondamento como no HS para ver se os valores batem.
                return ['aptc_override' => ceil($taxCredit['silver_tax_credit']/12)];
            }
//        }
        return [];
    }

    public static function createMedicalDeductionAndMoopsAttributes(array &$plans, int $memberCount=1, bool $perPerson=true): void
    {
        foreach ($plans as $index=>$plan) {
            $plan->medical_deductible = 0;
            $plan->moops_amount = 0;
            if(isset($plan->moops)) {
                foreach ($plan->moops as $moop){
                    if ($memberCount > 1) {
                        if($perPerson){
                            if ($moop->family_cost == 'Family Per Person') {
                                $plan->moops_amount = $moop->amount;
                                break;
                            }
                        } else {
                            if ($moop->family && $moop->family_cost == 'Family') {
                                $plan->moops_amount = $moop->amount;
                                break;
                            }
                        }
                    } else {
                        if($moop->individual&&$moop->family_cost=='Individual'){
                            $plan->moops_amount = $moop->amount;
                            break;
                        }
                    }

                }
            }
            foreach($plan->deductibles as $deductible) {
                if(str_contains($deductible->type, 'Medical')) {
                    if ($memberCount > 1) {
                        if($deductible->family&&$deductible->family_cost=='Family'){
                            $plan->medical_deductible = $deductible->amount;
                        }
                    } else {
                        if($deductible->individual&&$deductible->family_cost=='Individual'){
                            $plan->medical_deductible = $deductible->amount;
                        }
                    }
                }
            }
            $plans[$index] = $plan;
        }
    }
}
