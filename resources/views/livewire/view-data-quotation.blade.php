@extends('layouts.app')

@section('styles')
    <style>
        /* Estilos para a tabela */
        .table thead th {
            background-color: #007bff;
            color: white;
            font-weight: bold;
        }

        .table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .table tbody tr td {
            padding: 12px;
        }

        /* Estilos para o card */
        .card-header {
            background-color: #007bff;
            color: white;
            font-weight: bold;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .info-card {
            margin-bottom: 20px;
        }

        /* Flecha indicativa */
        .card-header .arrow {
            transition: transform 0.3s ease;
        }

        .card-header.collapsed .arrow {
            transform: rotate(90deg);
        }

        /* Estilos de transição para o colapso */
        .collapse {
            transition: height 0.3s ease;
        }

        /* Para diferenciar seções de informações */
        .section-header {
            background-color: #f0f0f0;
            padding: 15px;
            font-size: 18px;
            font-weight: bold;
        }

        .section-content {
            padding: 15px;
        }
    </style>
@endsection
{{-- 
@php
dd($application);
@endphp --}}


@section('content')
    <div class="container mt-5">
        <div class="position-relative mb-4">
            <h2 class="text-center">@lang('labels.dadosApp')</h2>
            <button type="button" onclick="window.location.href='{{ route('index') }}'" class="btn btn-primary position-absolute" style="right: 0; top: 0;">
                <i class="fas fa-arrow-left"></i> @lang('labels.buttonVoltar')
            </button>
        </div>

        <div id="accordion">
            <!-- Informações do Aplicante (Field Type 0) -->
            <div class="info-card card">
                <div class="card-header collapsed" data-bs-toggle="collapse" data-bs-target="#collapseApplicant" aria-expanded="false" aria-controls="collapseApplicant">
                    @lang('labels.infoApp')
                    <i class="fas fa-chevron-right arrow"></i>
                </div>
                <div id="collapseApplicant" class="collapse">
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>@lang('labels.nomeCompleto')</th>
                                    <th>@lang('labels.dataNascimento')</th>
                                    <th>SSN</th>
                                    <th>@lang('labels.nomeAgente')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    // Filtrando os membros com field_type = 0 (aplicante)
                                    $applicant = $application->householdMembers->filter(function ($member) {
                                        return $member->field_type == 0;
                                    })->first();

                                    // Buscando o agente da aplicação
                                    $agent = $application->agentReferrals->first() ? $application->agentReferrals->first()->agent : null;
                                @endphp

                                @if ($applicant)
                                    <tr>
                                        <td>{{ $applicant->firstname }} {{ $applicant->middlename }} {{ $applicant->lastname }}</td>
                                        <td>{{ \Carbon\Carbon::parse($applicant->birthdate)->format('d/m/Y') }}</td>
                                        <td>{{ $applicant->ssn }}</td>
                                        <!-- Exibe o nome do agente ou 'Sem agente' -->
                                        {{-- <td>{{ $agent ? $agent->name : @lang("labels.semAgente") }}</td> --}}
                                        <td>{{ $agent ? $agent->name : __('labels.semAgente') }}</td>
                                    </tr>
                                @else
                                    <tr>
                                        <td colspan="4">@lang('labels.appNotFound')</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Planos -->
            <div class="info-card card">
                <div class="card-header collapsed" data-bs-toggle="collapse" data-bs-target="#collapsePlans" aria-expanded="false" aria-controls="collapsePlans">
                    @lang('labels.dadaPlans')
                    <i class="fas fa-chevron-right arrow"></i>
                </div>
                <div id="collapsePlans" class="collapse">
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>@lang('labels.namePlan')</th>
                                    <th>@lang('labels.amountValue')</th>
                                    <th>@lang('labels.dataCriacao')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($application->plans as $plan)
                                    <tr>
                                        <td>{{ $plan->hios_plan_id }}</td>
                                        {{-- <td>{{ $plan->name ?? '@lang('labels.notSpecified')' }}</td> --}}
                                        <td>{{ $plan->name ?? __('labels.notSpecified') }}</td>
                                        <td>{{ formatCurrency($plan->value) }}</td>
                                        <td>{{ $plan->created_at->format('d/m/Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Membros da Família -->
            <div class="info-card card">
                <div class="card-header collapsed" data-bs-toggle="collapse" data-bs-target="#collapseFamily" aria-expanded="false" aria-controls="collapseFamily">
                    @lang('labels.membersFamily')
                    <i class="fas fa-chevron-right arrow"></i>
                </div>
                <div id="collapseFamily" class="collapse">
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>@lang('labels.nomeCompleto')</th>
                                    <th>@lang('labels.dataNascimento')</th>
                                    <th>SSN</th>
                                    <th>@lang('labels.aplicarCobertura')</th>
                                    <th>@lang('labels.yearlyIncome')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($application->householdMembers as $member)
                                    <tr>
                                        <td>{{ $member->firstname }} {{ $member->middlename }} {{ $member->lastname }}</td>
                                        <td>{{ \Carbon\Carbon::parse($member->birthdate)->format('d/m/Y') }}</td>
                                        <td>{{ $member->ssn }}</td>
                                        {{-- <td>{{ $member->applying_coverage ? '@lang('labels.checkYes')' : '@lang('labels.checkNo')' }}</td> --}}
                                        <td>{{ $member->applying_coverage ? __('labels.checkYes') : __('labels.checkNo') }}</td>
                                        <td>{{ formatCurrency($member->income_predicted_amount) }} </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Informações de Contato -->
            @if ($application->contact)
                <div class="info-card card">
                    <div class="card-header collapsed" data-bs-toggle="collapse" data-bs-target="#collapseContacts" aria-expanded="false" aria-controls="collapseContacts">
                        @lang('labels.contatos')
                        <i class="fas fa-chevron-right arrow"></i>
                    </div>
                    <div id="collapseContacts" class="collapse">
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>@lang('labels.numeroTelefone')</th>
                                        <th>@lang('labels.campoTipo')</th>
                                        <th>@lang('labels.telSecundario')</th>
                                        <th>@lang('labels.tipoecundario')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ $application->contact->phone ?? __('labels.naoInformado') }}</td>
                                        <td>{{ $application->contact->phoneType->name ?? __('labels.naoInformado') }}</td>
                                        <td>{{ $application->contact->second_phone ?? __('labels.naoInformado') }}</td>
                                        <td>{{ $application->contact->secondPhoneType->name ?? __('labels.naoInformado') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Endereço -->
            @if ($application->householdMembers->isNotEmpty() && $application->householdMembers->first()->address)
                <div class="info-card card">
                    <div class="card-header collapsed" data-bs-toggle="collapse" data-bs-target="#collapseAddress" aria-expanded="false" aria-controls="collapseAddress">
                        @lang('labels.enderecoSem')
                        <i class="fas fa-chevron-right arrow"></i>
                    </div>
                    <div id="collapseAddress" class="collapse">
                        <div class="card-body">
                            @php $address = $application->householdMembers->first()->address; @endphp
                            <p><strong>@lang('labels.enderecoRua'):</strong> {{ $address->street_address }}, {{ $address->apte_ste }}</p>
                            <p><strong>@lang('labels.enderecoCidade'):</strong> {{ $address->city }}</p>
                            <p><strong>@lang('labels.enderecoEstado')</strong> {{ $address->state }}</p>
                            <p><strong>@lang('labels.enderecoCEP'):</strong> {{ $address->zipcode }}</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@php
function formatCurrency($value) {
    if (is_numeric($value)) {
        return '$' . number_format($value, 2, '.', ',');
    } else {
        return '$0';
    }
}
@endphp

