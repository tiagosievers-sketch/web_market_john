@extends('layouts.app')



{{-- @php
dd($data);
@endphp --}}


@section('styles')
    <link rel="stylesheet" href="/css/quotation.css">
@endsection



@section('content')
    <!-- BREADCRUMB -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <h4 class="page-title">@lang('labels.householdTitulo')</h4>
        </div>
    </div>
    <!-- END BREADCRUMB -->

    <div class="row" id="client-info-cards">
        <div class="col-12 col-md-6">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mg-b-0 ">@lang('labels.clientData')</h4>
                        <a href="javascript:void(0);" class="tx-inverse" data-bs-toggle="dropdown"><i
                                class="mdi mdi-dots-horizontal text-gray"></i></a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive border">
                        <table class="table table-striped mg-b-0 text-md-nowrap">
                            <tbody>
                                @php $counter = 0; @endphp
                                @foreach ($data['application']['householdMembers'] as $member)
                                    @if ($member['field_type'] == 0)
                                        <tr>
                                            <th>@lang('labels.name')</th>
                                            <td>{{ $member->firstname }}</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('labels.enderecoCEP')</th>
                                            <td>{{ $member->address->zipcode ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('labels.income')</th>
                                            <td>
                                                <input type="text" class="form-control income-field"
                                                    value="{{ $member->income_predicted_amount }}" id="income"
                                                    title="Alterar renda" data-member-id="{{ $member->id }}"
                                                    data-application-id="{{ $application_id }}">
                                            </td>
                                        </tr>
                                    @endif
                                    @php $counter++; @endphp
                                @endforeach
                                <tr>
                                    <th>@lang('labels.householdTitulo')</th>
                                    <td>
                                        <input type="text" class="form-control" id="household-number-input"
                                            value="{{ $data['application']['override_household_number'] ?? $counter }}"
                                            title="Alterar número de membros" data-application-id="{{ $application_id }}">
                                    </td>
                                </tr>
                                   <tr>
                                        <th>@lang('labels.ano')</th>
                                        <td>
                                            <select
                                                class="form-select"
                                                id="year"
                                                name="year"
                                                title="@lang('labels.ano')"
                                                data-application-id="{{ $application_id }}"
                                            >
                                                <option value="">@lang('labels.campoSelecao')</option>
                                                @foreach($years as $yearOption)
                                                    <option 
                                                        value="{{ $yearOption }}" 
                                                        {{ ($data['year'] ?? '') == $yearOption ? 'selected' : '' }}
                                                    >
                                                        {{ $yearOption }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="card">
                <div class="card-header pb-0">
                    <h4 class="card-title mg-b-0">@lang('labels.elegivel')</h4>
                </div>
                <div class="card-body">
                    @php
                        $sortedMembers = collect($data['application']['householdMembers'])->sortBy('field_type');
                    @endphp

                    <ul class="list-unstyled" id="household-members-list">
                        @foreach ($sortedMembers as $memberEligible)
                            <li id="member-{{ $memberEligible->id }}"
                                style="display: flex; align-items: center; margin-bottom: 0.5rem;">
                                @php $age = \Carbon\Carbon::parse($memberEligible->birthdate)->age; @endphp

                                <!-- Coluna com o título do tipo de membro -->
                                <span class="marker" style="width: 150px; font-weight: bold;">
                                    @if ($memberEligible->field_type == 0)
                                        @lang('labels.memberPrincipal'):
                                    @elseif ($memberEligible->field_type == 1)
                                        @lang('labels.relacaoEsposa'):
                                    @else
                                        @lang('labels.dependent+'):
                                    @endif
                                </span>

                                <!-- Coluna com o sexo e idade -->
                                <span class="marker" style="flex-grow: 1;">
                                    {{ $memberEligible->sexModel->name }}, {{ $age }}
                                </span>

                                <!-- Botão de remoção apenas para membros que não são o principal -->
                                @if ($memberEligible->field_type != 0)
                                    <button type="button" class="btn btn-sm btn-danger btn-icon remove-member-btn"
                                        id="remove-member-{{ $memberEligible->id }}" data-id="{{ $memberEligible->id }}"
                                        style="margin-left: 0.5rem;">
                                        X
                                    </button>
                                @endif
                            </li>
                        @endforeach
                    </ul>



                    <!-- Botões para adicionar cônjuge e dependente -->
                    <button class="btn btn-outline-primary mt-3" id="btnAddSpouse">+ @lang('labels.relacaoEsposa')</button>
                    <button class="btn btn-outline-primary mt-3" id="btnAddDependent">+ @lang('labels.dependent')</button>
                </div>
            </div>
        </div>

    </div>

    <!-- Modal para Adicionar Cônjuge -->
    <div class="modal fade" id="addSpouseModal" tabindex="-1" aria-labelledby="addSpouseModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addSpouseModalLabel">@lang('labels.householdAddConjuge')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="spouseForm">
                        <div class="mb-3">
                            <label for="spouseBirthdate" class="form-label">@lang('labels.dataNascimento')</label>
                            <input type="text" class="form-control" id="spouseBirthdate" placeholder="MM/DD/YYYY"
                                required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">@lang('labels.userTabaco')</label>
                            <div class="d-flex">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="spouseTobacco"
                                        id="spouseTobacco_no" value="0" required>
                                    <label class="form-check-label" for="spouseTobacco_no">@lang('labels.checkNo')</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="spouseTobacco"
                                        id="spouseTobacco_yes" value="1" required>
                                    <label class="form-check-label" for="spouseTobacco_yes">@lang('labels.checkYes')</label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">@lang('labels.campoSexo')</label>
                            @foreach ($sexes as $id => $alias)
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="spouseSex"
                                        id="spouseSex_{{ $alias }}" value="{{ $id }}" required>
                                    <label class="form-check-label"
                                        for="spouseSex_{{ $alias }}">@lang('labels.' . $alias)</label>
                                </div>
                            @endforeach
                        </div>


                        <button type="button" class="btn btn-primary"
                            id="btnAddSpouseToList">@lang('labels.add')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Adicionar Dependente -->
    <div class="modal fade" id="addDependentModal" tabindex="-1" aria-labelledby="addDependentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addDependentModalLabel">@lang('labels.householdAddDependente')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="dependentForm">
                        <div class="mb-3">
                            <label for="dependentBirthdate" class="form-label">@lang('labels.dataNascimento')</label>
                            <input type="text" class="form-control" id="dependentBirthdate" placeholder="MM/DD/YYYY"
                                required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">@lang('labels.userTabaco')</label>
                            <div class="d-flex">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="dependentTobacco"
                                        id="dependentTobacco_no" value="no" required>
                                    <label class="form-check-label" for="dependentTobacco_no">@lang('labels.checkNo')</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="dependentTobacco"
                                        id="dependentTobacco_yes" value="yes" required>
                                    <label class="form-check-label" for="dependentTobacco_yes">@lang('labels.checkYes')</label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">@lang('labels.campoSexo')</label>
                            <div class="d-flex">
                                @foreach ($sexes as $id => $alias)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="dependentSex"
                                            id="dependentSex_{{ $alias }}" value="{{ $id }}" required>
                                        <label class="form-check-label"
                                            for="dependentSex_{{ $alias }}">@lang('labels.' . $alias)</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>


                        <div class="mb-3">
                            <label class="form-label">@lang('labels.householdRelacionamento'):</label>
                            <select class="form-select" name="relationshipPerson" id="relationshipPerson">
                                <option value="" selected>@lang('labels.campoSelecao')</option>
                                @foreach ($relationships as $key => $value)
                                    <option value="{{ $key }}">@lang('labels.' . $value)</option>
                                @endforeach
                            </select>
                        </div>

                        <button type="button" class="btn btn-primary" id="btnAddDependentToList">Adicionar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>



    {{-- teste --}}
    <div style="display: flex; justify-content: center; align-items: center; font-size: 2rem;" id="toggle-client-info"><i
            class="bi bi-caret-up"></i>
    </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                <div class="card-header pb-0">
                    <h4 class="card-title mg-b-0">@lang('labels.seguroSaude')</h4>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-wrap justify-content-center gap-2 gap-sm-3">
                    <button class="btn btn-outline-primary" id="btnMoreAccessible">@lang('labels.planoAcessivel')</button>
                    <button class="btn btn-outline-primary" id="btnPlanLessValue">@lang('labels.menorValor')</button>
                    <button class="btn btn-outline-primary" id="btnAllPlans">@lang('labels.allPlans')</button>
                    </div>
                </div>
                </div>
            </div>
        </div>


    <h3 id="tituloPlanoAcessivel" class="text-center mt-4" style="display:none;">@lang('labels.planosAcessiveis')</h3>
    <h3 id="tituloPlanoMenorValor" class="text-center mt-4" style="display:none;">@lang('labels.planosMenorValor')</h3>


    {{-- div de "NO - Savings --}}
    <div class="col-12 col-md-4 mx-auto" id="no-saving-msg" style="display: none;">
        <div class="card p-3">
            <h4 class="card-title mg-b-0 text-center">@lang('labels.probably')
                <hr class="border-bottom border-primary">
            </h4>
        </div>
    </div>


    <!-- Mensagem de Savings (quando estimateSub for maior que 0) -->
    <div class="col-12 col-md-4 mx-auto" id="savings-msg" style="display: none;">
        <div class="card p-3 text-center">
            <h4 class="card-title mg-b-0"
                style="font-size: 1.5rem; display: flex; justify-content: space-between; align-items: center;">
                <span>@lang('labels.savings'):</span>
                <span style="font-weight: bold; font-size: 1.8rem;">
                    <span id="savings-value"></span>
                    <small style="font-weight: normal; font-size: 1rem;">/mo</small>
                </span>
            </h4>
            <hr class="border-bottom border-primary">
        </div>
    </div>






    <!-- Modal para Mensagem "Nenhum Plano Encontrado" -->
    <div class="modal fade" id="noPlansModal" tabindex="-1" aria-labelledby="noPlansModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="noPlansModalLabel">@lang('labels.informacao')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @lang('labels.nenhumPlano').
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('labels.buttonFechar')</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Aviso de Planos Selecionados -->
    <div id="selected-plans-alert" class="alert alert-info d-none" role="alert">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div id="selected-plans-content">
                    <!-- Planos selecionados aparecerão aqui -->
                </div>
                <div>
                    <!-- Aqui os botões são agrupados em um div para alinhamento correto -->
                    <button id="compare-plans" class="btn btn-primary">@lang('labels.compare')</button>
                    <button id="close-alert" class="btn btn-secondary ms-2">@lang('labels.buttonFechar')</button>
                </div>
            </div>
        </div>
    </div>



    <!-- Modal de Comparação -->
    <div class="modal fade" id="compare-modal" tabindex="-1" aria-labelledby="compare-modal-label" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="compare-modal-label">@lang('labels.comparePlans')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    {{-- <button type="button" class="btn btn-primary" id="download-pdf">@lang('labels.downloadPdf')</button> --}}
                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle" type="button" id="download-pdf-button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-download me-2"></i>@lang('labels.downloadPdf') </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <button class="dropdown-item d-flex align-items-center download-pdf-language"
                                    data-language="en">
                                    <span class="avatar me-2 align-self-center bg-transparent">
                                        <img src="{{ asset('img/estados-unidos.png') }}" alt="English"
                                            style="width: 24px;">
                                    </span>
                                    <span>Download in English</span>
                                </button>
                            </li>
                            <li>
                                <button class="dropdown-item d-flex align-items-center download-pdf-language"
                                    data-language="pt">
                                    <span class="avatar me-2 align-self-center bg-transparent">
                                        <img src="{{ asset('img/brasil.png') }}" alt="Portuguese" style="width: 24px;">
                                    </span>
                                    <span>Baixar em Português</span>
                                </button>
                            </li>
                            <li>
                                <button class="dropdown-item d-flex align-items-center download-pdf-language"
                                    data-language="es">
                                    <span class="avatar me-2 align-self-center bg-transparent">
                                        <img src="{{ asset('img/espanha.png') }}" alt="spanish" style="width: 24px;">
                                    </span>
                                    <span>Descargar en español</span>
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table id="compare-datatable"
                            class="border-top-0 table table-bordered text-nowrap key-buttons border-bottom">
                            <thead>
                                <tr>
                                    <th class="border-bottom-0">@lang('labels.category')Categoria</th>
                                    <th class="border-bottom-0" id="plan-column-1">@lang('labels.plan') 1</th>
                                    <th class="border-bottom-0" id="plan-column-2">@lang('labels.plan') 2</th>
                                    <th class="border-bottom-0" id="plan-column-3" style="display:none;">
                                        @lang('labels.plan') 3</th>
                                </tr>
                            </thead>
                            <tbody id="compare-modal-body">
                                <!-- Comparação dos planos será inserida aqui pelo JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('labels.buttonFechar')</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Div para ícone de carregamento -->
    <div id="loading-indicator" style="display: none;" class="text-center mt-4">
        <!-- Ícone de carregamento (você pode customizar este ícone) -->
        <i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>
        <span class="sr-only">@lang('labels.carregandoPlanos')</span>
    </div>

    @if (isset($mostAccessible['ranges']))
        <div class="row mt-4">
            <div class="col-12 col-md-4" id="card-filters">
                <div class="card">
                    <div class="card-header pb-0">
                        <h4 class="card-title mg-b-0">@lang('labels.probably')</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="monthly-value" class="form-label">@lang('labels.monthValue'):</label>
                            <div class="d-flex align-items-center">
                                <input type="range" class="form-range me-2" id="monthly-value" min="0"
                                    max="{{ $mostAccessible['ranges']->premiums->max * 1.1 }}" step="1"
                                    value="{{ $mostAccessible['ranges']->premiums->max }}">
                                <div class="d-flex align-items-center">
                                    <span class="font-weight-bold me-1">$</span>
                                    <input type="number" class="form-control font-weight-bold" id="monthly-value-input"
                                        min="0" max="{{ $mostAccessible['ranges']->premiums->max * 1.1 }}"
                                        step="1" value="{{ $mostAccessible['ranges']->premiums->max }}"
                                        style="width: 80px;">
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="deductible" class="form-label">@lang('labels.franquia'):</label>
                            <div class="d-flex align-items-center">
                                <input type="range" class="form-range me-2" id="deductible" min="0"
                                    max="{{ $mostAccessible['ranges']->deductibles->max }}" step="10"
                                    value="0">
                                <div class="d-flex align-items-center">
                                    <span class="font-weight-bold me-1">$</span>
                                    <input type="number" class="form-control font-weight-bold" id="deductible-input"
                                        min="0" max="{{ $mostAccessible['ranges']->deductibles->max }}"
                                        step="10" value="0" style="width: 80px;">
                                </div>
                            </div>
                        </div>





                        <div class="mb-3">
                            <label class="form-label"><strong>@lang('labels.carriers'):</strong></label>
                            @foreach ($mostAccessible['facet_groups'][3]->facets as $filter)
                                <div class="form-check">
                                    <input class="form-check-input carrier-filter" type="checkbox"
                                        value="{{ $filter->value }}" id="carrier{{ Str::slug($filter->value) }}">
                                    <label class="form-check-label" for="carrier{{ Str::slug($filter->value) }}">
                                        {{ $filter->value }}
                                    </label>
                                </div>
                            @endforeach


                            <label class="form-label mt-3"><strong>@lang('labels.metalLevel'):</strong></label>
                            @php
                                // Obter os níveis de metal a partir do array de facetas
                                $facetGroups = $mostAccessible['facet_groups'] ?? [];
                                $metalLevels = [];

                                foreach ($facetGroups as $facetGroup) {
                                    if ($facetGroup->name === 'metalLevels') {
                                        $metalLevels = $facetGroup->facets;
                                        break;
                                    }
                                }
                            @endphp

                            @foreach ($metalLevels as $level)
                                <div class="form-check">
                                    <input class="form-check-input metal-filter" type="checkbox"
                                        value="{{ strtolower($level->value) }}" id="metal{{ $level->value }}">
                                    <label class="form-check-label" for="metal{{ $level->value }}">
                                        {{ $level->value }}
                                    </label>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
    @endif

    <!-- Código dos planos não é usado, apenas por causa da estrutura-->
    @if (isset($data['plans']) && !empty($data['plans']))
        <div class="col-12 col-md-8" id="all-plans" style="display: none;">
            @foreach ($data['plans'] as $plan)
                <div class="col-12 col-md-12 mb-3 plan-card" data-metal="{{ strtolower($plan->metal_level) }}"
                    data-plan-id="{{ $plan->id }}">
                    <div class="card">
                        <div class="card-body">
                            <div class="row d-flex align-items-center">
                                <div class="col-12 col-md-4 order-md-2">
                                    <div class="card p-3 text-center border border-primary">
                                        <p>@lang('labels.monthValue'): <span class="font-weight-bold monthly-value"
                                                style="font-size: 1.7rem;">
                                                ${{ number_format($plan->premium, 2, '.', ',') }}</span></p>
                                    </div>
                                </div>
                                <div class="col-12 col-md-8 order-md-1">
                                    <div class="d-flex align-items-center">
                                        <h3>{{ $plan->name }} - {{ $plan->type }}</h3>
                                    </div>
                                    <p>@lang('labels.by') <strong>{{ $plan->issuer->name }} - {{ $plan->type }}</strong>
                                    </p>
                                    <p>@lang('labels.franquia')-
                                        <strong class="deductible-value">
                                            @if ($counter == 1)
                                                {{ number_format($plan->deductibles[0]->amount, 2, '.', ',') }}
                                            @else
                                                @php $familyDeductibleFound = false; @endphp
                                                @foreach ($plan->deductibles as $deductible)
                                                    @if ($deductible->family_cost == 'Family')
                                                        {{ number_format($deductible->amount, 2, '.', ',') }}
                                                        @php $familyDeductibleFound = true; @endphp
                                                    @break
                                                @endif
                                            @endforeach
                                            @if (!$familyDeductibleFound)
                                                0
                                            @endif
                                        @endif
                                    </strong>
                                </p>
                                <p>
                                    <strong
                                        class="metal-level
                                        @if ($plan->metal_level == 'Gold') custom-bg bg-gold
                                        @elseif ($plan->metal_level == 'Silver') custom-bg bg-silver
                                        @elseif ($plan->metal_level == 'Bronze') custom-bg bg-bronze @endif">
                                        {{ $plan->metal_level }}
                                    </strong>
                                </p>
                                <ul>
                                    <li>@lang('labels.outOfPocket')::
                                        $@if ($counter == 1)
                                            {{ number_format($plan->moops[0]->amount, 2, '.', ',') }}
                                        @else
                                            @php $familyMoopFound = false; @endphp
                                            @foreach ($plan->moops as $moop)
                                                @if ($moop->family_cost == 'Family')
                                                    {{ number_format($moop->amount, 2, '.', ',') }}
                                                    @php $familyMoopFound = true; @endphp
                                                @break
                                            @endif
                                        @endforeach
                                        @if (!$familyMoopFound)
                                            0
                                        @endif
                                    @endif
                                </li>
                                <li>@lang('labels.especialistaVisits'):
                                    @php
                                        $specialistCost = null;
                                        foreach ($plan->benefits as $benefit) {
                                            if ($benefit->name == 'Specialist Visit') {
                                                foreach ($benefit->cost_sharings as $costSharing) {
                                                    if ($costSharing->network_tier == 'In-Network') {
                                                        if ($costSharing->display_string == 'No Charge') {
                                                            $specialistCost = 'Free';
                                                        } else {
                                                            $specialistCost = $costSharing->display_string;
                                                        }
                                                        break;
                                                    }
                                                }
                                                break;
                                            }
                                        }
                                        if (is_null($specialistCost)) {
                                            $specialistCost = '0';
                                        }
                                    @endphp
                                    {{ $specialistCost }}
                                </li>
                                <li>@lang('labels.consultaMedica'):
                                    @php
                                        $doctorCost = null;
                                        foreach ($plan->benefits as $benefit) {
                                            if ($benefit->name == 'Primary Care Visit to Treat an Injury or Illness') {
                                                foreach ($benefit->cost_sharings as $costSharing) {
                                                    if ($costSharing->network_tier == 'In-Network') {
                                                        if ($costSharing->display_string == 'No Charge') {
                                                            $doctorCost = 'Free';
                                                        } else {
                                                            $doctorCost = $costSharing->display_string;
                                                        }
                                                        break;
                                                    }
                                                }
                                                break;
                                            }
                                        }
                                        if (is_null($doctorCost)) {
                                            $doctorCost = '0';
                                        }
                                    @endphp
                                    {{ $doctorCost }}
                                </li>
                                <li>@lang('labels.medGenerico'):
                                    @php
                                        $drugCost = null;
                                        foreach ($plan->benefits as $benefit) {
                                            if ($benefit->name == 'Generic Drugs') {
                                                foreach ($benefit->cost_sharings as $costSharing) {
                                                    if ($costSharing->network_tier == 'In-Network') {
                                                        if ($costSharing->display_string == 'No Charge') {
                                                            $drugCost = 'Free';
                                                        } else {
                                                            $drugCost = $costSharing->display_string;
                                                        }
                                                        break;
                                                    }
                                                }
                                                break;
                                            }
                                        }
                                        if (is_null($drugCost)) {
                                            $drugCost = '0';
                                        }
                                    @endphp
                                    {{ $drugCost }}
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="stars">
                            @php
                                $rating = $plan->quality_rating->global_rating; // Classificação de 1 a 5
                            @endphp
                            @for ($i = 1; $i <= 5; $i++)
                                <span class="star {{ $i <= $rating ? 'filled' : '' }}">&#9733;</span>
                            @endfor
                        </div>
                    </div>
                    <div class="card-footer text-right d-flex justify-content-end align-items-center">
                        <input type="checkbox" id="compare-{{ $plan->id }}" class="me-2 compare-checkbox">
                        <label for="compare-{{ $plan->id }}">@lang('labels.compare')</label>
                        &nbsp;&nbsp;
                        <a href="{{ route('livewire.quotation-detail', ['application_id' => $application_id, 'plan_id' => $plan->id, 'premium' => $plan->premium]) }}"
                            class="btn btn-primary ms-3 me-2">@lang('labels.detalhes')</a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <!-- Contêiner de Paginação -->
    <div id="pagination-container" class="col-12 col-md-8 text-center mt-2 d-flex justify-content-between">
        <button id="prev-page" class="btn btn-secondary"></button>
        <div id="pagination-controls" class="d-inline-flex"></div>
        <button id="next-page" class="btn btn-secondary"></button>
    </div>
</div>
@else
<div class="col-12 col-md-8" id="all-plans" style="display: none;">
    <p class="text-center mt-5">@lang('labels.name')Nenhum plano encontrado.</p>
</div>
@endif

<!-- Plano Mais Acessível -->
<div class="col-12 col-md-8" id="plan-accessible" style="display:none;">
<div class="col-12 col-md-12 mb-3 plan-card" data-metal="" data-plan-id="">
    <div class="card">
        <div class="card-body">
            <div class="row d-flex align-items-center">
                <div class="col-12 col-md-4 order-md-2">
                    <div class="card p-3 text-center border border-primary">
                        <p>@lang('labels.monthValue'): <span class="font-weight-bold monthly-value"
                                style="font-size: 1.7rem;"></span></p>
                        <p class="was-value" display="none">Was:</p>
                    </div>
                </div>
                <div class="col-12 col-md-8 order-md-1">
                    <div class="d-flex align-items-center">
                        <img src="" alt="Issuer Logo" class="issuer-logo me-2"
                            style="width: 100px; height: auto;">
                        <h3 class="plan-name"></h3>
                    </div>
                    <p>@lang('labels.by') <strong class="issuer-name"></strong></p>
                    <p>
                        @lang('labels.franquia')-
                        <strong class="deductible-value"></strong>
                        <span class="per-person-value"
                            style="font-size: 0.8em; color: #666; margin-left: 5px;"></span>
                    </p>
                    <p>
                        <strong class="metal-level"></strong>
                    </p>
                    <ul>
                        <li>@lang('labels.outOfPocket'): <span class="moop-value" id="moop-value"></span></li>
                        <li>@lang('labels.especialistaVisits'): <span class="specialist-cost"></span></li>
                        <li>@lang('labels.consultaMedica'): <span class="doctor-cost"></span></li>
                        <li>@lang('labels.medGenerico'): <span class="drug-cost"></span></li>
                    </ul>
                </div>
            </div>
            <div class="mt-3">
                <div class="stars"></div>
            </div>
            <div class="card-footer text-right d-flex justify-content-end align-items-center">
                <a href="#" class="btn btn-primary ms-3 me-2 plan-details">@lang('labels.detalhes')</a>
            </div>
        </div>
    </div>
</div>
</div>

<!-- Plano Menor Valor -->
<div class="col-12 col-md-8" id="plan-less-value" style="display:none;">
<div class="col-12 col-md-12 mb-3 plan-card" data-metal="" data-plan-id="">
    <div class="card">
        <div class="card-body">
            <div class="row d-flex align-items-center">
                <div class="col-12 col-md-4 order-md-2">
                    <div class="card p-3 text-center border border-primary">
                        <p>@lang('labels.monthValue'): <span class="font-weight-bold monthly-value"
                                style="font-size: 1.7rem;"></span></p>
                        <p class="was-value" display="none">Was:</p>
                    </div>
                </div>
                <div class="col-12 col-md-8 order-md-1">
                    <div class="d-flex align-items-center">
                        <img src="" alt="Issuer Logo" class="issuer-logo me-2"
                            style="width: 100px; height: auto;">
                        <h3 class="plan-name"></h3>
                    </div>
                    <p>@lang('labels.by') <strong class="issuer-name"></strong></p>
                    <p>
                        @lang('labels.franquia')-
                        <strong class="deductible-value"></strong>
                        <span class="per-person-value"
                            style="font-size: 0.8em; color: #666; margin-left: 5px;"></span>
                    </p>
                    <p>
                        <strong class="metal-level"></strong>
                    </p>
                    <ul>
                        <li>@lang('labels.outOfPocket'): <span class="moop-value" id="moop-value"></span></li>
                        <li>@lang('labels.especialistaVisits'): <span class="specialist-cost"></span></li>
                        <li>@lang('labels.consultaMedica'): <span class="doctor-cost"></span></li>
                        <li>@lang('labels.medGenerico'): <span class="drug-cost"></span></li>
                    </ul>
                </div>
            </div>
            <div class="mt-3">
                <div class="stars"></div>
            </div>
            <div class="card-footer text-right d-flex justify-content-end align-items-center">
                <a href="#" class="btn btn-primary ms-3 me-2 plan-details">@lang('labels.detalhes')</a>
            </div>
        </div>
    </div>
</div>
</div>









{{-- @dd($data['plans']); --}}
{{-- dd($data['plans']); --}}



</div>
@endsection



@php
    $member = $data['application']['householdMembers'][0] ?? 0;
    $householdSize = count($data['application']['householdMembers']); // Calcula o número de membros no PHP
    $estimates = $data['estimate'][0]->aptc ?? 0;
    $estimateSub = $data['estimateSub'];

@endphp
@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>


<!-- Importar html2canvas primeiro -->
<script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>

<!-- Depois importar jsPDF -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/dompurify/2.4.0/purify.min.js"></script>
<!-- Inclua o SweetAlert2 CSS e JS -->
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



<script>
    @php
        $isEmpty = empty($mostAccessible) || !isset($mostAccessible['ranges']) || empty($mostAccessible['plans']);
        //dd($isEmpty);
    @endphp

    // Convertendo a variável PHP para JavaScript
    const isEmpty = @json($isEmpty);

    // Se o array estiver vazio, mostrar o SweetAlert
    if (isEmpty) {
        Swal.fire({
            title: 'Erro!',
            text: 'Nenhum plano encontrado.',
            icon: 'error',
            confirmButtonText: 'OK'
        })
        // .then((result) => {
        //     if (result.isConfirmed) {
        //         window.location.href = '{{ route('index') }}'; // Redirecionar para a página inicial
        //     }
        //});
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Definição de variáveis e elementos
        const toggleClientInfo = document.getElementById('toggle-client-info');
        const clientInfoCards = document.getElementById('client-info-cards');
        const monthlyValueRange = document.getElementById('monthly-value');
        const monthlyValueInput = document.getElementById('monthly-value-input');
        const deductibleInput = document.getElementById('deductible-input');

        //const monthlyValueDisplay = document.getElementById('monthly-value-display');
        const deductibleRange = document.getElementById('deductible');
        //const deductibleDisplay = document.getElementById('deductible-display');
        const carrierCheckboxes = document.querySelectorAll('.carrier-filter');
        const metalCheckboxes = document.querySelectorAll('.metal-filter');
        const btnMoreAccessible = document.getElementById('btnMoreAccessible');
        const btnAllPlans = document.getElementById('btnAllPlans');
        const btnPlanLessValue = document.getElementById('btnPlanLessValue');
        const cardFilters = document.getElementById('card-filters');
        const tituloPlanoAcessivel = document.getElementById('tituloPlanoAcessivel');
        const tituloPlanoMenorValor = document.getElementById('tituloPlanoMenorValor');
        const planAccessibleContainer = document.getElementById('plan-accessible');
        const planLessValueContainer = document.getElementById('plan-less-value');
        const allPlansContainer = document.getElementById('all-plans');
        const paginationControls = document.getElementById('pagination-controls');
        const paginationContainer = document.getElementById('pagination-container');
        const btnPrevPage = document.getElementById('prev-page');
        const btnNextPage = document.getElementById('next-page');


        // Novas referências para a div de savings e no-savings
        const savingsMsg = document.getElementById('savings-msg'); // Nova div de savings
        const savingsValue = document.getElementById(
            'savings-value'); // Span onde o valor do savings será mostrado
        const noSavingMsg = document.getElementById('no-saving-msg');


        let currentPage = 1;
        const applicationId = '{{ $application_id }}';
        let loading = false;
        let totalPlans = 0;
        const itemsPerPage = 10;
        let allPlans = [];
        let plansLoaded = false; // Marcar se os planos já foram carregados
        const mostAccessiblePlan = @json($mostAccessible['plans'][0] ?? null);
        const lessValuePlan = @json($data['plans'][0] ?? null);
        const householdSize = {{ $householdSize }};
        const hasMec = @json($hasMec);
        const estimateSub = @json($estimateSub) || 0;
        const estimates = @json($estimates) || 0;
        console.log("estimateSub:", estimateSub);
        console.log("estimates:", estimates);

        //const hasMec = [false, false, false, false];



        console.log(hasMec);
        // Atualizar o valor exibido quando o usuário arrasta o controle de faixa
        monthlyValueRange.addEventListener('input', function() {
            const value = monthlyValueRange.value;
            monthlyValueInput.value = value;
        });

        monthlyValueInput.addEventListener('input', function() {
            const value = monthlyValueInput.value;
            monthlyValueRange.value = value;
        });

        // Sincronizar slider com campo de entrada para Deductible
        deductibleRange.addEventListener('input', function() {
            const value = deductibleRange.value;
            deductibleInput.value = value;
        });

        deductibleInput.addEventListener('input', function() {
            const value = deductibleInput.value;
            deductibleRange.value = value;
        });

        // Função debounce para limitar a frequência das requisições, garantindo que a última requisição seja feita
        function debounce(func, delay) {
            let debounceTimer;
            return function(...args) {
                clearTimeout(debounceTimer); // Limpa o timer anterior
                debounceTimer = setTimeout(() => {
                    func.apply(this, args); // Executa a função após o atraso
                }, delay);
            };
        }

        // Função fetchFilteredPlans com debounce para evitar requisições excessivas
        const debouncedFetchFilteredPlans = debounce(fetchFilteredPlans, 500);

        // Função para desabilitar ou habilitar os checkboxes de filtros e sliders
        function toggleFilterCheckboxes(state) {
            const carrierCheckboxes = document.querySelectorAll('.carrier-filter');
            const metalCheckboxes = document.querySelectorAll('.metal-filter');
            const allCheckboxes = [...carrierCheckboxes, ...
                metalCheckboxes
            ]; // Combina os checkboxes de todos os filtros

            const monthlyValueSlider = document.getElementById(
                'monthly-value'); // Controle de faixa do valor mensal
            const deductibleSlider = document.getElementById('deductible'); // Controle de faixa do deductible

            // Desabilita/habilita os checkboxes
            allCheckboxes.forEach(checkbox => {
                checkbox.disabled = state; // Define o estado de "disabled" conforme o valor de `state`
            });

            // Desabilita/habilita os sliders
            if (monthlyValueSlider) monthlyValueSlider.disabled = state;
            if (monthlyValueInput) monthlyValueInput.disabled = state;
            if (deductibleSlider) deductibleSlider.disabled = state;
            if (deductibleInput) deductibleInput.disabled = state;
        }




        // Função fetchFilteredPlans com debounce para evitar requisições excessivas
        let totalPages = 0;

        function fetchFilteredPlans(page = 1) {
            return new Promise((resolve, reject) => {
                console.log('fetchFilteredPlans chamada com página:', page); // Log de depuração

                if (loading) {
                    console.log("A requisição já está em andamento, evitando nova requisição...");
                    return;
                }

                loading = true;
                toggleLoadingIndicator(true);
                toggleFilterCheckboxes(true);

                currentPage = page;

                const maxMonthlyValue = parseFloat(monthlyValueRange.value);
                const maxDeductibleValue = parseFloat(deductibleRange.value);
                const {
                    selectedCarriers,
                    selectedMetals
                } = getSelectedFilters();

                console.log('Filtros aplicados:', {
                    premium: maxMonthlyValue,
                    deductible: maxDeductibleValue,
                    issuers: selectedCarriers,
                    metal_level: selectedMetals
                });

                const filterData = {
                    premium: maxMonthlyValue,
                    deductible: maxDeductibleValue,
                    issuers: selectedCarriers,
                    metal_level: selectedMetals,
                    hasMec: hasMec,
                    ranges: {
                        premiums: {
                            min: 0,
                            max: maxMonthlyValue
                        },
                        deductibles: {
                            min: 0,
                            max: maxDeductibleValue
                        }
                    },
                };

                const csrf_token = '{{ csrf_token() }}';

                $.ajax({
                    url: `/plans/search/${applicationId}/${currentPage}`,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrf_token
                    },
                    data: JSON.stringify(filterData),
                    contentType: 'application/json',
                    success: function(response) {
                        console.log('Resposta recebida:', response);
                        if (response.status === 'success') {
                            if (response.data.plans && response.data.plans.length > 0) {
                                allPlans = response.data.plans;
                                totalPlans = response.data.total;
                                totalPages = Math.ceil(totalPlans / itemsPerPage);
                                renderPlans(allPlans);
                            } else {
                                allPlans = [];
                                totalPlans = 0;
                                totalPages = 0;
                                renderPlans(allPlans);
                            }
                            updatePaginationControls();
                            plansLoaded = true;
                        } else {
                            console.error('Erro ao buscar planos:', response.message);
                        }
                        loading = false;
                        toggleLoadingIndicator(false);
                        resolve();
                        toggleFilterCheckboxes(false);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('Erro na requisição:', errorThrown);
                        loading = false;
                        toggleLoadingIndicator(false);
                        toggleFilterCheckboxes(false);
                        reject(errorThrown);
                    }
                });
            });
        }

        // Função para mostrar/esconder o indicador de carregamento
        function toggleLoadingIndicator(show) {
            const loadingElement = document.getElementById('loading-indicator');
            if (loadingElement) {
                loadingElement.style.display = show ? 'block' : 'none';
            }
        }

        function updatePaginationButtons() {
            const totalPages = Math.ceil(totalPlans / itemsPerPage);
            btnPrevPage.disabled = currentPage <= 1;
            btnNextPage.disabled = currentPage >= totalPages;
            paginationContainer.style.display = totalPages > 1 ? 'flex' : 'none';
        }


        // Verifique se o elemento foi encontrado antes de adicionar o listener
        if (btnPrevPage) {
            btnPrevPage.addEventListener('click', function() {
                if (currentPage > 1) {
                    currentPage--;
                    fetchFilteredPlans(currentPage);
                }
            });
        } else {
            console.error('O botão prev-page não foi encontrado no DOM.');
        }

        if (btnNextPage) {
            btnNextPage.addEventListener('click', function() {
                const totalPages = Math.ceil(totalPlans / itemsPerPage);
                if (currentPage < totalPages) {
                    currentPage++;
                    fetchFilteredPlans(currentPage);
                }
            });
        } else {
            console.error('O botão btnNextPage não foi encontrado no DOM.');
        }

        // Função renderPlans ajustada
        function renderPlans(plans) {
            const plansContainer = document.getElementById('all-plans');
            plansContainer.innerHTML = '';

            const householdSize = {{ $householdSize ?? 1 }};


            if (plans.length === 0) {
                $('#noPlansModal').modal('show');
                return;
            }

            plans.forEach(plan => {
                const applicationId = '{{ $application_id }}';
                const planDetailsUrl =
                    `/quotation-detail/${applicationId}/${plan.id}/${month_value_final(plan).replace('$', '').replace(/,/g, '').trim()}`;

                var planCard = `
        <div class="col-12 col-md-12 mb-3 plan-card" data-metal="${plan.metal_level.toLowerCase()}" data-plan-id="${plan.id}">
            <div class="card">
                <div class="card-body">
                    <div class="row d-flex align-items-center">
                        <div class="col-12 col-md-4 order-md-2">
                            <div class="card p-3 text-center border border-primary">
                                <p>@lang('labels.monthValue'): <span class="font-weight-bold monthly-value" style="font-size: 1.7rem;">${month_value_final(plan)}</span></p>
                                <p class="was-value" style="display:none">Was ${formatCurrency(valueWas(plan))}</p>
                            </div>
                        </div>
                        <div class="col-12 col-md-8 order-md-1">
                            <div class="d-flex align-items-center">
                                <img src="" alt="Issuer Logo" class="issuer-logo me-2" style="width: 100px; height: auto;">
                                <h3>${plan.name} - ${plan.type}</h3>
                            </div>
                            <p>@lang('labels.by') <strong>${plan.issuer.name}</strong></p>      
                            <p>
                                @lang('labels.franquia')- 
                                <strong class="deductible-value">${calculateDeductible(plan)}</strong>
                                <span class="per-person-value" style="font-size: 0.8em; color: #666; margin-left: 5px;">
                                    ($${(calculateDeductible(plan).replace(/[^\d.-]/g, '') / householdSize).toFixed(2)}/@lang('labels.person'))
                                </span>
                            </p>                       
                            <p><strong class="metal-level ${getMetalLevelClass(plan.metal_level)}">${plan.metal_level}</strong></p>
                            <ul>
                                <li>@lang('labels.outOfPocket'): ${calculateMoop(plan)}</li>
                                <li>@lang('labels.especialistaVisits'): ${getSpecialistCost(plan)}</li>
                                <li>@lang('labels.consultaMedica'): ${getDoctorCost(plan)}</li>
                                <li>@lang('labels.medGenerico'): ${getDrugCost(plan)}</li>
                            </ul>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="stars">
                            ${renderStars(plan.quality_rating ? plan.quality_rating.global_rating : 0)}
                        </div>
                    </div>
                    <div class="card-footer text-right d-flex justify-content-end align-items-center">
                        <input type="checkbox" id="compare-${plan.id}" class="me-2 compare-checkbox" onchange="handlePlanSelection(this, '${plan.id}')">
                        <label for="compare-${plan.id}">@lang('labels.compare')</label>
                        &nbsp;&nbsp;
                        <a href="${planDetailsUrl}" class="btn btn-primary ms-3 me-2">@lang('labels.detalhes')</a>
                    </div>
                </div>
            </div>
        </div>
        `;

                plansContainer.insertAdjacentHTML('beforeend', planCard);

                const logoElement = plansContainer.querySelector(
                    `[data-plan-id="${plan.id}"] .issuer-logo`);
                if (logoElement) {
                    updateIssuerLogo(plan.issuer.name, logoElement);
                }

                const planElement = plansContainer.querySelector(`[data-plan-id="${plan.id}"]`);
                const wasValue = planElement.querySelector('.was-value');

                if (estimateSub > 0) {
                    wasValue.style.display = 'block';
                } else {
                    wasValue.style.display = 'none';
                }
            });

            var paginationHtml = '<div class="pagination-container">';
            for (let i = 1; i <= totalPages; i++) {
                paginationHtml +=
                    `<button class="btn ${i === currentPage ? 'btn-primary' : 'btn-secondary'}" data-page="${i}">${i}</button>`;
            }
            paginationHtml += '</div>';
            plansContainer.insertAdjacentHTML('beforeend', paginationHtml);

            document.querySelectorAll('.pagination-container button').forEach(button => {
                button.addEventListener('click', function() {
                    const page = parseInt(this.getAttribute('data-page'), 10);
                    if (page !== currentPage) {
                        currentPage = page;
                        fetchFilteredPlans(currentPage);
                    }
                });
            });

            updatePaginationButtons();
            attachCompareEventListeners();

            checkPaginationVisibility();
        }

        function checkPaginationVisibility() {
            const paginationContainer = document.querySelector('.pagination-container');
            if (!paginationContainer) {
                console.warn('Pagination container not found.');
                return;
            }

            const scrollTop = window.scrollY || document.documentElement.scrollTop;
            const windowHeight = window.innerHeight;
            const documentHeight = document.documentElement.scrollHeight;

            if (scrollTop + windowHeight >= documentHeight - 100) {
                paginationContainer.style.display = 'flex';
            } else {
                paginationContainer.style.display = 'none';
            }
        }

        window.addEventListener('scroll', checkPaginationVisibility);





        function updatePaginationControls() {
            const totalPages = Math.ceil(totalPlans / itemsPerPage);
            let paginationHtml = '';

            for (let i = 1; i <= totalPages; i++) {
                paginationHtml +=
                    `<button class="btn ${i === currentPage ? 'btn-primary' : 'btn-secondary'}" data-page="${i}">${i}</button>`;
            }

            paginationControls.innerHTML = paginationHtml;

            // Adiciona eventos de clique aos botões de paginação após atualizar o HTML
            document.querySelectorAll('#pagination-controls button').forEach(button => {
                button.addEventListener('click', function() {
                    const page = parseInt(this.getAttribute('data-page'),
                        10); // Converte o atributo para inteiro
                    if (page !== currentPage) {
                        fetchFilteredPlans(page); // Chama a função com a página correta
                    }
                });
            });

            btnPrevPage.disabled = currentPage <= 1;
            btnNextPage.disabled = currentPage >= totalPages;
            paginationContainer.style.display = totalPages > 1 ? 'flex' : 'none';
        }


        // Eventos para os filtros
        // Captura eventos de alteração no range (barra deslizante)
        monthlyValueRange.addEventListener('input', function() {
            const finalValue = monthlyValueRange.value; // Valor final do slider
            console.log("Valor da barra atualizado:", finalValue); // Exibe o valor final do slider
            currentPage = 1; // Reseta para a primeira página
            monthlyValueRange.value = finalValue;
            debouncedFetchFilteredPlans(); // Chama a função de requisição com debounce
        });

        monthlyValueInput.addEventListener('input', function() {
            const value = monthlyValueInput.value;
            monthlyValueRange.value = value;
            debouncedFetchFilteredPlans(); // Executa a busca ao editar o valor no campo de entrada
        });


        deductibleRange.addEventListener('input', function() {
            const finalValue = deductibleRange.value; // Valor final do slider
            console.log("Valor da barra atualizado:", finalValue); // Exibe o valor final do slider
            deductibleRange.value = finalValue;
            currentPage = 1; // Reseta para a primeira página
            debouncedFetchFilteredPlans(); // Chama a função de requisição com debounce
        });

        deductibleInput.addEventListener('input', function() {
            const value = deductibleInput.value;
            deductibleRange.value = value;
            debouncedFetchFilteredPlans(); // Executa a busca ao editar o valor no campo de entrada
        });


        // Função para capturar os filtros atualizados dos checkboxes
        function getSelectedFilters() {
            const selectedCarriers = Array.from(carrierCheckboxes)
                .filter(cb => cb.checked)
                .map(cb => cb.value);

            const selectedMetals = Array.from(metalCheckboxes)
                .filter(cb => cb.checked)
                .map(cb => cb.value.charAt(0).toUpperCase() + cb.value.slice(1).toLowerCase());

            console.log("Filtros de carriers aplicados:", selectedCarriers);
            console.log("Filtros de metais aplicados:", selectedMetals);

            return {
                selectedCarriers,
                selectedMetals
            };
        }

        // Atualize os filtros a cada vez que um checkbox for alterado
        carrierCheckboxes.forEach(cb => cb.addEventListener('change', function() {
            currentPage = 1; // Reseta para a primeira página ao modificar filtros
            debouncedFetchFilteredPlans(); // Chama a função de requisição com debounce
        }));

        metalCheckboxes.forEach(cb => cb.addEventListener('change', function() {
            currentPage = 1; // Reseta para a primeira página ao modificar filtros
            debouncedFetchFilteredPlans(); // Chama a função de requisição com debounce
        }));

        // Inicialização inicial
        fetchFilteredPlans();



        let selectedPlans = [];
        const compareModalBody = document.getElementById('compare-modal-body');
        if (!compareModalBody) {
            console.error('Elemento compareModalBody não encontrado.');
            return;
        }
        const downloadPdfButton = document.getElementById('download-pdf');
        const compareModal = new bootstrap.Modal(document.getElementById('compare-modal'));

        function attachCompareEventListeners() {
            const compareCheckboxes = document.querySelectorAll('.compare-checkbox');
            const selectedPlansAlert = document.getElementById('selected-plans-alert');
            const selectedPlansContent = document.getElementById('selected-plans-content');
            const closeAlertButton = document.getElementById('close-alert');

            // Botão para fechar o alerta e limpar seleção
            if (closeAlertButton) {
                closeAlertButton.addEventListener('click', function() {
                    selectedPlansAlert.classList.add('d-none');
                    selectedPlans = [];
                    compareCheckboxes.forEach(checkbox => checkbox.checked = false);
                });
            }

            // Para cada checkbox de plano
            compareCheckboxes.forEach(checkbox => {
                // Remove o atributo onchange do HTML se existir
                checkbox.removeAttribute('onchange');

                // Adiciona o evento via JavaScript
                checkbox.addEventListener('change', function() {
                    const planCard = this.closest('.plan-card');
                    const planId = planCard.getAttribute('data-plan-id');

                    // Encontrar o plano completo nos dados atuais
                    const selectedPlanData = allPlans.find(plan => plan.id === planId);

                    if (this.checked) {
                        if (selectedPlans.length < 3) {
                            // Armazenar o plano completo com todos os detalhes necessários
                            const planInfo = {
                                planId,
                                planName: planCard.querySelector('h3').textContent,
                                planValue: planCard.querySelector('.monthly-value')
                                    .textContent,
                                page: currentPage,
                                planDetails: selectedPlanData
                            };

                            selectedPlans.push(planInfo);
                            console.log('Plano adicionado:', planInfo);
                        } else {
                            this.checked = false;
                            Swal.fire('Aviso',
                                'Você pode selecionar no máximo 3 planos para comparar.',
                                'warning');
                        }
                    } else {
                        selectedPlans = selectedPlans.filter(plan => plan.planId !== planId);
                        console.log('Plano removido. Planos restantes:', selectedPlans);
                    }

                    updateSelectedPlansAlert(selectedPlans);
                });
            });
        }

        function updateSelectedPlansAlert(selectedPlans) {
            const selectedPlansAlert = document.getElementById('selected-plans-alert');
            const selectedPlansContent = document.getElementById('selected-plans-content');

            // Mostra o alerta com planos selecionados
            if (selectedPlans.length > 0) {
                selectedPlansContent.innerHTML = selectedPlans.map(plan => `
            <div class="alert alert-secondary d-flex justify-content-between align-items-center plan-alert">
                <span>${plan.planName} - ${plan.planValue}</span>
                <button class="btn-close" data-plan-id="${plan.planId}"></button>
            </div>
        `).join('');
                selectedPlansAlert.classList.remove('d-none');
            } else {
                selectedPlansAlert.classList.add('d-none');
            }
        }



        function handleCompareClick() {
            console.log('Iniciando comparação com planos:', selectedPlans);

            if (selectedPlans.length === 0) {
                Swal.fire('@lang('labels.warningSelect')', 'warning');
                return;
            }

            Swal.fire({
                title: '@lang('labels.prepareCompare')...',
                text: '@lang('labels.comparePlansModal')...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Pequeno timeout para garantir que o loading seja exibido
            setTimeout(() => {
                try {
                    fetchPlanDetails(selectedPlans);
                    Swal.close();
                    compareModal.show();
                } catch (error) {
                    console.error('Erro na comparação:', error);
                    Swal.fire('Erro', 'Ocorreu um erro ao comparar os planos', 'error');
                }
            }, 500);
        }



        const compareButton = document.getElementById('compare-plans');
        compareButton.removeEventListener('click', handleCompareClick); // Remove o evento existente
        compareButton.addEventListener('click', handleCompareClick); // Anexa o evento novamente





        function updateSelectedPlansAlert(selectedPlans) {
            const selectedPlansAlert = document.getElementById('selected-plans-alert');
            const selectedPlansContent = document.getElementById('selected-plans-content');

            if (selectedPlans.length > 0) {
                selectedPlansContent.innerHTML = selectedPlans.map(plan =>
                    `<div class="alert alert-secondary d-flex justify-content-between align-items-center plan-alert">
                <span>${plan.planName.split(' ').slice(0, 2).join(' ')} - ${plan.planValue}</span>
                <button class="btn-close" data-plan-id="${plan.planId}"></button>
            </div>`
                ).join('');

                selectedPlansAlert.classList.remove('d-none');
            } else {
                selectedPlansAlert.classList.add('d-none');
            }

            // Reanexa eventos de remoção ao botão de fechamento
            document.querySelectorAll('.btn-close').forEach(button => {
                button.addEventListener('click', function() {
                    const planId = this.getAttribute('data-plan-id');
                    removePlanFromSelection(planId); // Chama a função de remoção do plano
                });
            });
        }

        // Função para remover um plano da seleção e atualizar o alerta
        function removePlanFromSelection(planId) {
            // Remove o plano de `selectedPlans`
            selectedPlans = selectedPlans.filter(plan => plan.planId !== planId);
            console.log('Planos selecionados após remoção:', selectedPlans); // Log para depuração

            // Atualiza o alerta de planos selecionados
            updateSelectedPlansAlert(selectedPlans);

            // Desmarca o checkbox correspondente
            const checkbox = document.getElementById(`compare-${planId}`);
            if (checkbox) {
                checkbox.checked = false;
            }
        }





        //downloadPdfButton.addEventListener('click', handleDownloadPdf);


        function showLoadingInTable(categories, plan1, plan2 = null, plan3 = null) {
            console.log('showLoadingInTable chamado com:', {
                plan1,
                plan2,
                plan3
            });
            const compareModalBody = document.querySelector('#compare-datatable tbody');
            compareModalBody.innerHTML = ''; // Limpa a tabela antes de adicionar a mensagem de carregamento

            // Preenche a tabela com a mensagem de "Loading..." para cada categoria
            categories.forEach(category => {
                let rowHTML = `
            <tr>
                <td>${category}</td>
                <td>${plan1 ? 'Loading...' : '-'}</td>
        `;

                // Se plan2 existir, adiciona uma célula de "Loading...", caso contrário, adicione "-"
                rowHTML += plan2 ? `<td>Loading...</td>` : `<td>-</td>`;

                // Se plan3 existir, adiciona uma célula de "Loading...", caso contrário, adicione "-"
                rowHTML += plan3 ? `<td>Loading...</td>` : '';

                rowHTML += `</tr>`;
                compareModalBody.innerHTML += rowHTML;
            });
        }


        function preparePayloadForPdf(selectedPlans) {
            // Mapeia os dados dos planos selecionados com as chaves identificáveis
            const plansPayload = selectedPlans.map(plan => ({
                id: plan.planId, // ID do plano
                page: plan.page, // Página do plano
            }));

            return {
                plans: plansPayload,
                language: 'en',
                application_id: parseInt('{{ $application_id }}') // ID da aplicação
            };
        }




        function hideLoadingAndFillTable(plan1Values, plan2Values, plan3Values, categories) {
            console.log('hideLoadingAndFillTable chamado com:', {
                plan1Values,
                plan2Values,
                plan3Values
            });
            const compareModalBody = document.querySelector('#compare-datatable tbody');
            compareModalBody.innerHTML = ''; // Limpa a tabela para preencher com os dados reais

            categories.forEach((category, index) => {
                const plan1Value = plan1Values ? plan1Values[index] : '-';
                const plan2Value = plan2Values ? plan2Values[index] : '-';
                const plan3Value = plan3Values ? plan3Values[index] : '-';

                let rowHTML = `
            <tr>
                <td>${category}</td>
                <td>${plan1Value}</td>
                <td>${plan2Value}</td>
        `;

                if (plan3Values) {
                    rowHTML += `<td>${plan3Value}</td>`;
                }

                rowHTML += `</tr>`;
                compareModalBody.innerHTML += rowHTML;
            });
        }





        // Função para atualizar a exibição dos planos selecionados na modal de comparação
        function updateComparisonModal() {
            const compareModalBody = document.getElementById('compare-modal-body');
            compareModalBody.innerHTML = ''; // Limpar conteúdo existente

            if (selectedPlanIds.length === 0) {
                compareModalBody.innerHTML = '<p>Nenhum plano selecionado.</p>';
                return;
            }

            selectedPlanIds.forEach(planId => {
                // Aqui você pode adicionar lógica para buscar os detalhes do plano pelo ID e exibi-los na modal
                compareModalBody.insertAdjacentHTML('beforeend', `<p>Plano ID: ${planId}</p>`);
            });
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

        function getMetalLevelClass(metalLevel) {
            switch (metalLevel) {
                case 'Gold':
                    return 'custom-bg bg-gold';
                case 'Silver':
                    return 'custom-bg bg-silver';
                case 'Bronze':
                    return 'custom-bg bg-bronze';
                case 'Platinum':
                    return 'custom-bg bg-platinum';
                case 'Catastrophic':
                    return 'custom-bg bg-catastrophic';
                default:
                    return '';
            }
        }


        function renderStars(rating) {
            let starsHtml = '';
            for (let i = 1; i <= 5; i++) {
                starsHtml += `<span class="star ${i <= rating ? 'filled' : ''}">★</span>`;
            }
            return starsHtml;
        }



        function getSpecialistCost(plan) {
            for (var i = 0; i < plan.benefits.length; i++) {
                if (plan.benefits[i].name === 'Specialist Visit') {
                    for (var j = 0; j < plan.benefits[i].cost_sharings.length; j++) {
                        if (plan.benefits[i].cost_sharings[j].network_tier === 'In-Network') {
                            return plan.benefits[i].cost_sharings[j].display_string === 'No Charge' ?
                                'Free' :
                                plan.benefits[i].cost_sharings[j].display_string;
                        }
                    }
                    break;
                }
            }
            return '0';
        }

        function month_value_final(plan) {
            // Calcular o estimateNew com base nos valores setados anteriormente
            const estimateNew = estimateSub - estimates;

            // Calcular o valor mensal final
            const finalMonthlyValue = plan.premium_w_credit - estimateNew;

            // Retornar o valor final formatado como moeda
            return formatCurrency(finalMonthlyValue);

        };


        function valueWas(plan) { // was
            // Inicializar a variável finalMonthlyValue fora dos blocos if/else
            let finalMonthlyValue;

            finalMonthlyValue = plan.premium

            // Retornar o valor final formatado como moeda
            return finalMonthlyValue;
        }




        function getDoctorCost(plan) {
            for (var i = 0; i < plan.benefits.length; i++) {
                if (plan.benefits[i].name === 'Primary Care Visit to Treat an Injury or Illness') {
                    for (var j = 0; j < plan.benefits[i].cost_sharings.length; j++) {
                        if (plan.benefits[i].cost_sharings[j].network_tier === 'In-Network') {
                            return plan.benefits[i].cost_sharings[j].display_string === 'No Charge' ?
                                'Free' :
                                plan.benefits[i].cost_sharings[j].display_string;
                        }
                    }
                    break;
                }
            }
            return '0';
        }

        function getDrugCost(plan) {
            if (plan.benefits) {
                for (const benefit of plan.benefits) {
                    if (benefit.name === 'Generic Drugs') { // Verifica se o nome do benefício é 'Generic Drugs'
                        for (const costSharing of benefit.cost_sharings) {
                            if (costSharing.network_tier ===
                                'In-Network') { // Verifica se o custo compartilhado é da rede interna
                                return costSharing.display_string === 'No Charge' ? 'Free' : costSharing
                                    .display_string;
                            }
                        }
                    }
                }
            }
            return 'N/A'; // Retorna 'N/A' se não encontrar o custo de medicamentos genéricos
        }



        if (toggleClientInfo && clientInfoCards) {
            toggleClientInfo.addEventListener('click', function() {
                clientInfoCards.classList.toggle('hidden-card');
                this.querySelector('i').classList.toggle('bi-caret-up');
                this.querySelector('i').classList.toggle('bi-caret-down');
            });
        }

        // Função para exibir o plano acessível por padrão
        function showAccessiblePlan() {
            planAccessibleContainer.style.display = 'block'; // Mostrar o card de plano acessível
            allPlansContainer.style.display = 'none'; // Esconder o container de todos os planos
            cardFilters.style.display = 'none'; // Esconder os filtros
            planLessValueContainer.style.display = 'none'; // Esconder o card de "Menor Valor"
            tituloPlanoAcessivel.style.display = 'block'; // Mostrar o título do plano acessível
            noSavingMsg.style.display = 'block'; // Mostrar a mensagem de "provavelmente sem economia"
            planAccessibleContainer.classList.add('mx-auto');
            // Esconder o indicador de carregamento ao iniciar
            fillPlanData(mostAccessiblePlan, planAccessibleContainer, householdSize);
            toggleLoadingIndicator(false);
        }

        // Inicializa exibindo o plano acessível
        showAccessiblePlan();

        // Fazer a requisição automática ao carregar a página
        fetchFilteredPlans().then(() => {
            plansLoaded = true; // Marcar que os planos foram carregados
        });

        // Configura o botão "Menor Valor"
        btnPlanLessValue.addEventListener('click', function() {
            console.log('Botão "Menor Valor" clicado');
            allPlansContainer.style.display = 'none';
            cardFilters.style.display = 'none';
            planLessValueContainer.classList.add('mx-auto');
            planLessValueContainer.style.display = 'block';
            planLessValueContainer.classList.remove('d-none', 'hidden',
                'invisible'); // Remove classes que podem estar ocultando
            planLessValueContainer.style.opacity = '1'; // Garante a visibilidade
            planLessValueContainer.style.visibility =
                'visible'; // Reseta qualquer possível invisibilidade
            tituloPlanoAcessivel.style.display = 'none';
            tituloPlanoMenorValor.style.display = 'block';
            noSavingMsg.style.display = 'block';
            planAccessibleContainer.style.display = 'none';
            fillPlanData(lessValuePlan, planLessValueContainer, householdSize);
            toggleLoadingIndicator(false); // Esconde o indicador de carregamento
        });

        // Configura o botão "Plano mais Acessível"
        btnMoreAccessible.addEventListener('click', function() {
            cardFilters.style.display = 'none';
            tituloPlanoAcessivel.style.display = 'block';
            noSavingMsg.style.display = 'block';
            planAccessibleContainer.classList.add('mx-auto');
            planAccessibleContainer.style.display = 'block';
            planLessValueContainer.style.display = 'none';
            tituloPlanoMenorValor.style.display = 'none';
            allPlansContainer.style.display = 'none';
            fillPlanData(mostAccessiblePlan, planAccessibleContainer, householdSize);
            toggleLoadingIndicator(false); // Esconde o indicador de carregamento
        });

        // Configura o botão "Todos os Planos"
        btnAllPlans.addEventListener('click', function() {
            if (plansLoaded && !loading) {
                console.log("Planos já carregados, exibindo diretamente.");
                cardFilters.style.display = 'block';
                tituloPlanoAcessivel.style.display = 'none';
                noSavingMsg.style.display = 'none';
                planAccessibleContainer.style.display = 'none';
                planLessValueContainer.style.display = 'none';
                tituloPlanoMenorValor.style.display = 'none';
                allPlansContainer.style.display = 'block';
                savingsMsg.style.display = 'none';
                toggleLoadingIndicator(false); // Garantir que o loading desapareça
            } else if (!loading) {
                console.log("Carregando planos...");
                toggleLoadingIndicator(true);
                cardFilters.style.display = 'block';
                tituloPlanoAcessivel.style.display = 'none';
                noSavingMsg.style.display = 'none';
                planAccessibleContainer.style.display = 'none';
                planLessValueContainer.style.display = 'none';
                tituloPlanoMenorValor.style.display = 'none';
                savingsMsg.style.display = 'none';
                // Fazer a requisição de planos
                fetchFilteredPlans().then(() => {
                    allPlansContainer.style.display = 'block';
                    toggleLoadingIndicator(false); // Esconde o indicador de carregamento
                    plansLoaded = true; // Marcar que os planos foram carregados
                    console.log("Planos carregados com sucesso.");
                }).catch((error) => {
                    console.error('Erro ao carregar os planos:', error);
                    toggleLoadingIndicator(false); // Esconder o indicador de carregamento
                });
            } else {
                console.log("A requisição já está em andamento, aguardando conclusão...");
                toggleLoadingIndicator(true); // Mantém o loading até que a requisição termine
                cardFilters.style.display = 'block';
                tituloPlanoAcessivel.style.display = 'none';
                noSavingMsg.style.display = 'none';
                planAccessibleContainer.style.display = 'none';
                planLessValueContainer.style.display = 'none';
                tituloPlanoMenorValor.style.display = 'none';
                savingsMsg.style.display = 'none';

                // Aqui estamos aguardando a finalização da requisição, então removemos o loading no fim
                const checkLoading = setInterval(() => {
                    if (!loading) {
                        clearInterval(checkLoading); // Para a verificação
                        toggleLoadingIndicator(
                            false); // Remover o loading quando a requisição terminar
                        allPlansContainer.style.display =
                            'block'; // Exibe os planos ao término da requisição
                    }
                }, 200); // Checamos a cada 200ms
            }
        });






        let isComparingPlans = false;




        // Remova a função handlePlanSelection antiga e use esta nova versão
        function attachCompareEventListeners() {
            const compareCheckboxes = document.querySelectorAll('.compare-checkbox');
            const selectedPlansAlert = document.getElementById('selected-plans-alert');
            const selectedPlansContent = document.getElementById('selected-plans-content');
            const closeAlertButton = document.getElementById('close-alert');

            // Botão para fechar o alerta e limpar seleção
            if (closeAlertButton) {
                closeAlertButton.addEventListener('click', function() {
                    selectedPlansAlert.classList.add('d-none');
                    selectedPlans = [];
                    compareCheckboxes.forEach(checkbox => checkbox.checked = false);
                });
            }

            // Para cada checkbox de plano
            compareCheckboxes.forEach(checkbox => {
                // Remove o atributo onchange do HTML se existir
                checkbox.removeAttribute('onchange');

                // Adiciona o evento via JavaScript
                checkbox.addEventListener('change', function() {
                    const planCard = this.closest('.plan-card');
                    const planId = planCard.getAttribute('data-plan-id');

                    // Encontrar o plano completo nos dados atuais
                    const selectedPlanData = allPlans.find(plan => plan.id === planId);

                    if (this.checked) {
                        if (selectedPlans.length < 3) {
                            // Armazenar o plano completo com todos os detalhes necessários
                            const planInfo = {
                                planId,
                                planName: planCard.querySelector('h3').textContent,
                                planValue: planCard.querySelector('.monthly-value')
                                    .textContent,
                                page: currentPage,
                                planDetails: selectedPlanData
                            };
                            selectedPlans.push(planInfo);
                            console.log('Plano adicionado:', planInfo);
                        } else {
                            this.checked = false;
                            Swal.fire('@lang('labels.aviso')...', '@lang('labels.compare3plans').',
                                'warning');
                        }
                    } else {
                        selectedPlans = selectedPlans.filter(plan => plan.planId !== planId);
                        console.log('Plano removido. Planos restantes:', selectedPlans);
                    }

                    updateSelectedPlansAlert(selectedPlans);
                });
            });
        }

        // Modifique a função fetchPlanDetails para usar os dados já armazenados
        function fetchPlanDetails(selectedPlans) {
            console.log('Iniciando fetchPlanDetails com planos:', selectedPlans);

            if (!selectedPlans || selectedPlans.length === 0) {
                Swal.fire('Erro', 'Nenhum plano selecionado para comparação', 'error');
                return;
            }

            // Como já temos os detalhes dos planos armazenados, podemos usá-los diretamente
            const plan1 = selectedPlans[0]?.planDetails;
            const plan2 = selectedPlans[1]?.planDetails;
            const plan3 = selectedPlans[2]?.planDetails;

            if (plan1) {
                const householdMembers = @json($data['application']['householdMembers']);
                comparePlans(plan1, plan2, plan3, householdMembers);
            } else {
                Swal.fire('Erro', 'Não foi possível carregar os detalhes dos planos', 'error');
            }
        }

        // Modifique a função handleCompareClick para incluir feedback visual
        function handleCompareClick() {
            console.log('Iniciando comparação com planos:', selectedPlans);

            if (selectedPlans.length === 0) {
                Swal.fire('Aviso', 'Selecione pelo menos um plano para comparar', 'warning');
                return;
            }

            Swal.fire({
                title: '@lang('labels.prepareCompare')...',
                text: '@lang('labels.comparePlansModal')...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Pequeno timeout para garantir que o loading seja exibido
            setTimeout(() => {
                try {
                    fetchPlanDetails(selectedPlans);
                    Swal.close();
                    compareModal.show();
                } catch (error) {
                    console.error('Erro na comparação:', error);
                    Swal.fire('Erro', 'Ocorreu um erro ao comparar os planos', 'error');
                }
            }, 500);
        }


        function loadPlansForComparison(plan1Id, plan2Id = null, plan3Id = null, householdMembers) {
            let page = currentPage; // Começa na página atual
            let foundPlan1 = null;
            let foundPlan2 = null;
            let foundPlan3 = null;

            function loadNextPage() {
                page++;
                fetchFilteredPlans(page).then(() => {
                    if (!foundPlan1) {
                        foundPlan1 = allPlans.find(plan => plan.id.trim() === plan1Id);
                    }
                    if (plan2Id && !foundPlan2) { // Só busca o terceiro plano se ele foi selecionado
                        foundPlan2 = allPlans.find(plan => plan.id.trim() === plan2Id);
                    }
                    if (plan3Id && !foundPlan3) { // Só busca o terceiro plano se ele foi selecionado
                        foundPlan3 = allPlans.find(plan => plan.id.trim() === plan3Id);
                    }

                    // Verifica se encontrou os planos necessários (com ou sem plan3)
                    if (foundPlan1 && (foundPlan2 || !plan2Id) && (foundPlan3 || !plan3Id)) {
                        comparePlans(foundPlan1, foundPlan2, foundPlan3, householdMembers);
                    } else if (page < totalPages) {
                        loadNextPage(); // Continua buscando na próxima página
                    } else {
                        console.error('Um ou mais planos não foram encontrados em todas as páginas.');
                    }
                }).catch(error => {
                    console.error('Erro ao buscar planos em outra página:', error);
                });
            }

            loadNextPage();
        }


        function formatPlanName(planName) {
            const words = planName.split(' ');
            let formattedName = '';
            for (let i = 0; i < words.length; i++) {
                formattedName += words[i];
                if ((i + 1) % 3 === 0 && i < words.length - 1) {
                    formattedName += '<br>'; // Adiciona uma quebra de linha
                } else if (i < words.length - 1) {
                    formattedName += ' ';
                }
            }
            return formattedName;
        }


        function comparePlans(plan1, plan2, plan3, householdMembers) {
            const applicationId = @json($application_id);
            console.log('Application ID:', applicationId);

            if (!applicationId) {
                console.error('applicationId está indefinido. Verifique a fonte de dados.');
                return;
            }

            console.log('Plan 1 encontrado:', plan1);
            console.log('Plan 2 encontrado:', plan2);
            console.log('Plan 3 encontrado:', plan3);

            // Limpa o corpo do modal de comparação
            compareModalBody.innerHTML = '';

            // Limpa o cabeçalho da tabela e cria dinamicamente conforme os planos carregados
            const tableHeader = document.querySelector('#compare-datatable thead tr');
            tableHeader.innerHTML = '';

            // Adiciona a primeira coluna vazia para as categorias
            tableHeader.appendChild(document.createElement('th'));

            // Adiciona cabeçalhos para cada plano que está presente
            const planHeaders = [plan1, plan2, plan3].filter(Boolean); // Remove valores nulos ou indefinidos
            planHeaders.forEach(plan => {
                const th = document.createElement('th');
                th.className = 'border-bottom-0';
                th.innerHTML = formatPlanName(plan
                    .name); // Usa a função formatPlanName para quebrar o título
                tableHeader.appendChild(th);
            });

            // Define as categorias que serão exibidas na comparação
            const categories = [
                'Monthly Premium',
                'Deductible',
                'Out-of-pocket max',
                'Network',
                'Primary Care',
                'Generic Drugs',
                'Specialist',
                'Emergency Room',
                'X-rays',
                'Imaging (CT/PET/MRI)',
                'Blood work',
                'Urgent Care',
                'Benefits',
                'Info',
                'Forms'
            ];

            showLoadingInTable(categories, plan1, plan2, plan3);

            const promises = [
                getPlanValues(plan1, categories, householdMembers, applicationId),
                getPlanValues(plan2, categories, householdMembers, applicationId)
            ];

            if (plan3) {
                promises.push(getPlanValues(plan3, categories, householdMembers, applicationId));
            }

            Promise.all(promises).then(values => {
                const [plan1Values, plan2Values, plan3Values = null] = values;

                hideLoadingAndFillTable(plan1Values, plan2Values, plan3Values, categories);

                // Habilita o botão de download do PDF agora que temos os valores
                //downloadPdfButton.addEventListener('click', handleDownloadPdf);
            }).catch(error => {
                console.error('Erro ao comparar planos:', error);
            });
        }




        function fetchPlanDetailsFields(applicationId, planId) {
            console.log(
                `Buscando detalhes do plano para o Application ID: ${applicationId} e Plan ID: ${planId}`);
            return new Promise((resolve, reject) => {
                $.ajax({
                    url: `/plans/search/plan-detail/${applicationId}/${planId}`, // Certifique-se de que planId está correto
                    type: 'GET',
                    success: function(response) {
                        if (response.status === 'success' && response.data) {
                            resolve(response.data); // Retorna os detalhes do plano
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

        console.log('DOM Loaded - Iniciando configuração dos botões de download');

        // Primeiro, vamos verificar se o dropdown existe
        const downloadDropdown = document.querySelector('.dropdown');
        console.log('Dropdown encontrado:', downloadDropdown);

        if (!downloadDropdown) {
            console.error('Dropdown container não encontrado');
            return;
        }

        // Vamos verificar se os botões existem
        const downloadButtons = document.querySelectorAll('.download-pdf-language');
        console.log('Botões de download encontrados:', downloadButtons.length);

        if (downloadButtons.length === 0) {
            console.error('Botões de download não encontrados');
            return;
        }

        // Adiciona o evento de clique para cada botão
        downloadButtons.forEach(button => {
            console.log('Configurando botão:', button.getAttribute('data-language'));

            button.addEventListener('click', function(e) {
                console.log('Botão clicado - Idioma:', this.getAttribute('data-language'));
                e.preventDefault();
                e.stopPropagation();

                const language = this.getAttribute('data-language');

                // Verifica se temos planos selecionados
                console.log('Planos selecionados:', selectedPlans);

                downloadPdfInLanguage(language);
            });
        });

        function downloadPdfInLanguage(language) {
            console.log('Iniciando download do PDF em:', language);

            if (!selectedPlans || selectedPlans.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: language === 'en' ? 'Warning' : 'Aviso',
                    text: language === 'en' ?
                        'Select at least one plan for comparison.' :
                        'Selecione pelo menos um plano para comparação.'
                });
                return;
            }

            const payload = {
                plans: selectedPlans.map(plan => ({
                    id: plan.planId,
                    page: plan.page,
                })),
                language: language,
                application_id: parseInt('{{ $application_id }}')
            };

            console.log('Payload preparado:', payload);

            // Mostra o loading com mensagem apropriada ao idioma
            Swal.fire({
                title: language === 'en' ? 'Generating PDF...' : 'Gerando PDF...',
                text: language === 'en' ? 'Please wait...' : 'Por favor, aguarde...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Faz a requisição AJAX
            $.ajax({
                url: '{{ route('gerar-pdf-plano') }}',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: JSON.stringify(payload),
                contentType: 'application/json',
                xhrFields: {
                    responseType: 'blob'
                },
                success: function(blob) {
                    console.log('PDF gerado com sucesso');

                    // Cria e dispara o download
                    const url = window.URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = language === 'en' ? 'plan_comparison.pdf' :
                        'comparacao_planos.pdf';
                    document.body.appendChild(a);
                    a.click();
                    a.remove();
                    window.URL.revokeObjectURL(url);

                    // Fecha o loading
                    Swal.close();

                    // Mostra mensagem de sucesso
                    Swal.fire({
                        icon: 'success',
                        title: language === 'en' ? 'Success!' : 'Sucesso!',
                        text: language === 'en' ? 'PDF has been downloaded.' :
                            'O PDF foi baixado.',
                        timer: 2000,
                        showConfirmButton: false
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Erro na requisição:', error);
                    console.error('Status:', status);
                    console.error('Response:', xhr.responseText);

                    Swal.fire({
                        icon: 'error',
                        title: language === 'en' ? 'Error' : 'Erro',
                        text: language === 'en' ?
                            'Error generating PDF. Please try again.' :
                            'Erro ao gerar o PDF. Tente novamente.',
                    });
                }
            });
        }

        function getBenefitNameByCategory(category) {
            switch (category) {
                case 'X-rays':
                    return 'X-rays and Diagnostic Imaging';
                case 'Imaging (CT/PET/MRI)':
                    return 'Imaging (CT/PET Scans, MRIs)';
                case 'Blood work':
                    return 'Laboratory Outpatient and Professional Services';
                default:
                    return '';
            }
        }



        // Função auxiliar para obter o valor de uma categoria específica de um plano
        function getPlanValues(plan, categories, householdMembers, applicationId) {
            return new Promise((resolve, reject) => {
                if (!plan) {
                    console.error("Plano indefinido ao tentar acessar categorias.");
                    return resolve(new Array(categories.length).fill(
                        '-')); // Retorna valores padrões para todas as categorias
                }

                console.log(`Processando plano: ${plan.name}`);

                const values = [];

                const promises = categories.map(category => {
                    return new Promise((resolveCategory) => {
                        const childrenArrayCount = householdMembers.length;
                        const zipcodeState = householdMembers[0]?.address?.state || '';
                        const count = householdMembers.length;

                        const categoriesRequiringAjax = ['X-rays',
                            'Imaging (CT/PET/MRI)', 'Blood work'
                        ];

                        if (categoriesRequiringAjax.includes(category)) {
                            // Categorias que precisam de uma chamada AJAX
                            fetchPlanDetailsFields(applicationId, plan.id)
                                .then(planDetails => {
                                    const benefitName = getBenefitNameByCategory(
                                        category);
                                    const benefit = planDetails?.benefits?.find(b =>
                                        b.name === benefitName);
                                    if (benefit && benefit.cost_sharings) {
                                        // Especialmente para 'Imaging (CT/PET Scans, MRIs)'
                                        if (category === 'Imaging (CT/PET/MRI)') {
                                            for (let i = 0; i < benefit
                                                .cost_sharings.length; i++) {
                                                if (benefit.cost_sharings[i]
                                                    .network_tier === 'In-Network'
                                                ) {
                                                    if (benefit.cost_sharings[i]
                                                        .display_string ===
                                                        'No Charge') {
                                                        resolveCategory('Free');
                                                    } else {
                                                        resolveCategory(benefit
                                                            .cost_sharings[i]
                                                            .display_string);
                                                    }
                                                    break;
                                                }
                                            }
                                        } else {
                                            const costSharing = benefit
                                                .cost_sharings.find(cs => cs
                                                    .network_tier === 'In-Network');
                                            resolveCategory(costSharing ? (
                                                costSharing
                                                .display_string ===
                                                'No Charge' ? 'Free' :
                                                costSharing.display_string
                                            ) : '-');
                                        }
                                    } else {
                                        resolveCategory('-');
                                    }
                                })
                                .catch(error => {
                                    console.error(
                                        `Erro ao buscar detalhes do plano para ${category}:`,
                                        error);
                                    resolveCategory('-');
                                });
                        } else {
                            // Processamento das categorias que não precisam de AJAX
                            switch (category) {
                                case 'Monthly Premium':
                                    let value = month_value_final(plan);
                                    resolveCategory(value || '-');
                                    break;

                                case 'Deductible':
                                    let deductible = calculateDeductible(plan);
                                    // Calcular o valor por pessoa
                                    const numericDeductible = parseFloat(deductible
                                        .replace(/[^\d.-]/g, '')) || 0;
                                    const perPersonDeductible = (numericDeductible /
                                        householdMembers.length).toFixed(2);
                                    // Combinar o valor total com o valor por pessoa
                                    resolveCategory(
                                        `${deductible} <span style="font-size: 0.8em; color: #666; margin-left: 5px;">($${perPersonDeductible}/@lang('labels.person'))</span>` ||
                                        '-');
                                    break;

                                case 'Out-of-pocket max':
                                    let minMoops = calculateMoop(plan);
                                    console.log('minMoops:', minMoops);
                                    resolveCategory(minMoops);
                                    break;

                                case 'Network':
                                    resolveCategory(plan.type || '-');
                                    break;

                                case 'Primary Care':
                                    let drugs = getDoctorCost(plan);
                                    resolveCategory(drugs || '-');
                                    break;

                                case 'Generic Drugs':
                                    let genericDrugs = getDrugCost(plan);
                                    resolveCategory(genericDrugs || '-');
                                    break;

                                case 'Specialist':
                                    let specialists = getSpecialistCost(plan);
                                    resolveCategory(specialists || '-');
                                    break;

                                case 'Emergency Room':
                                    if (plan.benefits) {
                                        for (const benefit of plan.benefits) {
                                            if (benefit.name ===
                                                'Emergency Room Services') {
                                                for (const costSharing of benefit
                                                        .cost_sharings) {
                                                    if (costSharing.network_tier ===
                                                        'In-Network') {
                                                        resolveCategory(costSharing
                                                            .display_string ===
                                                            'No Charge' ? 'Free' :
                                                            costSharing
                                                            .display_string);
                                                        return;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    resolveCategory('-');
                                    break;

                                case 'Urgent Care':
                                    console.log('Urgent Care');
                                    if (plan.benefits) {
                                        for (const benefit of plan.benefits) {
                                            if (benefit.type ===
                                                'URGENT_CARE_CENTERS_OR_FACILITIES') {
                                                for (const costSharing of benefit
                                                        .cost_sharings) {
                                                    if (costSharing.network_tier ===
                                                        'In-Network') {
                                                        resolveCategory(costSharing
                                                            .display_string);
                                                        return;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    resolveCategory('-');
                                    break;

                                case 'Benefits':
                                    resolveCategory(plan.benefits_url ?
                                        `<a href="${plan.benefits_url}" target="_blank">Benefits</a>` :
                                        '-');
                                    break;

                                case 'Info':
                                    resolveCategory(plan.brochure_url ?
                                        `<a href="${plan.brochure_url}" target="_blank">Brochure</a>` :
                                        '-');
                                    break;

                                case 'Forms':
                                    resolveCategory(plan.formulary_url ?
                                        `<a href="${plan.formulary_url}" target="_blank">Forms</a>` :
                                        '-');
                                    break;

                                default:
                                    resolveCategory('-');
                                    break;
                            }
                        }
                    });
                });


                Promise.all(promises)
                    .then(results => {
                        resolve(results);
                    })
                    .catch(error => {
                        console.error('Erro ao resolver as promessas das categorias:', error);
                        reject(error);
                    });
            });
        }



        function updateIssuerLogo(issuerName, logoElement) {
            // Obtenha o arquivo da logo baseado no nome da seguradora
            const issuerLogoFile = getIssuerLogo(issuerName);

            console.log('issuerLogoFile:', issuerLogoFile);
            console.log('issuerName:', issuerName);

            if (issuerLogoFile) {
                logoElement.src = `/img/issuers/${issuerLogoFile}`;

                // Adiciona evento de erro para o caso de a logo não existir
                logoElement.onerror = function() {
                    console.error(`Erro ao carregar a imagem: /img/issuers/${issuerLogoFile}`);
                    logoElement.src = '/img/issuers/img.png'; // Logo padrão
                };

                console.log(`Caminho da imagem definido: /img/issuers/${issuerLogoFile}`);
            } else {
                console.error('Issuer logo file não encontrado');
                logoElement.src = '/img/issuers/img.png'; // Logo padrão
            }
        }




        // Preenche os dados do plano mais acessível
        function fillPlanData(plan, container, householdSize) {
            console.log('plan acessible e less:', plan);
            //console.log("Conteúdo do container:", container.innerHTML);

            const monthlyValue = container.querySelector('.monthly-value');
            const planName = container.querySelector('.plan-name');
            const issuerName = container.querySelector('.issuer-name');
            const deductibleValue = container.querySelector('.deductible-value');
            const perPersonValue = container.querySelector('.per-person-value');

            const metalLevel = container.querySelector('.metal-level');
            const specialistCost = container.querySelector('.specialist-cost');
            const doctorCost = container.querySelector('.doctor-cost');
            const drugCost = container.querySelector('.drug-cost');
            const starsContainer = container.querySelector('.stars');
            const logoElement = container.querySelector('.issuer-logo');
            const wasValue = container.querySelector('.was-value');
            const moopValue = container.querySelector('#moop-value');


            // Calcula e exibe o deductible e o valor por pessoa
            const deductible = calculateDeductible(plan);
            deductibleValue.textContent = deductible;

            // Calcula o valor por pessoa
            const numericDeductible = parseFloat(deductible.replace(/[^\d.-]/g, ''));
            const perPersonDeductible = (numericDeductible / householdSize).toFixed(2);
            perPersonValue.textContent = `($${perPersonDeductible}/@lang('labels.person'))`;



            // Aplica a classe de estilo do metal level
            const metalLevelElement = container.querySelector('.metal-level');
            metalLevelElement.textContent = plan.metal_level;
            metalLevelElement.className =
                `metal-level ${getMetalLevelClass(plan.metal_level)}`; // Atualiza a classe com a função

            // Atualiza o valor do plano
            monthlyValue.textContent = month_value_final(plan);
            wasValue.textContent = 'Was ' + formatCurrency(valueWas(plan));
            planName.textContent = plan.name + ' - ' + plan.type;
            issuerName.textContent = plan.issuer.name;
            deductibleValue.textContent = calculateDeductible(plan, householdSize);
            metalLevel.textContent = plan.metal_level;
            moopValue.textContent = calculateMoop(plan, householdSize); // Insere o valor no elemento
            specialistCost.textContent = getSpecialistCost(plan);
            doctorCost.textContent = getDoctorCost(plan);
            drugCost.textContent = getDrugCost(plan);



            // Condição para exibir ou ocultar no-saving-msg e savings-msg
            if (estimateSub > 0) {
                wasValue.style.display = 'block'; // Mostrar o "was-value" se estimateSub for maior que 0
                noSavingMsg.style.display = 'none'; // Ocultar no-saving-msg
                savingsMsg.style.display = 'block'; // Mostrar a nova div de savings
                if (savingsValue) {
                    savingsValue.textContent = formatCurrency(estimateSub); // Definir o valor dos savings
                }
            } else {
                wasValue.style.display = 'none'; // Esconder was-value se não houver savings
                noSavingMsg.style.display = 'block'; // Mostrar no-saving-msg
                savingsMsg.style.display = 'none'; // Ocultar savings-msg
            }



            // Chama a função para atualizar a logo
            if (logoElement) {
                updateIssuerLogo(plan.issuer.name, logoElement);
            }






            // Preenche as estrelas de avaliação
            starsContainer.innerHTML = '';
            for (let i = 1; i <= 5; i++) {
                const star = document.createElement('span');
                star.className = i <= (plan.quality_rating?.global_rating || 0) ?
                    'star filled' : 'star';
                star.textContent = '★';
                starsContainer.appendChild(star);
            }

            // Preenche o link de detalhes
            const planDetailsLink = container.querySelector('.plan-details');
            if (planDetailsLink) {
                // Remover o símbolo $ do resultado de month_value_final(plan) antes de adicionar à URL
                const formattedPremium = month_value_final(plan)
                    .replace('$', '') // Remove o símbolo de dólar
                    .replace(',', '') // Remove as vírgulas
                    .trim(); // Remove espaços em branco

                planDetailsLink.href = `/quotation-detail/${applicationId}/${plan.id}/${formattedPremium}`;
            }

        }






        function calculateDeductible(plan, count) {
            let minDeductibles = '-'; // Valor padrão inicial
            let varFamily = ''; // Para armazenar o prefixo 'Family' quando necessário

            if (!('medical_deductible' in plan)) {
                if (plan.deductibles && plan.deductibles.length > 0) {
                    for (let i = 0; i < plan.deductibles.length; i++) {
                        const deductible = plan.deductibles[i];

                        // Verificação para uma única pessoa
                        if (householdSize === 1) { // Aqui usamos `count` diretamente como um número
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
                    }
                }
            } else {
                minDeductibles = plan.medical_deductible;
            }

            return formatCurrency(minDeductibles);
        }


        //out of pocket MAX
        function calculateMoop(plan) {
            let minMoops = '-'; // Valor padrão inicial

            if (!('moops_amount' in plan)) {
                if (plan.moops && plan.moops.length > 0) {
                    for (const moop of plan.moops) {
                        console.log('Valor de moop:', moop);
                        if (moop.family_cost === 'Family Per Person' || moop.family_cost === 'Individual') {
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
            } else {
                minMoops = plan.moops_amount;
            }

            return formatCurrency(minMoops);
        }

        function getIssuerLogo(issuerName) {
            issuerName = issuerName.toLowerCase(); // Converter para minúsculas para facilitar a comparação

            if (issuerName.includes("aetna")) {
                return 'aetnaCvs.png';
            } else if (issuerName.includes("avmed")) {
                return 'avMed.png';
            } else if (issuerName.includes("ambetter")) {
                return 'ambetterFromSunshineHealth.png';
            } else if (issuerName.includes("florida blue")) {
                return 'floridaBlue.png';
            } else if (issuerName.includes("molina")) {
                return 'molinaHealthcare.png';
            } else if (issuerName.includes("oscar")) {
                return 'oscar.png';
            } else if (issuerName.includes("bridgespan")) {
                return 'bridgespan.png';
            } else if (issuerName.includes("cigna")) {
                return 'cignaHealth.png';
            } else if (issuerName.includes("regence")) {
                return 'regenceBlue.png';
            } else if (issuerName.includes("selecthealth")) {
                return 'selectHealth.png';
            } else if (issuerName.includes("university of utah")) {
                return 'universityUtah.png';
            } else if (issuerName.includes("blue cross")) {
                return 'blueCross.png';
            } else if (issuerName.includes("caresource")) {
                return 'careSource.png';
            } else if (issuerName.includes("unitedhealthcare")) {
                return 'unitedHealthcare.png';
            } else if (issuerName.includes("kaiser permanente")) {
                return 'kaiserFoundation.png';
            } else if (issuerName.includes("friday health")) {
                return 'fridayHealth.png';
            } else if (issuerName.includes("mutual")) {
                return 'medMutual.png';
            } else if (issuerName.includes("community health")) {
                return 'communityHealth.png';
            } else if (issuerName.includes("optima health")) {
                return 'optimaHealth.png';
            } else if (issuerName.includes("innovation health")) {
                return 'innovationHealth.png';
            } else if (issuerName.includes("healthkeepers")) {
                return 'healthKeepers.png';
            } else {
                return 'img.png'; // Uma imagem padrão se nenhuma correspondência for encontrada
            }
        }







        function formatCurrencyFromString(value) {
            // Remover todos os caracteres que não sejam números
            value = value.replace(/[^0-9]/g, '');

            // Se o valor for vazio ou NaN, retorna uma string vazia
            if (value === '' || isNaN(parseFloat(value))) {
                return '';
            }

            // Adicionar ponto decimal para formatação
            let numericValue = parseFloat(value) / 100;

            // Retornar o valor formatado como moeda, incluindo o símbolo $
            return '$' + numericValue.toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }

        function handleCurrencyInput(field) {
            // Armazenar a posição inicial do cursor
            const start = field.selectionStart;
            const end = field.selectionEnd;

            // Remover o símbolo de moeda e formatar o valor
            const rawValue = field.value.replace(/[^\d]/g, ''); // Apenas os números
            const formattedValue = formatCurrencyFromString(rawValue);

            // Definir o valor formatado no campo, com o símbolo $
            field.value = formattedValue;

            // Ajustar a posição do cursor após a formatação
            const diff = formattedValue.length - rawValue.length;
            field.setSelectionRange(start + diff, end + diff);
        }

        // Função para remover a formatação de moeda (incluindo $ e vírgulas)
        function removeFormatting(value) {
            // Remove o símbolo de moeda e vírgulas antes de enviar
            return value.replace(/[$,]/g, '');
        }

        // Quando a página carregar
        window.onload = function() {
            const incomeFields = document.querySelectorAll('.income-field');

            incomeFields.forEach(function(field) {
                // Adicionar um evento 'input' para formatar o valor em tempo real com $
                field.addEventListener('input', function() {
                    handleCurrencyInput(this);
                });

                // Formatar o valor já presente ao carregar a página
                handleCurrencyInput(field);
            });

            // Verificar se o formulário existe
            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('submit', function() {
                    incomeFields.forEach(function(field) {
                        // Remover a formatação ($ e vírgulas) antes de enviar
                        field.value = removeFormatting(field.value);
                    });
                });
            }


            // Evento de atualização de número de membros
            const householdNumberField = document.getElementById('household-number-input');
            if (householdNumberField) {
                householdNumberField.addEventListener('blur', function() {
                    const applicationId = '{{ $application_id }}';
                    const householdNumber = householdNumberField.value.trim();

                    if (householdNumber && !isNaN(householdNumber)) {
                        updateHouseholdNumber(applicationId, householdNumber);
                    } else {
                        alert('Por favor, insira um número válido para a contagem de membros.');
                    }
                });
            }

           
            // Função para atualizar o número de membros
            function updateHouseholdNumber(applicationId, householdNumber) {
                // Exibe o indicador de carregamento antes de iniciar a requisição
                Swal.fire({
                    title: '@lang('labels.atualizando')...',
                    text: '@lang('labels.updateMemberCountWait').',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: '{{ route('application.updateHouseholdNumber', ['application_id' => $application_id]) }}', // Rota para atualizar o número de membros
                    type: 'POST',
                    data: {
                        override_household_number: householdNumber,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            // Mostra uma mensagem de sucesso com um indicador de carregamento antes de recarregar a página
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: '@lang('labels.updateMemberCount')...',
                                showConfirmButton: false,
                                allowOutsideClick: false,
                                willOpen: () => {
                                    Swal.showLoading();
                                }
                            });

                            // Aguarda 1 segundo antes de recarregar para que o usuário veja a mensagem
                            setTimeout(() => {
                                location.reload();
                            }, 1000);
                        } else {
                            Swal.fire('Erro', response.message, 'error');
                        }
                    },
                    error: function(xhr) {
                        // Fecha o loading e exibe uma mensagem de erro
                        Swal.close();
                        Swal.fire('Erro', `Erro: ${xhr.responseJSON.message}`, 'error');
                    }
                });
            }

        };


            
           

        const incomeField = document.getElementById('income');

        incomeField.addEventListener('change', function() {
            const memberId = this.getAttribute('data-member-id');
            const applicationId = this.getAttribute('data-application-id');
            let income = this.value;

            // Remove o símbolo de $ e as vírgulas antes de enviar
            income = income.replace(/[$,]/g, '');

            // Mostrar o alerta de carregamento
            Swal.fire({
                title: '@lang('labels.atualRenda')',
                text: '@lang('labels.aguarde').',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Enviar uma requisição POST para atualizar a renda e depois recarregar a página
            $.ajax({
                url: '{{ route('income.quotationMainIncome') }}', // Rota para atualizar o income
                type: 'POST',
                data: {
                    application_id: applicationId,
                    member_id: memberId,
                    income_predicted_amount: income, // Valor sem o $
                    _token: '{{ csrf_token() }}' // Token CSRF
                },
                success: function(response) {
                    console.log('Resposta recebida:', response);

                    if (response.status === 'success') {
                        // Exibe um alert de carregamento
                        Swal.fire({
                            title: '@lang('labels.carregando')',
                            html: '@lang('labels.please').',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading(); // Mostra o ícone de loading
                            }
                        });

                        // Recarrega a página após um pequeno delay para garantir que o SweetAlert é exibido
                        setTimeout(() => {
                                location.reload(); // Recarrega a página inteira
                            },
                            1000
                        ); // Delay de 1 segundo para garantir que o SweetAlert seja mostrado
                    } else {
                        console.log('Erro', response);
                        Swal.fire('@lang('labels.erroRenda')', 'error');
                    }
                },
                error: function() {
                    Swal.fire('Erro!', 'Erro na requisição. Tente novamente.', 'error');
                }
            });
        });

          

        const languageSelect = document.getElementById('language-select');
        if (languageSelect) {
            // Oculta o seletor de idioma na página de quotation
            languageSelect.style.display = 'none';
        }


        document.addEventListener('click', function(event) {
            // Verifica se o clique foi em um botão com a classe 'remove-member-btn'
            if (event.target && event.target.classList.contains('remove-member-btn')) {
                // Obtém o ID do membro a partir do atributo data-id
                const memberId = event.target.getAttribute('data-id');

                if (memberId) {
                    // Chama a função para remover o membro
                    removeMember(memberId);
                }
            }
        });


        // Botão para abrir a modal de Spouse
        const btnAddSpouse = document.getElementById('btnAddSpouse');
        if (btnAddSpouse) {
            btnAddSpouse.addEventListener('click', function() {
                const addSpouseModal = new bootstrap.Modal(document.getElementById('addSpouseModal'));
                addSpouseModal.show();
            });
        }


        // Botão para adicionar Spouse dentro da modal
        const btnAddSpouseToList = document.getElementById('btnAddSpouseToList');
        if (btnAddSpouseToList) {
            btnAddSpouseToList.addEventListener('click', function() {
                const birthdate = document.getElementById('spouseBirthdate')?.value;
                const tobacco = document.querySelector('input[name="spouseTobacco"]:checked')?.value;
                const sex = document.querySelector('input[name="spouseSex"]:checked')?.value;

                if (birthdate && tobacco && sex) {
                    const data = {
                        field_type: 1,
                        birthdate,
                        tobacco: tobacco === '1' ? 1 : 0, // Ajuste para enviar como 0 ou 1
                        sex
                    };
                    addMember(data);

                    // Esconde a modal após a adição
                    const addSpouseModal = bootstrap.Modal.getInstance(document.getElementById(
                        'addSpouseModal'));
                    if (addSpouseModal) addSpouseModal.hide();
                } else {
                    alert("@lang('labels.spouseFields').");
                }
            });
        }


        // Botão para abrir a modal de Dependent
        const btnAddDependent = document.getElementById('btnAddDependent');
        if (btnAddDependent) {
            btnAddDependent.addEventListener('click', function() {
                const addDependentModal = new bootstrap.Modal(document.getElementById(
                    'addDependentModal'));
                addDependentModal.show();
            });
        }


        // Botão para adicionar Dependent dentro da modal
        const btnAddDependentToList = document.getElementById('btnAddDependentToList');
        if (btnAddDependentToList) {
            btnAddDependentToList.addEventListener('click', function() {
                const birthdate = document.getElementById('dependentBirthdate')?.value;
                const tobacco = document.querySelector('input[name="dependentTobacco"]:checked')?.value;
                const sex = document.querySelector('input[name="dependentSex"]:checked')?.value;

                if (birthdate && tobacco && sex) {
                    const data = {
                        field_type: 6,
                        birthdate,
                        tobacco: tobacco === '1' ? 1 : 0, // Ajuste para enviar como 0 ou 1
                        sex
                    };
                    addMember(data);

                    // Esconde a modal após a adição
                    const addDependentModal = bootstrap.Modal.getInstance(document.getElementById(
                        'addDependentModal'));
                    if (addDependentModal) addDependentModal.hide();
                } else {
                    alert("@lang('labels.dependentFields').");
                }
            });
        }



    }); //fim do codigo do dom.


    const csrf_token = '{{ csrf_token() }}';

    // Função para adicionar um membro ao servidor e recarregar a página
    function addMember(data) {
        const applicationId = '{{ $application_id }}'; // Certifique-se de que o ID da aplicação esteja disponível

        // Exibe o indicador de carregamento com mensagem de recarga
        Swal.fire({
            title: '@lang('labels.adicionando')...',
            text: '@lang('labels.aguardeCarregamento').',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        $.ajax({
            url: `{{ route('household.ajax.quick-quotation.add-member', ['application_id' => ':applicationId']) }}`
                .replace(':applicationId', applicationId),
            type: 'POST',
            data: data,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message + ' @lang('labels.recarregando')...',
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        willOpen: () => {
                            Swal
                                .showLoading(); // Mantém o loading ativo até que a página recarregue
                        }
                    });
                    setTimeout(() => location.reload(),
                        1000); // Aguarda 1 segundo antes de recarregar a página
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro',
                        text: response.message
                    });
                }
            },
            error: function() {
                // Fecha o loading e exibe uma mensagem de erro
                Swal.close();
                Swal.fire('Erro!', '@lang('labels.addMemberError').', 'error');
            }
        });
    }


    // Função para remover um membro e recarregar a página
    function removeMember(memberId) {
        const applicationId = '{{ $application_id }}';

        // Exibe o indicador de carregamento com mensagem de recarga
        Swal.fire({
            title: '@lang('labels.deletando')...',
            text: '@lang('labels.deletingMember').',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        $.ajax({
            url: `{{ route('household.ajax.quick-quotation.remove-member', ['application_id' => ':applicationId', 'member' => ':memberId']) }}`
                .replace(':applicationId', applicationId)
                .replace(':memberId', memberId),
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message + ' @lang('labels.recarregando')...',
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        willOpen: () => {
                            Swal
                                .showLoading(); // Mantém o loading ativo até que a página recarregue
                        }
                    });
                    setTimeout(() => location.reload(),
                        1000); // Aguarda 1 segundo antes de recarregar a página
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro',
                        text: response.message
                    });
                }
            },
            error: function() {
                // Fecha o loading e exibe uma mensagem de erro
                Swal.close();
                Swal.fire('Erro!', '@lang('labels.removeMemberError').', 'error');
            }
        });
    }

    $(function() {
        // Aplica a máscara de data para o formato MM/DD/YYYY
        $('#dependentBirthdate').mask('00/00/0000');
        $('#spouseBirthdate').mask('00/00/0000');
    });

          const yearField = document.getElementById('year');
                if (yearField) {
                    const applicationId = '{{ $application_id ?? ($data["application"]->id ?? "") }}';
                        
                        yearField.addEventListener('change', function() {
                            const selectedYear = parseInt(this.value);
                            const currentYear = new Date().getFullYear();

                            if (selectedYear && !isNaN(selectedYear) && selectedYear >= 2020 && selectedYear <= currentYear + 2) {
                                updateYear(applicationId, selectedYear);
                            } else {
                                alert('Por favor, selecione um ano válido entre 2020 e ' + (currentYear + 2) + '.');
                                yearField.value = '{{ $data["year"] ?? now()->year }}';
                            }
                        });
            }


         // Função para atualizar o ano na tabela applications
            function updateYear(applicationId, year) {
                    Swal.fire({
                        title: '@lang('labels.atualizando')...',
                        text: '@lang('labels.updateYearWait').',
                        allowOutsideClick: false,
                        didOpen: () => { Swal.showLoading(); }
                    });

                    $.ajax({
                        url: '/application/update-year/' + applicationId,
                        type: 'POST',
                        data: {
                            year: year,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: '@lang('labels.updateYearSuccess')...',
                                    showConfirmButton: false,
                                    allowOutsideClick: false,
                                    willOpen: () => { Swal.showLoading(); }
                                });
                                setTimeout(() => { location.reload(); }, 1000);
                            } else {
                                Swal.fire('Erro', response.message, 'error');
                            }
                        },
                        error: function(xhr) {
                            Swal.close();
                            let errorMessage = xhr.responseJSON?.message || 'Erro desconhecido';
                            Swal.fire('Erro', `Erro ao atualizar o ano: ${errorMessage}`, 'error');
                            yearField.value = '{{ $data["year"] ?? now()->year }}';
                        }
                    });
            };

</script>
@endsection
