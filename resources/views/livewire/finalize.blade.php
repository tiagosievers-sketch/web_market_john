@extends('layouts.app')

@section('styles')
    {{-- <link rel="stylesheet" href="css/abaNavegacao.css"> --}}

    <style>
        .align-right {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            margin-bottom: 1rem;
        }

        .button-container {
            margin-top: -2px;
        }

        .table th h4 {
            text-transform: none;
        }

        .table th,
        .table td {
            vertical-align: middle;
            text-align: left;
        }
    </style>
@endsection

@section('content')
    @php
        function formatToUSD($value)
        {
            if (!is_numeric($value)) {
                return '-'; // Retorna um traço caso o valor não seja numérico
            }

            return '$' . number_format($value, 2, '.', ',');
        }
    @endphp
    <!-- BREADCRUMB -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <label class="col-form-label" style="font-size: 20px;">@lang('labels.finalizeTitulo') <br>
                <label class="col-form-label" tyle="font-size: 8px; display: inline;" id="timerReview">@lang('labels.reservarMinutos')
        </div>
        <div class="d-flex justify-content-between align-items-center">
            <div class="button-container">
                <button id="btnPrint" class="btn btn-outline-primary">@lang('labels.print')</button>
            </div>
        </div>
    </div>
    <!-- END BREADCRUMB -->

    <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="tab">
                    <button id="camposReview" class="tablinks active"
                        onclick="openTab(event, 'review')">@lang('labels.analise')</button>
                    <button id="campoAgreements" class="tablinks"
                        onclick="openTab(event, 'agreements')">@lang('labels.acordo')</button>
                    <button id="campoSign" class="tablinks" onclick="openTab(event, 'sign')">@lang('labels.sinal')</button>

                </div>
            </div>
        </div>
    </div>


    <!-- ROW -->
    <div id="review" class="tabcontent" style="display: block;">
        <div class=" col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="tab-content">
                        <div class="d-flex justify-content-between align-items-center">
                            <label class="col-form-label" style="font-size: 20px; color: blue;">@lang('labels.contatoPrincipal')</label>
                            <div class="button-container">
                                <button id="btnEditMainMember" class="btn btn-outline-primary">@lang('labels.buttonEditar')</button>
                            </div>
                        </div>
                        <div class="tab-pane active">
                            <h4 class="tx-15 mb-3">@lang('labels.nomeCompleto'): {{ $mainMember['firstname'] }}
                                {{ $mainMember['lastname'] }}</h4>
                            <h4 class="tx-15 mb-3">@lang('labels.endereco') {{ $mainMember['address']['street_address'] }} ,
                                {{ $mainMember['address']['city'] ?? '' }}
                                , {{ $mainMember['address']['state'] }} {{ $mainMember['address']['zipcode'] ?? '' }}</h4>
                            <h4 class="tx-15 mb-3">@lang('labels.telefone') {{ $application['contact']['phone'] ?? '' }}</h4>
                            <h4 class="tx-15 mb-3">@lang('labels.email') {{ $application['contact']['email'] ?? '' }}</h4>
                            <h4 class="tx-15 mb-3">@lang('labels.atualizacaoEmail') @if ($mail == 1)
                                    {{ __('labels.checkYes') }}
                                @else
                                    {{ __('labels.checkNo') }}
                                @endif
                            </h4>
                            <h4 class="tx-15 mb-3">@lang('labels.linguagemPreferido') {{ $writtenLanguage ?? '' }}
                            </h4>
                            <h4 class="tx-15 mb-3">@lang('labels.idiomaPreferido') {{ $spokenLanguage ?? '' }}</h4>
                        </div>
                    </div>
                </div>


                <!-- Modal de Edição First Member-->
                <div class="modal fade" id="editMainMemberModal" tabindex="-1" role="dialog"
                    aria-labelledby="editMainMemberModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editMainMemberModalLabel">@lang('labels.editMemberModal')</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                    id="closeModalButton">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="editMainMemberForm">
                                    <h6>@lang('labels.personalInformation')</h6>
                                    <div class="row mb-3">
                                        <div class="col-md-6 form-group">
                                            <label for="firstname">@lang('labels.nome') <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="firstname" name="firstname"
                                                placeholder="Digite seu nome" required>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="middlename">@lang('labels.campoMiddleName') <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="middlename" name="middlename"
                                                placeholder="Digite seu nome do meio" required>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="lastname">@lang('labels.sobreNome') <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="lastname" name="lastname"
                                                placeholder="Digite seu sobrenome" required>
                                        </div>
                                    </div>

                                    <h6>@lang('labels.campoEndereco')</h6>
                                    <div class="row mb-3">
                                        <div class="col-md-6 form-group">
                                            <label for="street">@lang('labels.enderecoRua') <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="street" name="street"
                                                placeholder="Rua, Avenida, etc." required>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="city">@lang('labels.enderecoCidade') <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="city" name="city"
                                                placeholder="Cidade" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6 form-group">
                                            <label for="state">@lang('labels.enderecoEstado') <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-select" id="state" name="state" required>
                                                <option value="" selected>@lang('labels.campoSelecao')</option>
                                                @foreach ($states as $key => $value)
                                                    <option value="{{ $value }}"
                                                        {{ isset($state) && $state == $value ? 'selected' : '' }}>
                                                        {{ $value }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="zipcode">@lang('labels.enderecoCEP') <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="zipcode" name="zipcode"
                                                placeholder="Código Postal" onchange="loadCounties(this,'county')"
                                                required>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6 form-group">
                                            <label for="county">@lang('labels.campoCounty')</label>
                                            <input type="text" id="county" name="county" class="form-control"
                                                value="{{ $mainMember['address']['county'] ?? '' }}" readonly>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="phone">@lang('labels.numeroTelefone') <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="phone" name="phone"
                                                placeholder="Número de Telefone" required>
                                        </div>
                                    </div>

                                    <h6>@lang('labels.contato')</h6>
                                    <div class="row mb-3">
                                        <div class="col-md-6 form-group">
                                            <label for="email">@lang('labels.enderecoEmail') <span
                                                    class="text-danger">*</span></label>
                                            <input type="email" class="form-control" id="email" name="email"
                                                placeholder="exemplo@dominio.com" required>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="updates">@lang('labels.atualizacaoEmail')</label>
                                            <select class="form-control" id="updates" name="updates">
                                                <option value="1">@lang('labels.checkYes')</option>
                                                <option value="0">@lang('labels.checkNo')</option>
                                            </select>
                                        </div>
                                    </div>
                                    <h6>@lang('labels.preferenciasLinguagem')</h6>
                                    <div class="row mb-3">
                                        <div class="col-md-6 form-group">
                                            <label for="writtenLanguage">@lang('labels.campoLinguagem') <span
                                                    class="text-danger">*</span></label>
                                            <select id="written_lang" name="written_lang" class="form-select" required>
                                                <option value="" selected>@lang('labels.campoSelecao')</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="spokenLanguage">@lang('labels.campoIdiomaFalado') <span
                                                    class="text-danger">*</span></label>
                                            <select id="spoken_lang" name="spoken_lang" class="form-select" required>
                                                <option value="" selected>@lang('labels.campoSelecao')</option>
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" id="cancelButton"
                                    data-dismiss="modal">@lang('labels.buttonCancelar')</button>
                                <button type="button" class="btn btn-primary"
                                    id="btnSaveChanges">@lang('labels.buttonSalvar')</button>
                            </div>
                        </div>
                    </div>
                </div>



            </div>



            <!--household membros-->
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <label class="col-form-label" style="font-size: 20px; color: blue;">@lang('labels.householdMembros')</label>
                </div>

                <table class="table table-hover ">
                    <thead>
                        <tr>
                            <th>
                                <h4 class="tx-15 mb-3">@lang('labels.householdMembros')</h4>
                            </th>
                            <th>
                                <h4 class="tx-15 mb-3">@lang('labels.dob')</h4>
                            </th>
                            <th>
                                <h4 class="tx-15 mb-3">@lang('labels.campoSexo')</h4>
                            </th>
                            <th>
                                <h4 class="tx-15 mb-3">@lang('labels.cpf')</h4>
                            </th>
                            <th>
                                <h4 class="tx-15 mb-3">@lang('labels.relacao')</h4>
                            </th>
                            <th>
                                <h4 class="tx-15 mb-3">@lang('labels.tabaco')</h4>
                            </th>
                            <th>
                                <h4 class="tx-15 mb-3">@lang('labels.aplicando')</h4>
                            </th>
                        </tr>

                    </thead>
                    <tbody>
                        @foreach ($householdMembers as $member)
                            <tr>
                                <td>{{ $member['firstname'] }} {{ $member['lastname'] }}</td>
                                <td>{{ \Carbon\Carbon::parse($member['birthdate'])->format('m/d/Y') }}</td>
                                <td>{{ $member['sexModel']['name'] }}</td>
                                <td>{{ $member['ssn'] ?? '-' }}</td>
                                <td>
                                    {{ $relationshipsByMember[$member['id']] ?? '-' }}
                                </td>
                                <td>{{ $member['use_tobacco'] == 1 ? __('labels.checkYes') : __('labels.checkNo') }}</td>
                                <td>{{ $member['applying_coverage'] == 1 ? __('labels.checkYes') : __('labels.checkNo') }}
                                </td>
                                <td>
                                    <button class="btn btn-primary btn-sm btn-edit-member"
                                        data-member-id="{{ $member['id'] }}" data-member='@json($member)'>
                                        @lang('labels.buttonEditar')
                                    </button>

                                </td>

                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>

            <!--edicao household modal -->
            <!-- Household Members Modal -->
            <div class="modal fade" id="editMemberModal" tabindex="-1" role="dialog"
                aria-labelledby="editMemberModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editMemberModalLabel">@lang('labels.editMemberModal')</h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="editMemberForm">
                            <div class="modal-body">
                                <input type="hidden" id="household_member_id" name="household_member_id">

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="firstnameHousehold">@lang('labels.nome')</label>
                                        <input type="text" class="form-control" id="firstnameHousehold"
                                            name="firstnameHousehold" required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="middlenameHousehold">@lang('labels.campoMiddleName')</label>
                                        <input type="text" class="form-control" id="middlenameHousehold"
                                            name="middlenameHousehold">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="lastnameHousehold">@lang('labels.sobreNome')</label>
                                        <input type="text" class="form-control" id="lastnameHousehold"
                                            name="lastnameHousehold" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="ssn">@lang('labels.campoNumero')</label>
                                        <input type="text" class="form-control" id="ssn" name="ssn">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="d-block">@lang('labels.temSSN')</label>
                                        <label class="ckbox wd-16 mg-b-0">
                                            <input class="mg-0" type="checkbox" value="0" name="has_ssn"
                                                id="has_ssn">
                                            <span>@lang('labels.temSSN')</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="birthdate">@lang('labels.dob')</label>
                                        <input type="text" class="form-control" id="birthdate" name="birthdate"
                                            required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="sex">@lang('labels.campoSexo')</label>
                                        <select class="form-select" id="sex" name="sex" required>
                                            @foreach ($sexes as $key => $value)
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="relationshipHousehold">@lang('labels.relacao')</label>
                                        <select class="form-select" id="relationshipHousehold"
                                            name="relationshipHousehold">
                                            <option value="" selected>@lang('labels.campoSelecao')</option>
                                            @foreach ($relationships as $key => $value)
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="use_tobacco">@lang('labels.tabaco')</label>
                                        <select class="form-select" id="use_tobacco" name="use_tobacco">
                                            <option value="1">@lang('labels.checkYes')</option>
                                            <option value="0">@lang('labels.checkNo')</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="applying_coverage">@lang('labels.aplicando')</label>
                                        <select class="form-select" id="applying_coverage" name="applying_coverage">
                                            <option value="1">@lang('labels.checkYes')</option>
                                            <option value="0">@lang('labels.checkNo')</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">@lang('labels.buttonCancelar')</button>
                                <button type="submit" class="btn btn-primary"
                                    id="saveChangesButtonHouseHold">@lang('labels.buttonSalvar')</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>



            <!-- modal de income -->
            <div class="card-body">
                <div class="tab-content">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <label class="col-form-label" style="font-size: 20px; color: blue;">@lang('labels.renda')</label>
                    </div>
                    <div class="tab-pane active">
                        {{-- Tabela de Rendas - INCOME --}}
                        @php $hasIncome = false; @endphp
                        <table class="table table-bordered table-sm">
                            <tbody>
                                @php $hasIncome = false; @endphp

                                @foreach ($mainMember->incomesAndDeductions as $incomeList)
                                    @if ($incomeList->type == 0)
                                        @php $hasIncome = true; @endphp

                                        {{-- Cabeçalho e valores para essa linha --}}
                                        @php
                                            $columns = [];
                                            $values = [];

                                            // Tipo de Renda
                                            $columns[] = __('labels.campoTipo');
                                            $values[] = $incomeTypes[$incomeList->income_deduction_type] ?? '-';

                                            // Valor
                                            if (isset($incomeList->amount) && $incomeList->amount > 0) {
                                                $columns[] = __('labels.amountIncome');
                                                $values[] = formatToUSD($incomeList->amount) ?? '-';
                                            }

                                            // Frequência
                                            $columns[] = __('labels.frequencia');
                                            $values[] = $frequencies[$incomeList->frequency] ?? '-';

                                            // Outros tipos de renda
                                            if (isset($incomeList->other_type)) {
                                                $columns[] = __('labels.otherIncomeType');
                                                $values[] = $incomeList->other_type ?? '-';
                                            }

                                            // Montante Educacional
                                            if (
                                                isset($incomeList->educational_amount) &&
                                                $incomeList->educational_amount > 0
                                            ) {
                                                $columns[] = __('labels.educationalAmount');
                                                $values[] = formatToUSD($incomeList->educational_amount) ?? '-';
                                            }

                                            // Montante Não Educacional
                                            if (
                                                isset($incomeList->non_educational_amount) &&
                                                $incomeList->non_educational_amount > 0
                                            ) {
                                                $columns[] = __('labels.nonEducationalAmount');
                                                $values[] = formatToUSD($incomeList->non_educational_amount) ?? '-';
                                            }

                                            // Nome do Empregador
                                            if (isset($incomeList->employer_name)) {
                                                $columns[] = __('labels.employerName');
                                                $values[] = $incomeList->employer_name ?? '-';
                                            }

                                            // Estado do Empregador
                                            if (isset($incomeList->employer_former_state)) {
                                                $columns[] = __('labels.employerState');
                                                $values[] = $incomeList->employer_former_state ?? '-';
                                            }

                                            // Telefone do Empregador
                                            if (isset($incomeList->employer_phone_number)) {
                                                $columns[] = __('labels.employerPhoneNumber');
                                                $values[] = $incomeList->employer_phone_number ?? '-';
                                            }

                                            // Data de Desemprego
                                            if (isset($incomeList->unemployment_date)) {
                                                $columns[] = __('labels.dataDesemprego');
                                                $date = \Carbon\Carbon::parse($incomeList->unemployment_date);
                                                $values[] = $date->format('m/d/Y') ?? '-';
                                            }
                                        @endphp

                                        {{-- Cabeçalho da Tabela --}}
                                        <thead>
                                            <tr>
                                                @foreach ($columns as $column)
                                                    <th><strong>{{ $column }}</strong></th>
                                                @endforeach
                                                {{-- Adicione colunas vazias até completar 4 --}}
                                                @for ($i = count($columns); $i < 4; $i++)
                                                    <th></th>
                                                @endfor
                                                <th>@lang('labels.textAcoes')</th>
                                            </tr>
                                        </thead>

                                        {{-- Valores da Tabela --}}
                                        <tr>
                                            @foreach ($values as $value)
                                                <td>{{ $value }}</td>
                                            @endforeach
                                            {{-- Adicione células vazias até completar 4 --}}
                                            @for ($i = count($values); $i < 4; $i++)
                                                <td></td>
                                            @endfor
                                            <td>
                                                <button class="btn btn-primary btn-sm btn-edit-income"
                                                    data-income='@json($incomeList)'>
                                                    @lang('labels.buttonEditar')
                                                </button>
                                            </td>
                                        </tr>
                                        <thead>
                                            <tr>
                                                <th colspan="{{ count($columns) + 1 }}" class="empty-row"></th>
                                            </tr>
                                        </thead>
                                    @endif
                                @endforeach

                                {{-- Caso não haja dados de renda --}}
                                @unless ($hasIncome)
                                    <tr>
                                        <td colspan="9" class="text-center"><strong>@lang('labels.semRenda')</strong></td>
                                    </tr>
                                @endunless
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
            <!--Fim modal income-->


            <!-- Modal de edicao income -->
            <div class="modal fade" id="editIncomeModal" tabindex="-1" role="dialog"
                aria-labelledby="editIncomeModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editIncomeModalLabel">@lang('labels.incomes')</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="editIncomeForm">
                            <div class="modal-body">
                                <!-- Campos do formulário -->
                                <input type="hidden" id="income_id" name="income_id">

                                <div class="mb-3">
                                    <label for="income_deduction_type">@lang('labels.campoTipo')</label>
                                    <input type="text" class="form-control" id="income_deduction_type" readonly>
                                </div>

                                <div class="mb-3">
                                    <label for="amountIncome">@lang('labels.amountIncome')</label>
                                    <input type="text" class="form-control" id="amountIncome">
                                </div>

                                <div class="mb-3">
                                    <label for="frequency">@lang('labels.frequencia')</label>
                                    <select class="form-select" id="frequency" name="frequency" required>
                                        <option value="" selected>@lang('labels.campoSelecao')</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="educational_amount">@lang('labels.educationalAmount')</label>
                                    <input type="text" class="form-control" id="educational_amount">
                                </div>

                                <div class="mb-3">
                                    <label for="non_educational_amount">@lang('labels.nonEducationalAmount')</label>
                                    <input type="text" class="form-control" id="non_educational_amount">
                                </div>

                                <div class="mb-3">
                                    <label for="other_type">@lang('labels.otherIncomeType')</label>
                                    <input type="text" class="form-control" id="other_type">
                                </div>

                                <div class="mb-3">
                                    <label for="employer_name">@lang('labels.employerName')</label>
                                    <input type="text" class="form-control" id="employer_name">
                                </div>

                                <div class="mb-3">
                                    <label for="employer_former_state">@lang('labels.employerState')</label>
                                    <input type="text" class="form-control" id="employer_former_state">
                                </div>

                                <div class="mb-3">
                                    <label for="employer_phone_number">@lang('labels.employerPhoneNumber')</label>
                                    <input type="text" class="form-control" id="employer_phone_number">
                                </div>

                                <div class="mb-3">
                                    <label for="unemployment_date">@lang('labels.dataDesemprego')</label>
                                    <input type="text" class="form-control" id="unemployment_date">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" id="cancelIncomeButton"
                                    data-dismiss="modal">@lang('labels.buttonCancelar')</button>
                                <button type="submit" class="btn btn-primary"
                                    id="saveChangesButtonIncome">@lang('labels.buttonSalvar')</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>



            <!-- Deduções -->
            <div class="card-body">
                <div class="tab-content">
                    <div class="d-flex justify-content-between align-items-center">
                        <label class="col-form-label" style="font-size: 20px; color: blue;">@lang('labels.deducoes')</label>
                    </div>
                    <div class="tab-pane active">
                        {{-- Tabela de Dedutíveis --}}
                        <table class="table table-bordered">
                            <tbody>
                                @php $hasDeduction = false; @endphp

                                @foreach ($mainMember->incomesAndDeductions as $deduction)
                                    @if ($deduction->type == 1 && $deduction->amount > 0)
                                        @php $hasDeduction = true; @endphp

                                        {{-- Cabeçalho para cada linha --}}
                                        <thead>
                                            <tr>
                                                <th>@lang('labels.campoTipo')</th>
                                                <th>@lang('labels.amountIncome')</th>
                                                <th>@lang('labels.frequencia')</th>
                                                @isset($deduction->other_type)
                                                    <th>@lang('labels.otherIncomeType')</th>
                                                @else
                                                    <th></th> {{-- Coluna em branco para manter 4 colunas --}}
                                                @endisset
                                                <th>@lang('labels.textAcoes')</th>
                                            </tr>
                                        </thead>

                                        {{-- Dados para a linha atual --}}
                                        <tr>
                                            <td>{{ $deductionTypes[$deduction->income_deduction_type] ?? 'N/A' }}</td>
                                            <td>{{ formatToUSD($deduction->amount) }}</td>
                                            <td>{{ $frequencies[$deduction->frequency] ?? '-' }}</td>
                                            @isset($deduction->other_type)
                                                <td>{{ $deduction->other_type }}</td>
                                            @else
                                                <td></td> {{-- Célula em branco --}}
                                            @endisset
                                            <td> <!-- Coluna de ações -->
                                                <button class="btn btn-primary btn-sm btn-edit-deduction"
                                                    data-deduction='@json($deduction)'>
                                                    @lang('labels.buttonEditar')
                                                </button>
                                            </td>
                                        </tr>

                                        {{-- Linha vazia para espaçamento entre os grupos --}}
                                        <thead>
                                            <tr>
                                                <th colspan="10" class="empty-row"></th>
                                            </tr>
                                        </thead>
                                    @endif
                                @endforeach

                                {{-- Caso não haja dados de deduções --}}
                                @unless ($hasDeduction)
                                    <tr>
                                        <td colspan="10" class="text-center"><strong>@lang('labels.noDeducoes')</strong></td>
                                    </tr>
                                @endunless
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Deduções -->


            <!--modal de edicao da deductions-->
            <div class="modal fade" id="editDeductionModal" tabindex="-1" role="dialog"
                aria-labelledby="editDeductionModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editDeductionModalLabel">@lang('labels.deductions')</h5>
                            <button type="button" class="close" id="closeModalButton" data-dismiss="modal"
                                aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="editDeductionForm">
                            <div class="modal-body">
                                <input type="hidden" id="deduction_id" name="deduction_id">

                                <div class="mb-3">
                                    <label for="deduction_type">@lang('labels.campoTipo')</label>
                                    <input type="text" class="form-control" id="deduction_type" name="deduction_type"
                                        readonly>
                                </div>

                                <div class="mb-3">
                                    <label for="amountDeduction">@lang('labels.amountIncome')</label>
                                    <input type="text" class="form-control" id="amountDeduction"
                                        name="amountDeduction" required>
                                </div>

                                <div class="mb-3">
                                    <label for="frequencyDeduction">@lang('labels.frequencia')</label>
                                    <select class="form-select" id="frequencyDeduction" name="frequencyDeduction"
                                        required>
                                        @foreach ($frequencies as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>


                                <div class="mb-3">
                                    <label for="other_typeDeduction">@lang('labels.otherIncomeType')</label>
                                    <input type="text" class="form-control" id="other_typeDeduction"
                                        name="other_typeDeduction">
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" id="closeEditDeductionModal"
                                    data-dismiss="modal">@lang('labels.buttonCancelar')</button>
                                <button type="submit" id="saveChangesButtonDeduction"
                                    class="btn btn-primary">@lang('labels.buttonSalvar')</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!--fim modal de edicao da deductions-->





            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 mb-3">
                        <a href="" class="btn btn-primary btn-lg btn-block">@lang('labels.buttonVoltar')</a>
                    </div>
                    <div class="col-lg-6 mb-3">
                        <button id="btnContinue" class="btn btn-secondary btn-lg btn-block"
                            onclick="openTab(event, 'agreements')">@lang('labels.buttonContinue')</button>
                    </div>
                </div>
            </div>
        </div>

    </div>


    </div>
    <!-- END ROW -->


    <!-- ROW -->
    <div id="agreements" class="tabcontent" style="display: none;">
        <div class=" col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="tab-content">
                        <div class="d-flex justify-content-between align-items-center">
                            <label class="col-form-label"
                                style="font-size: 20px; color: blue;">@lang('labels.acordo')</label><br>
                        </div>
                        <div class="tab-pane active">
                            <label class="col-form-label">@lang('labels.atestados')</label>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <label class="col-form-label" style="font-size: 20px; color: blue;">@lang('labels.renovacao')</label>
                    </div>
                    <div class="tab-pane active">
                        <label class="col-form-label">@lang('labels.determinacao')</label>
                    </div>

                    <div class="row row-sm">
                        <div class="col-lg-6 mb-3">
                            <div class="input-group">
                                <div class="input-group-text">
                                    <label class="rdiobox wd-16 mg-b-0">
                                        <input class="mg-0" type="radio" name="checkcconcordancia"
                                            id="checkYesconcordo" value="1">
                                        <span></span>
                                    </label>
                                </div>
                                <div class="form-control">@lang('labels.concordo')</div>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <div class="input-group">
                                <div class="input-group-text">
                                    <label class="rdiobox wd-16 mg-b-0">
                                        <input class="mg-0" type="radio" name="checkcconcordancia"
                                            id="checkNodiscordo" value="0">
                                        <span></span>
                                    </label>
                                </div>
                                <div class="form-control">@lang('labels.discordo')</div>
                            </div>
                        </div>


                        <div class="form-group row align-items-center" id="anos" style="display:none">
                            <label class="col-form-label ">
                                @lang('labels.elegibilidadeRenovada') <br>
                                @lang('labels.pagarCobertura')</label>
                            <div class="col-lg-6 mb-3">
                                <div class="input-group">
                                    <select class="form-select" name="yearRenewed" id="yearRenewed">
                                        <option value="" selected>@lang('labels.campoSelecao')</option>
                                        @foreach ($years as $key => $value)
                                            <option value="{{ $key }}">@lang('labels.' . $value)</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <button id="btnBack" class="btn btn-primary btn-lg btn-block"
                                onclick="openTab(event, 'review')">@lang('labels.buttonVoltar')</button>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <button id="btnContinueTwo" class="btn btn-secondary btn-lg btn-block"
                                onclick="openTab(event, 'sign')">@lang('labels.buttonContinue')</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>


    </div>
    <!-- END ROW -->

    <!-- ROW -->
    <div id="sign" class="tabcontent" style="display: none;">
        <div class=" col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="tab-content">
                        <div class="d-flex justify-content-between align-items-center">
                            <label class="col-form-label"
                                style="font-size: 20px; color: blue;">@lang('labels.assineEnvie')</label><br>
                        </div>
                        <div class="tab-pane active">
                            <label class="col-form-label">@lang('labels.atestados')</label>
                            <label class="col-form-label">@lang('labels.programaInscrito')</label>
                        </div>

                        <div class="row row-sm">
                            <div class="col-lg-6 mb-3">
                                <div class="input-group">
                                    <div class="input-group-text">
                                        <label class="rdiobox wd-16 mg-b-0">
                                            <input class="mg-0" type="radio" name="checkcconcordanciasign"
                                                id="checkYesconcordosign" value="1">
                                            <span></span>
                                        </label>
                                    </div>
                                    <div class="form-control">@lang('labels.concordo')</div>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="input-group">
                                    <div class="input-group-text">
                                        <label class="rdiobox wd-16 mg-b-0">
                                            <input class="mg-0" type="radio" name="checkcconcordanciasign"
                                                id="checkNodiscordosign" value="0">
                                            <span></span>
                                        </label>
                                    </div>
                                    <div class="form-control">@lang('labels.discordo')</div>
                                </div>
                            </div>


                            <div class="form-group row align-items-center" id="inscritoCobertura" style="display:none">
                                <label class="col-form-label ">
                                    @lang('labels.inscritoCobertura')</label>
                                <div class="col-lg-6 mb-3">

                                    <div class="input-group">
                                        <div class="input-group-text">
                                            <label class="rdiobox wd-16 mg-b-0">
                                                <input class="mg-0" type="radio" name="checkcMarketplace"
                                                    id="checkYespermitirMarketplace" value="1">
                                                <span></span>
                                            </label>
                                        </div>
                                        <div class="form-control">@lang('labels.permitirMarketplace')</div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <div class="input-group">
                                        <div class="input-group-text">
                                            <label class="rdiobox wd-16 mg-b-0">
                                                <input class="mg-0" type="radio" name="checkcMarketplace"
                                                    id="checkNoPermitirMarketplace" value="0">
                                                <span></span>
                                            </label>
                                        </div>
                                        <div class="form-control">@lang('labels.naoPermitirMarketplace')</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="card-body">
                    <div class="tab-content">
                        <div class="d-flex justify-content-between align-items-center">
                            <label class="col-form-label"
                                style="font-size: 20px; color: blue;">@lang('labels.sinal')</label><br>
                        </div>
                        <div class="tab-pane active">
                            <label class="col-form-label">@lang('labels.requerimento')</label>
                        </div>

                        <div class="row row-sm">
                            <div class="col-lg-6 mb-3">
                                <div class="input-group">
                                    <div class="input-group-text">
                                        <label class="rdiobox wd-16 mg-b-0">
                                            <input class="mg-0" type="radio" name="checkcrequerimento"
                                                id="checkYesrequerimento" value="1">
                                            <span></span>
                                        </label>
                                    </div>
                                    <div class="form-control">@lang('labels.concordo')</div>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="input-group">
                                    <div class="input-group-text">
                                        <label class="rdiobox wd-16 mg-b-0">
                                            <input class="mg-0" type="radio" name="checkcrequerimento"
                                                id="checkNorequerimento" value="0">
                                            <span></span>
                                        </label>
                                    </div>
                                    <div class="form-control">@lang('labels.discordo')</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 mb-3" id="assinarEtronicamente" style="display:none;">
                            <div class="input-group">
                                <div class="input-group-text">
                                    @lang('labels.nomeCompleto'):
                                </div>
                                <input type="text" class="form-control" id="full_name">
                            </div>
                        </div>
                    </div>

                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <button id="btnBackTree" class="btn btn-primary btn-lg btn-block"
                                onclick="openTab(event, 'agreements')">@lang('labels.buttonVoltar')</button>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <button id="btnContinueTree"
                                class="btn btn-secondary btn-lg btn-block">@lang('labels.buttonContinue')</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>





    <!-- END ROW -->
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('build/assets/plugins/jquery.maskedinput/jquery.maskedinput.js') }}"></script>

    <!--    Aba de Navegacao JS -->
    <script src="{{ asset('js/finalize/paginacaoFinalize.js') }}"></script>
    <!--    Seleconar Check -->
    <script src="{{ asset('js/finalize/selecionarCheck.js') }}"></script>



    <script>
        function getFormData() {
            const applicationId = '{{ $application_id ?? 0 }}';

            const formData = {
                application_id: applicationId,
                allow_marketplace_income_data: $('input[name="checkcconcordancia"]:checked').val() || 0,
                years_renewal_of_eligibility: parseInt($('input[name="checkcconcordancia"]:checked').val(), 10) || $(
                    '#yearRenewed').val() || '',
                attestation_statement: $('input[name="checkcconcordanciasign"]:checked').val() || 0,
                marketplace_permission: $('input[name="checkcMarketplace"]:checked').val() || 0,
                penalty_of_perjury_agreement: $('input[name="checkcrequerimento"]:checked').val() || 0,
                full_name: $('#full_name').val() || '',
            };


            return formData;
        }


        function sendData() {
            const data = getFormData();
            const csrf_token = '{{ csrf_token() }}';

            const applicationId = '{{ $application_id }}';

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': csrf_token,
                    'Content-Type': 'application/json'
                },
                url: "{{ route('finalize.store', ['application_id' => $application_id]) }}",
                type: "POST",
                data: JSON.stringify(data), // Converte o objeto data para uma string JSON
                contentType: "application/json",
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            title: '@lang('labels.sucesso')!',
                            text: '@lang('labels.dadosSalvos')',
                            icon: 'success',
                            confirmButtonText: 'Ok',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href =
                                    "{{ route('index') }}";
                            }
                        });
                    }
                },
                error: function(xhr, status, error) {
                    // Manipule o erro
                    console.error('Error:', error);
                    alert('An error occurred while sending data.');
                }
            });
        }

        // Adicione um evento de clique ao botão de continuar
        $(document).ready(function() {
            // Evento de clique para o botão de impressão
            $('#btnPrint').on('click', function() {
                window.print(); // Chama a função de impressão do navegador
            });

            // Adicione um evento de clique ao botão de continuar
            $('#btnContinueTree').on('click', function(event) {
                event.preventDefault();
                console.log('Botão btnContinueTree clicado!'); // Verifique se este log aparece

                sendData();
            });

            $('#closeModalButton').on('click', function() {
                $('#editMainMemberModal').modal('hide');
            });

            // Evento de clique para o botão de cancelar
            $('#cancelButton').on('click', function() {
                $('#editMainMemberModal').modal('hide');
            });


            $('#btnEditMainMember').on('click', function() {

                // Dados do membro principal
                const mainMember = {
                    firstname: '{{ $mainMember['firstname'] }}',
                    middlename: '{{ $mainMember['middlename'] }}',
                    lastname: '{{ $mainMember['lastname'] }}',
                    written_lang: '{{ $languageId ?? '' }}',
                    spoken_lang: '{{ $spokenLanguageId ?? '' }}',
                    address: {
                        street: '{{ $mainMember['address']['street_address'] }}',
                        city: '{{ $mainMember['address']['city'] }}',
                        state: '{{ $mainMember['address']['state'] }}',
                        zipcode: '{{ $mainMember['address']['zipcode'] }}',
                        county: '{{ $mainMember['address']['county'] }}'
                    }
                };
                console.log('Main Member:', mainMember);

                const languages = @json($languages);

                const writtenLangSelect = $('#written_lang');
                const spokenLangSelect = $('#spoken_lang');

                // Limpar e preencher os selects
                writtenLangSelect.empty();
                spokenLangSelect.empty();

                writtenLangSelect.append('<option value="" selected>@lang('labels.campoSelecao')</option>');
                spokenLangSelect.append('<option value="" selected>@lang('labels.campoSelecao')</option>');

                Object.entries(languages).forEach(([key, value]) => {
                    const writtenSelected = parseInt(mainMember.written_lang) === parseInt(key) ?
                        'selected' : '';
                    const spokenSelected = parseInt(mainMember.spoken_lang) === parseInt(key) ?
                        'selected' : '';

                    writtenLangSelect.append(
                        `<option value="${key}" ${writtenSelected}>${value}</option>`
                    );
                    spokenLangSelect.append(
                        `<option value="${key}" ${spokenSelected}>${value}</option>`
                    );
                });


                // Preencher outros campos do formulário
                $('#firstname').val(mainMember.firstname);
                $('#middlename').val(mainMember.middlename);
                $('#lastname').val(mainMember.lastname);
                $('#street').val(mainMember.address.street);
                $('#city').val(mainMember.address.city);
                $('#state').val(mainMember.address.state);
                $('#zipcode').val(mainMember.address.zipcode);
                $('#county').val(mainMember.address.county);

                // Dados de contato
                $('#phone').val('{{ $application['contact']['phone'] ?? '' }}');
                $('#email').val('{{ $application['contact']['email'] ?? '' }}');

                // Atualizar select de envio de e-mails
                $('#updates').val('{{ $mail }}');

                // Mostrar a modal
                $('#editMainMemberModal').modal('show');
            });



        });

        const applicationId = '{{ $application_id }}';
        const memberId = '{{ $mainMemberId }}';

        $('#btnSaveChanges').on('click', function() {
            const data = {
                application_id: applicationId,
                household_member_id: memberId,
                firstname: $('#firstname').val(),
                middlename: $('#middlename').val(),
                lastname: $('#lastname').val(),
                street_address: $('#street').val(),
                phone: $('#phone').val(),
                email: $('#email').val(),
                send_email: $('#updates').val(),
                written_lang: $('#written_lang').val(),
                spoken_lang: $('#spoken_lang').val(),
                county: $('#county').val(),
                city: $('#city').val(),
                state: $('#state').val(),
                zipcode: $('#zipcode').val(),
            };

            $('#editMainMemberModal').modal('hide');

            const csrf_token = '{{ csrf_token() }}';
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': csrf_token,
                    'Content-Type': 'application/json'
                },
                url: "{{ route('finalize.update', ['application_id' => '__application_id__', 'member_id' => '__member_id__']) }}"
                    .replace('__application_id__', applicationId).replace('__member_id__', memberId),
                type: "POST",
                data: JSON.stringify(data),
                contentType: "application/json",
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            title: '@lang('labels.sucesso')!',
                            text: '@lang('labels.dadosSalvos')',
                            icon: 'success',
                            confirmButtonText: 'Ok',
                        }).then(() => {
                            location
                                .reload();
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    alert('An error occurred while saving data.');
                }
            });
        });

        function loadCounties(element, targetElem) {
            const csrf_token = '{{ csrf_token() }}';
            const selectElem = $('#' + targetElem);

            // Desabilita o select enquanto carrega os dados
            selectElem.prop('disabled', true);

            // Verifica se o CEP foi inserido e não está vazio
            if ('value' in element && element.value.trim() !== '') {
                let zipcode = element.value.trim(); // Remove espaços em branco

                // Limpa todas as opções do select, incluindo a opção "Select"
                selectElem.find('option[value=""]').remove(); // Remove explicitamente a opção vazia, se existir
                selectElem.empty(); // Limpa completamente o select

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': csrf_token
                    },
                    url: "{{ route('geography.counties', '') }}/" + zipcode,
                    type: "GET",
                    success: function(response) {
                        if ('status' in response && 'data' in response) {
                            if (response.status === 'success' && response.data.length > 0) {
                                // Itera sobre os counties recebidos e adiciona no select
                                response.data.forEach((county) => {
                                    let optionElement = document.createElement('option');
                                    optionElement.value = county;
                                    optionElement.innerHTML = county;
                                    document.getElementById(targetElem).appendChild(optionElement);
                                });

                                // Seleciona automaticamente o primeiro item
                                selectElem.val(response.data[0]); // Seleciona o primeiro county
                            } else {
                                console.log('Nenhum condado encontrado');
                            }
                        } else {
                            console.log('Resposta inesperada:', response);
                        }

                        // Reabilita o select após o carregamento
                        selectElem.prop('disabled', false);
                    },
                    error: function(error) {
                        console.error('Erro na requisição:', error);
                        selectElem.prop('disabled', false);
                    }
                });
            } else {
                // Se o campo de CEP estiver vazio, redefina o select com a opção padrão
                selectElem.empty(); // Limpa completamente o select
                let defaultOption = document.createElement('option');
                defaultOption.value = '';
                defaultOption.innerHTML = '@lang('labels.campoSelecao')'; // Mensagem padrão
                document.getElementById(targetElem).appendChild(defaultOption);
                selectElem.prop('disabled', false);
            }
        }


        // modal de edit houhold
        $(document).ready(function() {
            // Abrir modal para editar membro individual
            $('.btn-edit-member').on('click', function() {
                const memberData = $(this).data('member');
                const relationships = @json($relationshipsWithNames);
                const relationshipsFull = @json($relationships);

                console.log('Dados do membro:', memberData);

                // Preencher os campos do formulário
                $('#household_member_id').val(memberData.id || '');
                $('#firstnameHousehold').val(memberData.firstname || '');
                $('#middlenameHousehold').val(memberData.middlename || '');
                $('#lastnameHousehold').val(memberData.lastname || '');

                // Gerenciar o estado inicial do SSN e do checkbox
                if (memberData.ssn && memberData.ssn.trim() !== '') {
                    $('#ssn').val(memberData.ssn || '').prop('disabled', false).attr('required',
                    'required');
                    $('#has_ssn').prop('checked', false); // Não marcar o checkbox
                } else {
                    $('#ssn').val('').prop('disabled', false).removeAttr('required');
                    $('#has_ssn').prop('checked', true); // Marcar o checkbox
                }

                if (memberData.birthdate && memberData.birthdate.trim() !== '') {
                    const parts = memberData.birthdate.split('-');
                    const rawDate = new Date(parts[0], parts[1] - 1, parts[2]);
                    const formattedDate = rawDate.toLocaleDateString('en-US', {
                        year: 'numeric',
                        month: '2-digit',
                        day: '2-digit',
                    });

                    $('#birthdate').val(formattedDate || '');
                }

                $('#birthdate').mask('99/99/9999');
                $('#sex').val(memberData.sex || '');

                // Preencher o relacionamento
                const currentRelationship = relationships.find(
                    (relationship) => relationship.member_to_id === memberData.id
                );

                console.log('Relacionamento encontrado:', currentRelationship);

                if (currentRelationship) {
                    const relationshipIndex = Object.keys(relationshipsFull).find(
                        (key) => relationshipsFull[key] === currentRelationship.relationship_name
                    );

                    if (relationshipIndex) {
                        $('#relationshipHousehold').val(relationshipIndex).change();
                    } else {
                        $('#relationshipHousehold').val('').change();
                    }
                } else {
                    $('#relationshipHousehold').val('').change();
                }

                $('#use_tobacco').val(memberData.use_tobacco !== undefined ? memberData.use_tobacco : '');
                $('#applying_coverage').val(
                    memberData.applying_coverage !== undefined ? memberData.applying_coverage : ''
                );

                // Mostrar a modal
                $('#editMemberModal').modal('show');
            });

            // Alterar comportamento do campo SSN ao marcar o checkbox
            $('#has_ssn').on('change', function() {
                const ssnValue = $('#ssn').val().trim();
                if ($(this).is(':checked') || ssnValue === '') {
                    // Checkbox marcado ou SSN vazio: desabilitar o campo SSN e ajustar has_ssn para 0
                    $('#ssn').val('').prop('disabled', true).removeAttr('required');
                    $('#has_ssn').val(0); // Atualizar o valor escondido
                } else {
                    // Checkbox desmarcado e SSN preenchido: habilitar o campo SSN e ajustar has_ssn para 1
                    $('#ssn').prop('disabled', false).attr('required', 'required');
                    $('#has_ssn').val(1); // Atualizar o valor escondido
                }
            });

            // Submeter os dados do formulário
            $('#editMemberForm').on('submit', function(event) {
                event.preventDefault();

                // Obter o valor do campo SSN
                const ssnValue = $('#ssn').val().trim();

                // Determinar o valor de `has_ssn`
                const hasSsnValue = ssnValue !== '' ? 1 : 0;

                // Atualizar o campo hidden `has_ssn`
                $('#has_ssn').val(hasSsnValue);

                let formData = $(this).serialize(); // Serializa todos os campos do formulário
                const application_id = '{{ $application_id }}';
                formData += `&application_id=${application_id}`;

                const csrf_token = '{{ csrf_token() }}';

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': csrf_token,
                    },
                    url: "{{ route('finalize.householdFinalize.update') }}",
                    type: 'POST',
                    data: formData,
                    beforeSend: function() {
                        $('#editMemberModal').modal('hide');
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire({
                                title: '@lang('labels.sucesso')!',
                                text: '@lang('labels.dadosSalvos')',
                                icon: 'success',
                                confirmButtonText: 'Ok',
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                title: '@lang('labels.erro')!',
                                text: response.message || '@lang('labels.erroPadrao')',
                                icon: 'error',
                                confirmButtonText: 'Ok',
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Erro na requisição:', error);
                        Swal.fire({
                            title: '@lang('labels.erro')!',
                            text: '@lang('labels.erroPadrao')',
                            icon: 'error',
                            confirmButtonText: 'Ok',
                        });
                    },
                });
            });
        });






        $(document).on('click', '#saveChangesButtonHouseHold', function() {
            $('#editMemberForm').modal('hide');
        })



        //Modal income edit
        $(document).ready(function() {
            // Função para preencher os dados na modal de edição
            const currencyFields = ['#amountIncome', '#educational_amount', '#non_educational_amount'];
            currencyFields.forEach(fieldId => {
                const field = $(fieldId);
                field.on('focus', removeCurrencyFormatOnFocus); // Remove formatação ao focar
                field.on('input', formatCurrencyOnInput); // Formata enquanto digita
                field.on('blur', formatCurrencyOnBlur); // Aplica formatação ao sair do campo
            });

            // Se necessário, adicione essas ações também ao abrir a modal
            $('#editIncomeModal').on('show.bs.modal', function() {
                currencyFields.forEach(fieldId => {
                    const field = $(fieldId);
                    field.off('focus').on('focus',
                        removeCurrencyFormatOnFocus); // Garante que o evento será reatribuído
                    field.off('input').on('input', formatCurrencyOnInput);
                    field.off('blur').on('blur', formatCurrencyOnBlur);
                });
            });

            function fillIncomeData(incomeData) {
                income_deduction_type = incomeData.type_of_income_deduction?.id || '';

                const frequencies = @json($frequencies);
                const selectedFrequency = incomeData.frequency || '';

                const frequencySelect = $('#frequency');
                frequencySelect.empty(); // Limpa o dropdown

                // Adiciona opções ao select
                frequencySelect.append('<option value="" selected>-- Selecione --</option>');
                for (const [key, value] of Object.entries(frequencies)) {
                    const isSelected = key == selectedFrequency ? 'selected' : '';
                    frequencySelect.append(`<option value="${key}" ${isSelected}>${value}</option>`);
                }

                console.log('Preenchendo modal com dados:', incomeData);

                // Campos básicos
                $('#income_id').val(incomeData.id || '');
                $('#income_deduction_type').val(incomeData.type_of_income_deduction?.name || '');
                $('#amountIncome').val(incomeData.amount || '');
                formatCurrencyOnInput({
                    target: document.getElementById('amountIncome')
                });

                // Verifique os valores de cada campo
                console.log('Amount:', incomeData.amount);
                if (incomeData.amount === 0 || incomeData.amount === "0" || incomeData.amount === null) {
                    $('#amountIncome').closest('.mb-3').hide(); // Esconde o campo
                } else {
                    $('#amountIncome').closest('.mb-3').show(); // Exibe o campo
                }


                console.log('Educational Amount:', incomeData.educational_amount);
                $('#educational_amount').val(incomeData.educational_amount || '');
                formatCurrencyOnInput({
                    target: document.getElementById('educational_amount')
                });
                if (incomeData.educational_amount === 0 || incomeData.educational_amount === "0" || incomeData
                    .educational_amount === null) {
                    $('#educational_amount').closest('.mb-3').hide();
                } else {
                    $('#educational_amount').closest('.mb-3').show();
                }

                console.log('Non-Educational Amount:', incomeData.non_educational_amount);
                $('#non_educational_amount').val(incomeData.non_educational_amount || '');
                formatCurrencyOnInput({
                    target: document.getElementById('non_educational_amount')
                });
                if (incomeData.non_educational_amount === 0 || incomeData.non_educational_amount === "0" ||
                    incomeData.non_educational_amount === null) {
                    $('#non_educational_amount').closest('.mb-3').hide();
                } else {
                    $('#non_educational_amount').closest('.mb-3').show();
                }


                // Campos adicionais
                $('#frequency').val(incomeData.frequency?.id || '');
                // Other Type
                if (incomeData.other_type && incomeData.other_type.trim() !== '') {
                    $('#other_type').closest('.mb-3').show();
                    $('#other_type').val(incomeData.other_type);
                } else {
                    $('#other_type').closest('.mb-3').hide();
                }

                // Employer Name
                if (incomeData.employer_name && incomeData.employer_name.trim() !== '') {
                    $('#employer_name').closest('.mb-3').show();
                    $('#employer_name').val(incomeData.employer_name);
                } else {
                    $('#employer_name').closest('.mb-3').hide();
                }

                // Employer Former State
                if (incomeData.employer_former_state && incomeData.employer_former_state.trim() !== '') {
                    $('#employer_former_state').closest('.mb-3').show();
                    $('#employer_former_state').val(incomeData.employer_former_state);
                } else {
                    $('#employer_former_state').closest('.mb-3').hide();
                }

                // Employer Phone Number 
                if (incomeData.employer_phone_number && incomeData.employer_phone_number.trim() !== '') {
                    $('#employer_phone_number').closest('.mb-3').show();
                    $('#employer_phone_number').val(incomeData.employer_phone_number);
                } else {
                    $('#employer_phone_number').closest('.mb-3').hide();
                }
                console.log('Unemployment Date:', incomeData.unemployment_date);


                if (incomeData.unemployment_date && incomeData.unemployment_date.trim() !== '') {
                    // Quebra a string de data no formato YYYY-MM-DD
                    const parts = incomeData.unemployment_date.split('-'); // ["2001", "12", "31"]

                    // Cria a data usando os componentes (ano, mês, dia)
                    const rawDate = new Date(parts[0], parts[1] - 1, parts[2]); // Mês é zero-based

                    // Converte a data para o formato MM/DD/YYYY
                    const formattedDate = rawDate.toLocaleDateString('en-US', {
                        year: 'numeric',
                        month: '2-digit',
                        day: '2-digit',
                    });

                    // Exibe e preenche o campo de texto
                    $('#unemployment_date').closest('.mb-3').show();
                    $('#unemployment_date').val(formattedDate);
                    console.log('formattedDate:', formattedDate); // Confirmação no console
                } else {
                    $('#unemployment_date').closest('.mb-3').hide();
                }


            }


            // Função para enviar os dados
            function sendIncomeData() {
                const data = {
                    income_id: $('#income_id').val(),
                    income_deduction_type: income_deduction_type,
                    amount: removeCurrencyFormat($('#amountIncome').val()),
                    frequency: $('#frequency').val(),
                    employer_name: $('#employer_name').val(),
                    employer_former_state: $('#employer_former_state').val(),
                    educational_amount: removeCurrencyFormat($('#educational_amount').val()),
                    non_educational_amount: removeCurrencyFormat($('#non_educational_amount').val()),
                    other_type: $('#other_type').val(),
                    employer_phone_number: $('#employer_phone_number').val(),
                    unemployment_date: $('#unemployment_date').val(),
                    type_of_work: $('#type_of_work').val(),
                };

                const csrf_token = '{{ csrf_token() }}';

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': csrf_token
                    },
                    url: "{{ route('finalize.income.update') }}",
                    type: "POST",
                    data: JSON.stringify(data),
                    contentType: "application/json",
                    success: function(response) {
                        if (response.status === 'success') {
                            $('#editIncomeModal').modal('hide');
                            Swal.fire({
                                title: '@lang('labels.sucesso')!',
                                text: '@lang('labels.dadosSalvos')',
                                icon: 'success',
                                confirmButtonText: 'Ok'
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                title: '@lang('labels.erro')!',
                                text: response.message || '@lang('labels.erroPadrao')',
                                icon: 'error',
                                confirmButtonText: 'Ok'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            title: '@lang('labels.erro')!',
                            text: '@lang('labels.erroPadrao')',
                            icon: 'error',
                            confirmButtonText: 'Ok'
                        });
                    }
                });
            }

            // Evento de clique no botão de edição
            $(document).on('click', '.btn-edit-income', function() {

                // Input Masks
                $('#unemployment_date').mask('99/99/9999');
                $('#phone').mask('(999) 999-9999');
                $('#employer_phone_number').mask('(999) 999-9999');


                const incomeData = $(this).data('income');
                console.log(incomeData); // Verifique se os dados estão corretos aqui

                fillIncomeData(incomeData); // Chama a função para preencher os dados
                $('#editIncomeModal').modal('show'); // Exibe a modal
            });

            // Evento de submit no formulário
            $('#editIncomeForm').on('submit', function(event) {
                event.preventDefault();
                sendIncomeData(); // Chama a função para enviar os dados
            });

            // Evento para fechar a modal ao clicar no botão "Cancelar"
            $('#cancelIncomeButton').on('click', function() {
                $('#editIncomeModal').modal('hide');
            });

            // Evento para fechar a modal ao clicar no botão "X"
            $('#editIncomeModal .close').on('click', function() {
                $('#editIncomeModal').modal('hide');
            });

            $('#saveChangesButtonIncome').on('click', function() {
                $('#editIncomeModal').modal('hide');
            });
        });


        $(document).ready(function() {
            // Formatar o campo de valor para o padrão americano enquanto o usuário digita
            $('#amountIncome').on('input', function() {
                let value = $(this).val();

                // Remove caracteres inválidos (não numéricos, exceto ponto)
                value = value.replace(/[^0-9.]/g, '');

                // Garante que só existe um ponto decimal
                if ((value.match(/\./g) || []).length > 1) {
                    value = value.replace(/\.(?=.*\.)/g, '');
                }

                // Define o valor formatado no campo
                $(this).val(value);
            });
        });


        //edicao deductions
        $(document).ready(function() {
            const currencyFields = ['#amountDeduction'];
            currencyFields.forEach(fieldId => {
                const field = $(fieldId);
                field.on('focus', removeCurrencyFormatOnFocus); // Remove formatação ao focar
                field.on('input', formatCurrencyOnInput); // Formata enquanto digita
                field.on('blur', formatCurrencyOnBlur); // Aplica formatação ao sair do campo
            });

            // Se necessário, adicione essas ações também ao abrir a modal
            $('#editDeductionModal').on('show.bs.modal', function() {
                currencyFields.forEach(fieldId => {
                    const field = $(fieldId);
                    field.off('focus').on('focus',
                        removeCurrencyFormatOnFocus); // Garante que o evento será reatribuído
                    field.off('input').on('input', formatCurrencyOnInput);
                    field.off('blur').on('blur', formatCurrencyOnBlur);
                });
            });




            // Função para preencher os dados da modal de Deduction
            function fillDeductionData(deductionData) {
                income_deduction_type = deductionData.type_of_income_deduction?.id || ''; // Captura o ID para envio

                $('#deduction_id').val(deductionData.id || '');
                $('#deduction_type').val(deductionData.type_of_income_deduction?.name || ''); // Preenche o tipo
                $('#amountDeduction').val(deductionData.amount || '');
                formatCurrencyOnInput({
                    target: document.getElementById('amountDeduction')
                });

                $('#frequencyDeduction').val(deductionData.frequency?.id || ''); // ID da frequência
                if (deductionData.other_typeDeduction == null || deductionData.other_typeDeduction.trim() === '') {
                    // Se "other_typeDeduction" for nulo ou vazio, esconde o campo
                    $('#other_typeDeduction').closest('.mb-3').hide();
                } else {
                    // Caso contrário, exibe o campo e preenche com o valor
                    $('#other_typeDeduction').val(deductionData.other_typeDeduction);
                    $('#other_typeDeduction').closest('.mb-3').show();
                }


            }

            // Função para enviar os dados de Deduction
            function sendDeductionData() {
                const data = {
                    income_id: $('#deduction_id').val(),
                    income_deduction_type: income_deduction_type,
                    amount: removeCurrencyFormat($('#amountDeduction').val()),
                    frequency: $('#frequencyDeduction').val(),
                    other_type: $('#other_typeDeduction').val(),
                };

                const csrf_token = '{{ csrf_token() }}';

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': csrf_token,
                    },
                    url: "{{ route('finalize.income.update') }}",
                    type: "POST",
                    data: JSON.stringify(data),
                    contentType: "application/json",
                    success: function(response) {
                        if (response.status === 'success') {
                            $('#editDeductionModal').modal('hide');
                            Swal.fire({
                                title: '@lang('labels.sucesso')!',
                                text: '@lang('labels.dadosSalvos')',
                                icon: 'success',
                                confirmButtonText: 'Ok',
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                title: '@lang('labels.erro')!',
                                text: response.message || '@lang('labels.erroPadrao')',
                                icon: 'error',
                                confirmButtonText: 'Ok',
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            title: '@lang('labels.erro')!',
                            text: '@lang('labels.erroPadrao')',
                            icon: 'error',
                            confirmButtonText: 'Ok',
                        });
                    },
                });
            }

            // Evento de clique no botão de edição de Deduction
            $(document).on('click', '.btn-edit-deduction', function() {
                const deductionData = $(this).data('deduction');
                fillDeductionData(deductionData); // Preenche os dados
                $('#editDeductionModal').modal('show'); // Exibe a modal
            });

            // Evento de submit no formulário de Deduction
            $('#editDeductionForm').on('submit', function(event) {
                event.preventDefault();
                sendDeductionData(); // Envia os dados
            });

            // Evento para fechar a modal ao clicar no botão "Cancelar"
            $('#closeEditDeductionModal').on('click', function() {
                $('#editDeductionModal').modal('hide');
            });

            // Evento para fechar a modal ao clicar no botão "X"
            $('#closeModalButton').on('click', function() {
                $('#editDeductionModal').modal('hide');
            });

            $(document).on('click', '#saveChangesButtonDeduction', function() {
                $('#editDeductionModal').modal('hide');
            });
        });

        function formatCurrencyOnInput(event) {
            let value = event.target.value.replace(/[^0-9]/g, ''); // Remove caracteres não numéricos
            if (value) {
                value = (parseInt(value, 10) / 100).toFixed(2); // Divide por 100 para ajuste
                event.target.value = '$' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ','); // Adiciona vírgulas
            } else {
                event.target.value = '';
            }
        }

        function removeCurrencyFormatOnFocus(event) {
            event.target.value = event.target.value.replace(/[^0-9.]/g, ''); // Remove o símbolo de moeda e vírgulas
        }

        function formatCurrencyOnBlur(event) {
            let value = parseFloat(event.target.value.replace(/[^0-9.]/g, ''));
            if (!isNaN(value)) {
                event.target.value = '$' + value.toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            } else {
                event.target.value = '';
            }
        }

        function removeCurrencyFormat(value) {
            if (!value) return '';
            return value.replace(/[^0-9.]/g, ''); // Remove todos os caracteres, exceto números e ponto
        }
    </script>
@endsection
