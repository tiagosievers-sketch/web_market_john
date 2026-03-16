@extends('layouts.app')


@php

    if (isset($data)) {
        $counter = $data['application']->householdMembers->count();
    }
    //dd($plans);
@endphp





@section('styles')
    <style>
        body {
            font-family: sans-serif;
            background-color: #fff;
        }

        .content {
            padding: 20px;
            display: flex;
        }

        .menu {
            width: 250px;
            padding: 20px 0;
            margin-right: 20px;
        }

        .menu a {
            display: block;
            padding: 10px 20px;
            text-decoration: none;
            color: #333;
            transition: background-color 0.3s ease;
            border-bottom: 1px solid #eee;
        }

        .menu a.active,
        .menu a:hover {
            background-color: #f5f5f5;
            color: #007bff;
        }

        .sections {
            flex-grow: 1;
        }

        .section {
            display: none;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        }

        .section.active {
            display: block;
        }

        .table {
            width: 100%;
            max-width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        .table th {
            font-weight: 600;
        }

        .stars {
            display: inline-block;
        }

        .star {
            font-size: 1.5rem;
            color: #ccc;
            /* Cor das estrelas vazias */
        }

        .star.filled {
            color: gold;
            /* Cor das estrelas preenchidas */
        }

        .custom-bg {
            display: inline-block;
            padding: 0.5em;
            /* Ajuste o padding conforme necessário */
            border-radius: 0.25em;
            /* Ajuste o border-radius conforme necessário */
        }

        .bg-gold {
            background-color: #f5c518;
            /* Cor de fundo para Gold */
            color: #fff;
            /* Cor do texto */
        }

        .bg-silver {
            background-color: #c0c0c0;
            /* Cor de fundo para Silver */
            color: #000;
            /* Cor do texto */
        }

        .bg-bronze {
            background-color: #cd7f32;
            /* Cor de fundo para Bronze */
            color: #fff;
            /* Cor do texto */
        }

        .bg-platinum {
            background-color: #e5e4e2;
            /* Cor platina */
        }

        .bg-catastrophic {
            background-color: #4b0082;
            /* Cor roxa escura para Catastrophic */
            color: #fff;
            /* Cor do texto */
        }
    </style>
@endsection

@section('content')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <h4 class="page-title">@lang('labels.planDetails')</h4>
        </div>
    </div>

    <div id="loading" style="display: none; text-align: center;">
        <h3>@lang('labels.carregandoPlano')</h3>
    </div>

    <div class="container-fluid" style="display:none" id="plan-details-container">
        <div class="row">
            <!-- Menu lateral -->
            <div class="col-md-3">
                <div class="menu">
                    <a href="#overview" class="active" id="plan-name-menu"></a>
                    <a href="#doctor-visits">@lang('labels.doctorVisits')</a>
                    <a href="#prescription-drugs">@lang('labels.prescriptionDrugs')</a>
                    <a href="#labs-imaging">@lang('labels.labs')</a>
                    <a href="#hospital-emergency">@lang('labels.hospitalEmergency')</a>
                    <a href="#mental-health">@lang('labels.mentalHealth')</a>
                    <a href="{{ Route('livewire.quotation', ['application_id' => $application_id]) }}"
                        class="btn btn-secondary mt-3" id="voltarButton" onclick="showSpinnerAndRedirect(event)">
                        <span id="spinner" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"
                            style="display: none;"></span>
                        <span id="buttonText">@lang('labels.buttonVoltar')</span>
                    </a>



                    <form id="enroll-form">
                        @csrf
                        <input type="hidden" name="application_id" value="{{ $application_id }}">
                        <input type="hidden" name="plans[0][hios_plan_id]" value="{{ $plan_id }}">
                        <input type="hidden" name="plans[0][name]" id="plan_name_field">
                        <input type="hidden" name="plans[0][value]" value="{{ $premium }}">
                        <button type="submit" class="btn btn-primary mt-3">@lang('labels.enroll')</button>
                    </form>


                </div>
            </div>

            <!-- Conteúdo das seções -->
            <div class="col-md-9">
                <div class="sections">
                    <div id="overview" class="section active">
                        <div class="row">
                            <div class="col-md-6">
                                <h5 id="issuer-name">Issuer Name</h5>
                            </div>
                            <div class="col-md-6 text-right">
                                <h5 id="metal-level" class="text-uppercase font-weight-bold custom-bg">
                                    <!-- Aqui será inserido o valor do metal level dinamicamente -->
                                </h5>
                            </div>
                        </div>
                        <h6 id="plan-name">Plan Name</h6>
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th>@lang('labels.mensalidade'):</th>
                                    <td id="plan-premium">$0.00</td>
                                </tr>
                                <tr>
                                    <th>@lang('labels.franquia'):</th>
                                    <td id="plan-deductible">$0.00</td>
                                </tr>
                                <tr>
                                    <th>@lang('labels.outOfPocket'):</th>
                                    <td id="plan-moop">$0.00</td>
                                </tr>
                                <tr>
                                    <th>@lang('labels.network'):</th>
                                    <td id="plan-network">@lang('labels.network')</td>
                                </tr>
                                <tr>
                                    <th>@lang('labels.metal'):</th>
                                    <td id="plan-metal"></td>
                                </tr>
                                <tr>
                                    <th>@lang('labels.overall'):</th>
                                    <td>
                                        <div class="mt-3">
                                            <div class="stars" id="plan-rating">
                                                <!-- Estrelas serão inseridas dinamicamente -->
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div id="doctor-visits" class="section">
                        <h5>@lang('labels.doctorVisits')</h5>
                        <p>@lang('labels.doctorApplies')</p>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>@lang('labels.beforeDeductible')</th>
                                    <th>@lang('labels.afterDeductible')</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>@lang('labels.primaryCare')</td>
                                    <td id="primary-care-before">N/A</td>
                                    <td id="primary-care-after">N/A</td>
                                </tr>
                                <tr>
                                    <td>@lang('labels.specialist')</td>
                                    <td id="specialist-before">N/A</td>
                                    <td id="specialist-after">N/A</td>
                                </tr>
                                <tr>
                                    <td>@lang('labels.preventiveCare')</td>
                                    <td id="preventive-before">N/A</td>
                                    <td id="preventive-after">N/A</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div id="prescription-drugs" class="section">
                        <h5>@lang('labels.prescriptionDrugs')</h5>
                        <p>@lang('labels.prescriptionDrugsCoverage')</p>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>@lang('labels.beforeDeductible')</th>
                                    <th>@lang('labels.afterDeductible')</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>@lang('labels.generic')</td>
                                    <td id="generic-drugs-before">N/A</td>
                                    <td id="generic-drugs-after">N/A</td>
                                </tr>
                                <tr>
                                    <td>@lang('labels.brand')</td>
                                    <td id="brand-drugs-before">N/A</td>
                                    <td id="brand-drugs-after">N/A</td>
                                </tr>
                                <tr>
                                    <td>@lang('labels.nonPreferredBrand')</td>
                                    <td id="non-preferred-brand-drugs-before">N/A</td>
                                    <td id="non-preferred-brand-drugs-after">N/A</td>
                                </tr>
                                <tr>
                                    <td>@lang('labels.especialidade')</td>
                                    <td id="specialty-drugs-before">N/A</td>
                                    <td id="specialty-drugs-after">N/A</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div id="labs-imaging" class="section">
                        <h5>@lang('labels.labs')</h5>
                        <p>@lang('labels.testsDoctor')</p>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>@lang('labels.beforeDeductible')</th>
                                    <th>@lang('labels.afterDeductible')</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>@lang('labels.rays')</td>
                                    <td id="xray-before">N/A</td>
                                    <td id="xray-after">N/A</td>
                                </tr>
                                <tr>
                                    <td>@lang('labels.imagingCt')</td>
                                    <td id="imaging-before">N/A</td>
                                    <td id="imaging-after">N/A</td>
                                </tr>
                                <tr>
                                    <td>@lang('labels.bloodWork')</td>
                                    <td id="bloodwork-before">N/A</td>
                                    <td id="bloodwork-after">N/A</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div id="hospital-emergency" class="section">
                        <h5>@lang('labels.hospitalEmergency')</h5>
                        <p>@lang('labels.hospitalsErsUrgent')</p>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>@lang('labels.beforeDeductible')</th>
                                    <th>@lang('labels.afterDeductible')</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>@lang('labels.valormax')</td>
                                    <td id="urgent-care-before">N/A</td>
                                    <td id="urgent-care-after">N/A</td>
                                </tr>
                                <tr>
                                    <td>@lang('labels.emergencyRoom')</td>
                                    <td id="emergency-room-before">N/A</td>
                                    <td id="emergency-room-after">N/A</td>
                                </tr>
                                <tr>
                                    <td>@lang('labels.ambulancia')</td>
                                    <td id="ambulance-before">N/A</td>
                                    <td id="ambulance-after">N/A</td>
                                </tr>
                                <tr>
                                    <td>@lang('labels.hospitalStay')</td>
                                    <td id="hospital-facility-before">N/A</td>
                                    <td id="hospital-facility-after">N/A</td>
                                </tr>
                                <tr>
                                    <td>@lang('labels.hospitalStayPhysician')</td>
                                    <td id="hospital-physician-before">N/A</td>
                                    <td id="hospital-physician-after">N/A</td>
                                </tr>
                                <tr>
                                    <td>@lang('labels.outpatient')</td>
                                    <td id="outpatient-facility-before">N/A</td>
                                    <td id="outpatient-facility-after">N/A</td>
                                </tr>
                                <tr>
                                    <td>@lang('labels.outpatientPhysician')</td>
                                    <td id="outpatient-physician-before">N/A</td>
                                    <td id="outpatient-physician-after">N/A</td>
                                </tr>
                                <tr>
                                    <td>@lang('labels.physicalRehab')</td>
                                    <td id="rehab-before">N/A</td>
                                    <td id="rehab-after">N/A</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div id="mental-health" class="section">
                        <h5>@lang('labels.mentalHealth')</h5>
                        <p>@lang('labels.allPlansCoverBehavioralHealth')</p>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>@lang('labels.beforeDeductible')</th>
                                    <th>@lang('labels.afterDeductible')</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>@lang('labels.outpatientServices')</td>
                                    <td id="mental-outpatient-before">N/A</td>
                                    <td id="mental-outpatient-after">N/A</td>
                                </tr>
                                <tr>
                                    <td>@lang('labels.psychiatricHospitalStay')</td>
                                    <td id="mental-inpatient-before">N/A</td>
                                    <td id="mental-inpatient-after">N/A</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


@section('scripts')
    <script>
        const menuLinks = document.querySelectorAll('.menu a');
        const sections = document.querySelectorAll('.section');

        menuLinks.forEach(link => {
            link.addEventListener('click', (event) => {
                event.preventDefault();

                // Remove a classe 'active' do link e da seção atualmente ativos
                document.querySelector('.menu a.active').classList.remove('active');
                document.querySelector('.section.active').classList.remove('active');

                // Adiciona a classe 'active' ao link clicado
                link.classList.add('active');

                const targetId = link.getAttribute('href');

                // Verifica se o href é um seletor de ID válido (começa com '#')
                if (targetId.startsWith('#')) {
                    document.querySelector(targetId).classList.add('active');
                } else {
                    // Caso contrário, não tenta usar querySelector com um seletor inválido
                    console.warn(`O link ${targetId} não é um seletor de ID válido.`);
                }
            });
        });

        document.getElementById('voltarButton').addEventListener('click', function(event) {
            event.preventDefault(); // Impede o comportamento padrão do link

            // Redireciona para a URL do botão
            window.location.href = this.href;
        });





        const count = @json($counter);
        const premium = parseFloat(@json($premium));
        console.log('premium', premium);

        console.log('counter', count);

     function fillOtherFields(planComplete) {
        const deductibleValue = formatCurrency(planComplete.medical_deductible);
        $('#plan-deductible').text(`${deductibleValue}`);
    }

    function fillPlanDetails(plan) {
        // Preenchendo os dados no HTML
        $('#plan-name-menu').text(plan.name);
        $('#plan-name').text(plan.name);
        $('#issuer-name').text(plan.issuer.name);
        //$('#plan-premium').text(`${premium}`);
        $('#plan-premium').text(`${formatCurrency(plan.premium_w_credit)}`);
        console.log('plan', plan);
        // $('#plan-deductible').text(`$${plan.deductibles[0]?.amount || 'N/A'}`);
        //$('#plan-moop').text(`$${plan.moops[0]?.amount || 'N/A'}`);
        $('#plan-network').text(plan.type);
        $('#plan-metal').text(plan.metal_level);
        const oopmValue = formatCurrency(plan.moops_amount);
        $('#plan-moop').text(`${oopmValue}`);

        // Ajustar classes de metal level
        let metalClass = '';
        switch (plan.metal_level) {
            case 'Gold':
                metalClass = 'custom-bg bg-gold';
                break;
            case 'Silver':
                metalClass = 'custom-bg bg-silver';
                break;
            case 'Bronze':
                metalClass = 'custom-bg bg-bronze';
                break;
            case 'Catastrophic':
                metalClass = 'custom-bg bg-catastrophic';
                break;
            default:
                metalClass = 'custom-bg';
                break;
        }

        $('#metal-level').attr('class', 'text-uppercase font-weight-bold ' + metalClass).text(plan.metal_level);

        // Estrelas de classificação
        const rating = plan.quality_rating?.global_rating || 0;
        const starContainer = $('#plan-rating');
        starContainer.empty();
        for (let i = 1; i <= 5; i++) {
            const star = `<span class="star ${i <= rating ? 'filled' : ''}">&#9733;</span>`;
            starContainer.append(star);
        }
    }

        // Requisição AJAX para buscar detalhes do plano e preencher os dados
        $(document).ready(function() {
            const applicationId = @json($application_id); // Pegue o ID da aplicação
            const planId = @json($plan_id); // Pegue o ID do plano selecionado
            const planComplete = @json($planComplete);

            $('#loading').show();
            $('#plan-details-container').hide();

            fillOtherFields(planComplete);

        fetchPlanDetails(applicationId, planId)
            .then(plan => {
                $('#loading').hide();
                $('#plan-details-container').show();
                // Preencha os detalhes do plano
                fillPlanDetails(planComplete);
                fillDoctorVisitCosts(planComplete); // Preencher os custos das visitas médicas
                fillPrescriptionDrugCosts(planComplete); // Preencher os custos de medicamentos
                fillLabsImagingCosts(planComplete); // Preencher os custos de exames laboratoriais e de imagem
                fillHospitalEmergencyCosts(planComplete); // Preencher os custos de hospital e emergência
                fillMentalHealthCosts(planComplete); // Preencher os custos de saúde mental
            })
            .catch(error => {
                $('#loading').hide();
                console.error('Erro ao carregar os detalhes do plano:', error);
            });
        });

        function fetchPlanDetails(applicationId, planId) {
            return new Promise((resolve, reject) => {
                $.ajax({
                    url: `/plans/search/plan-detail/${applicationId}/${planId}`,
                    type: 'GET',
                    success: function(response) {
                        console.log('Resposta completa:',
                            response); // Verifique a estrutura da resposta aqui
                        if (response.status === 'success' && response.data) {
                            resolve(response.data); // Retorna os detalhes do plano
                            console.log('Plano encontrado:', response.data);
                        } else {
                            reject('Plano não encontrado.');
                        }
                    },
                    error: function(error) {
                        reject(error);
                    }
                });
            });
        }




           function calculateDeductible(plan, count) {
            let minDeductibles = '-'; // Valor padrão inicial
            let varFamily = ''; // Para armazenar o prefixo 'Family' quando necessário

            if (plan.deductibles && plan.deductibles.length > 0) {
                console.log('Deductibles array:', plan.deductibles);

                for (let i = 0; i < plan.deductibles.length; i++) {
                    const deductible = plan.deductibles[i];
                    console.log('Current deductible:', deductible);

                    // Verificação para uma única pessoa
                    if (count === 1) { // Aqui usamos `count` diretamente como um número
                        console.log('Checking for individual deductible');

                        if (deductible.family_cost === 'Family Per Person' || deductible
                            .family_cost ===
                            'Individual') {
                            minDeductibles = deductible.amount;
                            varFamily = ''; // Não é necessário 'Family'
                            break;
                        }
                    }
                    // Verificação de dedutível para famílias
                    else {
                        console.log('Checking for family deductible');

                        if (deductible.family_cost === 'Family') {
                            minDeductibles = deductible.amount;
                            varFamily = 'Family '; // Prefixo 'Family' é necessário
                            break;
                        }
                    }
                }

                // Se nenhum dedutível atender ao critério, use o primeiro valor disponível
                if (minDeductibles === '-') {
                    minDeductibles = plan.deductibles[0].amount || '-';
                    console.log('Using default deductible:', minDeductibles);

                } else {
                    console.warn('No deductibles found for this plan');

                }
            }
            console.log('Final deductible value:', minDeductibles);

            return formatCurrency(minDeductibles);
        }


        //out of pocket MAX
        function calculateMoop(plan) {
            let minMoops = '-'; // Valor padrão inicial
            console.log('Conteúdo de plan.moops:', plan.moops); // Verifique os valores de MOOP
            console.log('Tamanho do array plan.moops:', plan.moops.length); // Verifique o tamanho do array
            if (plan.moops && plan.moops.length > 0) {
                for (const moop of plan.moops) {
                    console.log('Valor de moop:', moop);
                    if (moop.family_cost === 'Family Per Person' || moop.family_cost === 'Individual') {
                        console.log('Family Cost:', moop.family_cost);
                        minMoops = moop.amount;
                        break;
                    }
                }

                // Se nenhum MOOP atender ao critério, usa o primeiro valor disponível
                if (minMoops === '-') {
                    minMoops = plan.moops[0].amount || '-';
                    console.log(
                        'Nenhum MOOP atendeu ao critério. Usando o primeiro valor disponível.'
                    ); // Verifique se o valor foi encontrado
                }
            }

            return formatCurrency(minMoops);
        }



        function fillDoctorVisitCosts(plan) {
            // Exemplo para "Primary Care Visit"
            const primaryCareCosts = getBenefitCostVisit(plan.benefits, 'Primary Care Visit to Treat an Injury or Illness');
            $('#primary-care-before').text(primaryCareCosts.costBefore);
            $('#primary-care-after').text(primaryCareCosts.costAfter);

            // Exemplo para "Specialist Visit"
            const specialistCosts = getBenefitCostVisit(plan.benefits, 'Specialist Visit');
            $('#specialist-before').text(specialistCosts.costBefore);
            $('#specialist-after').text(specialistCosts.costAfter);

            // Exemplo para "Preventive Care"
            const preventiveCareCosts = getBenefitCostVisit(plan.benefits, 'Preventive Care/Screening/Immunization');
            $('#preventive-before').text(preventiveCareCosts.costBefore);
            $('#preventive-after').text(preventiveCareCosts.costAfter);
        }

        function getBenefitCostVisit(benefits, benefitName, networkTier = 'In-Network') {
            let costBefore = 'N/A';
            let costAfter = 'N/A';

            const benefit = benefits.find(b => b.name === benefitName);
            if (benefit) {
                const costSharing = benefit.cost_sharings.find(cs => cs.network_tier === networkTier);

                if (costSharing) {
                    if (benefit.covered === true) {
                        if (costSharing.display_string === 'No Charge') {
                            costBefore = 'Free';
                            costAfter = 'Free';
                        } else if (costSharing.display_string.toLowerCase().includes('after deductible')) {
                            if (costSharing.display_string.includes('$') && costSharing.display_string.includes('%')) {
                                costBefore = `${costSharing.coinsurance_rate * 100}%`;
                                costAfter = `$${costSharing.copay_amount}`;
                            } else if (costSharing.display_string.includes('$')) {
                                costBefore = `$${costSharing.copay_amount}`;
                                costAfter = 'Full Price';
                            } else if (costSharing.display_string.includes('%')) {
                                costBefore = `${costSharing.coinsurance_rate * 100}%`;
                                costAfter = 'Full Price';
                            }
                        } else {
                            costBefore = costSharing.display_string;
                            costAfter = costSharing.display_string;
                        }
                    } else {
                        costBefore = 'Not Covered';
                        costAfter = 'Not Covered';
                    }
                }
            }

            return {
                costBefore,
                costAfter
            };
        }



        function fillPrescriptionDrugCosts(plan) {
            // Preencher "Generic Drugs"
            const genericDrugsCosts = getBenefitCostDrug(plan.benefits, 'Generic Drugs');
            $('#generic-drugs-before').text(genericDrugsCosts.costBefore);
            $('#generic-drugs-after').text(genericDrugsCosts.costAfter);

            // Preencher "Brand Drugs"
            const brandDrugsCosts = getBenefitCostDrug(plan.benefits, 'Preferred Brand Drugs');
            $('#brand-drugs-before').text(brandDrugsCosts.costBefore);
            $('#brand-drugs-after').text(brandDrugsCosts.costAfter);

            // Preencher "Non-Preferred Brand Drugs"
            const nonPreferredBrandDrugsCosts = getBenefitCostDrug(plan.benefits, 'Non-Preferred Brand Drugs');
            $('#non-preferred-brand-drugs-before').text(nonPreferredBrandDrugsCosts.costBefore);
            $('#non-preferred-brand-drugs-after').text(nonPreferredBrandDrugsCosts.costAfter);

            // Preencher "Specialty Drugs"
            const specialtyDrugsCosts = getBenefitCostDrug(plan.benefits, 'Specialty Drugs');
            $('#specialty-drugs-before').text(specialtyDrugsCosts.costBefore);
            $('#specialty-drugs-after').text(specialtyDrugsCosts.costAfter);
        }

        // Função para buscar os benefícios (mantida igual à anterior)
        function getBenefitCostDrug(benefits, benefitName, networkTier = 'In-Network') {
            let costBefore = 'N/A';
            let costAfter = 'N/A';

            const benefit = benefits.find(b => b.name === benefitName);
            if (benefit) {
                const costSharing = benefit.cost_sharings.find(cs => cs.network_tier === networkTier);

                if (costSharing) {
                    if (benefit.covered === true) {
                        if (costSharing.display_string === 'No Charge') {
                            costBefore = 'Free';
                            costAfter = 'Free';
                        } else if (costSharing.display_string.toLowerCase().includes('after deductible')) {
                            if (costSharing.display_string.includes('$') && costSharing.display_string.includes('%')) {
                                costBefore = `${costSharing.coinsurance_rate * 100}%`;
                                costAfter = `$${costSharing.copay_amount}`;
                            } else if (costSharing.display_string.includes('$')) {
                                costBefore = `$${costSharing.copay_amount}`;
                                costAfter = 'Full Price';
                            } else if (costSharing.display_string.includes('%')) {
                                costBefore = `${costSharing.coinsurance_rate * 100}%`;
                                costAfter = 'Full Price';
                            }
                        } else {
                            costBefore = costSharing.display_string;
                            costAfter = costSharing.display_string;
                        }
                    } else {
                        costBefore = 'Not Covered';
                        costAfter = 'Not Covered';
                    }
                }
            }

            return {
                costBefore,
                costAfter
            };
        }




        //JavaScript para preencher os custos de exames laboratoriais e de imagem
        function fillLabsImagingCosts(plan) {
            // Preencher "X-rays and Diagnostic Imaging"
            const xrayCosts = getBenefitCostLabs(plan.benefits, 'X-rays and Diagnostic Imaging');
            $('#xray-before').text(xrayCosts.costBefore);
            $('#xray-after').text(xrayCosts.costAfter);

            // Preencher "Imaging (CT/PET Scans, MRIs)"
            const imagingCosts = getBenefitCostLabs(plan.benefits, 'Imaging (CT/PET Scans, MRIs)');
            $('#imaging-before').text(imagingCosts.costBefore);
            $('#imaging-after').text(imagingCosts.costAfter);

            // Preencher "Laboratory Outpatient and Professional Services"
            const bloodworkCosts = getBenefitCostLabs(plan.benefits, 'Laboratory Outpatient and Professional Services');
            $('#bloodwork-before').text(bloodworkCosts.costBefore);
            $('#bloodwork-after').text(bloodworkCosts.costAfter);
        }

        // Função para buscar os benefícios e custos (igual às anteriores)
        function getBenefitCostLabs(benefits, benefitName, networkTier = 'In-Network') {
            let costBefore = 'N/A';
            let costAfter = 'N/A';

            const benefit = benefits.find(b => b.name === benefitName);
            if (benefit) {
                const costSharing = benefit.cost_sharings.find(cs => cs.network_tier === networkTier);

                if (costSharing) {
                    if (benefit.covered === true) {
                        if (costSharing.display_string === 'No Charge') {
                            costBefore = 'Free';
                            costAfter = 'Free';
                        } else if (costSharing.display_string.toLowerCase().includes('after deductible')) {
                            if (costSharing.display_string.includes('$') && costSharing.display_string.includes('%')) {
                                costBefore = `${costSharing.coinsurance_rate * 100}%`;
                                costAfter = `$${costSharing.copay_amount}`;
                            } else if (costSharing.display_string.includes('$')) {
                                costBefore = `$${costSharing.copay_amount}`;
                                costAfter = 'Full Price';
                            } else if (costSharing.display_string.includes('%')) {
                                costBefore = `${costSharing.coinsurance_rate * 100}%`;
                                costAfter = 'Full Price';
                            }
                        } else {
                            costBefore = costSharing.display_string;
                            costAfter = costSharing.display_string;
                        }
                    } else {
                        costBefore = 'Not Covered';
                        costAfter = 'Not Covered';
                    }
                }
            }

            return {
                costBefore,
                costAfter
            };
        }


        //JavaScript para preencher os custos do hospital e emergência
        function fillHospitalEmergencyCosts(plan) {
            // Preencher "Emergency Room Services"
            const emergencyRoomCosts = getBenefitCostEmergency(plan.benefits, 'Emergency Room Services');
            $('#emergency-room-before').text(emergencyRoomCosts.costBefore);
            $('#emergency-room-after').text(emergencyRoomCosts.costAfter);

            // Preencher "Emergency Transportation/Ambulance"
            const ambulanceCosts = getBenefitCostEmergency(plan.benefits, 'Emergency Transportation/Ambulance');
            $('#ambulance-before').text(ambulanceCosts.costBefore);
            $('#ambulance-after').text(ambulanceCosts.costAfter);

            // Preencher "Inpatient Hospital Services (e.g., Hospital Stay)"
            const hospitalFacilityCosts = getBenefitCostEmergency(plan.benefits,
                'Inpatient Hospital Services (e.g., Hospital Stay)');
            $('#hospital-facility-before').text(hospitalFacilityCosts.costBefore);
            $('#hospital-facility-after').text(hospitalFacilityCosts.costAfter);

            // Preencher "Inpatient Physician and Surgical Services"
            const hospitalPhysicianCosts = getBenefitCostEmergency(plan.benefits,
                'Inpatient Physician and Surgical Services');
            $('#hospital-physician-before').text(hospitalPhysicianCosts.costBefore);
            $('#hospital-physician-after').text(hospitalPhysicianCosts.costAfter);

            // Preencher "Outpatient Facility Fee (e.g., Ambulatory Surgery Center)"
            const outpatientFacilityCosts = getBenefitCostEmergency(plan.benefits,
                'Outpatient Facility Fee (e.g., Ambulatory Surgery Center)');
            $('#outpatient-facility-before').text(outpatientFacilityCosts.costBefore);
            $('#outpatient-facility-after').text(outpatientFacilityCosts.costAfter);

            // Preencher "Outpatient Surgery Physician/Surgical Services"
            const outpatientPhysicianCosts = getBenefitCostEmergency(plan.benefits,
                'Outpatient Surgery Physician/Surgical Services');
            $('#outpatient-physician-before').text(outpatientPhysicianCosts.costBefore);
            $('#outpatient-physician-after').text(outpatientPhysicianCosts.costAfter);

            // Preencher "Outpatient Rehabilitation Services"
            const rehabCosts = getBenefitCostEmergency(plan.benefits, 'Outpatient Rehabilitation Services');
            $('#rehab-before').text(rehabCosts.costBefore);
            $('#rehab-after').text(rehabCosts.costAfter);

            const urgentCareCosts = getBenefitCostUrgentCare(plan.benefits, 'URGENT_CARE_CENTERS_OR_FACILITIES');
            $('#urgent-care-before').text(urgentCareCosts.costBefore);
            $('#urgent-care-after').text(urgentCareCosts.costAfter);
        }

        // Função para buscar os benefícios e custos
        function getBenefitCostEmergency(benefits, benefitName, networkTier = 'In-Network') {
            let costBefore = 'N/A';
            let costAfter = 'N/A';

            const benefit = benefits.find(b => b.name === benefitName);
            if (benefit) {
                const costSharing = benefit.cost_sharings.find(cs => cs.network_tier === networkTier);

                if (costSharing) {
                    if (benefit.covered === true) {
                        if (costSharing.display_string === 'No Charge') {
                            costBefore = 'Free';
                            costAfter = 'Free';
                        } else if (costSharing.display_string.toLowerCase().includes('after deductible')) {
                            if (costSharing.display_string.includes('$') && costSharing.display_string.includes('%')) {
                                costBefore = `${costSharing.coinsurance_rate * 100}%`;
                                costAfter = `$${costSharing.copay_amount}`;
                            } else if (costSharing.display_string.includes('$')) {
                                costBefore = `$${costSharing.copay_amount}`;
                                costAfter = 'Full Price';
                            } else if (costSharing.display_string.includes('%')) {
                                costBefore = `${costSharing.coinsurance_rate * 100}%`;
                                costAfter = 'Full Price';
                            }
                        } else {
                            costBefore = costSharing.display_string;
                            costAfter = costSharing.display_string;
                        }
                    } else {
                        costBefore = 'Not Covered';
                        costAfter = 'Not Covered';
                    }
                }
            }

            return {
                costBefore,
                costAfter
            };
        }

        // Função para buscar os benefícios e custos
        function getBenefitCostUrgentCare(benefits, benefitType, networkTier = 'In-Network') {
            let costBefore = 'N/A';
            let costAfter = 'N/A';

            const benefit = benefits.find(b => b.type === benefitType);
            if (benefit) {
                const costSharing = benefit.cost_sharings.find(cs => cs.network_tier === networkTier);

                if (costSharing) {
                    if (benefit.covered === true) {
                        if (costSharing.display_string.toLowerCase().includes('after deductible')) {
                            if (costSharing.display_string.includes('$') && costSharing.display_string.includes('%')) {
                                costBefore = `${costSharing.coinsurance_rate * 100}%`;
                                costAfter = `$${costSharing.copay_amount}`;
                            } else if (costSharing.display_string.includes('$')) {
                                costBefore = `$${costSharing.copay_amount}`;
                                costAfter = 'Full Price';
                            } else if (costSharing.display_string.includes('%')) {
                                costBefore = `${costSharing.coinsurance_rate * 100}%`;
                                costAfter = 'Full Price';
                            }
                        } else {
                            costBefore = costSharing.display_string;
                            costAfter = costSharing.display_string;
                        }
                    } else {
                        costBefore = 'Not Covered';
                        costAfter = 'Not Covered';
                    }
                }
            }

            return {
                costBefore,
                costAfter
            };
        }

        //JavaScript para preencher os custos de saúde mental
        function fillMentalHealthCosts(plan) {
            // Preencher "Mental/Behavioral Health Outpatient Services"
            const mentalOutpatientCosts = getBenefitCostHealth(plan.benefits,
                'Mental/Behavioral Health Outpatient Services');
            $('#mental-outpatient-before').text(mentalOutpatientCosts.costBefore);
            $('#mental-outpatient-after').text(mentalOutpatientCosts.costAfter);

            // Preencher "Mental/Behavioral Health Inpatient Services"
            const mentalInpatientCosts = getBenefitCostHealth(plan.benefits, 'Mental/Behavioral Health Inpatient Services');
            $('#mental-inpatient-before').text(mentalInpatientCosts.costBefore);
            $('#mental-inpatient-after').text(mentalInpatientCosts.costAfter);
        }

        // Função para buscar os benefícios e custos
        function getBenefitCostHealth(benefits, benefitName, networkTier = 'In-Network') {
            let costBefore = 'N/A';
            let costAfter = 'N/A';

            const benefit = benefits.find(b => b.name === benefitName);
            if (benefit) {
                const costSharing = benefit.cost_sharings.find(cs => cs.network_tier === networkTier);

                if (costSharing) {
                    if (benefit.covered === true) {
                        if (costSharing.display_string === 'No Charge') {
                            costBefore = 'Free';
                            costAfter = 'Free';
                        } else if (costSharing.display_string.toLowerCase().includes('after deductible')) {
                            if (costSharing.display_string.includes('$') && costSharing.display_string.includes('%')) {
                                costBefore = `${costSharing.coinsurance_rate * 100}%`;
                                costAfter = `$${costSharing.copay_amount}`;
                            } else if (costSharing.display_string.includes('$')) {
                                costBefore = `$${costSharing.copay_amount}`;
                                costAfter = 'Full Price';
                            } else if (costSharing.display_string.includes('%')) {
                                costBefore = `${costSharing.coinsurance_rate * 100}%`;
                                costAfter = 'Full Price';
                            }
                        } else {
                            costBefore = costSharing.display_string;
                            costAfter = costSharing.display_string;
                        }
                    } else {
                        costBefore = 'Not Covered';
                        costAfter = 'Not Covered';
                    }
                }
            }

            return {
                costBefore,
                costAfter
            };
        }



        function formatCurrency(value) {
            if (typeof value === 'number' && isFinite(value)) {
                return value.toLocaleString('en-US', {
                    style: 'currency',
                    currency: 'USD',
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            } else {
                return '$0';
            }
        }


        $(document).ready(function() {
            const csrf_token = '{{ csrf_token() }}';

            // Pega o nome do plano e remove qualquer vírgula no valor do premium
            const premium = '{{ $premium }}'.replace(/,/g, '');

            $('#enroll-form').on('submit', function(e) {
                e.preventDefault(); // Evita o comportamento padrão do formulário

                // Pega o nome do plano no momento do envio
                const planName = $('#plan-name').text()
                    .trim(); // Certifica-se de pegar o texto atual e remover espaços em branco
                $('#plan_name_field').val(planName); // Define o valor no campo hidden

                // Atualiza o valor do campo premium
                $('input[name="plans[0][value]"]').val(premium);

                // Exibe o loader antes de enviar o formulário
                Swal.fire({
                    title: '@lang('labels.aguarde')',
                    text: '@lang('labels.processando')',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Serializa os dados do formulário
                let formData = $(this).serialize();
                console.log(formData);

                $.ajax({
                    url: '{{ route('plans.storePlans') }}', // URL da rota para enviar os dados
                    type: 'POST',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': csrf_token
                    },
                    success: function(response) {
                        Swal.close(); // Fecha o modal de carregamento

                        if (response.status === 'success') {
                            Swal.fire({
                                title: '@lang('labels.sucesso')!',
                                text: '@lang('labels.inscricao')!',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href =
                                        '{{ route('index') }}'; // Redireciona
                                }
                            });
                        } else {
                            Swal.fire({
                                title: 'Erro!',
                                text: '@lang('labels.erro'): ' + response
                                    .message,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.close(); // Fecha o modal de carregamento
                        Swal.fire({
                            title: '@lang('labels.erro')!',
                            text: '@lang('labels.erroProcessar').',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });

        });

        document.getElementById('voltarButton').addEventListener('click', function(event) {
            event.preventDefault(); // Impede o comportamento padrão do link

            // Exibe um SweetAlert com o spinner
            Swal.fire({
                title: '@lang('labels.carregando')',
                html: '@lang('labels.aguarde')',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading(); // Exibe o loader no SweetAlert
                    // Redireciona para a página após 2 segundos (ajustável conforme necessário)
                    window.location.href = event.currentTarget.href;
                }
            });
        });
    </script>
@endsection
