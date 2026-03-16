@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="/css/abaNavegacao.css">
    <link rel="stylesheet" href="/css/load.css">
@endsection

@php
   // dd($data);
@endphp

@section('content')
    <!-- BREADCRUMB -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <h4 class="page-title">@lang('labels.householdTitulo')</h4>
        </div>
    </div>
    <!-- END BREADCRUMB -->

    <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="tab">
                    <button id="tabHousehold" class="tablinks active"
                        onclick="openTab(event, 'household')">@lang('labels.householdCandidato')</button>
                </div>
            </div>
        </div>
    </div>

    <div id="household" class="tabcontent" style="display: block;">
        <input type="hidden" id="application_id" name="application_id" value="{{ $application_id ?? 0 }}">
        <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
            <div class="card">
                <div class="card-body" style="display: none;">
                    <div class="form-group row align-items-center">
                        <h1 class="col-form-label lx-5">@lang('labels.householdSolicitante')</h1>
                    </div>
                </div>
                <div class="card-body" style="display: none;">
                    <div class="row row-sm">
                        <label class="col-form-label">@lang('labels.householdSolicitanteUsuario')</label>
                        <div class="col-lg-6 mb-3">
                            <div class="input-group">
                                <div class="input-group-text">
                                    <label class="rdiobox wd-16 mg-b-0">
                                        <input class="mg-0" type="radio" name="householdCheck" id="householdcheckYes"
                                            value="1">
                                        <span></span>
                                    </label>
                                </div>
                                <div class="form-control">@lang('labels.checkYes')</div>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <div class="input-group">
                                <div class="input-group-text">
                                    <label class="rdiobox wd-16 mg-b-0">
                                        <input class="mg-0" type="radio" name="householdCheck" id="householdcheckNo"
                                            value="0">
                                        <span></span>
                                    </label>
                                </div>
                                <div class="form-control">@lang('labels.checkNo')</div>
                            </div>
                        </div>
                        <input type="hidden" id="applying_coverage" name="applying_coverage" value="1">
                    </div>
                </div>

                {{-- tabaco --}}
                <div class="card-body">
                    <div class="row row-sm">
                        <label class="col-form-label">@lang('labels.userTabaco')</label>
                        <div class="col-lg-6 mb-3">
                            <div class="input-group">
                                <div class="input-group-text">
                                    <label class="rdiobox wd-16 mg-b-0">
                                        <input class="mg-0" type="radio" name="householdTabaccoCheck"
                                            id="householdTabaccoCheckYes" value="1">
                                        <span></span>
                                    </label>
                                </div>
                                <div class="form-control">@lang('labels.checkYes')</div>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <div class="input-group">
                                <div class="input-group-text">
                                    <label class="rdiobox wd-16 mg-b-0">
                                        <input class="mg-0" type="radio" name="householdTabaccoCheck"
                                            id="householdTabaccoCheckNo" value="0">
                                        <span></span>
                                    </label>
                                </div>
                                <div class="form-control">@lang('labels.checkNo')</div>
                            </div>
                        </div>
                        <input type="hidden" id="applying_coverage" name="applying_coverage" value="1">
                    </div>
                </div>
                {{-- tabaco --}}



                {{-- income --}}
                <div class="card-body">
                    <div class="row row-sm">
                        <div class="col-lg-8 mb-4">
                            <div class="col-lg-5">
                                <label class="col-form-label">@lang('labels.yearlyIncome')</label>
                                <div class="input-group">
                                    <div class="input-group-text">@lang('labels.amountIncomeSymbol'):</div>
                                    <input type="text" class="form-control" name="incomeHouseHold" id="incomeHouseHold"
                                        placeholder="@lang('labels.amountIncome')" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- end income --}}


                <div class="card-body">
                    <div class="row row-sm">

                        <label class="col-form-label">@lang('labels.householdDireitoReducao')</label>
                        <div class="col-lg-6 mb-3">
                            <div class="input-group">
                                <div class="input-group-text">
                                    <label class="rdiobox wd-16 mg-b-0">
                                        <input class="mg-0" type="radio" name="checkYesapplying"
                                            id="checkYesapplyingYes" value="1">
                                        <span></span>
                                    </label>
                                </div>
                                <div class="form-control">@lang('labels.checkYes')</div>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <div class="input-group">
                                <div class="input-group-text">
                                    <label class="rdiobox wd-16 mg-b-0">
                                        <input class="mg-0" type="radio" name="checkYesapplying"
                                            id="checkYesapplyingNo" value="0">
                                        <span></span>
                                    </label>
                                </div>
                                <div class="form-control">@lang('labels.checkNo')</div>
                            </div>
                        </div>
                        <input type="hidden" id="eligible_cost_saving" name="eligible_cost_saving" value="1">
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <label class="col-form-label">@lang('labels.householdDemaisSolicitante')</label>
                        <div class="col-lg-6 mb-3">
                            <a href="#" class="btn btn-outline-secondary btn-lg btn-block"
                                id="btnAddSpouse">@lang('labels.householdAddConjuge')</a>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <a href="#" class="btn btn-outline-secondary btn-lg btn-block"
                                id="btnAddAnotherPerson">@lang('labels.householdAddDependente')</a>
                        </div>
                    </div>
                </div>


                <!-- Seção para a lista de cônjuges -->
                <div class="card-body" id="spouseSection" style="display: none">
                    <div class="row">
                        <label class="col-form-label">@lang('labels.relacaoEsposa')</label>
                        <div class="col-lg-12 mb-3">
                            <ul id="spouseList" class="list-group">
                                <!-- A lista será preenchida dinamicamente aqui -->
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Seção para a lista de dependentes -->
                <div class="card-body" id="dependentSection" style="display: none">
                    <div class="row">
                        <label class="col-form-label">@lang('labels.dependent')</label>
                        <div class="col-lg-12 mb-3">
                            <ul id="dependentList" class="list-group">
                                <!-- A lista será preenchida dinamicamente aqui -->
                            </ul>
                        </div>
                    </div>
                </div>



                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <a href="{{ route('index') }}" class="btn btn-primary btn-lg btn-block">
                                @lang('labels.buttonVoltar')
                            </a>
                        </div>
                        {{-- <div class="col-lg-6 mb-3">
                        <button id="btnContinue" class="btn btn-secondary btn-lg btn-block" onclick="openTab(event, 'taxHousehold')">@lang('labels.buttonContinue')</button>
                    </div> --}}
                        <div class="col-lg-6 mb-3">
                            <a href="#" class="btn btn-secondary btn-lg btn-block"
                                onclick="sendFormHousehold(this)">
                                @lang('labels.buttonContinue')</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal modalAddSpouse -->
    <!-- Modal HTML com o checkbox adicionado -->
    <div class="modal fade" id="modalAddSpouse" tabindex="-1" aria-labelledby="modalAddSpouseLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <h1 class="mb-0">@lang('labels.householdAddConjuge')</h1>
                            <button type="button" class="btn btn-primary ms-auto"
                                data-bs-dismiss="modal">@lang('labels.buttonCancelar')</button>
                        </div>

                        <div class="card-body">
                            <div class="row row-sm">
                                <div class="col-lg-6 mb-3">
                                    <div class="input-group">
                                        <div class="input-group-text">@lang('labels.nome'):</div>
                                        <input type="text" class="form-control" name="nameSpouse" id="nameSpouse"
                                            placeholder="@lang('labels.nome')">
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <div class="input-group">
                                        <div class="input-group-text">@lang('labels.campoCentral')</div>
                                        <input type="text" class="form-control" name="middleSpouse" id="middleSpouse"
                                            placeholder="@lang('labels.campoCentral')">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row row-sm">
                                <div class="col-lg-6 mb-3">
                                    <div class="input-group">
                                        <div class="input-group-text">@lang('labels.sobreNome'):</div>
                                        <input type="text" class="form-control" name="lastnameSpouse"
                                            id="lastnameSpouse" placeholder="@lang('labels.sobreNome')">
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <div class="input-group">
                                        <span class="input-group-text">@lang('labels.suffix'):</span>
                                        <select class="form-select" name="suffixSpouse" id="suffixSpouse">
                                            <option value="" selected>@lang('labels.campoSelecao')</option>
                                            @foreach ($suffixes as $key => $value)
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row row-sm">
                                <div class="col-lg-6 mb-3">
                                    <div class="input-group">
                                        <div class="input-group-text">@lang('labels.dataNascimento'):</div>
                                        <input class="form-control" name="birthdateSpouse" id="birthdateSpouse"
                                            placeholder="MM/DD/YYYY" type="text">
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <div class="input-group">
                                        <span class="input-group-text">@lang('labels.campoSexo') <i class="fas fa-question"
                                                data-bs-toggle="modal" data-bs-target="#alertModalSexo"
                                                title="@lang('labels.msgClicar')"></i></span>
                                        <select class="form-select" id="sexSpouse" name="sexSpouse" required>
                                            <option value="" selected>@lang('labels.campoSelecao')</option>
                                            @foreach ($sexes as $key => $value)
                                                <option value="{{ $key }}">@lang('labels.' . $value)</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- spouse use tabacco --}}
                        <div class="card-body">
                            <div class="row row-sm">
                                <label class="col-form-label">@lang('labels.userTabaco')</label>
                                <div class="col-lg-6 mb-3">
                                    <div class="input-group">
                                        <div class="input-group-text">
                                            <label class="rdiobox wd-16 mg-b-0">
                                                <input class="mg-0" type="radio" name="householdSpouseTabaccoCheck"
                                                    id="householdSpouseTabaccoCheckYes" value="1">
                                                <span></span>
                                            </label>
                                        </div>
                                        <div class="form-control">@lang('labels.checkYes')</div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <div class="input-group">
                                        <div class="input-group-text">
                                            <label class="rdiobox wd-16 mg-b-0">
                                                <input class="mg-0" type="radio" name="householdSpouseTabaccoCheck"
                                                    id="householdSpouseTabaccoCheckNo" value="0">
                                                <span></span>
                                            </label>
                                        </div>
                                        <div class="form-control">@lang('labels.checkNo')</div>
                                    </div>
                                </div>
                                <input type="hidden" id="applying_coverage" name="applying_coverage" value="1">
                            </div>
                        </div>
                        {{-- tabacco --}}
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12 mb-3">

                                    <a href="#" id="saveSpouseBtn"
                                        class="btn btn-primary btn-lg btn-block">@lang('labels.householdAddConjuge')</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Loader Overlay -->
    <div id="loaderOverlay" style="display: none;">
        <div id="loader">
            <div class="spinner-border text-primary" role="status">
                <span class="sr-only">Loading...</span>
            </div>
            <p style="color: white; text-align: center; margin-top: 10px;">Aguarde, carregando...</p>
        </div>
    </div>


    <!-- End Modal modalAddSpouse -->
    <!-- Modal modalAddAnotherPerson -->
    <div class="modal fade" id="modaldemoAddAnotherPerson" tabindex="-1"
        aria-labelledby="modaldemoAddAnotherPersonLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="card">

                        <div class="card-body d-flex justify-content-between align-items-center">
                            <h1 class="mb-0">@lang('labels.householdAddDependente')</h1>
                            <button type="button" class="btn btn-primary ms-auto"
                                data-bs-dismiss="modal">@lang('labels.buttonCancelar')</button>
                        </div>
                        <div class="card-body">
                            <div class="row row-sm">
                                <div class="col-lg-6 mb-3">
                                    <div class="input-group">
                                        <div class="input-group-text">@lang('labels.nome'):</div>
                                        <input type="text" class="form-control" name="namePerson" id="namePerson"
                                            placeholder="@lang('labels.nome')">
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <div class="input-group">
                                        <div class="input-group-text">@lang('labels.campoCentral'):</div>
                                        <input type="text" class="form-control" name="middlePerson" id="middlePerson"
                                            placeholder="@lang('labels.campoCentral')">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row row-sm">
                                <div class="col-lg-6 mb-3">
                                    <div class="input-group">
                                        <div class="input-group-text">@lang('labels.sobreNome'):</div>
                                        <input type="text" class="form-control" name="lastnamePerson"
                                            id="lastnamePerson" placeholder="@lang('labels.sobreNome')">
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <div class="input-group ">
                                        <span class="input-group-text">@lang('labels.suffix'):</span>
                                        <select class="form-select" name="suffixPerson" id="suffixPerson">
                                            <option value="" selected>@lang('labels.campoSelecao')</option>
                                            @foreach ($suffixes as $key => $value)
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row row-sm">
                                <div class="col-lg-6 mb-3">
                                    <div class="input-group">
                                        <div class="input-group-text">@lang('labels.dataNascimento'):</div>
                                        <input class="form-control" name="birthdatePerson" id="birthdatePerson"
                                            placeholder="MM/DD/YYYY" type="text">
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <div class="input-group">
                                        <span class="input-group-text">@lang('labels.campoSexo') <i class="fas fa-question"
                                                data-bs-toggle="modal" data-bs-target="#alertModalSexo"
                                                title="@lang('labels.msgClicar')"></i></span>
                                        <select class="form-select" id="sexPerson" name="sexPerson" required>
                                            <option value="" selected>@lang('labels.campoSelecao')</option>
                                            @foreach ($sexes as $key => $value)
                                                <option value="{{ $key }}">@lang('labels.' . $value)</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body" style="display: none">
                            <div class="row row-sm">
                                <div class="col-lg-12 mb-3">
                                    <div class="input-group">
                                        <span class="input-group-text">@lang('labels.householdRelacionamento'):</span>
                                        <select class="form-select" name="relationshipPerson" id="relationshipPerson">
                                            <option value="" selected>@lang('labels.campoSelecao')</option>
                                            @foreach ($relationships as $key => $value)
                                                <option value="{{ $key }}">@lang('labels.' . $value)</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- tabacco --}}
                        <div class="card-body">
                            <div class="row row-sm">
                                <label class="col-form-label">@lang('labels.userTabaco')</label>
                                <div class="col-lg-6 mb-3">
                                    <div class="input-group">
                                        <div class="input-group-text">
                                            <label class="rdiobox wd-16 mg-b-0">
                                                <input class="mg-0" type="radio" name="householdAnotherTabaccoCheck"
                                                    id="householdAnotherTabaccoCheckYes" value="1">
                                                <span></span>
                                            </label>
                                        </div>
                                        <div class="form-control">@lang('labels.checkYes')</div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <div class="input-group">
                                        <div class="input-group-text">
                                            <label class="rdiobox wd-16 mg-b-0">
                                                <input class="mg-0" type="radio" name="householdAnotherTabaccoCheck"
                                                    id="householdAnotherTabaccoCheckNo" value="0">
                                                <span></span>
                                            </label>
                                        </div>
                                        <div class="form-control">@lang('labels.checkNo')</div>
                                    </div>
                                </div>
                                <input type="hidden" id="applying_coverage" name="applying_coverage" value="1">
                            </div>
                        </div>
                        {{-- end tabacco --}}


                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12 mb-3">
                                    <a href="#" id="savePersonBtn"
                                        class="btn btn-primary btn-lg btn-block">@lang('labels.buttonSalvarPessoa')</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal modaldemoAddAnotherPerson -->

    <!-- Modal modaldemoAlerta -->
    <div class="modal fade" id="modaldemoAlerta" tabindex="-1" aria-labelledby="modaldemoAlertaLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="container">
                        <div class="card">
                            <div class="card-body">
                                <div class="row row-sm">
                                    <label class="col-form-label">@lang('labels.campoRecomendado')</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('labels.buttonFechar')</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal modaldemoAlerta -->


    <!-- Modal -->
    <div class=" modal fade" id="modaldemoAddWifeIfMarried" tabindex="-1"
        aria-labelledby="modaldemoAddWifeIfMarriedLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="container">
                        <div class="card">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <button type="button" class="btn btn-primary ms-auto"
                                    data-bs-dismiss="modal">@lang('labels.buttonCancelar')</button>
                            </div>
                            <div class="card-body">
                                <div class="row row-sm">
                                    <label class="col-form-label ">@lang('labels.householdAddConjugeTwo')</label>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-lg-4">
                                        <label class="form-label">@lang('labels.nome')</label>
                                        <input type="text" class="form-control" name="nameSpouseHouseholdTax"
                                            id="nameSpouseHouseholdTax" placeholder="@lang('labels.nome')">
                                    </div>
                                    <div class="col-lg-4">
                                        <label class="form-label">@lang('labels.campoCentral')</label>
                                        <input type="text" class="form-control" name="middleSpouseHouseholdTax"
                                            id="middleSpouseHouseholdTax" placeholder="@lang('labels.campoCentral')">
                                    </div>
                                    <div class="col-lg-4">
                                        <label class="form-label">@lang('labels.sobreNome')</label>
                                        <input type="text" class="form-control" name="lastnameSpouseHouseholdTax"
                                            id="lastnameSpouseHouseholdTax" placeholder="@lang('labels.sobreNome')">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-4">
                                        <label class="form-label">@lang('labels.suffix')</label>
                                        <select class="form-select" name="suffixesSpouseHouseholdTax"
                                            id="suffixesSpouseHouseholdTax">
                                            <option value="" selected>@lang('labels.campoSelecao')</option>
                                            @foreach ($suffixes as $key => $value)
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-4">
                                        <label class="form-label">@lang('labels.dataNascimento')</label>
                                        <input class="form-control" name="dateSpouseHouseholdTax"
                                            id="dateSpouseHouseholdTax" placeholder="MM/DD/YYYY" type="text">
                                    </div>
                                    <div class="col-lg-4">
                                        <label class="form-label">@lang('labels.campoSexo') <i
                                                class="fas fa-question custom-tooltip" data-bs-toggle="modal"
                                                data-bs-target="#alertModalSexo" title="@lang('labels.msgClicar')"></i></label>

                                        <select class="form-select" name="sexesSpouseHouseholdTax"
                                            id="sexesSpouseHouseholdTax">
                                            <option value="" selected>@lang('labels.campoSelecao')</option>
                                            @foreach ($sexes as $key => $value)
                                                <option value="{{ $key }}">@lang('labels.' . $value)</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-lg-7">
                                        <label class="form-label">@lang('labels.householdConfirmacao')</label>
                                        <div class="row">
                                            <div class="col-lg-6 mb-3">
                                                <div class="input-group">
                                                    <div class="input-group-text">
                                                        <label class="rdiobox wd-16 mg-b-0">
                                                            <input class="mg-0" type="radio" name="liveswithyou"
                                                                value="1">
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                    <input type="hidden" name="liveswithyou" value="1">
                                                    <div class="form-control">
                                                        @lang('labels.checkYes')
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 mb-3">
                                                <div class="input-group">
                                                    <div class="input-group-text">
                                                        <label class="rdiobox wd-16 mg-b-0">
                                                            <input class="mg-0" type="radio" name="liveswithyou"
                                                                value="0">
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                    <input type="hidden" name="liveswithyou" value="0">
                                                    <div class="form-control">
                                                        @lang('labels.checkNo')
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12 mb-3">
                                    <button type="button" id="addWifeIfMarriedBtn"
                                        class="btn btn-primary btn-lg btn-block">@lang('labels.householdAddConjuge')

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
    <!-- End Modal -->
    <!-- Modal de alerta -->

    <div class="modal fade" id="alertModal" tabindex="-1" aria-labelledby="alertModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="alertModalLabel">@lang('labels.aletaMensagem')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>
                    <div>@lang('labels.msgCasadoLegalmente')</div> <br>
                    <div>@lang('labels.msgSeparado')</div><br>
                    <div>@lang('labels.msgUniaoEstavel')</div><br>
                    <div>@lang('labels.msgMoracomParceiro')</div><br>
                    <div>@lang('labels.msgVitimaViolencia')</div><br>
                    <div>@lang('labels.msgDisponicel')</div>
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <!--End modal alerta -->


    <!-- Modal de alerta sobre o sexo -->

    <div class="modal fade" id="alertModalSexo" tabindex="-1" aria-labelledby="alertModalSexoLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="alertModalSexoLabel">@lang('labels.msgSobreoSexotitulo')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>@lang('labels.msgSobreoSexo')</p>
                    <p>@lang('labels.msgSobreoSexoGestante')</p>
                    <p>@lang('labels.msgInformacoesSite')</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>

    </div>
    <!--End modal alerta sobre o sexo -->
@endsection

@section('scripts')
    <!-- Mostar msg Modal JS -->
    <script src="{{ asset('/js/msgModal.js') }}"></script>

    <!-- Aba de Navegação JS -->
    {{-- <script src="{{ asset('/js/abaNavegacao.js') }}"></script> --}}

    <!-- Aba de MostraModal JS -->
    <script src="{{ asset('/js/mostraModal.js') }}"></script>

    <!-- MostraModal JS -->
    <script src="{{ asset('/js/hosehold/modalAddSpouse.js') }}"></script>

    <!--  MostraModal JS -->
    <script src="{{ asset('/js/hosehold/modaldemoAddAnotherPerson.js') }}"></script>

    <!--  MostraModal JS -->
    <script src="{{ asset('/js/hosehold/modaldemoAddWifeIfMarried.js') }}"></script>

    <!--  MostraModal JS -->
    <script src="{{ asset('/js/hosehold/modaldemoAlerta.js') }}"></script>

    <!-- checkbox -->
    <script src="{{ asset('/js/checkBox.js') }}"></script>

    <!-- Esconder Campo JS -->
    <script src="{{ asset('/js/mostrarCampo.js') }}"></script>

    <!--Marca e desmarca Radio-->
    <script src="{{ asset('/js/desmarcaRadio.js') }}"></script>

    <!-- INTERNAL DATEPICKER JS -->
    <script src="{{ asset('/build/assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>

    <!-- INTERNAL JQUERY.MASKEDINPUT JS -->
    <script src="{{ asset('/build/assets/plugins/jquery.maskedinput/jquery.maskedinput.js') }}"></script>

    <!-- INTERNAL SPECTRUM-COLORPICKER JS -->
    <script src="{{ asset('/build/assets/plugins/spectrum-colorpicker/spectrum.js') }}"></script>

    <!-- INTERNAL SELECT2 JS -->
    <script src="{{ asset('/build/assets/plugins/select2/js/select2.min.js') }}"></script>

    <!-- INTERNAL ION-RANGESLIDER JS -->
    <script src="{{ asset('/build/assets/plugins/ion-rangeslider/js/ion.rangeSlider.min.js') }}"></script>

    <!-- INTERNAL JQUERY-AMAZEUI DATETIMEPICKER JS -->
    <script src="{{ asset('/build/assets/plugins/amazeui-datetimepicker/js/amazeui.datetimepicker.min.js') }}"></script>

    <!-- INTERNAL JQUERY-SIMPLE DATETIMEPICKER JS -->
    <script src="{{ asset('/build/assets/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.js') }}"></script>

    <!-- INTERNAL PICKER JS -->
    <script src="{{ asset('/build/assets/plugins/pickerjs/picker.min.js') }}"></script>

    <!-- INTERNAL COLORPICKER JS -->
    <script src="{{ asset('/build/assets/plugins/colorpicker/pickr.es5.min.js') }}"></script>

    <!-- BOOTSTRAP-DATEPICKER JS -->
    <script src="{{ asset('/build/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>

    <!-- INTERNAL FORM-ELEMENTS JS -->
    <script src="{{ asset('/resources/assets/js/form-elements.js') }}"></script>

    <!-- Adicionando o SweetAlert2 via CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <!-- Vite Compilation -->
    @vite('resources/assets/js/colorpicker.js')
    @vite('resources/assets/js/modal.js')

    <script>
        const householdMembers = [];
        let nextId = 1; // Contador para IDs únicos
        function addhouseholdApplicant(tax) {
            const applyingCoverage = parseInt($('input[name="householdCheck"]:checked').val(), 10) || 1;
            const eligiblecostsaving = parseInt($('input[name="checkYesapplying"]:checked').val(), 10) || 0;
            const isdependent = parseInt($('input[name="dependent"]:checked').val(), 10) || 0;
            const userTabacco = $('#householdTabaccoCheckYes:checked').val() || 0;
            const incomeHouseHold = $('#incomeHouseHold').val();
            const marriedApplicant = $('#nameSpouse').val().trim() ? 1 : 0;

            const applicant = {
                id: nextId++, // Atribui um ID único
                'field_type': 0,
                'applying_coverage': applyingCoverage,
                'use_tobacco': userTabacco,
                'eligible_cost_saving': eligiblecostsaving,
                'is_dependent': isdependent,
                'income_predicted_amount': incomeHouseHold,
                'married': marriedApplicant,
            };

            addhouseholdMembers(applicant);
        }

        function addhouseholdSpouse(tax) {
            const householdSpouseTabaccoCheck = $('#householdSpouseTabaccoCheckYes:checked').val() || 0;
            const spouse = {
                id: nextId++, // Atribui um ID único    
                'firstname': $('#nameSpouse').val(),
                'middlename': $('#middleSpouse').val(),
                'lastname': $('#lastnameSpouse').val(),
                'suffix': $('#suffixSpouse').val(),
                'birthdate': $('#birthdateSpouse').val(),
                'sex': $('#sexSpouse').val(),
                'relationship': <?php echo $spouse_id ?? 3; ?>,
                'tax_form': tax,
                'lives_with_you': null,
                'married': 1,
                'tax_claimant': null,
                'eligible_cost_saving': null,
                'field_type': 1,
                'use_tobacco': householdSpouseTabaccoCheck,
                'income_predicted_amount': 0,
            };

            addhouseholdMembers(spouse);
            updateHouseholdList(); // Atualiza a lista após adicionar o cônjuge
        }

        function addhouseholdPerson(tax) {
            const householdAnotherTabaccoCheck = $('#householdAnotherTabaccoCheckYes:checked').val() || 0;
            const nextFieldType = householdMembers.filter(member => member.field_type >= 2).length + 2;

            const person = {
                id: nextId++, // Atribui um ID único
                'firstname': $('#namePerson').val(),
                'middlename': $('#middlePerson').val(),
                'lastname': $('#lastnamePerson').val(),
                'suffix': $('#suffixPerson').val(),
                'birthdate': $('#birthdatePerson').val(),
                'sex': $('#sexPerson').val(),
                'relationship':  <?php echo $child_id ?? 10; ?>,
                'tax_form': tax,
                'lives_with_you': null,
                'tax_claimant': null,
                'eligible_cost_saving': null,
                'field_type': 2, // Inicia em 2
                'field_type': nextFieldType, // Inicia em 2 para dependentes e incrementa
                'use_tobacco': householdAnotherTabaccoCheck,
                'income_predicted_amount': 0,
            };

            addhouseholdMembers(person);
            updateHouseholdList(); // Atualiza a lista após adicionar outra pessoa
        }

        function addhouseholdMembers(data) {
            householdMembers.push(data);
        }

        function updateHouseholdList() {
            const spouseListContainer = $('#spouseList');
            const dependentListContainer = $('#dependentList');
            const spouseSection = $('#spouseSection');
            const dependentSection = $('#dependentSection');
            console.log('Membros da household:', householdMembers);

            // Filtra e gera o HTML para a lista de cônjuges
            const spouses = householdMembers.filter(member => member.field_type === 1);
            const spouseListHtml = spouses
                .map(member => `
        <li class="list-group-item d-flex justify-content-between align-items-center">
            ${member.firstname} ${member.middlename} ${member.lastname}
            <a href="#" class="btn btn-outline-secondary btn-sm" data-member-id="${member.id}" onclick="removeHouseholdMember(this)">Remover</a>
        </li>
    `)
                .join('');

            // Filtra e gera o HTML para a lista de dependentes
            const dependents = householdMembers.filter(member => member.field_type >= 2);
            const dependentListHtml = dependents
                .map(member => `
        <li class="list-group-item d-flex justify-content-between align-items-center">
            ${member.firstname} ${member.middlename} ${member.lastname}
            <a href="#" class="btn btn-outline-secondary btn-sm" data-member-id="${member.id}" onclick="removeHouseholdMember(this)">Remover</a>
        </li>
    `)
                .join('');

            // Atualiza o HTML da lista com o novo conteúdo
            spouseListContainer.html(spouseListHtml);
            dependentListContainer.html(dependentListHtml);

            // Mostra ou esconde as seções conforme necessário
            spouseSection.css('display', spouses.length > 0 ? 'block' : 'none');
            dependentSection.css('display', dependents.length > 0 ? 'block' : 'none');
        }


        // Remove um membro da lista quando o botão "Remover" é clicado
        function removeHouseholdMember(button) {
            const memberId = $(button).data('member-id');
            const index = householdMembers.findIndex(member => member.id === memberId);

            if (index > -1) {
                householdMembers.splice(index, 1);
                updateHouseholdList();
            }
            return false; // Impede a ação padrão do link (navegação)
        }




        function formatHousehold() {
            const applicationId = '{{ $application_id ?? 0 }}';

            return JSON.stringify({
                'application_id': applicationId,
                'household_members': householdMembers
            });
        }


        const isClient = @json($isClient); 
         let successMessage;

        if (isClient) {
             successMessage = @json(__('labels.dadosGravadosClient'));
        } else {
             successMessage = @json(__('labels.dadosGravadosAgent'));
        }


        const errorMessage = @json(__('labels.errodadosGravados'));

        // Função para mostrar o loader
        function showLoader() {
            document.getElementById('loaderOverlay').style.display = 'block';
        }

        // Função para esconder o loader (caso necessário)
        function hideLoader() {
            document.getElementById('loaderOverlay').style.display = 'none';
        }


        function sendFormHousehold(buttonElement) {
            const household = formatHousehold();
            const csrf_token = '{{ csrf_token() }}';

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': csrf_token,
                    'Content-Type': 'application/json'
                },
                url: "{{ route('household.ajax.storequotation') }}",
                type: "POST",
                data: household,
                contentType: "application/json",
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            title: '@lang('labels.sucesso')!',
                            text: successMessage,
                            icon: 'success',
                            confirmButtonText: 'Ok',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Exibe o Swal com o loader
                                Swal.fire({
                                    title: '@lang('labels.carregando')!',
                                    html: '@lang('labels.aguarde').',
                                    allowOutsideClick: false,
                                    didOpen: () => {
                                        Swal.showLoading(); // Exibe o loader
                                        // Redireciona para a página de cotação
                                        window.location.href =
                                            "{{ route('livewire.quotation', $application_id) }}";
                                    }
                                });
                            }
                        });
                    } else {
                        Swal.fire({
                            title: 'Erro!',
                            text: errorMessage,
                            icon: 'error',
                            confirmButtonText: 'Ok'
                        });
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    Swal.fire({
                        title: 'Erro!',
                        text: 'Houve um erro na requisição.',
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    });
                    console.error("Erro na requisição:");
                    console.error("Código de Status:", jqXHR.status);
                    console.error("Texto do Status:", textStatus);
                    console.error("Erro Lançado:", errorThrown);

                    if (jqXHR.responseJSON) {
                        console.error("Erros de Validação:", jqXHR.responseJSON);
                    } else {
                        console.error("Texto da Resposta:", jqXHR.responseText);
                    }
                }
            });
        }

        window.onload = function() {
            hideLoader(); // Oculta o loader após carregar a página
        };



        $(document).ready(function() {
            $('#saveSpouseBtn').on('click', function(e) {
                e.preventDefault();

                const spouses = householdMembers.filter(member => member.field_type === 1);

                if (spouses.length > 0) {
                    $('#modalAddSpouse').modal('hide');
                    Swal.fire({
                        title: 'Atenção!',
                        text: 'Apenas uma esposa pode ser adicionada.',
                        icon: 'warning',
                        confirmButtonText: 'Ok'
                    });
                    return;
                }
                addhouseholdSpouse(0);

                // Fecha o modal
                $('#modalAddSpouse').modal('hide');
            });

            $('#savePersonBtn').on('click', function(e) {
                e.preventDefault();
                addhouseholdPerson(0);

                clearPersonForm();

                // Fecha o modal
                $('#modaldemoAddAnotherPerson').modal('hide');
                // Limpa o formulário
            });

            $('#incomeHouseHold').on('change', function() {
                addhouseholdApplicant(0);
            });

            // Máscaras de entrada
            $('#birthdateSpouse').mask('99/99/9999');
            $('#birthdatePerson').mask('99/99/9999');
            $('#dateDependents').mask('99/99/9999');

            function clearPersonForm() {
                $('#namePerson').val('');
                $('#middlePerson').val('');
                $('#lastnamePerson').val('');
                $('#suffixPerson').val('');
                $('#birthdatePerson').val('');
                $('#sexPerson').val('');
                $('input[name="householdAnotherTabaccoCheck"]').prop('checked', false);
                $('#relationshipPerson').val('');
            }

            function formatCurrency(value) {
                if (!isNaN(value) && value !== '') {
                    let numberValue = parseFloat(value.replace(/,/g,
                        '')); // Remove as vírgulas e converte para número
                    return numberValue.toLocaleString('en-US', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                } else {
                    return '';
                }
            }


            document.getElementById('incomeHouseHold').addEventListener('input', function(e) {
                // Remove o formato atual para facilitar a digitação
                let value = e.target.value.replace(/[^0-9.]/g, '');

                // Atualiza o valor sem o formato enquanto o usuário digita
                e.target.value = value;
            });

            document.getElementById('incomeHouseHold').addEventListener('blur', function(e) {
                let value = e.target.value;

                // Formata o valor no estilo de moeda ao sair do campo
                e.target.value = formatCurrency(value);
            });
        });
    </script>
@endsection
