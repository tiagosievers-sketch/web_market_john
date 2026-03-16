<?php

namespace App\Actions;

use App\Models\Domain;
use App\Models\DomainValue;
use Carbon\Carbon;
use App\Models\Address;
use App\Models\Contact;
use App\Models\Application;
use App\Models\Relationship;
use App\Models\HouseholdMember;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\FilterPlansRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FullApplicationActions
{
    const SEGURADORAS_POR_ESTADO = [
        "FL" => ["Aetna", "Ambetter", "Cigna", "Florida Blue", "Oscar", "Molina", "United Health Care"],
        "TX" => ["Aetna", "Ambetter", "Cigna", "BlueCross Blue Shield Of Texas", "Oscar", "Molina", "United Health Care"],
//        "GA" => ["Aetna", "Ambetter", "Anthem", "Cigna", "BlueCross Blue Shield", "Oscar", "United Health Care"],
        "NC" => ["Aetna", "Ambetter", "Cigna", "Oscar", "United Health Care"],
        "SC" => ["Ambetter", "Cigna", "United Health Care"],
        "OH" => ["Ambetter", "Cigna", "Molina"],
        "CA" => ["Aetna", "Anthem", "Blue Cross Blue Shield", "Molina", "Oscar"],
        "NJ" => ["Aetna", "Ambetter", "Blue Cross Blue Shield (Horizon)", "Oscar"],
        "PA" => ["Ambetter", "Oscar"],
        "CO" => ["Anthem", "Cigna", "BlueCross BlueShield", "United Health Care"],
        "VA" => ["Aetna", "Anthem", "Blue Cross Blue Shield", "Cigna", "Oscar", "United Health Care"],
    ];

    CONST DEDUCTIBLE_INC = 500;

    // Mapeamento de aliases para IDs
    private static function mapAliasToId(string $alias, string $type): ?int
    {
        switch ($type) {
            case 'sex':
                $domain = Domain::select('id')->where('alias', '=', 'sex')->first();
                $domainValue = match (mb_strtolower($alias)) {
                    'male' =>   DomainValue::select('id')->where('alias', '=', 'masculino')
                        ->where('domain_id', '=', $domain->id)->first(),
                    'female' => DomainValue::select('id')->where('alias', '=', 'feminino')
                        ->where('domain_id', '=', $domain->id)->first()
                };
                return $domainValue->id;
            case 'language':
                $domain = Domain::select('id')->where('alias', '=', 'language')->first();
                $domainValue = match (mb_strtolower($alias)) {
                    'english' =>   DomainValue::select('id')->where('alias', '=', 'english')
                        ->where('domain_id', '=', $domain->id)->first(),
                    'spanish' => DomainValue::select('id')->where('alias', '=', 'spanish')
                        ->where('domain_id', '=', $domain->id)->first(),
                    'portuguese' => DomainValue::select('id')->where('alias', '=', 'portuguese')
                        ->where('domain_id', '=', $domain->id)->first()
                };
                return $domainValue->id;
            case 'relationship':
                $domain = Domain::select('id')->where('alias', '=', 'relationship')->first();
                $domainValue = match (mb_strtolower($alias)) {
                    'spouse' =>   DomainValue::select('id')->where('alias', '=', 'relacaoEsposa')
                        ->where('domain_id', '=', $domain->id)->first(),
                    'child' => DomainValue::select('id')->where('alias', '=', 'relacaoCrianca')
                        ->where('domain_id', '=', $domain->id)->first(),
                    'stepchild' => DomainValue::select('id')->where('alias', '=', 'relacaoEnteado')
                        ->where('domain_id', '=', $domain->id)->first()
                };
                return $domainValue->id;
            default:
                $map = [
                    'sex' => [
                        'Male' => 8,
                        'Female' => 9
                    ],
                    'language' => [
                        'English' => 33,
                        'Spanish' => 34,
                        'Portuguese' => 32
                    ],
                    'relationship' => [
                        'Spouse' => 1,
                        'Child' => 11,
                        'Stepchild' => 3
                    ]
                ];
                return $map[$type][$alias] ?? null;
        }
    }

    // Função para criar Application
    public static function createApplication(array $data): Application
    {
        $userId = Auth::id();

        // Mapeamento de aliases para os IDs corretos
        $data['sex'] = is_string($data['sex']) ? self::mapAliasToId($data['sex'], 'sex') : $data['sex'];
        $data['written_lang'] = is_string($data['written_lang']) ? self::mapAliasToId($data['written_lang'], 'language') : $data['written_lang'];
        $data['spoken_lang'] = is_string($data['spoken_lang']) ? self::mapAliasToId($data['spoken_lang'], 'language') : $data['spoken_lang'];

        // Criar a aplicação
        $application = Application::create([
            'notices_mail_or_email' => $data['notices_mail_or_email'],
            'send_email' => $data['send_email'] ?? false,
            'send_text' => $data['send_text'] ?? false,
            'created_by' => $userId,
            'external_id' => $data['external_id'] ?? null,
            'additional_external_id' => $data['additional_external_id'] ?? null,
            'external_agent' => $data['external_agent'] ?? null,
            'webhook' => $data['webhook'] ?? null,
            'agent_id' => $userId,
            'year' => $data['year'],
        ]);

        // Criar o membro principal
        $birthdate = Carbon::createFromFormat('m/d/Y', $data['birthdate'])->format('Y-m-d');
        HouseholdMember::create([
            'application_id' => $application->id,
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'birthdate' => $birthdate,
            'sex' => $data['sex'],
            'has_ssn' => $data['has_ssn'],
            'ssn' => $data['ssn'] ?? null,
            'use_tobacco' => $data['use_tobacco'] ?? false,
            'field_type' => 0, // applicant
            'created_by' => $userId,
            'eligible_cost_saving' => 1,
            'married' => $data["married"],
            'applying_coverage' => 1,
            
            
        ]);

        // Criar o endereço do Applicant
        Address::create([
            'household_member_id' => $application->householdMembers()->first()->id,
            'street_address' => $data['street_address']??null,
            'city' => $data['city']??null,
            'state' => $data['state']??null,
            'zipcode' => $data['zipcode'],
            'county' => $data['county'],
            'mailing' => false,
            'created_by' => $userId,
        ]);

        // Criar o contato
        Contact::create([
            'application_id' => $application->id,
            'email' => $data['email'] ?? null,
            'phone' => $data['phone'],
            'written_lang' => $data['written_lang'],
            'spoken_lang' => $data['spoken_lang'],
            'type' => $data['type'],
            'created_by' => $userId
        ]);

        return $application;
    }

    // Função para criar Household
    public static function createHousehold(array $data, int $applicationId): array
    {
        $userId = Auth::id();
        $householdMembers = [];

        // Definir os membros padrão que não devem ser criados com base nos nomes
        $excludedNames = [
            ['firstname' => 'Test', 'lastname' => 'Doe'],
            ['firstname' => 'John', 'lastname' => 'Doe'],
            ['firstname' => 'Jhon', 'lastname' => 'Doe']
        ];

        foreach ($data['household_members'] as $member) {
            // Verificar se o membro está na lista de exclusão comparando apenas firstname e lastname
            $isExcluded = false;
            foreach ($excludedNames as $excludedMember) {
                if (
                    str_contains($member['firstname'], $excludedMember['firstname']) &&
                    str_contains($member['lastname'], $excludedMember['lastname'])
                ) {
                    $isExcluded = true;
                    break;
                }
            }

            // Se o nome não está na lista de exclusão, criar o membro
            if (!$isExcluded) {
                $member['sex'] = is_string($member['sex']) ? self::mapAliasToId($member['sex'], 'sex') : $member['sex'];
                $member['relationship'] = is_string($member['relationship']) ? self::mapAliasToId($member['relationship'], 'relationship') : $member['relationship'];

                $birthdate = Carbon::createFromFormat('m/d/Y', $member['birthdate'])->format('Y-m-d');

                $householdMember = HouseholdMember::create([
                    'application_id' => $applicationId,
                    'firstname' => $member['firstname'],
                    'lastname' => $member['lastname'],
                    'birthdate' => $birthdate,
                    'sex' => $member['sex'],
                    'relationship' => $member['relationship'],
                    'field_type' => $member['field_type'],
                    'use_tobacco' => $member['use_tobacco'],
                    'eligible_cost_saving' => 1,
                    'is_dependent' => ($member["field_type"] > 0 ? 1 : 0),
                    'created_by' => $userId,
                    'married' => $member["married"],
                    'applying_coverage' => 1
                ]);

                $householdMembers[] = $householdMember;
            }
        }

        return $householdMembers;
    }



    // Função para criar Quotation
    public static function createQuotation(array $data, int $applicationId): array
    {
        $userId = Auth::id();

        // Atualizar o applicant com o income_predicted_amount
        $applicant = HouseholdMember::where('application_id', $applicationId)->where('field_type', 0)->first();
        $applicant->update([
            'income_predicted_amount' => $data['income_predicted_amount']
        ]);

        return [$applicant];  // Retorna o applicant atualizado
    }


    /**
     * @throws \Exception
     */
    static public function getPlanDetail(Application $application, $quotations): array
    {
        $quotationDetail = [];
        $hasMec = [];

        $searchPlansData = InsurancePlansActions::buildSearchPlansData($application, $hasMec);

        foreach ($quotations as $key => $quotation) {
            if (isset($quotation['id'])) {
                $planDetails = InsurancePlansActions::SearchPlansDetails($searchPlansData, $quotation['id']);
                $quotationDetail[$key] = $planDetails;
            } else {
                Log::warning("Plan ID not found for key: $key");
            }
        }

        return $quotationDetail;
    }

    /**
     * @throws \Exception
     */
    static public function getPlanDetailByPlanId($plan_id, int $memberCount, Application $application, $csrOverride, $aptcOverride){
        $plans_ids = [$plan_id];
        $searchPlansByIdsData = InsurancePlansActions::buildSearchPlansByIdsData($application, $plans_ids, $csrOverride, $aptcOverride);
        $plansComplete = InsurancePlansActions::searchPlansByIds($searchPlansByIdsData);
        InsurancePlansActions::createMedicalDeductionAndMoopsAttributes($plansComplete,$memberCount);
        return $plansComplete[0];
    }


    /**
     * @throws \Exception
     */
    public static function getAllAccessiblePlans(int $application_id, FilterPlansRequest $request = null): array
    {
        $application = Application::find($application_id);
        $application->load(['householdMembers']);

        // Similar à função searchMostAccessiblePlan
        $placeData = InsurancePlansActions::buildPlaceData($application);
        $medicaidData = InsurancePlansActions::buildMedicaidData($placeData);
        $hasMec = [];
        $hasMecAffordability = [];
        $estimateData = InsurancePlansActions::buildHouseEstimatesData($application, $placeData, $medicaidData, $hasMec);
        $estimates = InsurancePlansActions::getMembersEstimates($estimateData);
        $estimateSub = isset($estimates[0]->aptc) ? $estimates[0]->aptc : 0;

        $chips = [];
        foreach ($estimates as $value) {
            $chips[] = $value->is_medicaid_chip ? 1 : 0;
        }

        $estimate2Data = InsurancePlansActions::buildHouseEstimates2Data($application, $placeData, $chips, $hasMec, $hasMecAffordability, $medicaidData);

        if (count($estimate2Data) > 0) {
            $estimate2 = InsurancePlansActions::getMembersEstimates($estimate2Data);
            $estimates = count($estimate2) > 0 ? $estimate2 : $estimates;
            $estimateSub = $estimates[0]->aptc ?? $estimateSub;
        } else {
            InsurancePlansActions::organizeMecArrays($application, $hasMec, $hasMecAffordability, $medicaidData, $estimateSub);
        }

        $csrOverride = InsurancePlansActions::getEstimateCsrOverride($estimates);

        // Filtro de planos (com fallback para filtros vazios)
        $arFilter = self::buildFilter();  // Filtros sempre vazios, chamada correta dentro da classe


        $allPlans = [];
        $page = 1;

        // Laço para buscar todas as páginas de planos e despaginar
        $searchPlansData = InsurancePlansActions::buildSearchPlansData($application, $hasMec, $page, $arFilter, 'premium', 10, $csrOverride);
        $allPlans = array_merge(['searchData' => $searchPlansData], $allPlans);
        do {
            $searchPlansData = InsurancePlansActions::buildSearchPlansData($application, $hasMec, $page, $arFilter, 'premium', 10, $csrOverride);
            $plans = InsurancePlansActions::searchPlans($searchPlansData);

            if (isset($plans['plans'])) {
                $allPlans = array_merge($allPlans, $plans['plans']);
            }

            $page++;
        } while (count($plans['plans'] ?? []) > 0);

        return $allPlans;
    }

    private static function isPlanLowestDeductible($plan, $lowestBefore)
    {
        if (!$lowestBefore) {
            return $plan;
        }
        foreach ($plan->deductibles as $deductiblePlan) {
            if (str_contains($deductiblePlan->type, 'Medical')) {
                foreach ($lowestBefore->deductibles as $deductibleLower) {
                    if (str_contains($deductibleLower->type, 'Medical') && $deductiblePlan->amount < $deductibleLower->amount) {
                        return true;
                    }
                }
            }
        }
        return false;
    }

    /**
     * @throws \Exception
     */
    public static function getPlansInColumns(int $application_id, $deductibleZero = true): array
    {
        $application = Application::find($application_id);
        $application->load(['householdMembers', 'mainMember']);
        $memberCount = $application->householdMembers()->count();

        // Similar à função searchMostAccessiblePlan
        $placeData = InsurancePlansActions::buildPlaceData($application);
        Log::info('Chosen place data:',$placeData);
        $medicaidData = InsurancePlansActions::buildMedicaidData($placeData);
        $hasMec = [];
        $hasMecAffordability = [];
        $estimateData = InsurancePlansActions::buildHouseEstimatesData($application, $placeData, $medicaidData, $hasMec);

        Log::info("Filtro hasMec & Estimates 1");
        Log::info(print_r($hasMec, true));
        Log::info(print_r($estimateData, true));

        $estimates = InsurancePlansActions::getMembersEstimates($estimateData);

        Log::info("Estimates 1");
        Log::info(print_r($estimates, true));

        $estimateSub = isset($estimates[0]->aptc) ? $estimates[0]->aptc : 0;

        $chips = [];
        foreach ($estimates as $value) {
            $chips[] = $value->is_medicaid_chip ? 1 : 0;
        }

        $estimate2Data = InsurancePlansActions::buildHouseEstimates2Data($application, $placeData, $chips, $hasMec, $hasMecAffordability, $medicaidData);

        Log::info("Filtro hasMec & Estimates 2");
        Log::info(print_r($hasMec, true));
        Log::info(print_r($estimate2Data, true));

        if (count($estimate2Data) > 0) {
            $estimate2 = InsurancePlansActions::getMembersEstimates($estimate2Data);

            Log::info("Estimates 2");
            Log::info(print_r($estimate2, true));

            $estimates = count($estimate2) > 0 ? $estimate2 : $estimates;
            $estimateSub = $estimates[0]->aptc ?? $estimateSub;
        } else {
            InsurancePlansActions::organizeMecArrays($application, $hasMec, $hasMecAffordability, $medicaidData, $estimateSub);
            Log::info("resultado hasMec & hasMecAffordability");
            Log::info(print_r($hasMec, true));
            Log::info(print_r($hasMecAffordability, true));
        }

        $csrOverride = InsurancePlansActions::getEstimateCsrOverride($estimates);
        $aptcOverride = InsurancePlansActions::calculateApcOverride($application, $medicaidData, $placeData);


        // Filtro de planos (com fallback para filtros vazios)
        $arFilter = self::buildFilter();  // Filtros sempre vazios, chamada correta dentro da classe
        //Caso seja verdadeira, coloca o deductible como zero, se não é enviado null.
        //$arFilter = array_merge($arFilter, ['deductible' => ($deductibleZero ? 0 : null)]);

        $stateLetter = $placeData["state"]??$application->mainMember->address->state;
        $allPlans = [];
        $page = 1;

        // Laço para buscar todas as páginas de planos e despaginar
        $searchPlansData = InsurancePlansActions::buildSearchPlansData($application, $hasMec, $page, $arFilter, 'premium', 10, $csrOverride, $aptcOverride);

        Log::info("Search plans data:");
        Log::info(print_r($searchPlansData, true));
        Log::info(json_encode($searchPlansData));
        $maxDeductible = null;
        do {
            $searchPlansData = InsurancePlansActions::buildSearchPlansData($application, $hasMec, $page, $arFilter, 'premium', 10, $csrOverride, $aptcOverride);
            $plans = InsurancePlansActions::searchPlans($searchPlansData);

            if (isset($plans['plans'])) {
                $allPlans = array_merge($allPlans, $plans['plans']);
            }

            if($maxDeductible === null) {
                $ranges = $plans['ranges'];
                $maxDeductible = $ranges->deductibles->max;
            }

            $page++;
        } while (count($plans['plans'] ?? []) > 0);
        $hmoPlan = null;
        $oopcPlan = null;
        $epoPlan = null;
        Log::info("MAX DEDUCTIBLE: ".$maxDeductible.".");
        InsurancePlansActions::createMedicalDeductionAndMoopsAttributes($allPlans, $memberCount);

        Log::info("Plans found");
        Storage::disk('public')->put("application_json_$application_id.json", json_encode($allPlans));

        foreach ($allPlans as $plan) {
            if (isset($plan->type) && $plan->type === 'HMO') {
                if (isset($plan->issuer) && isset($plan->issuer->name) && isset($stateLetter)) {
                    if (self::coveredInsuranceByState($plan->issuer->name, $stateLetter)) {
                        if ($stateLetter != 'FL') {
                            if ($hmoPlan === null) {
                                $hmoPlan = $plan;
                            } else if ($plan->premium_w_credit < $hmoPlan->premium_w_credit && self::isPlanLowestDeductible($plan, $hmoPlan)) {
                                $hmoPlan = $plan;
                            }
                        } else if ($plan->issuer->name != 'Ambetter Health') {
                            if ($hmoPlan === null) {
                                $hmoPlan = $plan;
                            } else if ($plan->premium_w_credit < $hmoPlan->premium_w_credit && self::isPlanLowestDeductible($plan, $hmoPlan)) {
                                $hmoPlan = $plan;
                            }
                        }
                    }
                }
            }
        }

        // Verificar se o plano está na Florida e aplicar a regra específica para Ambetter
        // Se for Ambetter e do tipo HMO, ignorar este plano
        // Verificar se este plano tem o menor OOPC até agora
        foreach ($allPlans as $plan) {
            if (isset($plan->issuer) && isset($plan->issuer->name) && isset($stateLetter)) {
                if (self::coveredInsuranceByState($plan->issuer->name, $stateLetter)) {
                    if ($stateLetter != 'FL') {
                        if (isset($plan->moops) && isset($plan->moops[0])) {
                            if ($oopcPlan === null) {
                                $oopcPlan = $plan;
                            } else if ($plan->moops[0]->amount < $oopcPlan->moops[0]->amount && self::isPlanLowestDeductible($plan, $oopcPlan)) {
                                $oopcPlan = $plan;
                            }
                        } else {
                            if ($oopcPlan === null) {
                                $oopcPlan = $plan;
                            } else if ($plan->oopc < $oopcPlan->oopc && self::isPlanLowestDeductible($plan, $oopcPlan)) {
                                $oopcPlan = $plan;
                            }
                        }
                    } else {
                        if ($plan->issuer->name == 'Ambetter Health' && $plan->type == 'HMO') {
                            continue;
                        }
                        if (isset($plan->moops) && isset($plan->moops[0])) {
                            if ($oopcPlan === null) {
                                $oopcPlan = $plan;
                            } else if ($plan->moops[0]->amount < $oopcPlan->moops[0]->amount && self::isPlanLowestDeductible($plan, $oopcPlan)) {
                                $oopcPlan = $plan;
                            }
                        } else {
                            if ($oopcPlan === null) {
                                $oopcPlan = $plan;
                            } else if ($plan->oopc < $oopcPlan->oopc && self::isPlanLowestDeductible($plan, $oopcPlan)) {
                                $oopcPlan = $plan;
                            }
                        }
                    }
                }
            }
        }

        // Verificar se é um array e o tipo é "EPO"
        // Verificar se é um plano da Oscar Insurance Company of Florida
        // Se for o primeiro plano Oscar ou tiver uma mensalidade menor, atualize o plano preferencial
        // Atualizar o plano com menor mensalidade geral, caso o plano tenha uma mensalidade menor
        foreach ($allPlans as $plan) {
            if (isset($plan->issuer)) {
                if (isset($plan->issuer->name) && isset($stateLetter)) {
                    if (self::coveredInsuranceByState($plan->issuer->name, $stateLetter)) {
                        if (isset($plan->type) && $plan->type === 'EPO') {
                            if ($plan->issuer->name == 'Oscar Insurance Company of Florida') {
                                if ($epoPlan === null) {
                                    $epoPlan = $plan;
                                } else if ($plan->premium_w_credit < $epoPlan->premium_w_credit && self::isPlanLowestDeductible($plan, $epoPlan)) {
                                    $epoPlan = $plan;
                                }
                            }
                        }
                    }
                }
            }
        }
        if ($epoPlan == null) {
            foreach ($allPlans as $plan) {
                if (isset($plan->issuer)) {
                    if (isset($plan->issuer->name) && isset($stateLetter)) {
                        if (self::coveredInsuranceByState($plan->issuer->name, $stateLetter)) {
                            if (isset($plan->type) && $plan->type === 'EPO') {
                                if ($epoPlan === null) {
                                    $epoPlan = $plan;
                                } else if ($plan->premium_w_credit < $epoPlan->premium_w_credit && self::isPlanLowestDeductible($plan, $epoPlan)) {
                                    $epoPlan = $plan;
                                }
                            }
                        }
                    }
                }
            }
        }
        if ($hmoPlan === null) {
            $hmoPlan = [];
        } else{
            $hmoPlan = self::getPlanDetailByPlanId($hmoPlan->id,$memberCount,$application,$csrOverride,$aptcOverride);
        }
        if ($oopcPlan === null) {
            $oopcPlan = [];
        } else{
            $oopcPlan = self::getPlanDetailByPlanId($oopcPlan->id,$memberCount,$application,$csrOverride,$aptcOverride);
        }
        if ($epoPlan === null) {
            $epoPlan = [];
        } else{
            $epoPlan = self::getPlanDetailByPlanId($epoPlan->id,$memberCount,$application,$csrOverride,$aptcOverride);
        }

        return  [
            'hmo_plan' => collect($hmoPlan)->toArray(),
            'oopc_plan' => collect($oopcPlan)->toArray(),
            'epo_plan' => collect($epoPlan)->toArray()
        ];
    }

    public static function buildFilter(): array
    {
        // Retorna filtros vazios
        return [
            "issuers" => [],
            "metal_levels" => [],
            "premium" => null,
            "hsa" => false,
        ];
    }

    public static function coveredInsuranceByState(string $name, $stateLetter): bool
    {
        if (isset(self::SEGURADORAS_POR_ESTADO[$stateLetter])) {
            $insurances = self::SEGURADORAS_POR_ESTADO[$stateLetter];
            return count(array_filter($insurances, fn($insurance)  => str_contains($name, $insurance))) > 0;
        }
        return false;
    }

    /**
     * @throws \Exception
     */
    public static function getPlansInColumnsScreenQuotation(int $application_id, array $planIds): array
    {
        $application = Application::find($application_id);
        $application->load(['householdMembers', 'mainMember']);

        $placeData = InsurancePlansActions::buildPlaceData($application);
        $medicaidData = InsurancePlansActions::buildMedicaidData($placeData);
        $hasMec = [];
        $estimateData = InsurancePlansActions::buildHouseEstimatesData($application, $placeData, $medicaidData, $hasMec);

        $estimates = InsurancePlansActions::getMembersEstimates($estimateData);

        $csrOverride = InsurancePlansActions::getEstimateCsrOverride($estimates);
        $aptcOverride = InsurancePlansActions::calculateApcOverride($application, $medicaidData, $placeData);

        $allPlans = [];
        //Recupera os planos escolhidos pelos ids
        $arPlansIds = $planIds;
        $searchPlansByIdsData = InsurancePlansActions::buildSearchPlansByIdsData($application, $arPlansIds, $csrOverride, $aptcOverride);
        $plans = InsurancePlansActions::searchPlansByIds($searchPlansByIdsData);
        $memberCount = $application->override_household_number??$application->householdMembers()->count();
        if (count($plans) > 0) {
            InsurancePlansActions::createMedicalDeductionAndMoopsAttributes($plans,$memberCount);
            $allPlans = array_merge($allPlans, $plans);
        }
        $allPlans = collect($allPlans)->map(fn($plan) => (array) $plan)->toArray();

        $plans = collect($allPlans);

        // Filtrar os planos por ID conforme o array `$planIds`
        $hmoPlan = $plans->firstWhere('id', $planIds[0] ?? []);
        $oopcPlan = $plans->firstWhere('id', $planIds[1] ?? []);
        $epoPlan = $plans->firstWhere('id', $planIds[2] ?? []);

        return [
            'hmo_plan' => collect($hmoPlan)->toArray(),
            'oopc_plan' => collect($oopcPlan)->toArray(),
            'epo_plan' => collect($epoPlan)->toArray()
        ];
    }


}
