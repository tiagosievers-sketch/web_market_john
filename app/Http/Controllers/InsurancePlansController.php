<?php

namespace App\Http\Controllers;

use App\Actions\InsurancePlansActions;
use App\Http\Requests\FilterPlansRequest;
use App\Http\Requests\GetPlansSearchRequest;
use App\Models\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use stdClass;

class InsurancePlansController extends Controller
{


    /**
     * @throws \Exception
     */
    public function searchMostAccessiblePlan(int $application_id, FilterPlansRequest $request): JsonResponse
    {
        //Recovers
        $application = Application::find($application_id);
        $application->load(['householdMembers']);
        $memberCount = $application->householdMembers()->count();
        $placeData = InsurancePlansActions::buildPlaceData($application);
        $medicaidData = InsurancePlansActions::buildMedicaidData($placeData);
        $hasMec = [];
        $hasMecAffordability = [];
        $estimateData = InsurancePlansActions::buildHouseEstimatesData($application, $placeData, $medicaidData, $hasMec);
        $estimates = InsurancePlansActions::getMembersEstimates($estimateData);
        $csrOverride = InsurancePlansActions::getEstimateCsrOverride($estimates);
        $aptcOverride = InsurancePlansActions::calculateApcOverride($application,$medicaidData,$placeData);


        $estimateSub = 0;
        if (isset($estimates[0]->aptc)) {
            $estimateSub = $estimates[0]->aptc;
        }
        $chips = [];
        foreach ($estimates as $key => $value) {
            if ($value->is_medicaid_chip == true) {
                $chips[] = 1;
            } else {
                $chips[] = 0;
            }
        }
        $estimate2Data = InsurancePlansActions::buildHouseEstimates2Data($application, $placeData, $chips, $hasMec, $hasMecAffordability, $medicaidData);
        if (count($estimate2Data) > 0) {
            $estimate2 = InsurancePlansActions::getMembersEstimates($estimate2Data);
            if (count($estimate2) > 0) {
                $estimates = $estimate2;
                if (isset($estimates[0]->aptc)) {
                    $estimateSub = $estimates[0]->aptc;
                }
            }
        } else {
            InsurancePlansActions::organizeMecArrays($application, $hasMec, $hasMecAffordability, $medicaidData, $estimateSub);
        }
        //Gera o filtro se baseando no request
        $arFilter = InsurancePlansActions::buildFilter($request);

        $searchAffordableData = InsurancePlansActions::buildSearchPlansData($application, $hasMec, 1, [], 'total_costs',10,$csrOverride,$aptcOverride);
        try {
            $affordable = InsurancePlansActions::searchPlans($searchAffordableData);
            if (isset($affordable['plans'])) {
                InsurancePlansActions::createMedicalDeductionAndMoopsAttributes($affordable['plans'],$memberCount);
            }
            $data = [];
            if (count($affordable) > 0) {
                if (isset($affordable["plans"])) {
                    $plansAux = $affordable["plans"];
                    reset($plansAux);
                    $data['affordable'] = current($plansAux);
                }
                if (isset($affordable["total"])) {
                    $data["total"] = $affordable["total"];
                }
                if (isset($affordable["rate_area"])) {
                    $data["rate_area"] = $affordable["rate_area"];
                }
                if (isset($affordable["facet_groups"])) {
                    $data["facet_groups"] = $affordable["facet_groups"];
                }
                if (isset($affordable["ranges"])) {
                    $data["ranges"] = $affordable["ranges"];
                }
            }
            //para filtrar apenas
            $filter = [
                "issuers" => [],
                "metal_levels" => [],
                "deductible" => 0,
                "premium" => null
            ];
            if (count($arFilter) > 0) {
                $filter = $arFilter;
            }
            $searchPlansData = InsurancePlansActions::buildSearchPlansData($application, $hasMec, 1, $filter, 'premium',10,$csrOverride,$aptcOverride);
            $plans = InsurancePlansActions::searchPlans($searchPlansData);
            if (isset($plans['plans'])) {
                InsurancePlansActions::createMedicalDeductionAndMoopsAttributes($plans['plans'],$memberCount);
                $data['plans'] = $plans['plans'];
            }
            if(count($aptcOverride) > 0){
                $data['estimateSub'] = $aptcOverride['aptc_override'];
                $estimateObj = new StdClass();
                $estimateObj->aptc = $aptcOverride['aptc_override'];
                $data['estimate'] = [$estimateObj];
            } else {
                $data['estimateSub'] = $estimateSub;
                $data['estimate'] = $estimates;
            }
            $data['hasMec'] = $hasMec;
            return response()->json([
                'status' => 'success',
                'data' => $data,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'It was not possible to retrieve plan data ' . $e->getMessage()
            ], 500);
        }
    }
    /**
     * @throws \Exception
     */
    public function searchPlans(int $application_id, int $page, FilterPlansRequest $request): JsonResponse
    {

        $application = Application::find($application_id);
        $application->load(['householdMembers']);
        $memberCount = $application->householdMembers()->count();
        $placeData = InsurancePlansActions::buildPlaceData($application);
        $medicaidData = InsurancePlansActions::buildMedicaidData($placeData);
        $hasMec = $request->input('has_mec') ?? [];
        $estimateData = InsurancePlansActions::buildHouseEstimatesData($application, $placeData, $medicaidData, $hasMec);
        $estimates = InsurancePlansActions::getMembersEstimates($estimateData);
        $csrOverride = InsurancePlansActions::getEstimateCsrOverride($estimates);
        $aptcOverride = InsurancePlansActions::calculateApcOverride($application,$medicaidData,$placeData);

        //        dd($application);
        //Gera o filtro se baseando no request
        $arFilter = InsurancePlansActions::buildFilter($request);
        $searchPlansData = InsurancePlansActions::buildSearchPlansData($application, $hasMec, $page, $arFilter, 'premium',10,$csrOverride,$aptcOverride);
        try {
            $plans = InsurancePlansActions::searchPlans($searchPlansData);
            if (isset($plans['plans'])) {
                InsurancePlansActions::createMedicalDeductionAndMoopsAttributes($plans['plans'],$memberCount);
            }
            return response()->json([
                'status' => 'success',
                'data' => $plans,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'It was not possible to retrieve plans data ' . $e->getMessage()
            ], 500);
        }
    }


    /**
     * @throws \Exception
     */
    public function searchPlansDetails(int $application_id, string $hios_plan_id, Request $request): JsonResponse
    {
        $hasMec = $request->query('has_mac') ?? [];
        $application = Application::find($application_id);
        $application->load(['householdMembers']);
        $placeData = InsurancePlansActions::buildPlaceData($application);
        $medicaidData = InsurancePlansActions::buildMedicaidData($placeData);
        $hasMec = $request->input('has_mec') ?? [];
        $estimateData = InsurancePlansActions::buildHouseEstimatesData($application, $placeData, $medicaidData, $hasMec);
        $estimates = InsurancePlansActions::getMembersEstimates($estimateData);
        $csrOverride = InsurancePlansActions::getEstimateCsrOverride($estimates);
        $aptcOverride = InsurancePlansActions::calculateApcOverride($application,$medicaidData,$placeData);
      
        //        dd($application);
//        $searchPlansData = InsurancePlansActions::buildSearchPlansData($application, $hasMec, 1, [], 'premium',10,$csrOverride,$aptcOverride);
        $plans_ids = [$hios_plan_id];
        $memberCount = $application->override_household_number??$application->householdMembers()->count();
        $searchPlansByIdsData = InsurancePlansActions::buildSearchPlansByIdsData($application, $plans_ids, $csrOverride, $aptcOverride);

        

        try {
//            $plan = InsurancePlansActions::searchPlansDetails($searchPlansData, $hios_plan_id);
            $plansComplete = InsurancePlansActions::searchPlansByIds($searchPlansByIdsData);
            InsurancePlansActions::createMedicalDeductionAndMoopsAttributes($plansComplete,$memberCount);
            $plan = $plansComplete[0];
            return response()->json([
                'status' => 'success',
                'data' => $plan,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'It was not possible to retrieve plan detailed data ' . $e->getMessage()
            ], 500);
        }
    }

    public function searchMostAccessiblePlanFiltered(int $application_id): JsonResponse
    {
        $application = Application::find($application_id);

        if (!$application) {
            return response()->json([
                'status' => 'error',
                'message' => 'Application not found'
            ], 404);
        }

        $application->load(['householdMembers']);
        $placeData = InsurancePlansActions::buildPlaceData($application);
        $medicaidData = InsurancePlansActions::buildMedicaidData($placeData);
        $hasMec = [];
        $hasMecAffordability = [];
        $estimateData = InsurancePlansActions::buildHouseEstimatesData($application, $placeData, $medicaidData, $hasMec);
        $estimates = InsurancePlansActions::getMembersEstimates($estimateData);
        $estimateSub = isset($estimates[0]->aptc) ? $estimates[0]->aptc : 0;

        // Chips logic
        $chips = [];
        foreach ($estimates as $value) {
            $chips[] = $value->is_medicaid_chip ? 1 : 0;
        }

        $estimate2Data = InsurancePlansActions::buildHouseEstimates2Data($application, $placeData, $chips, $hasMec, $hasMecAffordability, $medicaidData);
        if (count($estimate2Data) > 0) {
            $estimate2 = InsurancePlansActions::getMembersEstimates($estimate2Data);
            $estimates = count($estimate2) > 0 ? $estimate2 : $estimates;
            $estimateSub = isset($estimates[0]->aptc) ? $estimates[0]->aptc : $estimateSub;
        } else {
            InsurancePlansActions::organizeMecArrays($application, $hasMec, $hasMecAffordability, $medicaidData, $estimateSub);
        }

        // 1. Filtrar e pegar o primeiro plano com o tipo 'HMO' ordenado por 'premium'
        $filterHMO = [
            'type' => 'HMO'
        ];
        $searchPlansDataHMO = InsurancePlansActions::buildSearchPlansData($application, $hasMec, 1, $filterHMO, 'premium');
        $plansHMO = InsurancePlansActions::searchPlans($searchPlansDataHMO);
        $hmoPlan = isset($plansHMO['plans']) ? $plansHMO['plans'][0] : null;

        // 2. Filtrar e pegar o plano com o menor 'OOPC'
        $filterOopc = [];
        $searchPlansDataOopc = InsurancePlansActions::buildSearchPlansData($application, $hasMec, 1, $filterOopc, 'oopc');
        $plansOopc = InsurancePlansActions::searchPlans($searchPlansDataOopc);
        $oopcPlan = isset($plansOopc['plans']) ? $plansOopc['plans'][0] : null;

        // 3. Filtrar e pegar o primeiro plano com o tipo 'EPO' e issuer 'Oscar Insurance Company of Florida'
        $filterEPO = [
            'type' => 'EPO',
            'issuer' => 'Oscar Insurance Company of Florida'
        ];
        $searchPlansDataEPO = InsurancePlansActions::buildSearchPlansData($application, $hasMec, 1, $filterEPO, 'premium');
        $plansEPO = InsurancePlansActions::searchPlans($searchPlansDataEPO);
        $epoPlan = isset($plansEPO['plans']) ? $plansEPO['plans'][0] : null;

        // Fallback se nenhum plano for encontrado com o issuer 'Oscar'
        if (!$epoPlan) {
            $filterEPOFallback = ['type' => 'EPO'];
            $searchPlansDataEPOFallback = InsurancePlansActions::buildSearchPlansData($application, $hasMec, 1, $filterEPOFallback, 'premium');
            $plansEPOFallback = InsurancePlansActions::searchPlans($searchPlansDataEPOFallback);
            $epoPlan = isset($plansEPOFallback['plans']) ? $plansEPOFallback['plans'][0] : null;
        }

        // Retornar os três planos
        return response()->json([
            'status' => 'success',
            'data' => [
                'hmo_plan' => $hmoPlan,
                'oopc_plan' => $oopcPlan,
                'epo_plan' => $epoPlan
            ]
        ]);
    }

}
