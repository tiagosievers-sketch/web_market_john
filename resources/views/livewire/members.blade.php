@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="/css/acordion.css">
@endsection


@section('content')
    <!-- BREADCRUMB -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <h4 class="page-title">@lang('labels.canidatoTitulo')</h4>
        </div>
    </div>


    {{-- <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    Jesse Rovira
                </button>
            </h2>
            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                data-bs-parent="#accordionExample"> --}}
    <div class="card-body">
        <!-- END BREADCRUMB -->
        <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="form-group row align-items-center">
                        <label class="col-form-label ">@lang('labels.informacoesTitulo')</label>
                    </div>
                </div>
                <div class="card-body">
                    <label class="col-form-label">@lang('labels.numeroSegurançaSocial')</label><br>
                    <label class="col-form-label">@lang('labels.ssnTitulo')</label>
                    <div class="row">
                        <div class="col-xl-12 mb-3">
                            <div class="input-group" id="ssnMaskContainer">
                                <span class="input-group-text">@lang('labels.cpf'):</span>
                                <input class="form-control form-control-lg" id="ssnNumber" placeholder="000-00-0000"
                                    type="text">
                            </div>
                        </div>
                    </div>
                </div>


                <div class="card-body">
                    <div class="row row-sm">
                        <div class="col-lg-12 mb-3">
                            <div class="input-group" id="ssnFieldContainer">
                                <div class="input-group-text">
                                    <label class="ckbox wd-16 mg-b-0">
                                        <input class="mg-0" type="checkbox" id="ssnFieldContaine">
                                        <span></span>
                                    </label>
                                </div>
                                <input type="hidden" name="hasSsn" id="nohaveSSN" value="1">
                                <div class="form-control">
                                    @lang('labels.campoSSN')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row row-sm">
                        <label class="col-form-label">@lang('labels.usoDeCigarro')</label>
                        <div class="col-lg-6 mb-3">
                            <div class="input-group">
                                <div class="input-group-text">
                                    <label class="rdiobox wd-16 mg-b-0">
                                        <input class="mg-0" type="radio" name="checkcigarro" id="checkYescigarro"
                                            value=1>
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
                                        <input class="mg-0" type="radio" name="checkcigarro" id="checkNocigarro"
                                            value=0>
                                        <span></span>
                                    </label>
                                </div>
                                <div class="form-control">@lang('labels.checkNo')</div>
                            </div>
                        </div>

                        <div class="row row-sm">
                            <div class="col-lg-6 mb-3">
                                <div class="input-group" id="fieldToShow" style="display: none;">
                                    <div class="input-group-text">@lang('labels.dataDoConsumoTabaco'):</div>
                                    <input class="form-control date-input" name="lastTobaccoUsage" id="dateLastTobaccoUsage"
                                        placeholder="MM/DD/YYYY" type="text">
                                </div>
                                <div class="invalid-feedback" style="display: none;"> <!-- Inicialmente escondida -->
                                    <!-- A mensagem de erro será inserida aqui -->
                                </div>
                            </div>
                        </div>
                    </div>

                </div>


                {{-- is_lawfully_present_american_samoan  - pergunta Are you a US citizen or US national? 3 pergunta --}}
                <div class="card-body">
                    <div class="row row-sm">
                        <label class="col-form-label">@lang('labels.cidadaoAmericano')</label>
                        <div class="col-lg-6 mb-3">
                            <div class="input-group">
                                <div class="input-group-text">
                                    <label class="rdiobox wd-16 mg-b-0">
                                        <input class="mg-0" type="radio" name="checkamericano" id="checkYesamericano"
                                            value=1>
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
                                        <input class="mg-0" type="radio" name="checkamericano" id="checkNoamericano"
                                            value="0">
                                        <span></span>
                                    </label>
                                </div>
                                <div class="form-control">@lang('labels.checkNo')</div>
                            </div>
                        </div>
                    </div>
                </div>


                {{-- 4 pergunta encarcerado / Are you currently incarcerated (detained or jailed) banco é is_incarcerated --}}
                <div class="card-body">
                    <div class="row row-sm">
                        <label class="col-form-label">@lang('labels.encarcerado')</label>
                        <div class="col-lg-6 mb-3">
                            <div class="input-group">
                                <div class="input-group-text">
                                    <label class="rdiobox wd-16 mg-b-0">
                                        <input class="mg-0" type="radio" name="checkencarcerado"
                                            id="checkYesencarcerado" value="1">
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
                                        <input class="mg-0" type="radio" name="checkencarcerado"
                                            id="checkNoencarcerado" value="0">
                                        <span></span>
                                    </label>
                                </div>
                                <div class="form-control">@lang('labels.checkNo')</div>
                            </div>
                        </div>
                    </div>
                </div>


                {{-- 5 pergunta indioAmericano Are you an american Indian or Alaska Native? banco é is_federally_recognized_indian_tribe --}}
                <div class="card-body">
                    <div class="row row-sm">
                        <label class="col-form-label">@lang('labels.indioAmericano')</label>
                        <div class="col-lg-6 mb-3">
                            <div class="input-group">
                                <div class="input-group-text">
                                    <label class="rdiobox wd-16 mg-b-0">
                                        <input class="mg-0" type="radio" name="checkindioamericano"
                                            id="checkYesindioAmericano" value=1>
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
                                        <input class="mg-0" type="radio" name="checkindioamericano"
                                            id="checkNoindioAmericano" value="0">
                                        <span></span>
                                    </label>
                                </div>
                                <div class="form-control">@lang('labels.checkNo')</div>
                            </div>
                        </div>
                    </div>
                </div>

                @if ($female)
                    <!-- Campo para "is_pregnant" -->
                    <div class="row row-sm" style="margin-left: 10px">
                        <label class="col-form-label">@lang('labels.gravida')</label>
                        <div class="col-lg-6 mb-3">
                            <div class="input-group">
                                <div class="input-group-text">
                                    <label class="rdiobox wd-16 mg-b-0">
                                        <input class="mg-0" type="radio" name="is_pregnant" id="isPregnantYes"
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
                                        <input class="mg-0" type="radio" name="is_pregnant" id="isPregnantNo"
                                            value="0">
                                        <span></span>
                                    </label>
                                </div>
                                <div class="form-control">@lang('labels.checkNo')</div>
                            </div>
                        </div>
                    </div>

                    <!-- Campo para "babies_expected" -->
                    <div class="row row-sm " id="babiesExpectedField" style="display: none; margin-left: 10px;">
                        <label class="col-form-label">@lang('labels.gestanteBebes'):</label>
                        <div class="col-lg-6 mb-3 ml-3">
                            <div class="input-group">
                                <input class="form-control" id="babiesExpected" name="babies_expected" type="number"
                                    min="1" max="10" placeholder="@lang('labels.gestanteBebes')">
                            </div>
                        </div>
                    </div>
                @endif

                {{-- 6 pergunta Are you incarcerated pending disposition of charges? banco é is_incarcerated_pending  --}}
                <div class="card-body">
                    <div class="row row-sm">
                        <label class="col-form-label">@lang('labels.aguardandoDecisao')</label>
                        <div class="col-lg-6 mb-3">
                            <div class="input-group">
                                <div class="input-group-text">
                                    <label class="rdiobox wd-16 mg-b-0">
                                        <input class="mg-0" type="radio" name="aguardandoDecisao"
                                            id="checkYesaguardandoDecisao" value=1>
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
                                        <input class="mg-0" type="radio" name="aguardandoDecisao"
                                            id="checkNoaguardandoDecisao" value="0">
                                        <span></span>
                                    </label>
                                </div>
                                <div class="form-control">@lang('labels.checkNo')</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- pergunta 7 origem Are you of Hispanic, Latino, or Spanish origin? campo no banco is_hip_lat_spanish --}}
                <div class="card-body">
                    <div class="row row-sm">
                        <label class="col-form-label">@lang('labels.origem')</label>
                        <div class="col-lg-6 mb-3">
                            <div class="input-group">
                                <div class="input-group-text">
                                    <label class="rdiobox wd-16 mg-b-0">
                                        <input class="mg-0" type="radio" name="origem" id="checkYesorigem" value=1>
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
                                        <input class="mg-0" type="radio" name="origem" id="checkNoorigem"
                                            value="0">
                                        <span></span>
                                    </label>
                                </div>
                                <div class="form-control">@lang('labels.checkNo')</div>
                            </div>
                        </div>

                        <div class="col-lg-6 mb-3">
                            <div class="input-group">
                                <div class="input-group-text">
                                    <label class="rdiobox wd-16 mg-b-0">
                                        <input class="mg-0" type="radio" name="origem" id="checkNoAnswer"
                                            value="1">
                                        <span></span>
                                    </label>
                                </div>
                                <div class="form-control">@lang('labels.recusarResponder')</div>
                            </div>
                        </div>
                    </div>


                    <div class="row row-sm">
                        <div class="col-lg-6 mb-3">
                            <div class="input-group" id="especificacaoTitulo" style="display:none">
                                <div class="input-group-text">
                                    @lang('labels.especificacaoTitulo'):
                                </div>
                                <select class="form-select" name="especificacaoTitulo" id="especificacaoTituloSelect">
                                    <option value="" selected>@lang('labels.campoSelecao')</option>
                                    @foreach ($originLatino as $key => $value)
                                        <option value="{{ $key }}">@lang('labels.' . $value)</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <div class="input-group" id="entinia" style="display:none">
                                <div class="input-group-text">
                                    @lang('labels.entinia'):
                                </div>
                                <select class="form-select" name="race" id="race">
                                    <option value="" selected>@lang('labels.campoSelecao')</option>
                                    @foreach ($raceEthnicity as $key => $value)
                                        <option value="{{ $key }}">@lang('labels.' . $value)</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row row-sm">
                        <label class="col-form-label">@lang('labels.sexoNascimento', ['name' => $currentMember->firstname . ' ' . $currentMember->lastname])</label>
                        <label class="col-form-label">@lang('labels.sexoEncontrar')</label>
                        <div class="col-lg-6 mb-3">
                            <div class="input-group">
                                <select class="form-select" name="sexNasimento" id="sexNasimento">
                                    <option value="" selected>@lang('labels.campoSelecao')</option>
                                    @foreach ($sexAtBirth as $key => $value)
                                        <option value="{{ $key }}">@lang('labels.' . $value)</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row row-sm">
                        <label class="col-form-label">@lang('labels.indentidadeGenero', ['name' => $currentMember->firstname . ' ' . $currentMember->lastname])</label>
                        <div class="col-lg-6 mb-3">
                            <select class="form-select" name="genderIdentity" id="genderIdentity">
                                <option value="" selected>@lang('labels.campoSelecao')</option>
                                @foreach ($genderIdentity as $key => $value)
                                    <option value="{{ $key }}">@lang('labels.' . $value)</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row row-sm">
                        <label class="col-form-label">@lang('labels.orientacaoSexual', ['name' => $currentMember->firstname . ' ' . $currentMember->lastname])</label>
                        <div class="col-lg-6 mb-3">
                            <div class="input-group">
                                <select class="form-select" name="orientacaoSexual" id="orientacaoSexual">
                                    <option value="" selected>@lang('labels.campoSelecao')</option>
                                    @foreach ($sexualOrientation as $key => $value)
                                        <option value="{{ $key }}">@lang('labels.' . $value)</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <button id="btnBack" class="btn btn-primary btn-lg btn-block">@lang('labels.buttonVoltar')</button>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <button id="btnContinue" class="btn btn-secondary btn-lg btn-block"
                                onclick="sendFormHousehold(this)">@lang('labels.buttonContinue')</button>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <!-- END ROW -->


        <!-- Modal modalSSN -->

        <div class="modal" id="modalSSN">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title"></h6><button aria-label="Close" class="close" data-bs-dismiss="modal"
                            type="button"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="card-body">
                            <div>
                                @lang('labels.fonecerSSN')<br>
                                @lang('labels.cmsTitulo')

                                <div class="row">
                                    <div class="col-xl-12 mb-3">
                                        <div class="input-group">
                                            <div class="input-group-text">
                                                <label class="ckbox wd-16 mg-b-0">
                                                    <input class="mg-0" type="checkbox" value=1 name="ckbox-campoSSN"
                                                        id="ckbox-campoSSN">
                                                    <span></span>
                                                </label>
                                            </div>
                                            <input type="hidden" name="has_ssn" id="has_ssn" value=1>
                                            <div class="form-control">
                                                @lang('labels.naoPoussuiSSN', ['name' => $currentMember->firstname . ' ' . $currentMember->lastname])
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-control">
                                        @lang('labels.candidatossSemSSN', ['name' => $currentMember->firstname . ' ' . $currentMember->lastname])
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="modal-footer">
                        <!-- <button class="btn ripple btn-primary" type="button">Save changes</button> -->
                        <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal modaFormulario -->

        <div class="modal" id="ModalStatusImigracao">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title"></h6><button aria-label="Close" class="close" data-bs-dismiss="modal"
                            type="button"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="card-body">
                            <div>
                                @lang('labels.statusImigracao')<br>
                                @lang('labels.statusImigracaoLista')

                                <div class="row">
                                    <div class="col-xl-12 mb-3">
                                        <div class="input-group">
                                            <div class="input-group-text">
                                                <label class="ckbox wd-16 mg-b-0">
                                                    <input class="mg-0" type="checkbox" value=1
                                                        name="statusImigracaoLegivel" id="checkStatusImigracaoLegivel">
                                                    <span></span>
                                                </label>
                                            </div>

                                            <div class="form-control">
                                                @lang('labels.statusImigracaoLegivel')
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-12 mb-3">
                                        <div class="input-group">
                                            <div class="input-group-text">
                                                <label class="ckbox wd-16 mg-b-0">
                                                    <input class="mg-0" type="checkbox" value=1
                                                        name="statusImigrationLegivel">
                                                    <span></span>
                                                </label>
                                            </div>

                                            <div class="form-control">
                                                @lang('labels.coberturaCompleta')
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row row-sm" id="documentoStatusWrapper">
                                        <label class="col-form-label" id="documentoStatusLabel">@lang('labels.documentoStatus')</label>
                                        <div class="col-lg-12 mb-3">
                                            <div class="input-group">
                                                <select class="form-select" id="documentoStatus" name="documentoStatus"
                                                    required>
                                                    <option value="" selected>@lang('labels.campoSelecao')</option>
                                                    @foreach ($documentType as $key => $value)
                                                        <option value="{{ $key }}">@lang('labels.' . $value)
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>


                                    <!-- CAMPOS QUE APARECE DE ACORDO COM O OPTION SELECIONADO Permanent Resident Card("Green Card", l-551) -->
                                    <div id="greenCardFields" class="hidden-fields">
                                        <div class="row row-sm">
                                            <div>
                                                @lang('labels.inserirInformacoes'):
                                            </div>
                                            <div class="col-lg-5 mb-3">
                                                <div class="input-group">
                                                    <div class="input-group-text">
                                                        @lang('labels.numeroEstrangeiro'):
                                                    </div>
                                                    <input type="text" class="form-control" id="numeroEstrangeiro1"
                                                        name="numeroEstrangeiro" placeholder="@lang('labels.numeroEstrangeiro')">
                                                </div>
                                            </div>
                                            <div class="col-lg-7 mb-3">
                                                <div class="input-group">
                                                    <div class="input-group-text">
                                                        @lang('labels.numeroCartao'):
                                                    </div>
                                                    <input type="text" class="form-control" id="numeroCartao1"
                                                        name="numeroCartao" placeholder="@lang('labels.numeroCartao')">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row row-sm">
                                            <div class="col-lg-8 mb-3">
                                                <div class="input-group">
                                                    <div class="input-group-text">
                                                        @lang('labels.dataExpiracao'):
                                                    </div>
                                                    <input type="text" class="form-control data-expiracao"
                                                        id="dataExpiracao1" name="dataExpiracao"
                                                        placeholder="MM/DD/YYYY">
                                                </div>
                                                <div class="invalid-feedback" style="display: none;">
                                                    <!-- Inicialmente escondida -->
                                                    <!-- A mensagem de erro será inserida aqui -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--FIM DOS CAMPOS QUE APARECE DE ACORDO COM O OPTION SELECIONADO Permanent Resident Card("Green Card", l-551) -->


                                    <!-- CAMPOS QUE APARECE DE ACORDO COM O OPTION SELECIONADO Temporary l-551 Stamp (on passport or l-94, l-94A) -->
                                    <div id="temporary" class="hidden-fields">
                                        <div class="row row-sm">
                                            <!-- <div>
                                                                                                                                                                                                                                        @lang('labels.inserirInformacoes'):
                                                                                                                                                                                                                                    </div> -->
                                            <div class="col-lg-5 mb-3">
                                                <div class="input-group">
                                                    <div class="input-group-text">
                                                        @lang('labels.numeroEstrangeiro'):
                                                    </div>
                                                    <input type="text" class="form-control" id="numeroEstrangeiro2"
                                                        name="numeroEstrangeiro" placeholder="@lang('labels.numeroEstrangeiro')">
                                                </div>
                                            </div>
                                            <div class="col-lg-7 mb-3">
                                                <div class="input-group">
                                                    <div class="input-group-text">
                                                        @lang('labels.numeroPassaporte'):
                                                    </div>
                                                    <input type="text" class="form-control" id="numeroPassaporte1"
                                                        name="numeroPassaporte" placeholder="@lang('labels.numeroPassaporte')">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row row-sm">
                                            <div class="col-lg-7 mb-3">
                                                <div class="input-group">
                                                    <div class="input-group-text">
                                                        @lang('labels.paisDeEmissão'):
                                                    </div>
                                                    <select class="form-select paisDeEmissão" id="paisDeEmissão"
                                                        name="paisDeEmissão">
                                                        <option value="" selected>@lang('labels.campoSelecao')</option>
                                                        @foreach ($country as $key => $value)
                                                            <option value="{{ $key }}">@lang('labels.' . $value)
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-5 mb-3">
                                                <div class="input-group">
                                                    <div class="input-group-text">
                                                        @lang('labels.dataExpiracao'):
                                                    </div>
                                                    <input type="text" class="form-control data-expiracao"
                                                        id="dataExpiracao2" name="dataExpiracao"
                                                        placeholder="MM/DD/YYYY">
                                                </div>
                                                <div class="invalid-feedback" style="display: none;">
                                                    <!-- Inicialmente escondida -->
                                                    <!-- A mensagem de erro será inserida aqui -->
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <!--FIM DOS CAMPOS QUE APARECE DE ACORDO COM O OPTION SELECIONADO Temporary l-551 Stamp (on passport or l-94, l-94A) -->



                                    <!-- CAMPOS QUE APARECE DE ACORDO COM O OPTION SELECIONADO Reentry Permit(l-327) -->
                                    <div id="reentry" class="hidden-fields">
                                        <div class="row row-sm">
                                            <!-- <div>
                                                                                                                                                                                                                                        @lang('labels.inserirInformacoes'):
                                                                                                                                                                                                                                    </div> -->
                                            <div class="col-lg-5 mb-3">
                                                <div class="input-group">
                                                    <div class="input-group-text">
                                                        @lang('labels.numeroEstrangeiro'):
                                                    </div>
                                                    <input type="text" class="form-control" id="numeroEstrangeiro3"
                                                        name="numeroEstrangeiro" placeholder="@lang('labels.numeroEstrangeiro')">
                                                </div>
                                            </div>

                                            <div class="col-lg-7 mb-3">
                                                <div class="input-group">
                                                    <div class="input-group-text">
                                                        @lang('labels.dataExpiracao'):
                                                    </div>
                                                    <input type="text" class="form-control data-expiracao"
                                                        id="dataExpiracao3" name="dataExpiracao"
                                                        placeholder="MM/DD/YYYY">
                                                </div>
                                                <div class="invalid-feedback" style="display: none;">
                                                    <!-- Inicialmente escondida -->
                                                    <!-- A mensagem de erro será inserida aqui -->
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <!--FIM DOS CAMPOS QUE APARECE DE ACORDO COM O OPTION SELECIONADO Reentry Permit(l-327) -->


                                    <!-- CAMPOS QUE APARECE DE ACORDO COM O OPTION SELECIONADO Machine Readable lmmigrant Visa (with temporary l-1551 language) -->
                                    <div id="machine" class="hidden-fields">
                                        <div class="row row-sm">
                                            <div>
                                                @lang('labels.informaçõesVisto')
                                            </div>
                                            <div class="col-lg-5 mb-3">
                                                <div class="input-group">
                                                    <div class="input-group-text">
                                                        @lang('labels.numeroEstrangeiro'):
                                                    </div>
                                                    <input type="text" class="form-control" id="numeroEstrangeiro4"
                                                        name="numeroEstrangeiro" placeholder="@lang('labels.numeroEstrangeiro')">
                                                </div>
                                            </div>
                                            <div class="col-lg-7 mb-3">
                                                <div class="input-group">
                                                    <div class="input-group-text">
                                                        @lang('labels.numeroPassaporte'):
                                                    </div>
                                                    <input type="text" class="form-control" id="numeroPassaporte2"
                                                        name="numeroPassaporte" placeholder="@lang('labels.numeroPassaporte')">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row row-sm">
                                            <div class="col-lg-7 mb-3">
                                                <div class="input-group">
                                                    <div class="input-group-text">
                                                        @lang('labels.paisDeEmissão'):
                                                    </div>
                                                    <select class="form-select paisDeEmissão" id="paisDeEmissão"
                                                        name="paisDeEmissão">
                                                        <option value="" selected>@lang('labels.campoSelecao')</option>
                                                        @foreach ($country as $key => $value)
                                                            <option value="{{ $key }}">@lang('labels.' . $value)
                                                            </option>
                                                        @endforeach

                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-5 mb-3">
                                                <div class="input-group">
                                                    <div class="input-group-text">
                                                        @lang('labels.dataExpiracao'):
                                                    </div>
                                                    <input type="text" class="form-control data-expiracao"
                                                        id="dataExpiracao4" name="dataExpiracao"
                                                        placeholder="MM/DD/YYYY">
                                                </div>
                                                <div class="invalid-feedback" style="display: none;">
                                                    <!-- Inicialmente escondida -->
                                                    <!-- A mensagem de erro será inserida aqui -->
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <!--FIM DOS CAMPOS QUE APARECE DE ACORDO COM O OPTION SELECIONADO TMachine Readable lmmigrant Visa (with temporary l-1551 language) -->


                                    <!-- CAMPOS QUE APARECE DE ACORDO COM O OPTION SELECIONADO Employment Authorization Card (EAS, l-766) -->
                                    <div id="employment" class="hidden-fields">
                                        <div class="row row-sm">
                                            <div>
                                                @lang('labels.cartaoAutorizacao')
                                            </div>
                                            <div class="col-lg-5 mb-3">
                                                <div class="input-group">
                                                    <div class="input-group-text">
                                                        @lang('labels.numeroEstrangeiro'):
                                                    </div>
                                                    <input type="text" class="form-control" id="numeroEstrangeiro5"
                                                        name="numeroEstrangeiro" placeholder="@lang('labels.numeroEstrangeiro')">
                                                </div>
                                            </div>
                                            <div class="col-lg-7 mb-3">
                                                <div class="input-group">
                                                    <div class="input-group-text">
                                                        @lang('labels.numeroCartao'):
                                                    </div>
                                                    <input type="text" class="form-control" id="numeroCartao2"
                                                        name="numeroCartao" placeholder="@lang('labels.numeroCartao')">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row row-sm">
                                            <div class="col-lg-7 mb-3">
                                                <div class="input-group">
                                                    <div class="input-group-text">
                                                        @lang('labels.codigoCategoria'):
                                                    </div>
                                                    <input type="text" class="form-control" id="codigoCategoria"
                                                        name="codigoCategoria" placeholder="@lang('labels.codigoCategoria')">
                                                </div>
                                            </div>

                                            <div class="col-lg-5 mb-3">
                                                <div class="input-group">
                                                    <div class="input-group-text">
                                                        @lang('labels.dataExpiracao'):
                                                    </div>
                                                    <input type="text" class="form-control data-expiracao"
                                                        id="dataExpiracao5" name="dataExpiracao"
                                                        placeholder="MM/DD/YYYY">
                                                </div>
                                                <div class="invalid-feedback" style="display: none;">
                                                    <!-- Inicialmente escondida -->
                                                    <!-- A mensagem de erro será inserida aqui -->
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <!--FIM DOS CAMPOS QUE APARECE DE ACORDO COM O OPTION SELECIONADO Employment Authorization Card (EAS, l-766) -->


                                    <!-- CAMPOS QUE APARECE DE ACORDO COM O OPTION SELECIONADO Arrival/Departure Record (l-94, l-944) -->
                                    <div id="arrivalDepartureRecord" class="hidden-fields">
                                        <div class="row row-sm">
                                            <!-- <div>
                                                                                                                                                                                                                                        @lang('labels.cartaoAutorizacao')
                                                                                                                                                                                                                                    </div> -->
                                            <div class="col-lg-6 mb-3">
                                                <div class="input-group">
                                                    <div class="input-group-text">
                                                        @lang('labels.numero'):
                                                    </div>
                                                    <input type="text" class="form-control"
                                                        id="numeroArrivalDepartureRecord"
                                                        name="numeroArrivalDepartureRecord"
                                                        placeholder="@lang('labels.numero')">
                                                </div>
                                            </div>

                                            <div class="col-lg-6 mb-3">
                                                <div class="input-group">
                                                    <div class="input-group-text">
                                                        @lang('labels.dataExpiracao'):
                                                    </div>
                                                    <input type="text" class="form-control data-expiracao"
                                                        id="dataExpiracao6" name="dataExpiracao"
                                                        placeholder="MM/DD/YYYY">
                                                </div>
                                                <div class="invalid-feedback" style="display: none;">
                                                    <!-- Inicialmente escondida -->
                                                    <!-- A mensagem de erro será inserida aqui -->
                                                </div>
                                            </div>

                                        </div>


                                        <div class="row row-sm">
                                            <label class="col-form-label">@lang('labels.informacoesEstudante')</label>
                                            <div class="col-lg-6 mb-3">
                                                <div class="input-group">
                                                    <div class="input-group-text">
                                                        <label class="rdiobox wd-16 mg-b-0">
                                                            <input class="mg-0" type="radio"
                                                                name="checkinformacoesEstudante"
                                                                id="checkYesinformacoesEstudante" value=1>
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
                                                            <input class="mg-0" type="radio"
                                                                name="checkinformacoesEstudante"
                                                                id="checkiNoinformacoesEstudante" value="0">
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                    <div class="form-control">@lang('labels.checkNo')</div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row row-sm">

                                            <div class="col-lg-6 mb-3">
                                                <div class="input-group" id="sevisID" style="display:none">
                                                    <div class="input-group-text">
                                                        @lang('labels.sevisID'):
                                                    </div>
                                                    <input type="text" class="form-control sevis-number"
                                                        name="sevis" placeholder="@lang('labels.sevisID')" id="sevis">
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <!--FIM DOS CAMPOS QUE APARECE DE ACORDO COM O OPTION SELECIONADO Arrival/Departure Record (l-94, l-94A)-->

                                    <!-- CAMPOS QUE APARECE DE ACORDO COM O OPTION SELECIONADO Arrival/Departure Record in unexpired foreign passport (l-94) -->
                                    <div id="arrivalDepartureRecordPassport" class="hidden-fields">
                                        <div class="row row-sm">
                                            <div>
                                                @lang('labels.informacoesl-94/l94A')
                                            </div>
                                            <div class="col-lg-5 mb-3">
                                                <div class="input-group">
                                                    <div class="input-group-text">
                                                        @lang('labels.numero'):
                                                    </div>
                                                    <input type="text" class="form-control" id="numeroRecordl94"
                                                        name="numeroRecordl94" placeholder="@lang('labels.numero')">
                                                </div>
                                            </div>
                                            <div class="col-lg-7 mb-3">
                                                <div class="input-group">
                                                    <div class="input-group-text">
                                                        @lang('labels.numeroPassaporte'):
                                                    </div>
                                                    <input type="text" class="form-control" id="numeroPassaporte3"
                                                        name="numeroPassaporte" placeholder="@lang('labels.numeroPassaporte')">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row row-sm">
                                            <div class="col-lg-7 mb-3">
                                                <div class="input-group">
                                                    <div class="input-group-text">
                                                        @lang('labels.paisDeEmissão'):
                                                    </div>
                                                    <select class="form-select paisDeEmissão" id="paisDeEmissão"
                                                        name="paisDeEmissão">
                                                        <option value="" selected>@lang('labels.campoSelecao')</option>
                                                        @foreach ($country as $key => $value)
                                                            <option value="{{ $key }}">@lang('labels.' . $value)
                                                            </option>
                                                        @endforeach

                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-5 mb-3">
                                                <div class="input-group">
                                                    <div class="input-group-text">
                                                        @lang('labels.dataExpiracao'):
                                                    </div>
                                                    <input type="text" class="form-control data-expiracao"
                                                        id="dataExpiracao7" name="dataExpiracao"
                                                        placeholder="MM/DD/YYYY">
                                                </div>
                                                <div class="invalid-feedback" style="display: none;">
                                                    <!-- Inicialmente escondida -->
                                                    <!-- A mensagem de erro será inserida aqui -->
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row row-sm">
                                            <label class="col-form-label">@lang('labels.informacoesEstudante')</label>
                                            <div class="col-lg-6 mb-3">
                                                <div class="input-group">
                                                    <div class="input-group-text">
                                                        <label class="rdiobox wd-16 mg-b-0">
                                                            <input class="mg-0" type="radio"
                                                                name="checkinformacoesEstudanteArrival"
                                                                id="checkYesinformacoesEstudanteArrival" value=1>
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
                                                            <input class="mg-0" type="radio"
                                                                name="checkinformacoesEstudanteArrival"
                                                                id="checkiNoinformacoesEstudanteArrival" value="0">
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                    <div class="form-control">@lang('labels.checkNo')</div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row row-sm">
                                            <div class="col-lg-6 mb-3" id="sevisIDArrival" style="display:none">
                                                <div class="input-group">
                                                    <div class="input-group-text">
                                                        @lang('labels.sevisID'):
                                                    </div>
                                                    <input type="text" class="form-control sevis-number"
                                                        name="sevis" id="sevis1" placeholder="@lang('labels.sevisID')">
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                    <!--FIM DOS CAMPOS QUE APARECE DE ACORDO COM O OPTION SELECIONADO Arrival/Departure Record in unexpired foreign passport (l-94) -->

                                    <!-- CAMPOS QUE APARECE DE ACORDO COM O OPTION SELECIONADO Refugee Travel Document (l-571 -->
                                    <div id="refugeeTravel" class="hidden-fields">
                                        <div class="row row-sm">
                                            <div>
                                                @lang('labels.informacoesl-571')
                                            </div>
                                            <div class="col-lg-6 mb-3">
                                                <div class="input-group">
                                                    <div class="input-group-text">
                                                        @lang('labels.numeroEstrangeiro'):
                                                    </div>
                                                    <input type="text" class="form-control" id="numeroEstrangeiro6"
                                                        name="numeroEstrangeiro" placeholder="@lang('labels.numeroEstrangeiro')">
                                                </div>
                                            </div>

                                            <div class="col-lg-6 mb-3">
                                                <div class="input-group">
                                                    <div class="input-group-text">
                                                        @lang('labels.dataExpiracao'):
                                                    </div>
                                                    <input type="text" class="form-control data-expiracao"
                                                        id="dataExpiracao8" name="dataExpiracao"
                                                        placeholder="MM/DD/YYYY">
                                                </div>
                                                <div class="invalid-feedback" style="display: none;">
                                                    <!-- Inicialmente escondida -->
                                                    <!-- A mensagem de erro será inserida aqui -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!--FIM DOS CAMPOS QUE APARECE DE ACORDO COM O OPTION SELECIONADO Refugee Travel Document (l-571 -->


                                    <!-- CAMPOS QUE APARECE DE ACORDO COM O OPTION SELECIONADO Certificate of Eligibility for Nonimmigrant (F-1) Student Status (l-20) -->
                                    <div id="certificateEligibility" class="hidden-fields">
                                        <div class="row row-sm">
                                            <div>
                                                @lang('labels.informacoesl-20')
                                            </div>
                                            <div class="col-lg-5 mb-3">
                                                <div class="input-group">
                                                    <div class="input-group-text">
                                                        @lang('labels.numero'):
                                                    </div>
                                                    <input type="text" class="form-control"
                                                        id="numeroNonimigrantF1L20" name="numeroNonimigrantF1L20"
                                                        placeholder="@lang('labels.numero')">
                                                </div>
                                            </div>
                                            <div class="col-lg-7 mb-3">
                                                <div class="input-group">
                                                    <div class="input-group-text">
                                                        @lang('labels.numeroPassaporte'):
                                                    </div>
                                                    <input type="text" class="form-control" id="numeroPassaporte4"
                                                        name="numeroPassaporte" placeholder="@lang('labels.numeroPassaporte')">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row row-sm">
                                            <div class="col-lg-7 mb-3">
                                                <div class="input-group">
                                                    <div class="input-group-text">
                                                        @lang('labels.paisDeEmissão'):
                                                    </div>
                                                    <select class="form-select paisDeEmissão" id="paisDeEmissão"
                                                        name="paisDeEmissão">
                                                        <option value="" selected>@lang('labels.campoSelecao')</option>
                                                        @foreach ($country as $key => $value)
                                                            <option value="{{ $key }}">@lang('labels.' . $value)
                                                            </option>
                                                        @endforeach

                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-5 mb-3">
                                                <div class="input-group">
                                                    <div class="input-group-text">
                                                        @lang('labels.dataExpiracao'):
                                                    </div>
                                                    <input type="text" class="form-control data-expiracao"
                                                        id="dataExpiracao9" name="dataExpiracao"
                                                        placeholder="MM/DD/YYYY">
                                                </div>
                                                <div class="invalid-feedback" style="display: none;">
                                                    <!-- Inicialmente escondida -->
                                                    <!-- A mensagem de erro será inserida aqui -->
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row row-sm">
                                            <div class="col-lg-6 mb-3">
                                                <div class="input-group">
                                                    <div class="input-group-text">
                                                        @lang('labels.sevisID'):
                                                    </div>
                                                    <input type="text" class="form-control sevis-number"
                                                        name="sevis" id="sevis2" placeholder="@lang('labels.sevisID')">
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                    <!--FIM DOS CAMPOS QUE APARECE DE ACORDO COM O OPTION SELECIONADOCertificate of Eligibility for Nonimmigrant (F-1) Student Status (l-20) -->



                                    <!-- CAMPOS QUE APARECE DE ACORDO COM O OPTION SELECIONADO Certificate of Eligibility for Exchange Visitor (J-1)Status (DS2019) -->
                                    <div id="certificateEligibilityExchange" class="hidden-fields">
                                        <div class="row row-sm">
                                            <div class="col-lg-5 mb-3">
                                                <div class="input-group">
                                                    <div class="input-group-text">
                                                        @lang('labels.numero'):
                                                    </div>
                                                    <input type="text" class="form-control" id="numeroVistiorJ1"
                                                        name="numeroVistiorJ1" placeholder="@lang('labels.numero')">
                                                </div>
                                            </div>
                                            <div class="col-lg-7 mb-3">
                                                <div class="input-group">
                                                    <div class="input-group-text">
                                                        @lang('labels.numeroPassaporte'):
                                                    </div>
                                                    <input type="text" class="form-control" id="numeroPassaporte5"
                                                        name="numeroPassaporte" placeholder="@lang('labels.numeroPassaporte')">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row row-sm">
                                            <div class="col-lg-7 mb-3">
                                                <div class="input-group">
                                                    <div class="input-group-text">
                                                        @lang('labels.paisDeEmissão'):
                                                    </div>
                                                    <select class="form-select paisDeEmissão" id="paisDeEmissão"
                                                        name="paisDeEmissão">
                                                        @foreach ($country as $key => $value)
                                                            <option value="{{ $key }}">@lang('labels.' . $value)
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-5 mb-3">
                                                <div class="input-group">
                                                    <div class="input-group-text">
                                                        @lang('labels.dataExpiracao'):
                                                    </div>
                                                    <input type="text" class="form-control data-expiracao"
                                                        id="dataExpiracao10" name="dataExpiracao"
                                                        placeholder="MM/DD/YYYY">
                                                </div>
                                                <div class="invalid-feedback" style="display: none;">
                                                    <!-- Inicialmente escondida -->
                                                    <!-- A mensagem de erro será inserida aqui -->
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row row-sm">
                                            <div class="col-lg-6 mb-3">
                                                <div class="input-group">
                                                    <div class="input-group-text">
                                                        @lang('labels.sevisID'):
                                                    </div>
                                                    <input type="text" class="form-control sevis-number"
                                                        name="sevis" id="sevis3" placeholder="@lang('labels.sevisID')">
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                    <!--FIM DOS CAMPOS QUE APARECE DE ACORDO COM O OPTION SELECIONADO Certificate of Eligibility for Exchange Visitor (J-1)Status (DS2019) -->


                                    <!-- CAMPOS QUE APARECE DE ACORDO COM O OPTION SELECIONADO Notice of Action (l-797) -->
                                    <div id="noticeAction" class="hidden-fields">
                                        <div class="row row-sm">
                                            <div>
                                                @lang('labels.informacoesl-797')
                                            </div>

                                            <div class="row row-sm">
                                                <label class="col-form-label">@lang('labels.digiteNumeros')</label>
                                                <div class="col-lg-6 mb-3">
                                                    <div class="input-group">
                                                        <div class="input-group-text">
                                                            <label class="rdiobox wd-16 mg-b-0">
                                                                <input class="mg-0" type="radio"
                                                                    name="alienOrL94"
                                                                    id="checkAlienNumber" value="1">
                                                                <span></span>
                                                            </label>
                                                        </div>
                                                        <div class="form-control">@lang('labels.numeroEstrangeiro')</div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 mb-3">
                                                    <div class="input-group">
                                                        <div class="input-group-text">
                                                            <label class="rdiobox wd-16 mg-b-0">
                                                                <input class="mg-0" type="radio"
                                                                    name="alienOrL94"
                                                                    id="checkl94Number" value="0">
                                                                <span></span>
                                                            </label>
                                                        </div>
                                                        <div class="form-control">@lang('labels.numerol-94')</div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="row row-sm">
                                                <div class="col-lg-6 mb-3" id="alienNumber" style="display:none">
                                                    <div class="input-group">
                                                        <div class="input-group-text">
                                                            @lang('labels.numeroEstrangeiro'):
                                                        </div>
                                                        <input type="text" class="form-control"
                                                            name="numeroEstrangeiro" id="numeroEstrangeiro7"
                                                            placeholder="@lang('labels.numeroEstrangeiro')">
                                                    </div>
                                                </div>


                                                <div class="col-lg-6 mb-3" id="l94Number" style="display:none">
                                                    <div class="input-group">
                                                        <div class="input-group-text">
                                                            @lang('labels.numerol-94'):
                                                        </div>
                                                        <input type="text" class="form-control" name="l94NumberField"
                                                            id="l94NumberField" placeholder="@lang('labels.numerol-94')">
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                    <!--FIM DOS CAMPOS QUE APARECE DE ACORDO COM O OPTION SELECIONADO Notice of Action (l-797) -->


                                    <!-- CAMPOS QUE APARECE DE ACORDO COM O OPTION SELECIONADO Unexpired foreign passport -->
                                    <div id="unexpiredForeign" class="hidden-fields">
                                        <div class="row row-sm">
                                            <div>
                                                @lang('labels.informacoesPassaporte')
                                            </div>
                                            <div class="col-lg-5 mb-3">
                                                <div class="input-group">
                                                    <div class="input-group-text">
                                                        @lang('labels.numero'):
                                                    </div>
                                                    <input type="text" class="form-control" id="numeroUnexpired"
                                                        name="numeroUnexpired" placeholder="@lang('labels.numero')">
                                                </div>
                                            </div>
                                            <div class="col-lg-7 mb-3">
                                                <div class="input-group">
                                                    <div class="input-group-text">
                                                        @lang('labels.numeroPassaporte'):
                                                    </div>
                                                    <input type="text" class="form-control" id="numeroPassaporte6"
                                                        name="numeroPassaporte" placeholder="@lang('labels.numeroPassaporte')">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row row-sm">
                                            <div class="col-lg-7 mb-3">
                                                <div class="input-group">
                                                    <div class="input-group-text">
                                                        @lang('labels.paisDeEmissão'):
                                                    </div>
                                                    <select class="form-select paisDeEmissão" id="paisDeEmissão"
                                                        name="paisDeEmissão">
                                                        <option value="" selected>@lang('labels.campoSelecao')</option>
                                                        @foreach ($country as $key => $value)
                                                            <option value="{{ $key }}">@lang('labels.' . $value)
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-5 mb-3">
                                                <div class="input-group">
                                                    <div class="input-group-text">
                                                        @lang('labels.dataExpiracao'):
                                                    </div>
                                                    <input type="text" class="form-control" name="dataExpiracao"
                                                        id="dataExpiracao11" placeholder="MM/DD/YYYY">
                                                </div>
                                                <div class="invalid-feedback" style="display: none;">
                                                    <!-- Inicialmente escondida -->
                                                    <!-- A mensagem de erro será inserida aqui -->
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row row-sm">
                                            <label class="col-form-label">@lang('labels.informacoesEstudante')</label>
                                            <div class="col-lg-6 mb-3">
                                                <div class="input-group">
                                                    <div class="input-group-text">
                                                        <label class="rdiobox wd-16 mg-b-0">
                                                            <input class="mg-0" type="radio"
                                                                name="checkinformacoesPassaporte"
                                                                id="checkYesinformacoesPassaporte" value=1>
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
                                                            <input class="mg-0" type="radio"
                                                                name="checkinformacoesPassaporte"
                                                                id="checkiNoinformacoesPassaporte" value="0">
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                    <div class="form-control">@lang('labels.checkNo')</div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row row-sm">
                                            <div class="col-lg-6 mb-3" id="sevisIDPassaporte" style="display:none">
                                                <div class="input-group">
                                                    <div class="input-group-text">
                                                        @lang('labels.sevisID'):
                                                    </div>
                                                    <input type="text" class="form-control sevis-number"
                                                        name="sevis" id="sevis4" placeholder="@lang('labels.sevisID')">
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                    <!--FIM DOS CAMPOS QUE APARECE DE ACORDO COM O OPTION SELECIONADO Unexpired foreign passport -->


                                    <!-- CAMPOS QUE APARECE DE ACORDO COM O OPTION SELECIONADO Other document with an alien Number or l-94 number -->
                                    <div id="otherDocumentWithAlien" class="hidden-fields">
                                        <div class="row row-sm">
                                            <div>
                                                @lang('labels.informacoesl-94')
                                            </div>
                                            <div class="col-lg-12 mb-3">
                                                <div class="input-group">
                                                    <div class="row">

                                                        <div class="col-xl-12 mb-3">
                                                            <div class="input-group">
                                                                <div class="input-group-text">
                                                                    <label class="ckbox wd-16 mg-b-0">
                                                                        <input class="mg-0" type="checkbox"
                                                                            id="isFederallyRecognizedIndianTribe"
                                                                            name="isFederallyRecognizedIndianTribe"
                                                                            value="1"> <span></span>
                                                                    </label>
                                                                </div>
                                                                <div class="form-control">
                                                                    @lang('labels.membrosTribos')
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-12 mb-3">
                                                            <div class="input-group">
                                                                <div class="input-group-text">
                                                                    <label class="ckbox wd-16 mg-b-0">
                                                                        <input class="mg-0" type="checkbox"
                                                                            id="refugeeResettlementCert"
                                                                            name="refugeeResettlementCert" value="1">
                                                                        <span></span>
                                                                    </label>
                                                                </div>
                                                                <div class="form-control">
                                                                    @lang('labels.CertificacaoDepartamento')
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <div class="col-xl-12 mb-3">
                                                            <div class="input-group">
                                                                <div class="input-group-text">
                                                                    <label class="ckbox wd-16 mg-b-0">
                                                                        <input class="mg-0" type="checkbox"
                                                                            id="eligibilityLetter"
                                                                            name="eligibilityLetter" value="1">
                                                                        <span></span>
                                                                    </label>
                                                                </div>
                                                                <div class="form-control">
                                                                    @lang('labels.cartaElegibilidade')
                                                                </div>
                                                            </div>
                                                        </div>



                                                        <div class="col-xl-12 mb-3">
                                                            <div class="input-group">
                                                                <div class="input-group-text">
                                                                    <label class="ckbox wd-16 mg-b-0">
                                                                        <input class="mg-0" type="checkbox"
                                                                            id="cubanHaitianEntrantCheckbox"
                                                                            name="cubanHaitianEntrant" value="1">
                                                                        <span></span>
                                                                    </label>
                                                                </div>
                                                                <div class="form-control">
                                                                    @lang('labels.cubanoHaitiano')
                                                                </div>
                                                            </div>
                                                        </div>



                                                        <div class="col-xl-12 mb-3">
                                                            <div class="input-group">
                                                                <div class="input-group-text">
                                                                    <label class="ckbox wd-16 mg-b-0">
                                                                        <input class="mg-0" type="checkbox"
                                                                            id="lawfullyPresentAmericanSamoa"
                                                                            name="lawfullyPresentAmericanSamoa"
                                                                            value="1"> <span></span>
                                                                    </label>
                                                                </div>
                                                                <div class="form-control">
                                                                    @lang('labels.samoaAmericana')
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <!-- Conjuge Filho Pai -->
                                                        <div class="col-xl-12 mb-3">
                                                            <div class="input-group">
                                                                <div class="input-group-text">
                                                                    <label class="ckbox wd-16 mg-b-0">
                                                                        <input class="mg-0" type="checkbox"
                                                                            id="batteredSpouseChildParent"
                                                                            name="batteredSpouseChildParent"
                                                                            value="1"> <span></span>
                                                                    </label>
                                                                </div>
                                                                <div class="form-control">
                                                                    @lang('labels.conjugueFilhoPai')
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <!-- Outro Documento -->
                                                        <div class="col-xl-12 mb-3">
                                                            <div class="input-group">
                                                                <div class="input-group-text">
                                                                    <label class="ckbox wd-16 mg-b-0">
                                                                        <input class="mg-0" type="checkbox"
                                                                            id="anotherDocumentAlien"
                                                                            name="anotherDocumentAlien" value="1">
                                                                        <span></span>
                                                                    </label>
                                                                </div>
                                                                <div class="form-control">
                                                                    @lang('labels.outroDocumento')
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <!-- Nenhum Destes -->
                                                        <div class="col-xl-12 mb-3">
                                                            <div class="input-group">
                                                                <div class="input-group-text">
                                                                    <label class="ckbox wd-16 mg-b-0">
                                                                        <input class="mg-0" type="checkbox"
                                                                            id="theseDocumentNone"
                                                                            name="theseDocumentNone" value="1">
                                                                        <span></span>
                                                                    </label>
                                                                </div>
                                                                <div class="form-control">
                                                                    @lang('labels.nenhumDestes')
                                                                </div>
                                                            </div>
                                                        </div>


                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <!--FIM DOS CAMPOS QUE APARECE DE ACORDO COM O OPTION SELECIONADO Other document with an alien Number or l-94 number -->



                                    <!-- CAMPOS QUE APARECE DE ACORDO COM O OPTION SELECIONADO None of these -->
                                    <div id="noneOfThese" class="hidden-fields">
                                        <div class="row row-sm">
                                            <div>
                                                @lang('labels.informacoesl-94')
                                            </div>
                                            <div class="col-lg-12 mb-3">
                                                <div class="input-group">
                                                    <div class="row">
                                                        <div class="col-xl-12 mb-3">
                                                            <div class="input-group">
                                                                <div class="input-group-text">
                                                                    <label class="ckbox wd-16 mg-b-0">
                                                                        <input class="mg-0" type="checkbox"
                                                                            value="1"
                                                                            name="isFederallyRecognizedIndianTribeCheck"
                                                                            id="isFederallyRecognizedIndianTribeCheck">
                                                                        <span></span>
                                                                    </label>
                                                                </div>
                                                                <div class="form-control">
                                                                    @lang('labels.membrosTribos')
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <div class="col-xl-12 mb-3">
                                                            <div class="input-group">
                                                                <div class="input-group-text">
                                                                    <label class="ckbox wd-16 mg-b-0">
                                                                        <input class="mg-0" type="checkbox"
                                                                            value="1" name="refugeeResettlementCert"
                                                                            id="refugeeResettlement"> <span></span>
                                                                    </label>
                                                                </div>
                                                                <div class="form-control">
                                                                    @lang('labels.CertificacaoDepartamento')
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <div class="col-xl-12 mb-3">
                                                            <div class="input-group">
                                                                <div class="input-group-text">
                                                                    <label class="ckbox wd-16 mg-b-0">
                                                                        <input class="mg-0" type="checkbox"
                                                                            value="1" name="eligibility"
                                                                            id="eligibility"> <span></span>
                                                                    </label>
                                                                </div>
                                                                <div class="form-control">
                                                                    @lang('labels.cartaElegibilidade')
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <div class="col-xl-12 mb-3">
                                                            <div class="input-group">
                                                                <div class="input-group-text">
                                                                    <label class="ckbox wd-16 mg-b-0">
                                                                        <input class="mg-0" type="checkbox"
                                                                            value="1" name="cubanHaitian"
                                                                            id="cubanHaitian"> <span></span>
                                                                    </label>
                                                                </div>
                                                                <div class="form-control">
                                                                    @lang('labels.cubanoHaitiano')
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <div class="col-xl-12 mb-3">
                                                            <div class="input-group">
                                                                <div class="input-group-text">
                                                                    <label class="ckbox wd-16 mg-b-0">
                                                                        <input class="mg-0" type="checkbox"
                                                                            value="1"
                                                                            name="lawfullyPresentAmericanSamoa"
                                                                            id="americanSamoaCheck"> <span></span>
                                                                    </label>
                                                                </div>
                                                                <div class="form-control">
                                                                    @lang('labels.samoaAmericana')
                                                                </div>
                                                            </div>
                                                        </div>



                                                        <div class="col-xl-12 mb-3">
                                                            <div class="input-group">
                                                                <div class="input-group-text">
                                                                    <label class="ckbox wd-16 mg-b-0">
                                                                        <input class="mg-0" type="checkbox"
                                                                            value="1"
                                                                            name="batteredSpouseChildParent"
                                                                            id="batteredSpouseChildParent"> <span></span>
                                                                    </label>
                                                                </div>
                                                                <div class="form-control">
                                                                    @lang('labels.conjugueFilhoPai')
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-12 mb-3">
                                                            <div class="input-group">
                                                                <div class="input-group-text">
                                                                    <label class="ckbox wd-16 mg-b-0">
                                                                        <input class="mg-0" type="checkbox"
                                                                            value="1" name="anotherDocument"
                                                                            id="anotherDocumentCheck"> <span></span>
                                                                    </label>
                                                                </div>
                                                                <div class="form-control">
                                                                    @lang('labels.outroDocumento')
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-12 mb-3">
                                                            <div class="input-group">
                                                                <div class="input-group-text">
                                                                    <label class="ckbox wd-16 mg-b-0">
                                                                        <input class="mg-0" type="checkbox"
                                                                            value="1" name="theseDocument"
                                                                            id="theseDocumentCheck"> <span></span>
                                                                    </label>
                                                                </div>
                                                                <div class="form-control">
                                                                    @lang('labels.nenhumDestes')
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                    <!--FIM DOS CAMPOS QUE APARECE DE ACORDO COM O OPTION SELECIONADO None of these -->


                                    <!--Campos que corresponde preenchimento do documento-->
                                    <div class="row row-sm">
                                        <label class="col-form-label">@lang('labels.nomedocumento')</label>
                                        <label class="col-form-label">{{ $currentMember->firstname }}
                                            {{ $currentMember->lastname }}</label>
                                        <div class="col-lg-6 mb-3">
                                            <div class="input-group">
                                                <div class="input-group-text">
                                                    <label class="rdiobox wd-16 mg-b-0">
                                                        <input class="mg-0" type="radio"
                                                            name="checkcnomedocumento" id="checkYesnomedocumento"
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
                                                        <input class="mg-0" type="radio"
                                                            name="checkcnomedocumento" id="checkNonomedocumento"
                                                            value="0">
                                                        <span></span>
                                                    </label>
                                                </div>
                                                <div class="form-control">@lang('labels.checkNo')</div>
                                            </div>
                                        </div>
                                    </div>

                                    <!--Campos quando o documento nao estiver no nome-->

                                    <div class="row row-sm">
                                        <label class="col-form-label" id="documentLabel"
                                            style="display:none;">@lang('labels.dadosDocumento', ['name' => $currentMember->firstname . ' ' . $currentMember->lastname])</label>

                                        <div class="col-lg-6 mb-3" id="documentFirstName" style="display:none;">
                                            <div class="input-group">
                                                <div class="input-group-text">
                                                    @lang('labels.nome'):
                                                </div>
                                                <input type="text" class="form-control" name="FirstName"
                                                    id="FirstName" placeholder="@lang('labels.nome')">
                                            </div>
                                        </div>

                                        <div class="col-lg-6 mb-3" id="documentMiddle" style="display:none;">
                                            <div class="input-group">
                                                <div class="input-group-text">
                                                    @lang('labels.campoCentral'):
                                                </div>
                                                <input type="text" class="form-control" name="MiddelName"
                                                    id="MiddelName" placeholder="@lang('labels.campoCentral')">
                                            </div>
                                        </div>

                                        <div class="col-lg-6 mb-3" id="documentLastName" style="display:none;">
                                            <div class="input-group">
                                                <div class="input-group-text">
                                                    @lang('labels.sobreNome'):
                                                </div>
                                                <input type="text" class="form-control" name="LastName"
                                                    id="LastName" placeholder="@lang('labels.sobreNome')">
                                            </div>
                                        </div>

                                        <div class="col-lg-6 mb-3" id="documentSuffix" style="display:none;">
                                            <div class="input-group">
                                                <div class="input-group-text">
                                                    @lang('labels.suffix'):
                                                </div>
                                                <select class="form-select">
                                                    <option value="" selected>@lang('labels.campoSelecao')</option>
                                                    @foreach ($suffixes as $key => $value)
                                                        <option value="{{ $key }}">{{ $value }}</option>
                                                    @endforeach

                                                </select>
                                            </div>
                                        </div>
                                    </div>


                                    <!--Fim Campos que corresponde preenchimento do documento-->


                                    <div class="row row-sm">
                                        <label class="col-form-label"> @lang('labels.moraNoEUA', ['name' => $currentMember->firstname . ' ' . $currentMember->lastname])
                                        </label>
                                        <div class="col-lg-6 mb-3">
                                            <div class="input-group">
                                                <div class="input-group-text">
                                                    <label class="rdiobox wd-16 mg-b-0">
                                                        <input class="mg-0" type="radio" name="checkcmoranoeua"
                                                            id="checkYesmoranoeua" value=1>
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
                                                        <input class="mg-0" type="radio" name="checkcmoranoeua"
                                                            id="checkNomoranoeua" value=0>
                                                        <span></span>
                                                    </label>
                                                </div>
                                                <div class="form-control">@lang('labels.checkNo')</div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="row row-sm">

                                    <div class="modal-footer">
                                        <!-- <button class="btn ripple btn-primary" type="button">Save changes</button> -->
                                        <!-- <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Close</button> -->
                                        <a href="#" id="saveMembersBtn"
                                            class="btn btn-primary btn-lg btn-block">@lang('labels.addMembers')</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    {{-- </div>
                        </div>
                    </div> --}}

                    <!-- Spinner de carregamento -->
                    <div class="loader" id="loader">
                        <div class="spinner"></div>
                    </div>
                @endsection

                @section('scripts')
                    <!-- INTERNAL DATEPICKER JS -->
                    <script src="{{ asset('build/assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>

                    <!-- INTERNAL JQUERY.MASKEDINPUT JS -->
                    <script src="{{ asset('build/assets/plugins/jquery.maskedinput/jquery.maskedinput.js') }}"></script>

                    <!-- INTERNAL SPECTRUM-COLORPICKER JS -->
                    <script src="{{ asset('build/assets/plugins/spectrum-colorpicker/spectrum.js') }}"></script>

                    <!--  INTERNAL SELECT2 JS -->
                    <script src="{{ asset('build/assets/plugins/select2/js/select2.min.js') }}"></script>

                    <!-- INTERNAL ION-RANGESLIDER JS -->
                    <script src="{{ asset('build/assets/plugins/ion-rangeslider/js/ion.rangeSlider.min.js') }}"></script>

                    <!-- INTERNAL JQUERY-AMAZEUI DATETIMEPICKER JS -->
                    <script src="{{ asset('build/assets/plugins/amazeui-datetimepicker/js/amazeui.datetimepicker.min.js') }}"></script>

                    <!-- INTERNAL JQUERY-SIMPLE DATETIMEPICKER JS -->
                    <script src="{{ asset('build/assets/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.js') }}"></script>

                    <!-- INTERNAL PICKER JS -->
                    <script src="{{ asset('build/assets/plugins/pickerjs/picker.min.js') }}"></script>

                    <!-- INTERNAL COLORPICKER JS -->
                    <script src="{{ asset('build/assets/plugins/colorpicker/pickr.es5.min.js') }}"></script>
                    @vite('resources/assets/js/colorpicker.js')


                    <!-- BOOTSTRAP-DATEPICKER JS -->
                    <script src="{{ asset('build/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>

                    <!-- INTERNAL FORM-ELEMENTS JS -->
                    @vite('resources/assets/js/form-elements.js')

                    <!--   MOSTRAR MODAL SSN -->
                    <script src="{{ asset('js/members/modalSSN.js') }}"></script>

                    <!--   MOSTRAR CAMPO DATA -->
                    <script src="{{ asset('js/members/mostrarCampo.js') }}"></script>

                    <!--   MOSTRAR CAMPO DE ACORDO COM O OPTION-->
                    <script src="{{ asset('js/members/mostraCamposOption.js') }}"></script>

                    <script>
                        const documentTypeMap = @json($documentType);

                        let householdMembers = [{}]; // Inicializa com um objeto vazio para evitar múltiplos membros
                        function isValidDate(dateString) {
                            return !isNaN(Date.parse(dateString)); // Verifica se a data é válida
                        }

                        function updateMemberData() {
                            // Captura dos valores de cada campo em variáveis
                            const ssn = ($('#ssnNumber').val() || '').replace(/-/g, '') || null;
                            const hasSsn = $('#ssnFieldContaine').is(':checked') ? 0 : 1; //ok
                            const ckboxCampoSSN = $('#ckbox-campoSSN').is(':checked') ? 1 : 0; //ok
                            const useTobacco = $('input[name="checkcigarro"]:checked').val() || 0; //ok
                            const lastTobaccoUsage = $('#dateLastTobaccoUsage').val() ||
                                null; //ok
                            const isUsCitizen = $('input[name="checkamericano"]:checked').val() ||
                                null; //ok
                            const eligibleImmigrationStatus = $('input[name="statusImigracaoLegivel"]:checked').val() || 0;
                            const numeroRecordl94 = $('#numeroRecordl94').val() || null;
                            // Dados de documentos
                            const documentNumber = $('input[name="numeroEstrangeiro"]').filter(function() {
                                return $(this).val().trim() !== ''; // Filtra apenas os inputs com valor preenchido
                            }).first().val() || null;

                            const cardNumber = $('input[name="numeroCartao"]').filter(function() {
                                return $(this).val().trim() !== ''; // Filtra apenas os inputs com valor preenchido
                            }).first().val() || null;

                            const documentExpirationDate = $('.data-expiracao').filter(function() {
                                return isValidDate($(this).val());
                            }).first().val() || null;

                            console.log(documentExpirationDate);
                            const documentCountryIssuance = $('.paisDeEmissão').filter(function() {
                                return $(this).val(); // Retorna apenas os elementos com valor
                            }).first().val() || null;
                            const document_type = $('#documentoStatus').val() || null;

                            // Dados de identidade
                            const genderIdentity = $('#genderIdentity').val() || null;
                            const birthSex = $('#sexNasimento').val() || null; //ok
                            const isIncarcerated = $('input[name="checkencarcerado"]:checked').val() || null; // ok 

                            // Campos de nome de documento
                            const documentFirstName = $('#FirstName').val() || null;
                            const documentMiddleName = $('#MiddelName').val() || null;
                            const documentLastName = $('#LastName').val() || null;
                            const documentSuffix = $('#documentSuffix').val() || null;
                            const document_category_code = $('#codigoCategoria').val() || null;
                            const numeroArrivalDepartureRecord = $('#numeroArrivalDepartureRecord').val() || null;
                            const has_sevis = $('input[name="checkinformacoesPassaporte"]:checked').val() ||
                                $('input[name="informacoesPassaporte"]:checked').val() ||
                                 $('input[name="checkinformacoesEstudanteArrival"]:checked').val() || 
                                 $('input[name="checkinformacoesEstudante"]:checked').val() || null;

                            const alien_or_l_94_number = $('input[name="alienOrL94"]:checked').val() || null;
                            const sevis_number = $('.sevis-number').filter(function() {
                                return $(this).val(); // Retorna apenas os elementos com valor
                            }).first().val() || householdMembers[0].sevis_number || null;


                            const numeroPassaporte = $('input[name="numeroPassaporte"]').filter(function() {
                                return $(this).val(); // Filtra os campos com valor preenchido
                            }).first().val() || null;

                            console.log(numeroPassaporte);

                            const numeroNonimigrantF1L20 = $('#numeroNonimigrantF1L20').val() || null;
                            const numeroVistiorJ1 = $('#numeroVistiorJ1').val() || null;
                            const l94NumberField = $('#l94NumberField').val() || null;
                            const numeroUnexpired = $('#numeroUnexpired').val() || null;
                            const live_in_eua = $('input[name="checkcmoranoeua"]:checked').val() || null;
                            const statusImigrationLegivel = $('#statusImigrationLegivel').is(':checked') ? 1 : 0;
                            const same_document_name =
                                $('[name="checkcnomedocumento"]:checked').val() !== undefined ?
                                parseInt($('[name="checkcnomedocumento"]:checked').val(), 10) :
                                null;

                            // Checkboxes e campos adicionais
                            const isFederallyRecognizedIndianTribe = $('#isFederallyRecognizedIndianTribe').is(':checked') ? 1 : 0;
                            const isFederallyRecognizedIndianTribeCheck = $('#isFederallyRecognizedIndianTribeCheck').is(':checked') ? 1 :
                                0;
                            const hasHhsOrRefugeeResettlementCert = $('[name="refugeeResettlementCert"]').is(':checked') ? 1 : 0;
                            const hasOrrEligibilityLetter = $('#eligibilityLetter').is(':checked') ? 1 : 0;
                            const eligibility = $('[name="eligibilityCheckbox"]').is(':checked') ? 1 : 0;
                            const isCubanHaitianEntrant = $('#cubanHaitianEntrantCheckbox').is(':checked') ? 1 : 0;
                            const cubanHaitianChecked = $('input[name="cubanHaitian"]').is(':checked') ? 1 : 0;
                            const isLawfullyPresentAmericanSamoa = $('#lawfullyPresentAmericanSamoa').is(':checked') ? 1 : 0;
                            const americanSamoa = $('#americanSamoaCheck').is(':checked') ? 1 : 0;
                            const isBatteredSpouseChildParentVawa = $('#batteredSpouseChildParent').is(':checked') ? 1 : 0;
                            const hasAnotherDocumentOrAlienNumber = $('#anotherDocumentAlien').is(':checked') ? 1 : 0;
                            const anotherDocument = $('#anotherDocumentCheck').is(':checked') ? 1 : 0;
                            const noneOfTheseDocument = $('#theseDocumentNone').is(':checked') ? 1 : 0;
                            const is_hip_lat_spanish = $('#checkYesorigem').is(':checked') ? 1 : 0;
                            const checkindioamericano = $('[name="checkindioamericano"]:checked').val() ? 1 : 0;
                            const declined_race = $('#checkNoAnswer').is(':checked') ? 1 : 0;
                            const race = $('#race').val() || null;
                            const sexual_orientation = $('#orientacaoSexual').val() || null;
                            const hip_lat_spanish_specific = $('#especificacaoTituloSelect').val() || null;
                            const is_incarcerated_pending = $('input[name="aguardandoDecisao"]:checked').val() || null;

                            // Campos para gravidez e bebês esperados
                            const isPregnant = $('input[name="is_pregnant"]:checked').val() || null; //ok
                            const babiesExpected = $('#babiesExpected').val() || 0; //ok
                            const answer_member_information = 1;


                            // Atualiza o primeiro membro com os dados capturados
                            householdMembers[0] = {
                                ...householdMembers[0], // Mantém dados anteriores
                                ssn: ssn,
                                has_ssn: hasSsn,
                                use_tobacco: useTobacco,
                                last_tobacco_usage: lastTobaccoUsage,
                                is_us_citizen: isUsCitizen,
                                eligible_immigration_status: eligibleImmigrationStatus,
                                document_number: documentNumber || numeroRecordl94 || numeroNonimigrantF1L20 || numeroVistiorJ1 ||
                                    l94NumberField || numeroUnexpired,
                                document_expiration_date: documentExpirationDate,
                                document_country_issuance: documentCountryIssuance,
                                gender_identity: genderIdentity,
                                birth_sex: birthSex,
                                same_document_name: same_document_name,
                                is_incarcerated: isIncarcerated,
                                document_first_name: documentFirstName,
                                document_middle_name: documentMiddleName,
                                document_last_name: documentLastName,
                                document_suffix: documentSuffix,
                                is_federally_recognized_indian_tribe: isFederallyRecognizedIndianTribe ||
                                    isFederallyRecognizedIndianTribeCheck,
                                has_hhs_or_refugee_resettlement_cert: hasHhsOrRefugeeResettlementCert,
                                has_orr_eligibility_letter: hasOrrEligibilityLetter || eligibility,
                                is_cuban_haitian_entrant: isCubanHaitianEntrant || cubanHaitianChecked,
                                is_lawfully_present_american_samoa: isLawfullyPresentAmericanSamoa || americanSamoa,
                                is_battered_spouse_child_parent_vawa: isBatteredSpouseChildParentVawa,
                                has_another_document_or_alien_number: hasAnotherDocumentOrAlienNumber || anotherDocument,
                                none_of_these_document: noneOfTheseDocument,
                                is_pregnant: isPregnant,
                                babies_expected: babiesExpected,
                                is_incarcerated_pending: is_incarcerated_pending,
                                answer_member_information: answer_member_information,
                                isAiAln: checkindioamericano,
                                is_hip_lat_spanish: is_hip_lat_spanish,
                                declined_race: declined_race,
                                hip_lat_spanish_specific: hip_lat_spanish_specific,
                                race: race,
                                sexual_orientation: sexual_orientation,
                                ckboxCampoSSN: ckboxCampoSSN, //ver qual campo no banco.
                                document_type: document_type ,
                                document_complement_number: numeroArrivalDepartureRecord || cardNumber,
                                has_sevis: has_sevis || alien_or_l_94_number,
                                live_in_eua: live_in_eua,
                                ineligible_full_coverage: statusImigrationLegivel,
                                sevis_number: sevis_number,
                                document_number_type: numeroPassaporte,
                                document_category_code: document_category_code
                            };

                            console.log("Dados do membro atualizados:", householdMembers[0]);
                        }



                        function saveModalData() {
                            updateMemberData(); // Salva dados ao clicar em `saveMembersBtn`
                            console.log("Dados após modal:", householdMembers[0]);
                        }

                        function formatHousehold() {
                            const applicationId = '{{ $application_id ?? 0 }}';
                            const member_id = '{{ $member_id ?? 0 }}';

                            const formattedData = {
                                'application_id': applicationId,
                                'this_household_member_id': member_id,
                                'household_members': householdMembers
                            };

                            console.log("Dados para envio:", formattedData);
                            return formattedData;
                        }


                        function sendFormHousehold() {
                            const household = formatHousehold();
                            const csrf_token = '{{ csrf_token() }}';
                            console.log("household", household);
                            document.getElementById('loader').style.display = 'block';

                            $.ajax({
                                headers: {
                                    'X-CSRF-TOKEN': csrf_token,
                                },
                                url: "{{ route('memberinfo.store') }}",
                                method: 'POST',
                                contentType: 'application/json',
                                processData: false,
                                data: JSON.stringify(household),
                                success: function(response) {
                                    console.log("Response completa:", response);

                                    if (response.status === 'success' && response.data && response.data.id) {
                                        // Redireciona para o próximo membro
                                        const nextMemberId = response.data.id;
                                        const applicationId = '{{ $application_id }}';

                                        Swal.fire({
                                            title: '@lang('labels.formSaved')',
                                            text: '@lang('labels.clickOk').',
                                            icon: 'info',
                                            confirmButtonText: 'OK'
                                        }).then(() => {
                                            window.location.href =
                                                `/members/${applicationId}?member_id=${nextMemberId}`;
                                        });
                                    } else if (response.status === 'completed') {
                                        // Redireciona para a página de Income quando todos os membros foram completados
                                        Swal.fire({
                                            title: '@lang('labels.sucesso')',
                                            text: '@lang('labels.completoMembers').',
                                            icon: 'success',
                                            confirmButtonText: 'OK'
                                        }).then(() => {
                                            window.location.href =
                                                "{{ route('livewire.income', ['application_id' => $application_id]) }}";
                                        });
                                    }
                                },

                                error: function(jqXHR) {
                                    Swal.fire({
                                        title: 'Erro!',
                                        text: 'Erro ao salvar os dados.',
                                        icon: 'error',
                                        confirmButtonText: 'OK'
                                    });
                                    console.error("Erro de resposta:", jqXHR.responseText);
                                }
                            });
                        }






                        $(document).ready(function() {
                            $('input, select').on('change blur', function() {
                                updateMemberData(); // Atualiza dados a cada interação com inputs
                            });

                            $('#saveMembersBtn').on('click', function(e) {
                                e.preventDefault();
                                saveModalData();
                                $('#ModalStatusImigracao').modal('hide');
                            });

                            $('#dataExpiracao1').mask('99/99/9999');
                            $('#dataExpiracao2').mask('99/99/9999');
                            $('#dataExpiracao3').mask('99/99/9999');
                            $('#dataExpiracao4').mask('99/99/9999');
                            $('#dataExpiracao5').mask('99/99/9999');
                            $('#dataExpiracao6').mask('99/99/9999');
                            $('#dataExpiracao7').mask('99/99/9999');
                            $('#dataExpiracao8').mask('99/99/9999');
                            $('#dataExpiracao9').mask('99/99/9999');
                            $('#dataExpiracao10').mask('99/99/9999');
                            $('#dataExpiracao11').mask('99/99/9999');
                            $('#dateLastTobaccoUsage').mask('99/99/9999');
                            $('#ssnNumber').mask('999-99-9999');
                        });


                        $(function() {
                            // Validação para todos os campos com a classe 'date-input'
                            $('.date-input').on('blur', function() {
                                const dateValue = $(this).val();
                                const parts = dateValue.split('/');
                                const errorMessage = $('.invalid-feedback'); // Seleciona a div de feedback

                                // Limpa mensagens de erro anteriores
                                errorMessage.text('');
                                errorMessage.hide(); // Esconde a mensagem de erro
                                $(this).removeClass('is-invalid');

                                if (parts.length === 3) {
                                    const month = parseInt(parts[0], 10);
                                    const day = parseInt(parts[1], 10);

                                    if (month > 12) {
                                        errorMessage.text('@lang('labels.monthBig').');
                                        errorMessage.show(); // Mostra a mensagem de erro
                                        $(this).addClass('is-invalid'); // Adiciona classe de erro
                                    } else if (day > 31) {
                                        errorMessage.text('@lang('labels.dayBig').');
                                        errorMessage.show(); // Mostra a mensagem de erro
                                        $(this).addClass('is-invalid'); // Adiciona classe de erro
                                    }
                                }
                            });
                        });
                    </script>
                @endsection
