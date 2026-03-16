<?php

namespace App\Actions;

use App\Libraries\Crm2easyApiLibrary;
use App\Libraries\GatewayHttpLibrary;
use App\Libraries\Railway2easyApiLibrary;
use App\Models\Application;
use App\Models\DomainValue;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\InsurancePlansController;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PdfActions
{
    public static function selectLanguage(int $application_id)
    {
        // Primeiro, verifica se há um idioma solicitado na sessão
        if (session()->has('pdf_language')) {
            $requestedLanguage = session('pdf_language');
            // Remove da sessão após usar
            session()->forget('pdf_language');

            // Converte o código do idioma para o formato esperado
            return match ($requestedLanguage) {
                'pt' => 'portuguese',
                'es' => 'spanish',
                'en' => 'english',
                default => 'english'
            };
        }


        /** @var Application $application */
        $application = Application::find($application_id);

        if ($application) {
            $application->load(['contact']);

            if ($application->contact) {
                $languageId = $application->contact['written_lang'];

                if (is_int($languageId)) {
                    $language = DomainValue::find($languageId);
                    if ($language && isset($language->alias)) {
                        // Retorna diretamente o alias, que já deve estar no formato correto
                        return strtolower($language->alias);
                    }
                }
            }
        }

        return 'english';
    }

    public static function generateDateByLanguage(string $language, $timestamp): string
    {
        $date = Carbon::parse($timestamp);
        switch ($language) {
            case 'portuguese':
                $date->locale('pt_BR');
                return $date->isoFormat('D [de] MMMM [de] YYYY');
            case 'spanish':
                $date->locale('es');
                return $date->isoFormat('D [de] MMMM [de] YYYY');
            default:
                $date->locale('en_US');
                return $date->isoFormat('MMMM D, YYYY');
        }
    }

    /**
     * @throws \Exception
     */
    public static function generatePdf($application_id, array $plans, array $planDetails = [])
    {
        $language = self::selectLanguage($application_id);
        $application = Application::find($application_id);
        if ($application) {
            $application->load(['mainMember', 'householdApplicants']);

            $excludedNames = [
                ['firstname' => 'Test1', 'lastname' => 'Doe'],
                ['firstname' => 'Test2', 'lastname' => 'Doe'],
                ['firstname' => 'Test3', 'lastname' => 'Doe'],
                ['firstname' => 'Test4', 'lastname' => 'Doe']
            ];

            // Contar os membros filtrados e adicionar o mainMember
            $membersNumber = $application->householdApplicants()->count(); // Sempre conta o mainMember
            $user = User::find($application->created_by);
            Log::info('User for Image:', [$user]);
            $profileImagePath = public_path('img/Cotacao.png');
            Log::info('Caminho padrão da imagem:' . $profileImagePath);

            if (isset($user->profile_image_pdf)) {
                $profileImagePath = public_path('storage/' . $user->profile_image_pdf);
                Log::info('Caminho da imagem do user:' . $profileImagePath);
            }

            $viewData = [
                'nomeCliente' => $application->mainMember->firstname . ' ' . $application->mainMember->lastname,
                'income' => self::formatCurrency($application->mainMember->income_predicted_amount) ?? 'N/A',
                'membersNumber' => $membersNumber,
                'agentName' => $application->external_agent ?? 'Atendimento',
                'agentPhone' => $user->phone ?? null,
                'zipcode' => $application->mainMember->address->zipcode ?? 'N/A',
                'county' => $application->mainMember->address->county ?? 'N/A',
                'dataCompletaLocalizada' => self::generateDateByLanguage($language, Carbon::now()),
                'profileImagePath' => $profileImagePath,
            ];

            $mensagem = 'Quotation PDF sent with success.';
            Log::info('HMO PLAN TEST: ', ['test' => empty($plans['hmo_plan'])]);
            if (!empty($plans['hmo_plan'])) {
                $viewData = array_merge($viewData, [
                    'issuerCompany1' => $plans['hmo_plan']['issuer']->name,
                    'typeOfInsurance1' => $plans['hmo_plan']['name'],
                    'monthlyPremium1' => self::month_value_final($plans['hmo_plan'], $application),
                    'deductible1' => self::calculateDeductible($plans['hmo_plan'], $membersNumber),
                    'outOfPocketMax1' => self::calculateMoop($plans['hmo_plan'], $membersNumber),
                    'network1' => $plans['hmo_plan']['type'],
                    'primaryCare1' => self::getDoctorCost($plans['hmo_plan']),
                    'specialist1' => self::getSpecialistCost($plans['hmo_plan']),
                    'genericDrugs1' => self::getDrugCost($plans['hmo_plan']),
                    'emergencyRoom1' => self::getEmergencyRoomCost($plans['hmo_plan']),
                    'emergencyRoomValue1' => self::getUrgentCareCost($plans['hmo_plan']),
                    'radiography1' => self::getRadiographyCost($plans['hmo_plan']),
                    'imagingExams1' => self::getImagingCost($plans['hmo_plan']),
                    'bloodtests1' => self::getBloodWorkCost($plans['hmo_plan']),
                    'benefitsLink1' => $plans['hmo_plan']['benefits_url'],
                    'informationLink1' => $plans['hmo_plan']['brochure_url'],
                    'formLink1' => $plans['hmo_plan']['formulary_url'],
                ]);
            } else {
                $mensagem .= ' No first column plan found.';
                $viewData = array_merge($viewData, [
                    'issuerCompany1' => '',
                    'typeOfInsurance1' => '',
                    'monthlyPremium1' => '',
                    'deductible1' => '',
                    'outOfPocketMax1' => '',
                    'network1' => '',
                    'primaryCare1' => '',
                    'specialist1' => '',
                    'genericDrugs1' => '',
                    'emergencyRoom1' => '',
                    'emergencyRoomValue1' => '',
                    'radiography1' => '',
                    'imagingExams1' => '',
                    'bloodtests1' => '',
                    'benefitsLink1' => '',
                    'informationLink1' => '',
                    'formLink1' => '',
                ]);
            }

            Log::info('OOPC PLAN TEST: ', ['test' => empty($plans['oopc_plan'])]);
            if (!empty($plans['oopc_plan'])) {
                $viewData = array_merge($viewData, [
                    'issuerCompany2' => $plans['oopc_plan']['issuer']->name,
                    'typeOfInsurance2' => $plans['oopc_plan']['name'],
                    'monthlyPremium2' => self::month_value_final($plans['oopc_plan'], $application),
                    'deductible2' => self::calculateDeductible($plans['oopc_plan'], $membersNumber),
                    'outOfPocketMax2' => self::calculateMoop($plans['oopc_plan'], $membersNumber),
                    'network2' => $plans['oopc_plan']['type'],
                    'primaryCare2' => self::getDoctorCost($plans['oopc_plan']),
                    'specialist2' => self::getSpecialistCost($plans['oopc_plan']),
                    'genericDrugs2' => self::getDrugCost($plans['oopc_plan']),
                    'emergencyRoom2' => self::getEmergencyRoomCost($plans['oopc_plan']),
                    'emergencyRoomValue2' => self::getUrgentCareCost($plans['oopc_plan']),
                    'radiography2' => self::getRadiographyCost($plans['oopc_plan']),
                    'imagingExams2' => self::getImagingCost($plans['oopc_plan']),
                    'bloodtests2' => self::getBloodWorkCost($plans['oopc_plan']),
                    'benefitsLink2' => $plans['oopc_plan']['benefits_url'],
                    'informationLink2' => $plans['oopc_plan']['brochure_url'],
                    'formLink2' => $plans['oopc_plan']['formulary_url'],
                ]);
            } else {
                $mensagem .= ' No second column plan found.';
                $viewData = array_merge($viewData, [
                    'issuerCompany2' => '',
                    'typeOfInsurance2' => '',
                    'monthlyPremium2' => '',
                    'deductible2' => '',
                    'outOfPocketMax2' => '',
                    'network2' => '',
                    'primaryCare2' => '',
                    'specialist2' => '',
                    'genericDrugs2' => '',
                    'emergencyRoom2' => '',
                    'emergencyRoomValue2' => '',
                    'radiography2' => '',
                    'imagingExams2' => '',
                    'bloodtests2' => '',
                    'benefitsLink2' => '',
                    'informationLink2' => '',
                    'formLink2' => '',
                ]);
            }

            Log::info('EPO PLAN TEST: ', ['test' => empty($plans['epo_plan'])]);
            if (!empty($plans['epo_plan'])) {
                $viewData = array_merge($viewData, [
                    'issuerCompany3' => $plans['epo_plan']['issuer']->name,
                    'typeOfInsurance3' => $plans['epo_plan']['name'],
                    'monthlyPremium3' => self::month_value_final($plans['epo_plan'], $application),
                    'deductible3' => self::calculateDeductible($plans['epo_plan'], $membersNumber),
                    'outOfPocketMax3' => self::calculateMoop($plans['epo_plan'], $membersNumber),
                    'network3' => $plans['epo_plan']['type'],
                    'primaryCare3' => self::getDoctorCost($plans['epo_plan']),
                    'specialist3' => self::getSpecialistCost($plans['epo_plan']),
                    'genericDrugs3' => self::getDrugCost($plans['epo_plan']),
                    'emergencyRoom3' => self::getEmergencyRoomCost($plans['epo_plan']),
                    'emergencyRoomValue3' => self::getUrgentCareCost($plans['epo_plan']),
                    'radiography3' => self::getRadiographyCost($plans['epo_plan']),
                    'imagingExams3' => self::getImagingCost($plans['epo_plan']),
                    'bloodtests3' => self::getBloodWorkCost($plans['epo_plan']),
                    'benefitsLink3' => $plans['epo_plan']['benefits_url'],
                    'informationLink3' => $plans['epo_plan']['brochure_url'],
                    'formLink3' => $plans['epo_plan']['formulary_url'],
                ]);
            } else {
                $mensagem .= ' No third column plan found.';
                $viewData = array_merge($viewData, [
                    'issuerCompany3' => '',
                    'typeOfInsurance3' => '',
                    'monthlyPremium3' => '',
                    'deductible3' => '',
                    'outOfPocketMax3' => '',
                    'network3' => '',
                    'primaryCare3' => '',
                    'specialist3' => '',
                    'genericDrugs3' => '',
                    'emergencyRoom3' => '',
                    'emergencyRoomValue3' => '',
                    'radiography3' => '',
                    'imagingExams3' => '',
                    'bloodtests3' => '',
                    'benefitsLink3' => '',
                    'informationLink3' => '',
                    'formLink3' => '',
                ]);
            }

            if (empty($plans['hmo_plan']) && empty($plans['oopc_plan']) && empty($plans['epo_plan'])) {
                throw new \Exception('It was not possible to find any insurance plan to this application data.');
            }
            // Seleciona a view correta com base no idioma
            $view = self::getPdfViewByLanguage($language);
            Log::info("View Data: ", $viewData);
            // Gerar o PDF usando a view correta e passando os dados
            $pdf = Pdf::loadView($view, $viewData);
            $fileName = 'application_plans_' . $application_id . '.pdf';
            $filePath = storage_path('app/public/' . $fileName);
            Log::info("Filepath $filePath");

            // Retorna o PDF gerado
            $pdf->save($filePath);
            $url = url('') . Storage::url($fileName);
            Log::info("URL $url");
            $externalId = (int) $application->external_id;
            Log::info("External ID $externalId");
            $clientId = (int) $application->additional_external_id;
            Log::info("Client ID: $clientId");
            $webhookOverwrite = $application->webhook ?? null;
            $response = Railway2easyApiLibrary::postDocument($fileName, $externalId, $clientId, $url, $mensagem, $webhookOverwrite);
            if ($response) {
                return true;
            }
        }
        return false;
    }

    private static function getPdfViewByLanguage($language): string
    {
        // Defina o locale com base no idioma
        switch ($language) {
            case 'portuguese':
                App::setLocale('pt'); // Define o locale para português
                break;
            case 'spanish':
                App::setLocale('es'); // Define o locale para espanhol
                break;
            default:
                App::setLocale('en'); // Define o locale para inglês como padrão
                break;
        }

        // Seleciona a view correta com base no idioma
        return match ($language) {
            'portuguese' => 'livewire.pdf.pdfPortugues',
            'spanish' => 'livewire.pdf.pdfEspanhol',
            default => 'livewire.pdf.pdfIngles',
        };
    }



    public static function formatCurrency($value)
    {
        if (is_numeric($value) && is_finite($value)) {
            return '$' . number_format($value, 2, '.', ',');
        } else {
            return '$0.00';
        }
    }


    /**
     * @throws \Exception
     */
    public static function month_value_final($plan, $application)
    {
        // Construir os dados de place, Medicaid, e estimativas
        $placeData = InsurancePlansActions::buildPlaceData($application);
        $medicaidData = InsurancePlansActions::buildMedicaidData($placeData);
        $hasMec = [];
        $hasMecAffordability = [];
        $estimateData = InsurancePlansActions::buildHouseEstimatesData($application, $placeData, $medicaidData, $hasMec);
        $estimates = InsurancePlansActions::getMembersEstimates($estimateData);

        // Definir o valor de estimateSub e estimates
        $estimateSub = 0;
        if (isset($estimates[0]->aptc)) {
            $estimateSub = $estimates[0]->aptc;
        }

        $chips = [];
        foreach ($estimates as $value) {
            $chips[] = $value->is_medicaid_chip ? 1 : 0;
        }

        $estimate2Data = InsurancePlansActions::buildHouseEstimates2Data($application, $placeData, $chips, $hasMec, $hasMecAffordability, $medicaidData);

        // Se existirem estimativas alternativas, substituir os valores
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

        // Calcular o estimateNew com base nos valores capturados
        $estimateNew = $estimateSub - ($estimates[0]->aptc ?? 0);
        Log::info('Valor de redução: ' . $estimateNew ?? 'NONE');
        // Calcular o valor mensal final
        $finalMonthlyValue = $plan['premium_w_credit'] - $estimateNew;

        // Retornar o valor final formatado como moeda
        return self::formatCurrency($finalMonthlyValue);
    }

    public static function calculateDeductible($plan, $householdSize)
    {
        if (isset($plan['medical_deductible'])) {
            return self::formatCurrency($plan['medical_deductible']);
        } else if (isset($plan->medical_deductible)) {
            return self::formatCurrency($plan->medical_deductible);
        }

        $minDeductibles = '-'; // Valor padrão inicial
        $varFamily = ''; // Para armazenar o prefixo 'Family' quando necessário

        if (isset($plan['deductibles']) && count($plan['deductibles']) > 0) {
            foreach ($plan['deductibles'] as $deductible) {
                // Verificação para uma única pessoa
                if ($householdSize === 1) {
                    if ($deductible->family_cost === 'Family Per Person' || $deductible->family_cost === 'Individual') {
                        $minDeductibles = $deductible->amount;
                        $varFamily = ''; // Não é necessário 'Family'
                        break;
                    }
                }
                // Verificação de dedutível para famílias
                else {
                    if ($deductible->family_cost === 'Family') {
                        $minDeductibles = $deductible->amount;
                        $varFamily = 'Family '; // Prefixo 'Family' é necessário
                        break;
                    }
                }
            }

            // Se nenhum dedutível atender ao critério, use o primeiro valor disponível
            if ($minDeductibles === '-') {
                $minDeductibles = isset($plan['deductibles'][0]->amount) ? $plan['deductibles'][0]->amount : '-';
            }
        }
        return self::formatCurrency($minDeductibles);
    }

    public static function calculateMoop($plan, $householdSize)
    {
        if (isset($plan['moops_amount'])) {
            return self::formatCurrency($plan['moops_amount']);
        } else if (isset($plan->moops_amount)) {
            return self::formatCurrency($plan->moops_amount);
        }

        $minMoops = '-'; // Valor padrão inicial

        if (isset($plan['moops']) && count($plan['moops']) > 0) {
            foreach ($plan['moops'] as $moop) {
                if ($householdSize === 1) {
                    if ($moop->family_cost === 'Family Per Person' || $moop->family_cost === 'Individual') {
                        $minMoops = $moop->amount;
                        break;
                    }
                } else {
                    if ($moop->family_cost === 'Family') {
                        $minMoops = $moop->amount;
                        break;
                    }
                }
            }

            // Se nenhum MOOP atender ao critério, usa o primeiro valor disponível
            if ($minMoops === '-') {
                $minMoops = $plan['moops'][0]->amount ?? '-';
            }
        }

        return self::formatCurrency($minMoops);
    }

    public static function getDoctorCost($plan)
    {
        // Verifica se o plano possui benefícios
        if (isset($plan['benefits']) && count($plan['benefits']) > 0) {
            foreach ($plan['benefits'] as $benefit) {
                // Verifica se o benefício é para atendimento de cuidados primários
                if ($benefit->name === 'Primary Care Visit to Treat an Injury or Illness') {
                    foreach ($benefit->cost_sharings as $cost_sharing) {
                        // Verifica se a rede é "In-Network"
                        if ($cost_sharing->network_tier === 'In-Network') {
                            // Verifica se o valor é 'No Charge', retornando 'Free' se for o caso
                            return $cost_sharing->display_string === 'No Charge' ? 'Free' : $cost_sharing->display_string;
                        }
                    }
                    break; // Para a execução caso o benefício seja encontrado
                }
            }
        }

        return '0'; // Retorna 0 se não encontrar o custo para o atendimento primário
    }

    public static function getSpecialistCost($plan)
    {
        // Verifica se o plano possui benefícios
        if (isset($plan['benefits']) && count($plan['benefits']) > 0) {
            foreach ($plan['benefits'] as $benefit) {
                // Verifica se o benefício é a consulta com especialista
                if ($benefit->name === 'Specialist Visit') {
                    foreach ($benefit->cost_sharings as $cost_sharing) {
                        // Verifica se a rede é "In-Network"
                        if ($cost_sharing->network_tier === 'In-Network') {
                            // Verifica se o valor é 'No Charge', retornando 'Free' se for o caso
                            return $cost_sharing->display_string === 'No Charge' ? 'Free' : $cost_sharing->display_string;
                        }
                    }
                    break; // Para a execução caso o benefício seja encontrado
                }
            }
        }

        return '0'; // Retorna 0 se não encontrar o custo da consulta com especialista
    }

    public static function getDrugCost($plan)
    {
        // Verifica se o plano possui benefícios
        if (isset($plan['benefits']) && count($plan['benefits']) > 0) {
            foreach ($plan['benefits'] as $benefit) {
                // Verifica se o benefício é para medicamentos genéricos
                if ($benefit->name === 'Generic Drugs') {
                    foreach ($benefit->cost_sharings as $cost_sharing) {
                        // Verifica se o custo compartilhado é da rede interna ("In-Network")
                        if ($cost_sharing->network_tier === 'In-Network') {
                            // Se for 'No Charge', retorna 'Free', caso contrário, retorna o valor
                            return $cost_sharing->display_string === 'No Charge' ? 'Free' : $cost_sharing->display_string;
                        }
                    }
                }
            }
        }

        return 'N/A'; // Retorna 'N/A' se não encontrar o custo de medicamentos genéricos
    }

    public static function getEmergencyRoomCost($plan)
    {
        // Verifica se o plano tem benefícios
        if (isset($plan['benefits']) && count($plan['benefits']) > 0) {
            foreach ($plan['benefits'] as $benefit) {
                // Verifica se o benefício é para "Emergency Room Services"
                if ($benefit->name === 'Emergency Room Services') {
                    foreach ($benefit->cost_sharings as $cost_sharing) {
                        // Verifica se o custo compartilhado é da rede interna ("In-Network")
                        if ($cost_sharing->network_tier === 'In-Network') {
                            // Retorna 'Free' se for 'No Charge', caso contrário, o valor do display_string
                            return $cost_sharing->display_string === 'No Charge' ? 'Free' : $cost_sharing->display_string;
                        }
                    }
                }
            }
        }

        return '-'; // Retorna '-' se não encontrar o custo para "Emergency Room Services"
    }

    public static function getUrgentCareCost($plan)
    {
        // Verifica se o plano tem benefícios
        if (isset($plan['benefits']) && count($plan['benefits']) > 0) {
            foreach ($plan['benefits'] as $benefit) {
                // Verifica se o benefício é para "Emergency Room Services"
                if ($benefit->type === 'URGENT_CARE_CENTERS_OR_FACILITIES') {
                    foreach ($benefit->cost_sharings as $cost_sharing) {
                        // Verifica se o custo compartilhado é da rede interna ("In-Network")
                        if ($cost_sharing->network_tier === 'In-Network') {
                            // Retorna o valor do display_string
                            return $cost_sharing->display_string;
                        }
                    }
                }
            }
        }

        return '-'; // Retorna '-' se não encontrar o custo para "Urgent Care"
    }

    public static function getRadiographyCost($plan)
    {
        if (isset($plan['benefits'])) {
            foreach ($plan['benefits'] as $benefit) {
                if ($benefit->name === 'X-rays and Diagnostic Imaging') {
                    foreach ($benefit->cost_sharings as $costSharing) {
                        if ($costSharing->network_tier === 'In-Network') {
                            return $costSharing->display_string === 'No Charge' ? 'Free' : $costSharing->display_string;
                        }
                    }
                }
            }
        }
        return '-';
    }

    public static function getImagingCost($plan)
    {
        if (isset($plan['benefits'])) {
            foreach ($plan['benefits'] as $benefit) {
                if ($benefit->name === 'Imaging (CT/PET Scans, MRIs)') {
                    foreach ($benefit->cost_sharings as $costSharing) {
                        if ($costSharing->network_tier === 'In-Network') {
                            return $costSharing->display_string === 'No Charge' ? 'Free' : $costSharing->display_string;
                        }
                    }
                }
            }
        }
        return '-';
    }

    public static function getBloodWorkCost($plan)
    {
        if (isset($plan['benefits'])) {
            foreach ($plan['benefits'] as $benefit) {
                if ($benefit->name === 'Laboratory Outpatient and Professional Services') {
                    foreach ($benefit->cost_sharings as $costSharing) {
                        if ($costSharing->network_tier === 'In-Network') {
                            return $costSharing->display_string === 'No Charge' ? 'Free' : $costSharing->display_string;
                        }
                    }
                }
            }
        }
        return '-';
    }


    public static function generatePdfFromPlans(array $plans, int $applicationId, string $language = 'en')
    {
        // Escolher o template com base no idioma
        $view = self::getPdfViewByLanguage($language);
        // Defina os dados que serão enviados para a view
        $viewData = [
            'plans' => $plans,
            'applicationId' => $applicationId,
        ];

        // Carregar a view com os dados e gerar o PDF
        $pdf = Pdf::loadView($view, $viewData);

        // Retornar o PDF como download ou inline
        return $pdf->download('comparacao_planos.pdf');
    }


    public static function generatePdfTeste($application_id, array $plans, array $planDetails = [])
    {
        $user = Auth::user();

        // Pega o idioma da requisição se disponível
        $language = $plans['language'] ?? self::selectLanguage($application_id);


        $application = Application::find($application_id);
        if ($application) {
            $application->load(['mainMember', 'householdMembers']);

            $membersNumber = $application->householdMembers->count();
            $user = auth()->user();
            $profileImagePath = public_path('img/Cotacao.png');
            if (isset($user->profile_image_pdf)) {
                $profileImagePath = public_path('storage/' . $user->profile_image_pdf);
            }

            $viewData = [
                'nomeCliente' => $application->mainMember->firstname . ' ' . $application->mainMember->lastname,
                'income' => self::formatCurrency($application->mainMember->income_predicted_amount) ?? 'N/A',
                'membersNumber' => $membersNumber,
                'agentName' => $user->name ?? 'None',
                'agentPhone' => $user->phone ?? 'None',
                'zipcode' => $application->mainMember->address->zipcode ?? '',
                'county' => $application->mainMember->address->county ?? '',
                'dataCompletaLocalizada' => self::generateDateByLanguage($language, Carbon::now()),
                'profileImagePath' => $profileImagePath,
            ];

            // Convertemos os objetos para arrays onde necessário
            $plans = [
                'hmo_plan' => isset($plans['hmo_plan']) ? (array) $plans['hmo_plan'] : [],
                'oopc_plan' => isset($plans['oopc_plan']) ? (array) $plans['oopc_plan'] : [],
                'epo_plan' => isset($plans['epo_plan']) ? (array) $plans['epo_plan'] : [],
            ];

            // Configura cada plano (HMO, OOPC, EPO) individualmente
            if (!empty($plans['hmo_plan'])) {
                $issuer = isset($plans['hmo_plan']['issuer']) ? (array) $plans['hmo_plan']['issuer'] : [];
                $viewData = array_merge($viewData, [
                    'issuerCompany1' => $issuer['name'] ?? '',
                    'typeOfInsurance1' => $plans['hmo_plan']['name'] ?? '',
                    'monthlyPremium1' => self::month_value_final($plans['hmo_plan'], $application),
                    'deductible1' => self::calculateDeductible($plans['hmo_plan'], $membersNumber),
                    'outOfPocketMax1' => self::calculateMoop($plans['hmo_plan'], $membersNumber),
                    'network1' => $plans['hmo_plan']['type'] ?? '',
                    'primaryCare1' => self::getDoctorCost($plans['hmo_plan']),
                    'specialist1' => self::getSpecialistCost($plans['hmo_plan']),
                    'genericDrugs1' => self::getDrugCost($plans['hmo_plan']),
                    'emergencyRoom1' => self::getEmergencyRoomCost($plans['hmo_plan']),
                    'emergencyRoomValue1' => self::getUrgentCareCost($plans['hmo_plan']),
                    'radiography1' => self::getRadiographyCost($plans['hmo_plan'] ?? []),
                    'imagingExams1' => self::getImagingCost($plans['hmo_plan'] ?? []),
                    'bloodtests1' => self::getBloodWorkCost($plans['hmo_plan'] ?? []),
                    'benefitsLink1' => $plans['hmo_plan']['benefits_url'] ?? '',
                    'informationLink1' => $plans['hmo_plan']['brochure_url'] ?? '',
                    'formLink1' => $plans['hmo_plan']['formulary_url'] ?? '',
                ]);
            } else {
                // Define valores vazios para o primeiro plano se estiver ausente
                $viewData = array_merge($viewData, [
                    'issuerCompany1' => '',
                    'typeOfInsurance1' => '',
                    'monthlyPremium1' => '',
                    'deductible1' => '',
                    'outOfPocketMax1' => '',
                    'network1' => '',
                    'primaryCare1' => '',
                    'specialist1' => '',
                    'genericDrugs1' => '',
                    'emergencyRoom1' => '',
                    'emergencyRoomValue1' => '',
                    'radiography1' => '',
                    'imagingExams1' => '',
                    'bloodtests1' => '',
                    'benefitsLink1' => '',
                    'informationLink1' => '',
                    'formLink1' => '',
                ]);
            }

            // Configura o segundo plano (OOPC) com valores específicos
            if (!empty($plans['oopc_plan'])) {
                $issuer = isset($plans['oopc_plan']['issuer']) ? (array) $plans['oopc_plan']['issuer'] : [];
                $viewData = array_merge($viewData, [
                    'issuerCompany2' => $issuer['name'] ?? '',
                    'typeOfInsurance2' => $plans['oopc_plan']['name'] ?? '',
                    'monthlyPremium2' => self::month_value_final($plans['oopc_plan'], $application),
                    'deductible2' => self::calculateDeductible($plans['oopc_plan'], $membersNumber),
                    'outOfPocketMax2' => self::calculateMoop($plans['oopc_plan'], $membersNumber),
                    'network2' => $plans['oopc_plan']['type'] ?? '',
                    'primaryCare2' => self::getDoctorCost($plans['oopc_plan']),
                    'specialist2' => self::getSpecialistCost($plans['oopc_plan']),
                    'genericDrugs2' => self::getDrugCost($plans['oopc_plan']),
                    'emergencyRoom2' => self::getEmergencyRoomCost($plans['oopc_plan']),
                    'emergencyRoomValue2' => self::getUrgentCareCost($plans['oopc_plan']),
                    'radiography2' => self::getRadiographyCost($plans['oopc_plan'] ?? []),
                    'imagingExams2' => self::getImagingCost($plans['oopc_plan'] ?? []),
                    'bloodtests2' => self::getBloodWorkCost($plans['oopc_plan'] ?? []),
                    'benefitsLink2' => $plans['oopc_plan']['benefits_url'] ?? '',
                    'informationLink2' => $plans['oopc_plan']['brochure_url'] ?? '',
                    'formLink2' => $plans['oopc_plan']['formulary_url'] ?? '',
                ]);
            } else {
                $viewData = array_merge($viewData, [
                    'issuerCompany2' => '',
                    'typeOfInsurance2' => '',
                    'monthlyPremium2' => '',
                    'deductible2' => '',
                    'outOfPocketMax2' => '',
                    'network2' => '',
                    'primaryCare2' => '',
                    'specialist2' => '',
                    'genericDrugs2' => '',
                    'emergencyRoom2' => '',
                    'emergencyRoomValue2' => '',
                    'radiography2' => '',
                    'imagingExams2' => '',
                    'bloodtests2' => '',
                    'benefitsLink2' => '',
                    'informationLink2' => '',
                    'formLink2' => '',
                ]);
            }

            // Configura o terceiro plano (EPO) com valores específicos
            if (!empty($plans['epo_plan'])) {
                $issuer = isset($plans['epo_plan']['issuer']) ? (array) $plans['epo_plan']['issuer'] : [];
                $viewData = array_merge($viewData, [
                    'issuerCompany3' => $issuer['name'] ?? '',
                    'typeOfInsurance3' => $plans['epo_plan']['name'] ?? '',
                    'monthlyPremium3' => self::month_value_final($plans['epo_plan'], $application),
                    'deductible3' => self::calculateDeductible($plans['epo_plan'], $membersNumber),
                    'outOfPocketMax3' => self::calculateMoop($plans['epo_plan'], $membersNumber),
                    'network3' => $plans['epo_plan']['type'] ?? '',
                    'primaryCare3' => self::getDoctorCost($plans['epo_plan']),
                    'specialist3' => self::getSpecialistCost($plans['epo_plan']),
                    'genericDrugs3' => self::getDrugCost($plans['epo_plan']),
                    'emergencyRoom3' => self::getEmergencyRoomCost($plans['epo_plan']),
                    'emergencyRoomValue3' => self::getUrgentCareCost($plans['epo_plan']),
                    'radiography3' => self::getRadiographyCost($plans['epo_plan'] ?? []),
                    'imagingExams3' => self::getImagingCost($plans['epo_plan'] ?? []),
                    'bloodtests3' => self::getBloodWorkCost($plans['epo_plan'] ?? []),
                    'benefitsLink3' => $plans['epo_plan']['benefits_url'] ?? '',
                    'informationLink3' => $plans['epo_plan']['brochure_url'] ?? '',
                    'formLink3' => $plans['epo_plan']['formulary_url'] ?? '',
                ]);
            } else {
                $viewData = array_merge($viewData, [
                    'issuerCompany3' => '',
                    'typeOfInsurance3' => '',
                    'monthlyPremium3' => '',
                    'deductible3' => '',
                    'outOfPocketMax3' => '',
                    'network3' => '',
                    'primaryCare3' => '',
                    'specialist3' => '',
                    'genericDrugs3' => '',
                    'emergencyRoom3' => '',
                    'emergencyRoomValue3' => '',
                    'radiography3' => '',
                    'imagingExams3' => '',
                    'bloodtests3' => '',
                    'benefitsLink3' => '',
                    'informationLink3' => '',
                    'formLink3' => '',
                ]);
            }


            $view = self::getPdfViewByLanguage($language);

            \Log::info('PDF Template:', [
                'view' => $view,
                'language' => $language
            ]);

            return Pdf::loadView($view, $viewData)->stream("application_plans_{$application_id}.pdf");
        }

        return response()->json(['error' => 'Application not found'], 404);
    }
}
