@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="/css/abaNavegacao.css">
<link rel="stylesheet" href="/css/load.css">
@endsection

@php
$houseHoldA = [];
$houseHoldAmarried = null;
$houseHoldAisDependent = null;
$houseHoldAeligibleCostSaving = null;
$houseHoldAjointlyTaxedSpouse = null;
$houseHoldApplying_coverage = null;

if(isset($houseHold[0][0])){
    $houseHoldA = $houseHold[0][0];
    $houseHoldAmarried = $houseHoldA['married'];
    $houseHoldAisDependent = $houseHoldA['is_dependent'];
    $houseHoldAeligibleCostSaving = $houseHoldA['eligible_cost_saving'];
    $houseHoldAjointlyTaxedSpouse = $houseHoldA['jointly_taxed_spouse'];
    $houseHoldApplying_coverage = $houseHoldA['applying_coverage'];
}
//dd($houseHoldA['household_members'][0]['field_type']);
//dd($houseHoldA) ;
    // Dados do Cônjuge (se houver):
        $spouseFirstName = null;
        $spouseMiddleName = null;
        $spouseLastName = null;
        $spouseSuffix = null;
        $spouseBirthdate = null;
        $spouseSex = null;
    if ((isset($houseHoldA['household_members'][0]) && $houseHoldA['household_members'][0]['field_type'] == 1)) {
        $spouse = $houseHoldA['household_members'][0]; 
        $spouseFirstName = $spouse['firstname'] ?? null; 
        $spouseMiddleName = $spouse['middlename'] ?? null;
        $spouseLastName = $spouse['lastname'] ?? null;
        $spouseSuffix = $spouse['suffix'] ?? null;
        $spouseBirthdate = $spouse['birthdate'] ?? null;
        $spouseSex = $spouse['sex'] ?? null;
    }

    // Dados da Outra Pessoa (se houver):
        $anotherPersonFirstName = null;
        $anotherPersonMiddleName = null;
        $anotherPersonLastName = null;
        $anotherPersonSuffix = null;
        $anotherPersonBirthdate = null;
        $anotherPersonSex = null;
        $anotherPersonRelationship = null;
    if((isset($houseHoldA['tax_household_members'][0]) && $houseHoldA['tax_household_members'][0]['field_type'] == 2) || 
        (isset($houseHoldA['tax_household_members'][1]) && $houseHoldA['tax_household_members'][1]['field_type'] == 2)){
        $arr = $houseHoldA['household_members'][0]['field_type'] == 2 ? 1 : 0;
        $anotherPerson = $houseHoldA['household_members'][$arr];
        $anotherPersonFirstName = $anotherPerson['firstname'] ?? null;
        $anotherPersonMiddleName = $anotherPerson['middlename'] ?? null;
        $anotherPersonLastName = $anotherPerson['lastname'] ?? null;
        $anotherPersonSuffix = $anotherPerson['suffix'] ?? null;
        $anotherPersonBirthdate = $anotherPerson['birthdate'] ?? null;
        $anotherPersonSex = $anotherPerson['sex'] ?? null;
        $anotherPersonRelationship = $anotherPerson['relationship'] ?? null;
    }


    // Dados da Pessoa Casada (se houver):
        $marriedFirstName = null;
        $marriedMiddleName = null;
        $marriedLastName = null;
        $marriedSuffix = null;
        $marriedBirthdate = null;
        $marriedSex = null;
        $marriedLivesWithYou = null;
    if((isset($houseHoldA['tax_household_members'][0]) && $houseHoldA['tax_household_members'][0]['field_type'] == 3)){
        $marriedPerson = $houseHoldA['tax_household_members'][0];
        $marriedFirstName = $marriedPerson['firstname'] ?? null;
        $marriedMiddleName = $marriedPerson['middlename'] ?? null;
        $marriedLastName = $marriedPerson['lastname'] ?? null;
        $marriedSuffix = $marriedPerson['suffix'] ?? null;
        $marriedBirthdate = $marriedPerson['birthdate'] ?? null;
        $marriedSex = $marriedPerson['sex'] ?? null;
        $marriedLivesWithYou = $marriedPerson['lives_with_you'] ?? null;
    }
    

    // Dados do Dependente (se houver):
        $dependentFirstName = null;
        $dependentMiddleName = null;
        $dependentLastName = null;
        $dependentSuffix = null;
        $dependentBirthdate = null;
        $dependentSex = null;
        $dependentRelationship = null;
        $dependentLivesWithYou = null;
        $dependentEligibleCostSaving = null;
        $dependentFieldType = null;
    if((isset($houseHoldA['tax_household_members'][0]) && $houseHoldA['tax_household_members'][0]['field_type'] == 4 ) || 
        (isset($houseHoldA['tax_household_members'][1]) && $houseHoldA['tax_household_members'][1]['field_type'] == 4)){
        $arr = $houseHoldA['tax_household_members'][0]['field_type'] == 4 ? 0 : 1;
        $dependent = $houseHoldA['tax_household_members'][$arr];
        $dependentFirstName = $dependent['firstname'] ?? null;
        $dependentMiddleName = $dependent['middlename'] ?? null;
        $dependentLastName = $dependent['lastname'] ?? null;
        $dependentSuffix = $dependent['suffix'] ?? null;
        $dependentBirthdate = $dependent['birthdate'] ?? null;
        $dependentSex = $dependent['sex'] ?? null;
        $dependentRelationship = $dependent['relationship'] ?? null;
        $dependentLivesWithYou = $dependent['lives_with_you'] ?? null;
        $dependentEligibleCostSaving = $dependent['eligible_cost_saving'] ?? null;
        $dependentFieldType = $dependent['field_type'] ?? null;
    }

    if((isset($houseHoldA['tax_household_members'][0]) && $houseHoldA['tax_household_members'][0]['field_type'] == 5) || 
        (isset($houseHoldA['tax_household_members'][1]) && $houseHoldA['tax_household_members'][1]['field_type'] == 5)){
        $arr = $houseHoldA['tax_household_members'][0]['field_type'] == 5 ? 0 : 1;
        $dependent = $houseHoldA['tax_household_members'][$arr];
        $dependentFirstName = $dependent['firstname'] ?? null;
        $dependentMiddleName = $dependent['middlename'] ?? null;
        $dependentLastName = $dependent['lastname'] ?? null;
        $dependentSuffix = $dependent['suffix'] ?? null;
        $dependentBirthdate = $dependent['birthdate'] ?? null;
        $dependentSex = $dependent['sex'] ?? null;
        $dependentRelationship = $dependent['relationship'] ?? null;
        $dependentLivesWithYou = $dependent['lives_with_you'] ?? null;
        $dependentEligibleCostSaving = $dependent['eligible_cost_saving'] ?? null;
        $dependentFieldType = $dependent['field_type'] ?? null;
    }


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
                <button id="tabHousehold" class="tablinks active" onclick="openTab(event, 'household')">@lang('labels.householdCandidato')</button>
                <button id="tabTaxHousehold" class="tablinks" onclick="openTab(event, 'taxHousehold')">@lang('labels.householdFamilia')</button>
            </div>
        </div>
    </div>
</div>

<div id="household" class="tabcontent" style="display: block;">
    <input type="hidden" id="application_id" name="application_id" value="{{$application_id??0}}">
    <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="form-group row align-items-center">
                    <h1 class="col-form-label">@lang('labels.householdSolicitante')</h1>
                </div>
            </div>
            <div class="card-body">
                <div class="row row-sm">
                    <label class="col-form-label">@lang('labels.householdSolicitanteUsuario')</label>
                    <div class="col-lg-6 mb-3">
                        <div class="input-group">
                            <div class="input-group-text">
                                <label class="rdiobox wd-16 mg-b-0">
                                    <input class="mg-0" type="radio" name="householdCheck" id="householdcheckYes" value="1" @if($houseHoldApplying_coverage == 1) checked @endif>
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
                                    <input class="mg-0" type="radio" name="householdCheck" id="householdcheckNo" value="0">
                                    <span></span>
                                </label>
                            </div>
                            <div class="form-control">@lang('labels.checkNo')</div>
                        </div>
                    </div>
                    <input type="hidden" id="applying_coverage" name="applying_coverage" value="1" >
                </div>
            </div>

            <div class="card-body">
                <div class="row row-sm">

                    <label class="col-form-label">@lang('labels.householdDireitoReducao')</label>
                    <div class="col-lg-6 mb-3">
                        <div class="input-group">
                            <div class="input-group-text">
                                <label class="rdiobox wd-16 mg-b-0">
                                    <input class="mg-0" type="radio" name="checkYesapplying" id="checkYesapplyingYes" value="1" @if($houseHoldAeligibleCostSaving == 1) checked @endif>
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
                                    <input class="mg-0" type="radio" name="checkYesapplying" id="checkYesapplyingNo" value="0">
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
                        <a href="#" class="btn btn-outline-secondary btn-lg btn-block" id="btnAddSpouse">@lang('labels.householdAddConjuge')</a>
                    </div>
                    <div class="col-lg-6 mb-3">
                        <a href="#" class="btn btn-outline-secondary btn-lg btn-block" id="btnAddAnotherPerson">@lang('labels.householdAddPessoa')</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 mb-3">
                        <button id="btnBackTwo" class="btn btn-primary btn-lg btn-block" onclick="openTab(event, 'yourInformation')">@lang('labels.buttonVoltar')</button>
                    </div>
                    <div class="col-lg-6 mb-3">
                        <button id="btnContinue" class="btn btn-secondary btn-lg btn-block" onclick="openTab(event, 'taxHousehold')">@lang('labels.buttonContinue')</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal modalAddSpouse -->
<!-- Modal HTML com o checkbox adicionado -->
<div class="modal fade" id="modalAddSpouse" tabindex="-1" aria-labelledby="modalAddSpouseLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <div class="card">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <h1 class="mb-0">@lang('labels.householdAddConjuge')</h1>
                        <button type="button" class="btn btn-primary ms-auto" data-bs-dismiss="modal">@lang('labels.buttonCancelar')</button>
                    </div>

                    <div class="card-body">
                        <div class="row row-sm">
                            <div class="col-lg-6 mb-3">
                                <div class="input-group">
                                    <div class="input-group-text">@lang('labels.nome'):</div>
                                    <input type="text" class="form-control" name="nameSpouse" id="nameSpouse" placeholder="@lang('labels.nome')" value="{{ $spouseFirstName }}">
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="input-group">
                                    <div class="input-group-text">@lang('labels.campoCentral')</div>
                                    <input type="text" class="form-control" name="middleSpouse" id="middleSpouse" placeholder="@lang('labels.campoCentral')" value="{{ $spouseMiddleName }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row row-sm">
                            <div class="col-lg-6 mb-3">
                                <div class="input-group">
                                    <div class="input-group-text">@lang('labels.sobreNome'):</div>
                                    <input type="text" class="form-control" name="lastnameSpouse" id="lastnameSpouse" placeholder="@lang('labels.sobreNome')" value="{{ $spouseLastName }}">
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="input-group">
                                    <span class="input-group-text">@lang('labels.suffix'):</span>
                                    <select class="form-select" name="suffixSpouse" id="suffixSpouse">
                                        <option value="" selected>@lang('labels.campoSelecao')</option>
                                        @foreach($dataLabel['suffixes'] as $key=>$value)
                                        <option value="{{ $key }}" {{ $spouseSuffix == $key ? 'selected' : '' }}>@lang($value)</option>
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
                                    <input class="form-control" name="birthdateSpouse" id="birthdateSpouse" placeholder="MM/DD/YYYY" type="text" value="{{ $spouseBirthdate ? \Carbon\Carbon::parse($spouseBirthdate)->format('m/d/Y') : ''}}">
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="input-group">
                                    <span class="input-group-text">@lang('labels.campoSexo') <i class="fas fa-question" data-bs-toggle="modal" data-bs-target="#alertModalSexo" title="@lang('labels.msgClicar')"></i></span>
                                    <select class="form-select" id="sexSpouse" name="sexSpouse" required>
                                        <option value="" selected>@lang('labels.campoSelecao')</option>
                                        @foreach($dataLabel['sexes'] as $key=>$value)
                                        <option value="{{ $key }}" {{ $spouseSex == $key ? 'selected' : '' }}>@lang('labels.'. $value)</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12 mb-3">

                                <a href="#" id="saveSpouseBtn" class="btn btn-primary btn-lg btn-block">@lang('labels.householdAddConjuge')</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- End Modal modalAddSpouse -->
<!-- Modal modalAddAnotherPerson -->
<div class="modal fade" id="modaldemoAddAnotherPerson" tabindex="-1" aria-labelledby="modaldemoAddAnotherPersonLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <div class="card">

                    <div class="card-body d-flex justify-content-between align-items-center">
                        <h1 class="mb-0">@lang('labels.householdAddPessoa')</h1>
                        <button type="button" class="btn btn-primary ms-auto" data-bs-dismiss="modal">@lang('labels.buttonCancelar')</button>
                    </div>
                    <div class="card-body">
                        <div class="row row-sm">
                            <div class="col-lg-6 mb-3">
                                <div class="input-group">
                                    <div class="input-group-text">@lang('labels.nome'):</div>
                                    <input type="text" class="form-control" name="namePerson" id="namePerson" placeholder="@lang('labels.nome')" value="{{ $anotherPersonFirstName }}">
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="input-group">
                                    <div class="input-group-text">@lang('labels.campoCentral'):</div>
                                    <input type="text" class="form-control" name="middlePerson" id="middlePerson" placeholder="@lang('labels.campoCentral')" value="{{$anotherPersonMiddleName}}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row row-sm">
                            <div class="col-lg-6 mb-3">
                                <div class="input-group">
                                    <div class="input-group-text">@lang('labels.sobreNome'):</div>
                                    <input type="text" class="form-control" name="lastnamePerson" id="lastnamePerson" placeholder="@lang('labels.sobreNome')" value="{{$anotherPersonLastName}}">
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="input-group ">
                                    <span class="input-group-text">@lang('labels.suffix'):</span>
                                    <select class="form-select" name="suffixPerson" id="suffixPerson">
                                        <option value="" selected>@lang('labels.campoSelecao')</option>
                                         @foreach($dataLabel['suffixes'] as $key=>$value)
                                        <option value="{{ $key }}" {{ $anotherPersonSuffix == $key ? 'selected' : '' }}>@lang($value)</option>
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
                                    <input class="form-control" name="birthdatePerson" id="birthdatePerson" placeholder="MM/DD/YYYY" type="text"value="{{ $anotherPersonBirthdate ? \Carbon\Carbon::parse(@$anotherPersonBirthdate)->format('m/d/Y') : ''}}">
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="input-group">
                                    <span class="input-group-text">@lang('labels.campoSexo') <i class="fas fa-question" data-bs-toggle="modal" data-bs-target="#alertModalSexo" title="@lang('labels.msgClicar')"></i></span>
                                    <select class="form-select" id="sexPerson" name="sexPerson" required>
                                        <option value="" selected>@lang('labels.campoSelecao')</option>
                                        @foreach($dataLabel['sexes'] as $key=>$value)
                                        <option value="{{ $key }}" {{ $anotherPersonSex == $key ? 'selected' : '' }}>@lang('labels.'. $value)</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row row-sm">
                            <div class="col-lg-12 mb-3">
                                <div class="input-group">
                                    <span class="input-group-text">@lang('labels.householdRelacionamento'):</span>
                                    <select class="form-select" name="relationshipPerson" id="relationshipPerson">
                                        <option value="" selected>@lang('labels.campoSelecao')</option>
                                        @foreach($dataLabel['relationships'] as $key=>$value)
                                        <option value="{{ $key }}" {{ $anotherPersonRelationship == $key ? 'selected' : '' }}>@lang('labels.' . $value)</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12 mb-3">
                                <a href="#" id="savePersonBtn" class="btn btn-primary btn-lg btn-block">@lang('labels.buttonSalvarPessoa')</a>
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
<div class="modal fade" id="modaldemoAlerta" tabindex="-1" aria-labelledby="modaldemoAlertaLabel" aria-hidden="true">
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

<div id="taxHousehold" class="tabcontent">
    <!-- END BREADCRUMB -->
    <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="form-group row align-items-center">
                    <h1 class="col-form-label ">@lang('labels.householdInformacoesFiscais')</h1>
                </div>

            </div>
            <div class="card-body">
                <div class="row row-sm">
                    <label class="col-form-label">
                        @lang('labels.householdCasado')
                        <i class="fas fa-question custom-tooltip" data-bs-toggle="modal" data-bs-target="#alertModal" title="@lang('labels.msgClicar')"></i>
                    </label>
                    <div class="col-lg-6 mb-3">
                        <div class="input-group">
                            <div class="input-group-text">
                                <label class="rdiobox wd-16 mg-b-0">
                                    <input class="mg-0" type="radio" name="householdOptionMarried" id="checkYesMarried" value="1" >
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
                                    <input class="mg-0" type="radio" name="householdOptionMarried" id="checkNoMarried" value="0"  >
                                    <span></span>
                                </label>
                            </div>
                            <div class="form-control">@lang('labels.checkNo')</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="row row-sm">
                    <label class="col-form-label">
                        @lang('labels.householdDeclaracaoImposto', ['year' => date('Y')]) <br>
                        @lang('labels.householdDeclaracaoAlerta')
                    </label>
                    <div class="col-lg-6 mb-3">
                        <div class="input-group">
                            <div class="input-group-text">
                                <label class="rdiobox wd-16 mg-b-0">
                                    <input class="mg-0" type="radio" name="incomeTax" id="showHouseholdYes" value="1">
                                    <span></span>
                                </label>
                            </div>
                            <input type="hidden" name="incomeTax" id="incomeTaxYes" value="1">
                            <div class="form-control">
                                @lang('labels.checkYes')
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-3">
                        <div class="input-group">
                            <div class="input-group-text">
                                <label class="rdiobox wd-16 mg-b-0">
                                    <input class="mg-0" type="radio" name="incomeTax" id="showHouseholdNo" value="0">
                                    <span></span>
                                </label>
                            </div>
                            <input type="hidden" name="incomeTax" id="incomeTaxNo" value="0">
                            <div class="form-control">
                                @lang('labels.checkNo')
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row row-sm" id="impostoConjugetwo" style="display: none;">
                    <label class="col-form-label">@lang('labels.householdDeclaracaoImpostoConjugetwo', ['year' => date('Y')])</label>
                    <div class="col-lg-6 mb-3">
                        <div class="input-group">
                            <div class="input-group-text">
                                <label class="rdiobox wd-16 mg-b-0">
                                    <input class="mg-0" type="radio" name="taxedspouse" id="showHouseholdConjugeYestwo" value="1">
                                    <span></span>
                                </label>
                            </div>
                            <input type="hidden" name="taxedspouse" id="taxedspouseYes" value="1">
                            <div class="form-control">
                                @lang('labels.checkYes')
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-3">
                        <div class="input-group">
                            <div class="input-group-text">
                                <label class="rdiobox wd-16 mg-b-0">
                                    <input class="mg-0" type="radio" name="taxedspouse" id="showHouseholdConjugeNotwo" value="0">
                                    <span></span>
                                </label>
                            </div>
                            <input type="hidden" name="taxedspouse" id="taxedspouseNo" value="0">
                            <div class="form-control">
                                @lang('labels.checkNo')
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row row-sm" id="impostoConjugethree" style="display: none;">
                    <label class="col-form-label">@lang('labels.householdDeclaracaoImpostoConjugethree', ['year' => date('Y')])</label>
                    <div class="col-lg-6 mb-3">
                        <div class="input-group">
                            <div class="input-group-text">
                                <label class="rdiobox wd-16 mg-b-0">
                                    <input class="mg-0" type="radio" name="showHouseholdConjugeThree" id="showHouseholdConjugeYesthree">
                                    <span></span>
                                </label>
                            </div>
                            <input type="hidden" name="showHouseholdConjugeThree" value="0">
                            <div class="form-control">
                                @lang('labels.checkYes')
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-3">
                        <div class="input-group">
                            <div class="input-group-text">
                                <label class="rdiobox wd-16 mg-b-0">
                                    <input class="mg-0" type="radio" name="showHouseholdConjugeThree" id="showHouseholdConjugeNothree">
                                    <span></span>
                                </label>
                            </div>
                            <input type="hidden" name="showHouseholdConjugeThree" value="0">
                            <div class="form-control">
                                @lang('labels.checkNo')
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row row-sm" id="addDependente" style="display: none;">
                    <div class="row">
                        <label class="col-form-label ">@lang('labels.householdDependente')</label>
                        <div class="col-lg-6 mb-3">
                            <a class="modal-effect btn btn-outline-secondary btn-lg btn-block" data-bs-effect="effect-scale" data-bs-toggle="modal" href="#modalDemoAddDependents">@lang('labels.householdAddDependente')</a>
                        </div>
                    </div>
                </div>

                <div class="row row-sm" id="impostoConjuge" style="display: none;">
                    <label class="col-form-label">@lang('labels.householdDeclaracaoImpostoConjuge', ['year' => date('Y')])</label>
                    <div class="col-lg-6 mb-3">
                        <div class="input-group">
                            <div class="input-group-text">
                                <label class="rdiobox wd-16 mg-b-0">
                                    <input class="mg-0" type="radio" name="checkHouseholdConjuge" id="showHouseholdConjugeYes">
                                    <span></span>
                                </label>
                            </div>
                            <input type="hidden" name="checkHouseholdConjuge" value="1">
                            <div class="form-control">
                                @lang('labels.checkYes')
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-3">
                        <div class="input-group">
                            <div class="input-group-text">
                                <label class="rdiobox wd-16 mg-b-0">
                                    <input class="mg-0" type="radio" name="checkHouseholdConjuge" id="showHouseholdConjugeNo">
                                    <span></span>
                                </label>
                            </div>
                            <input type="hidden" name="checkHouseholdConjuge" value="0">
                            <div class="form-control">
                                @lang('labels.checkNo')
                            </div>
                        </div>
                    </div>
                </div>



                <div class="row row-sm" id="imposYou" style="display: none;">
                    <label class="col-form-label">@lang('labels.householdDeclaracaoImposYou')</label>
                    <div class="col-lg-6 mb-3">
                        <div class="input-group">
                            <div class="input-group-text">
                                <label class="rdiobox wd-16 mg-b-0">
                                    <input class="mg-0" type="radio" name="dependent" id="showHouseholdImposYouYes" value="0">
                                    <span></span>
                                </label>
                            </div>
                            <div class="form-control">
                                @lang('labels.checkYes')
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-3">
                        <div class="input-group">
                            <div class="input-group-text">
                                <label class="rdiobox wd-16 mg-b-0">
                                    <input class="mg-0" type="radio" name="dependent" id="showHouseholdImposYouNo" value="1">
                                    <span></span>
                                </label>
                            </div>
                            <div class="form-control">
                                @lang('labels.checkNo')
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 mb-3">
                        <button id="btnBack" class="btn btn-primary btn-lg btn-block" onclick="openTab(event, 'household')">@lang('labels.buttonVoltar')</button>
                    </div>

                    <div class="col-lg-6 mb-3">
                        <a href="#" class="btn btn-secondary btn-lg btn-block" onclick="sendFormHousehold(this)">
                            @lang('labels.buttonContinue')</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class=" modal fade" id="modalDemoAddDependents" tabindex="-1" aria-labelledby="modalDemoAddDependentsLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn btn-primary ms-auto" data-bs-dismiss="modal">X</button>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-lg-4">
                                            <label class="form-label">@lang('labels.nome')</label>
                                            <input type="text" class="form-control" name="nameDependents" id="nameDependents" placeholder="@lang('labels.nome')" value="{{ $dependentFieldType == 0 ? $dependentFirstName : '' }}">
                                        </div>
                                        <div class="col-lg-4">
                                            <label class="form-label">@lang('labels.campoCentral')</label>
                                            <input type="text" class="form-control" name="middleDependents" id="middleDependents" placeholder="@lang('labels.campoCentral')" value="{{ $dependentFieldType == 0 ? $dependentMiddleName : '' }}">
                                        </div>
                                        <div class="col-lg-4">
                                            <label class="form-label">@lang('labels.sobreNome')</label>
                                            <input type="text" class="form-control" name="lastnameDependents" id="lastnameDependents" placeholder="@lang('labels.sobreNome')" value="{{ $dependentFieldType == 0 ? $dependentLastName : '' }}">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-lg-4">
                                            <label class="form-label">@lang('labels.suffix')</label>
                                            <select class="form-select" name="suffixesDependents" id="suffixesDependents">
                                                <option value="" selected>@lang('labels.campoSelecao')</option>
                                                @foreach($dataLabel['suffixes'] as $key=>$value)
                                                <option value="{{ $dependentFieldType == 0 ? $key : '' }}" {{ $dependentSuffix == $key ? 'selected' : '' }}>@lang($value)</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-4">
                                            <label class="form-label">@lang('labels.dataNascimento')</label>
                                            <input class="form-control" name="dateDependents" id="dateDependents" placeholder="MM/DD/YYYY" type="text" value="{{ $dependentFieldType == 0 ? $dependentBirthdate ? \Carbon\Carbon::parse(@$dependentBirthdate)->format('m/d/Y') : '' : '' }}">
                                        </div>
                                        <div class="col-lg-4">
                                            <label class="form-label">@lang('labels.campoSexo') <i class="fas fa-question custom-tooltip" data-bs-toggle="modal" data-bs-target="#alertModalSexo" title="@lang('labels.msgClicar')"></i></label>
                                            <select class="form-select" name="sexoDependents" id="sexoDependents">
                                                <option value="" selected>@lang('labels.campoSelecao')</option>
                                                 @foreach($dataLabel['sexes'] as $key=>$value)
                                                <option value="{{ $dependentFieldType == 0 ? $key : '' }}" {{ $dependentSex == $key ? 'selected' : '' }}>@lang('labels.' . $value)</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-lg-6">
                                            <label class="form-label">@lang('labels.householdRelacionamento')</label>
                                            <select class="form-select" name="relationshipsDependents" id="relationshipsDependents">
                                                <option value="" selected>@lang('labels.campoSelecao')</option>
                                                @foreach($dataLabel['relationships'] as $key=>$value)
                                                <option value="{{ $dependentFieldType == 0 ? $key : '' }}" {{ $dependentRelationship == $key ? 'selected' : '' }}>@lang('labels.' . $value)</option>
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
                                                                <input class="mg-0" type="radio" name="liveswithyou" value="1" @if($dependentLivesWithYou == 1 && $dependentFieldType == 0 ) checked @endif>
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
                                                                <input class="mg-0" type="radio" name="liveswithyou" value="0" @if($dependentLivesWithYou == 0 && $dependentFieldType == 0) checked @endif >
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
                                        <button type="button" id="addDependentbtn" class="btn btn-primary btn-lg btn-block">@lang('labels.householdAddDependente')

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>


            </div>

        </div>

    </div>
    <!-- End Modal -->


    <!-- Modal -->
    <div class=" modal fade" id="modaldemo9" tabindex="-1" aria-labelledby="modaldemo9Label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="container">
                        <div class="card">
                            <div class="card-body">
                                <div class="row row-sm">
                                    <label class="col-form-label">@lang('labels.householdDeclarante', ['year', date('Y')])</label>
                                    <div class="col-lg-6 mb-3">
                                        <div class="input-group">
                                            <div class="input-group-text">
                                                <label class="checkbox wd-16 mg-b-0">
                                                    <input class="mg-0" type="checkbox" name="reclamanteimposto" value="1">
                                                    <span></span>
                                                </label>
                                            </div>
                                            <div class="form-control">
                                                @lang('labels.householdAlguem')
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-lg-4">
                                        <label class="form-label">@lang('labels.nome')</label>
                                        <input type="text" class="form-control" name="nameDependentTax" id="nameDependentTax" placeholder="@lang('labels.nome')" value="{{ $dependentFieldType == 1 ? $dependentFirstName : ''}}">
                                    </div>
                                    <div class="col-lg-4">
                                        <label class="form-label">@lang('labels.campoCentral')</label>
                                        <input type="text" class="form-control" name="middleDependentTax" id="middleDependentTax" placeholder="@lang('labels.campoCentral')" value="{{ $dependentFieldType == 1 ? $dependentMiddleName : '' }}">
                                    </div>
                                    <div class="col-lg-4">
                                        <label class="form-label">@lang('labels.sobreNome')</label>
                                        <input type="text" class="form-control" name="lastnameDependentTax" id="lastnameDependentTax" placeholder="@lang('labels.sobreNome')" value="{{ $dependentFieldType == 1 ? $dependentLastName : '' }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-4">
                                        <label class="form-label">@lang('labels.suffix')</label>
                                        <select class="form-select" name="suffixesDependentTax" id="suffixesDependentTax">
                                            <option value="" selected>@lang('labels.campoSelecao')</option>
                                            @foreach($dataLabel['suffixes'] as $key=>$value)
                                            <option value="{{ $dependentFieldType == 1 ? $key : ''}}" {{ $dependentSuffix == $key ? 'selected' : '' }}>@lang($value)</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-4">
                                        <label class="form-label">@lang('labels.dataNascimento')</label>
                                        <input class="form-control" name="dateDependentTax" id="dateDependentTax" placeholder="MM/DD/YYYY" type="text" value="{{ $dependentFieldType == 1 ? $dependentBirthdate ? \Carbon\Carbon::parse(@$dependentBirthdate)->format('m/d/Y') : '' : '' }}">
                                    </div>
                                    <div class="col-lg-4">
                                        <label class="form-label">@lang('labels.campoSexo') <i class="fas fa-question custom-tooltip" data-bs-toggle="modal" data-bs-target="#alertModalSexo" title="@lang('labels.msgClicar')"></i></label>
                                        <select class="form-select" name="sexesDependentTax" id="sexesDependentTax">
                                            <option value="" selected>@lang('labels.campoSelecao')</option>
                                            @foreach($dataLabel['sexes'] as $key=>$value)
                                            <option value="{{ $dependentFieldType == 1 ? $key : '' }}" {{ $dependentSex == $key ? 'selected' : '' }}>@lang('labels.' . $value)</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-6">
                                        <label class="form-label">@lang('labels.householdRelacionamento')</label>
                                        <select class="form-select" name="relationshipsDependentTax" id="relationshipsDependentTax">
                                            <option value="" selected>@lang('labels.campoSelecao')</option>
                                            @foreach($dataLabel['relationships'] as $key=>$value)
                                            <option value="{{ $dependentFieldType == 1 ? $key : '' }}" {{ $dependentRelationship == $key ? 'selected' : '' }}>@lang('labels.' . $value)</option>
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
                                                            <input class="mg-0" type="radio" name="liveswithyou" value="1" @if($dependentLivesWithYou == 1 && $dependentFieldType == 1) checked @endif >
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                    <div class="form-control">
                                                        @lang('labels.checkYes')
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 mb-3">
                                                <div class="input-group">
                                                    <div class="input-group-text">
                                                        <label class="rdiobox wd-16 mg-b-0">
                                                            <input class="mg-0" type="radio" name="liveswithyou" value="0" @if($dependentLivesWithYou == 0 && $dependentFieldType == 1) checked @endif >
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                    <div class="form-control">
                                                        @lang('labels.checkNo')
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="card-body">
                                <div class="row row-sm">
                                    <label class="col-form-label">Eligible Cost Saving</label>
                                    <div class="col-lg-6 mb-3">
                                        <div class="input-group">
                                            <div class="input-group-text">
                                                <label class="rdiobox wd-16 mg-b-0">
                                                    <input class="mg-0" type="radio" name="eligiblecostsaving" value="1" @if($dependentEligibleCostSaving == 1 && $dependentFieldType == 1 ) checked @endif>
                                                    <span></span>
                                                </label>
                                            </div>
                                            <div class="form-control">Yes</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <div class="input-group">
                                            <div class="input-group-text">
                                                <label class="rdiobox wd-16 mg-b-0">
                                                    <input class="mg-0" type="radio" name="eligiblecostsaving" value="0" @if($dependentEligibleCostSaving == 0 && $dependentFieldType == 1 ) checked @endif>
                                                    <span></span>
                                                </label>
                                            </div>
                                            <div class="form-control">No</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12 mb-3">
                                        <button type="button" id="addDependentTexbtn" class="btn btn-primary btn-lg btn-block">@lang('labels.householdAddDependente')

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

        </div>

    </div>

</div>
<!-- End Modal -->

<!-- Modal -->
<div class=" modal fade" id="modaldemoAddWifeIfMarried" tabindex="-1" aria-labelledby="modaldemoAddWifeIfMarriedLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <div class="container">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <button type="button" class="btn btn-primary ms-auto" data-bs-dismiss="modal">@lang('labels.buttonCancelar')</button>
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
                                    <input type="text" class="form-control" name="nameSpouseHouseholdTax" id="nameSpouseHouseholdTax" placeholder="@lang('labels.nome')" value="{{ $marriedFirstName }}">
                                </div>
                                <div class="col-lg-4">
                                    <label class="form-label">@lang('labels.campoCentral')</label>
                                    <input type="text" class="form-control" name="middleSpouseHouseholdTax" id="middleSpouseHouseholdTax" placeholder="@lang('labels.campoCentral')" value="{{ $marriedMiddleName }}">
                                </div>
                                <div class="col-lg-4">
                                    <label class="form-label">@lang('labels.sobreNome')</label>
                                    <input type="text" class="form-control" name="lastnameSpouseHouseholdTax" id="lastnameSpouseHouseholdTax" placeholder="@lang('labels.sobreNome')" value="{{ $marriedLastName }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-4">
                                    <label class="form-label">@lang('labels.suffix')</label>
                                    <select class="form-select" name="suffixesSpouseHouseholdTax" id="suffixesSpouseHouseholdTax">
                                        <option value="" selected>@lang('labels.campoSelecao')</option>
                                        @foreach($dataLabel['suffixes'] as $key=>$value)
                                        <option value="{{ $key }}" {{ $marriedSuffix == $key ? 'selected' : '' }}>@lang($value)</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-4">
                                    <label class="form-label">@lang('labels.dataNascimento')</label>
                                    <input class="form-control" name="dateSpouseHouseholdTax" id="dateSpouseHouseholdTax" placeholder="MM/DD/YYYY" type="text" value="{{ $marriedBirthdate ? \Carbon\Carbon::parse(@$marriedBirthdate)->format('m/d/Y') : ''}}">
                                </div>
                                <div class="col-lg-4">
                                    <label class="form-label">@lang('labels.campoSexo') <i class="fas fa-question custom-tooltip" data-bs-toggle="modal" data-bs-target="#alertModalSexo" title="@lang('labels.msgClicar')"></i></label>

                                    <select class="form-select" name="sexesSpouseHouseholdTax" id="sexesSpouseHouseholdTax">
                                        <option value="" selected>@lang('labels.campoSelecao')</option>
                                          @foreach($dataLabel['sexes'] as $key=>$value)
                                        <option value="{{ $key }}" {{ $marriedSex == $key ? 'selected' : '' }}>@lang('labels.' . $value)</option>
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
                                                        <input class="mg-0" type="radio" name="liveswithyou" value="1" @if($marriedLivesWithYou == 1) checked @endif>
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
                                                        <input class="mg-0" type="radio" name="liveswithyou" value="0" @if($marriedLivesWithYou == 0) checked @endif>
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
                                <button type="button" id="addWifeIfMarriedBtn" class="btn btn-primary btn-lg btn-block">@lang('labels.householdAddConjuge')

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
                <h5 class="modal-title" id="alertModalLabel">Alert Message</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>
                <div>@lang("labels.msgCasadoLegalmente")</div> <br>
                <div>@lang("labels.msgSeparado")</div><br>
                <div>@lang("labels.msgUniaoEstavel")</div><br>
                <div>@lang("labels.msgMoracomParceiro")</div><br>
                <div>@lang("labels.msgVitimaViolencia")</div><br>
                <div>@lang("labels.msgDisponicel")</div>
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

<div class="modal fade" id="alertModalSexo" tabindex="-1" aria-labelledby="alertModalSexoLabel" aria-hidden="true">
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

<!-- Spinner de carregamento -->
<div class="loader" id="loader">
    <div class="spinner"></div>
</div>

@endsection

@section('scripts')
<!-- Mostar msg Modal JS -->
<script src="{{ asset('/js/msgModal.js') }}"></script>

<!-- Aba de Navegação JS -->
<script src="{{ asset('/js/abaNavegacao.js') }}"></script>

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

    function addhouseholdSpouse(tax) {
        const spouse = {
            'firstname': $('#nameSpouse').val(),
            'middlename': $('#middleSpouse').val(),
            'lastname': $('#lastnameSpouse').val(),
            'suffix': $('#suffixSpouse').val(),
            'birthdate': $('#birthdateSpouse').val(),
            'sex': $('#sexSpouse').val(),
            'relationship': <?php echo $spouse_id ?? 3; ?>,
            'tax_form': tax,
            'lives_with_you': null,
            'tax_claimant': null,
            'eligible_cost_saving': null,
            'field_type': 1,

        };

        addhouseholdMembers(spouse);
    }


    function addhouseholdPerson(tax) {
        const person = {
            'firstname': $('#namePerson').val(),
            'middlename': $('#middlePerson').val(),
            'lastname': $('#lastnamePerson').val(),
            'suffix': $('#suffixPerson').val(),
            'birthdate': $('#birthdatePerson').val(),
            'sex': $('#sexPerson').val(),
            'relationship': $('#relationshipPerson').val(),
            'tax_form': tax,
            'lives_with_you': null,
            'tax_claimant': null,
            'eligible_cost_saving': null,
            'field_type': 2,
        }

        addhouseholdMembers(person);
    }


    function addspouseHouseholdTax(tax) {
        const liveswith = parseInt($('input[name="liveswithyou"]:checked').val(), 10) || 0;
        const SpouseHouseholdTax = {
            'firstname': $('#nameSpouseHouseholdTax').val(),
            'middlename': $('#middleSpouseHouseholdTax').val(),
            'lastname': $('#lastnameSpouseHouseholdTax').val(),
            'suffix': $('#suffixesSpouseHouseholdTax').val(),
            'birthdate': $('#dateSpouseHouseholdTax').val(),
            'sex': $('#sexesSpouseHouseholdTax').val(),
            'relationship': 10,
            'tax_form': tax,
            'lives_with_you': liveswith,
            'tax_claimant': null,
            'eligible_cost_saving': null,
            'field_type': 3,
        };

        addhouseholdMembers(SpouseHouseholdTax);
    }



    function addhouseholdDependent(tax) {
        const liveswith = parseInt($('input[name="liveswithyou"]:checked').val(), 10) || 0;
        const dependent = {
            'firstname': $('#nameDependents').val(),
            'middlename': $('#middleDependents').val(),
            'lastname': $('#lastnameDependents').val(),
            'suffix': $('#suffixesDependents').val(),
            'birthdate': $('#dateDependents').val(),
            'sex': $('#sexoDependents').val(),
            'relationship': $('#relationshipsDependents').val(),
            'tax_form': tax,
            'lives_with_you': liveswith,
            'tax_claimant': null,
            'eligible_cost_saving': null,
            'field_type': 4,
        }

        addhouseholdMembers(dependent);
    }

    function addhouseholdDependentTax(tax) {
        const liveswith = parseInt($('input[name="liveswithyou"]:checked').val(), 10) || 0;
        const taxClaimantValue = $('input[name="reclamanteimposto"]').is(':checked')
        const eligibleCostSavingValue = parseInt($('input[name="eligiblecostsaving"]:checked').val(), 10) || 0;

        const dependentTax = {
            'firstname': $('#nameDependentTax').val(),
            'middlename': $('#middleDependentTax').val(),
            'lastname': $('#lastnameDependentTax').val(),
            'suffix': $('#suffixesDependentTax').val(),
            'birthdate': $('#dateDependentTax').val(),
            'sex': $('#sexesDependentTax').val(),
            'relationship': $('#relationshipsDependentTax').val(),
            'tax_form': tax,
            'lives_with_you': liveswith,
            'tax_claimant': taxClaimantValue,
            'eligible_cost_saving': eligibleCostSavingValue,
            'field_type': 5,
        }

        addhouseholdMembers(dependentTax);
    }


    function addhouseholdMembers(data) {
        householdMembers.push(data);
    }


    function formatHousehold() {
        const applicationId = '{{$application_id ?? 0}}';

        // Captura o valor do rádio button selecionado e converte para inteiro
        const applyingCoverage = parseInt($('input[name="householdCheck"]:checked').val(), 10) || 0;
        const eligiblecostsaving = parseInt($('input[name="checkYesapplying"]:checked').val(), 10) || 0;
        const married = parseInt($('input[name="householdOptionMarried"]:checked').val(), 10) || 0;
        const fedtaxincomereturn = parseInt($('input[name="incomeTax"]:checked').val(), 10) || 0;
        const jointlytaxedspouse = parseInt($('input[name="taxedspouse"]:checked').val(), 10) || 0;
        const isdependent = parseInt($('input[name="dependent"]:checked').val(), 10) || 0;

        return JSON.stringify({
            'application_id': applicationId,
            'applying_coverage': applyingCoverage,
            'eligible_cost_saving': eligiblecostsaving,
            'married': married,
            'fed_tax_income_return': fedtaxincomereturn,
            'jointly_taxed_spouse': jointlytaxedspouse,
            'is_dependent': isdependent,
            'household_members': householdMembers
        });
    }



    const successMessage = @json(__('labels.dadosGravados'));
    const errorMessage = @json(__('labels.errodadosGravados'));

    function sendFormHousehold(buttonElement) {
        const household = formatHousehold();
        const csrf_token = '{{ csrf_token() }}';

        document.getElementById('loader').style.display = 'block';

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': csrf_token,
                'Content-Type': 'application/json'
            },
            url: "{{ route('household.ajax.update', ['application_id' => $application_id ?? 0]) }}",
            type: "PUT",
            data: household,
            contentType: "application/json",
            success: function(response) {
                document.getElementById('loader').style.display = 'none';
                if (response.status === 'success') {
                    Swal.fire({
                        title: 'Sucesso!',
                        text: successMessage,
                        icon: 'success',
                        confirmButtonText: 'Ok',
                        willClose: () => {
                            window.location.href = "{{ route('index') }}";
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
                document.getElementById('loader').style.display = 'none';
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


    $(document).ready(function() {
        $('#saveSpouseBtn').on('click', function(e) {
            e.preventDefault();
            addhouseholdSpouse(0);

            // Close the modal
            $('#modalAddSpouse').modal('hide');
        });

        $('#savePersonBtn').on('click', function(e) {
            e.preventDefault();
            addhouseholdPerson(0);

            // Close the modal
            $('#modaldemoAddAnotherPerson').modal('hide');
        });

        $('#addWifeIfMarriedBtn').on('click', function(e) {
            e.preventDefault();
            addspouseHouseholdTax(1);

            // Close the modal
            $('#modaldemoAddWifeIfMarried').modal('hide');
        });


        $('#addDependentbtn').on('click', function(e) {
            e.preventDefault();
            addhouseholdDependent(1);

            // Close the modal
            $('#modalDemoAddDependents').modal('hide');
        });


        $('#addDependentTexbtn').on('click', function(e) {
            e.preventDefault();
            addhouseholdDependentTax(1);

            // Close the modal
            $('#modaldemo9').modal('hide');
        });

        // Input Masks
        $('#birthdateSpouse').mask('99/99/9999');
        $('#birthdatePerson').mask('99/99/9999');
        $('#dateDependents').mask('99/99/9999');
        $('#dateDependentTax').mask('99/99/9999');
        $('#dateSpouseHouseholdTax').mask('99/99/9999');
        $('#phone').mask('(999) 999-9999');
        $('#second_phone').mask('(999) 999-9999');
    });


    function openTab(evt, tabName) {
        let i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].classList.remove("active");
        }
        document.getElementById(tabName).style.display = "block";
        evt.currentTarget.classList.add("active");
    }
    document.getElementById("tabHousehold").click();
    document.getElementById("btnContinue").addEventListener("click", function() {
        document.getElementById("tabTaxHousehold").click();
    });
    document.getElementById("btnBack").addEventListener("click", function() {
        document.getElementById("tabHousehold").click();
    });
</script>

@endsection