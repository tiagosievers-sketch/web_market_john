@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="/css/abaNavegacao.css">
    <link rel="stylesheet" href="/css/load.css">
@endsection

@section('content')
    {{-- <div class="loader" id="loader">
        <div class="spinner"></div>
    </div> --}}

    <!-- BREADCRUMB -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <h4 class="page-title">@lang('labels.incomeInformation')</h4>
        </div>
    </div>
    <!-- END BREADCRUMB -->

    {{-- msg inicial --}}
    <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <h6 class="col-md-8 col-xl-8 col-xs-8 col-sm-8"> <label class="col-form-label">@lang('labels.textIncome')</label>
                    </h6>
                    <h6 class="col-md-4 col-xl-4 col-xs-4 col-sm-4 text-end"> <label
                            class="col-form-label">@lang('labels.incomeViewList')</label>
                    </h6>
                </div>
            </div>
        </div>
    </div>
    {{-- fim msg inicial --}}


    <div id="tabIncome" class="tabcontent" style="display: block;">
        <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="form-group row align-items-center">
                        <h1 class="col-form-label" style="font-size: 18px;">@lang('labels.currentIncome', ['name' => $applicant_name])</h1>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row row-sm">
                        <label class="col-form-label">@lang('labels.currentIncomeApplyng', ['name' => $firstMainMember->firstname . ' ' . $firstMainMember->lastname])</label>
                        <div class="col-lg-6 mb-3">
                            <div class="input-group">
                                <div class="input-group-text">
                                    <label class="rdiobox wd-16 mg-b-0">
                                        <input class="mg-0" type="radio" name="incomeCheck" id="incomecheckYes"
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
                                        <input class="mg-0" type="radio" name="incomeCheck" id="incomecheckNo"
                                            value="0" {{ $firstMainMember->has_income == 0 ? 'checked' : '' }}> 
                                        <span></span>
                                    </label>
                                </div>
                                <div class="form-control">@lang('labels.checkNo')</div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="container mt-4 col-lg-12 mb-3" style="margin-left: 15px;">
                    <!-- Lista de Items Income -->
                    <div id="incomeItemsContainer" class="mt-4">
                        <h5>@lang('labels.incomes'):</h5>
                        <div id="incomeItemsList" class="mb-3">
                        </div>
                    </div>
                </div>


                <hr>
                <div class="form-group row align-items-center ms-1">
                    <h2 class="col-form-label" style="font-size: 18px; ">@lang('labels.deductionsIncome', ['name' => $firstMainMember->firstname . ' ' . $firstMainMember->lastname])</h2>
                </div>

                <div class="card-body">
                    <div class="row row-sm">
                        <label class="col-form-label">@lang('labels.incomeQuestionDeductions', ['name' => $firstMainMember->firstname . ' ' . $firstMainMember->lastname, 'year' => date('Y')])</label>
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
                                        <input class="mg-0" type="radio" name="checkYesapplying" id="checkYesapplyingNo"
                                            value="0" {{ $firstMainMember->has_deduction_current_year == 0 ? 'checked' : '' }}>
                                        <span></span>
                                    </label>
                                </div>
                                <div class="form-control">@lang('labels.checkNo')</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4 mb-3">
                            <button id="bntAddDeduction" class="btn btn-primary btn-lg btn-block"
                                style="display: none">@lang('labels.addDeduction')</button>
                        </div>
                    </div>
                </div>


                <div class="container mt-4 col-lg-12 mb-3" style="margin-left: 15px;">
                    <!-- Lista de Items Income -->
                    <div id="incomeItemsContainer" class="mt-4">
                        <h5>@lang('labels.deductions'):</h5>
                        <div id="deductionItemsList" class="mb-3">
                        </div>
                    </div>
                </div>




                {{-- terceira pergunta Incoming --}}
                <hr>
                <div class="form-group row align-items-center ms-1">
                    <h2 class="col-form-label" style="font-size: 18px; ">@lang('labels.deductionsIncomeYearly', ['name' => $firstMainMember->firstname . ' ' . $firstMainMember->lastname])</h2>
                </div>



                <div class="card-body">
                    <div class="row row-sm">
                        <label class="col-form-label">
                            @lang('labels.incomeQuestionDeductionsQuestion', [
                                'name' => $firstMainMember->firstname . ' ' . $firstMainMember->lastname,
                                'year' => date('Y'),
                                'total' => '<span id="netIncomeTotal">0.00</span>',
                            ])
                        </label>
                        <div class="col-lg-6 mb-3">
                            <div class="input-group">
                                <div class="input-group-text">
                                    <label class="rdiobox wd-16 mg-b-0">
                                        <input class="mg-0" type="radio" name="checkIncomeing"
                                            id="checkYesIncomeYes" value="1"
                                            {{ $firstMainMember->income_confirmed == 1 ? 'checked' : '' }}>
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
                                        <input class="mg-0" type="radio" name="checkIncomeing" id="checkYesIncomeNo"
                                            value="0">
                                        <span></span>
                                    </label>
                                </div>
                                <div class="form-control">@lang('labels.checkNo')</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Terceira pergunta --}}

                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <button id="btnBackTwo" class="btn btn-primary btn-lg btn-block"
                                onclick="openTab(event, 'yourInformation')">@lang('labels.buttonVoltar')</button>
                        </div>
                        {{-- <div class="col-lg-6 mb-3">
                            <button id="btnContinue" class="btn btn-secondary btn-lg btn-block"
                                onclick="openTab(event, 'taxHousehold')">@lang('labels.buttonContinue')</button>
                        </div> --}}
                        <div class="col-lg-6 mb-3">
                            <button id="btnContinue" class="btn btn-secondary btn-lg btn-block"
                                onclick="sendFormHousehold2(true)">@lang('labels.buttonContinue')</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalIncomeType" tabindex="-1" aria-labelledby="modalIncomeType"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="container">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row row-sm">
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-lg-6">
                                            <label class="form-label">@lang('labels.incomeTypeSelect')</label>
                                            <select class="form-select" name="typeIncomeSelect" id="typeIncomeSelect">
                                                <option value="" selected>@lang('labels.campoSelecao')</option>
                                                @foreach ($incomeType as $key => $value)
                                                    <option value="{{ $key }}">@lang('labels.' . $value)</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    {{-- Seção "Regular Pay Income" --}}
                                    <div class="row mb-3" id="regularPayIncome" style="display: none;">
                                        <div class="col-lg-12">
                                            <p class="mb-2">@lang('labels.regularPayIncome', ['name' => $applicant_name])</p>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <!-- Campo de Nome do Empregador -->
                                        <div class="col-lg-4">
                                            <div class="input-group" id="employerNameOcult"
                                                style="display: none; width: 100%;">
                                                <span class="input-group-text bg-light"
                                                    style="min-width: 150px;">@lang('labels.employerName'):</span>
                                                <input type="text" class="form-control w-100" name="nameEmployer"
                                                    id="nameEmployer" placeholder="@lang('labels.employerName')"
                                                    aria-label="@lang('labels.employerName')" style="border-radius: 0 4px 4px 0;">
                                            </div>
                                        </div>
                                        <!-- Campo de Telefone do Empregador -->
                                        <div class="col-lg-4 mt-2 mt-lg-0">
                                            <div class="input-group" id="phoneOcult" style="display: none; width: 100%;">
                                                <span class="input-group-text bg-light"
                                                    style="min-width: 150px;">@lang('labels.numeroTelefone'):</span>
                                                <input type="text" class="form-control w-100" id="phone"
                                                    name="phone" placeholder="(000) 000-0000"
                                                    aria-label="@lang('labels.numeroTelefone')" required
                                                    style="border-radius: 0 4px 4px 0;">
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row mb-3" id="selfEmploymentMsg" style="display: none;">
                                        <div class="col-lg-12">
                                            <p class="mb-2">@lang('labels.selfEmploymentMsg', ['name' => $applicant_name])</p>
                                        </div>
                                    </div>

                                    <div class="row mb-3" id="selfEmploymentMsg2" style="display: none;">
                                        <div class="col-lg-12">
                                            <p class="mb-2">@lang('labels.selfEmploymentMsg2')</p>
                                        </div>
                                    </div>


                                    <div class="row mb-3" id="typeOfWorkOcult" style="display: none;">
                                        <div class="col-lg-4">
                                            <label class="form-label">@lang('labels.typeOfWork')</label>
                                            <input type="text" class="form-control" name="typeOfWork" id="typeOfWork"
                                                placeholder="@lang('labels.typeOfWork')">
                                        </div>
                                    </div>

                                    <div class="row mb-2 mt-4" id="otherIncomeType" style="display: none;">
                                        <div class="col-lg-4">
                                            <label class="form-label">@lang('labels.otherIncomeType2')</label>
                                            <input type="text" class="form-control" name="otherIncome"
                                                id="otherIncome">
                                        </div>
                                    </div>

                                    <div class="row mb-3" id="unemploymentMsg" style="display: none;">
                                        <div class="col-lg-12">
                                            <p class="mb-2">@lang('labels.unemploymentMsg', ['name' => $applicant_name])</p>
                                        </div>
                                    </div>

                                    <div class="row mb-3 mt-3" id="unemployment" style="display: none;">
                                        <div class="col-lg-4">
                                            <label class="form-label">@lang('labels.unemploye')</label>
                                            <input type="text" class="form-control" name="unemploymentJob"
                                                id="unemploymentJob">
                                        </div>
                                    </div>


                                    <div class="row mb-3">
                                        <div class="col-lg-6 mb-3" id="employeBenefitsOcult" style="display: none;">
                                            <div class="input-group">
                                                <label class="form-label">@lang('labels.dateUnemployeBenefits')</label>
                                                <div class="input-group-text"></div>
                                                <input class="form-control" name="employeBenefits" id="employeBenefits"
                                                    placeholder="MM/DD/YYYY" type="text">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3" id="alimonyMsg" style="display: none;">
                                        <div class="col-lg-12">
                                            <p class="mb-2">@lang('labels.alimonyMsg', ['name' => $applicant_name])</p>
                                        </div>
                                    </div>

                                    <div class="row mb-3" id="alimonyMsg2" style="display: none;">
                                        <div class="col-lg-12">
                                            <p class="mb-2">@lang('labels.alimonyMsg2', ['year' => \Carbon\Carbon::now()->format('Y')])</p>
                                        </div>
                                    </div>

                                    <div class="row mb-3" id="socialSecurityMsg" style="display: none;">
                                        <div class="col-lg-12">
                                            <p class="mb-2">@lang('labels.socialSecurityMsg', ['name' => $applicant_name])</p>
                                        </div>
                                    </div>
                                    <div class="row mb-3" id="retirementMsg" style="display: none;">
                                        <div class="col-lg-12">
                                            <p class="mb-2">@lang('labels.retirementMsg', ['name' => $applicant_name])</p>
                                        </div>
                                    </div>

                                    <div class="row mb-3" id="pensionMsg" style="display: none;">
                                        <div class="col-lg-12">
                                            <p class="mb-2">@lang('labels.pensionMsg', ['name' => $applicant_name])</p>
                                        </div>
                                    </div>
                                    <div class="row mb-3" id="cashSupportMsg" style="display: none;">
                                        <div class="col-lg-12">
                                            <p class="mb-2">@lang('labels.cashSupportMsg')</p>
                                        </div>
                                    </div>
                                    <div class="row mb-3" id="capitalGainsMsg" style="display: none;">
                                        <div class="col-lg-12">
                                            <p class="mb-2">@lang('labels.capitalGainsMsg', ['name' => $applicant_name])</p>
                                        </div>
                                    </div>
                                    <div class="row mb-3" id="investimentMsg" style="display: none;">
                                        <div class="col-lg-12">
                                            <p class="mb-2">@lang('labels.investimentMsg', ['name' => $applicant_name])</p>
                                        </div>
                                    </div>
                                    <div class="row mb-3" id="investimentMsg2" style="display: none;">
                                        <div class="col-lg-12">
                                            <p class="mb-2">@lang('labels.investimentMsg2')</p>
                                        </div>
                                    </div>
                                    <div class="row mb-3" id="rentalOrRoaltyMsg" style="display: none;">
                                        <div class="col-lg-12">
                                            <p class="mb-2">@lang('labels.rentalOrRoaltyMsg', ['name' => $applicant_name])</p>
                                        </div>
                                    </div>
                                    <div class="row mb-3" id="scholarshipMsg" style="display: none;">
                                        <div class="col-lg-12">
                                            <p class="mb-2">@lang('labels.scholarshipMsg')</p>
                                        </div>
                                    </div>
                                    <div class="row mb-3" id="scholarshipMsg2" style="display: none;">
                                        <div class="col-lg-12">
                                            <p class="mb-2">@lang('labels.scholarshipMsg2')</p>
                                        </div>
                                    </div>
                                    <div class="row mb-3" id="prizeMsg" style="display: none;">
                                        <div class="col-lg-12">
                                            <p class="mb-2">@lang('labels.prizeMsg', ['name' => $applicant_name])</p>
                                        </div>
                                    </div>
                                    <div class="row mb-3" id="countAwardsMsg" style="display: none;">
                                        <div class="col-lg-12">
                                            <p class="mb-2">@lang('labels.countAwardsMsg', ['name' => $applicant_name])</p>
                                        </div>
                                    </div>
                                    <div class="row mb-3" id="juryDutyPayMsg" style="display: none;">
                                        <div class="col-lg-12">
                                            <p class="mb-2">@lang('labels.juryDutyPayMsg', ['name' => $applicant_name])</p>
                                        </div>
                                    </div>
                                    <div class="row mb-3" id="juryDutyPayMsg2" style="display: none;">
                                        <div class="col-lg-12">
                                            <p class="mb-2">@lang('labels.juryDutyPayMsg2')</p>
                                        </div>
                                    </div>
                                    <div class="row mb-3" id="canceledDebpMsg" style="display: none;">
                                        <div class="col-lg-12">
                                            <p class="mb-2">@lang('labels.canceledDebpMsg', ['name' => $applicant_name])</p>
                                        </div>
                                    </div>

                                    <div class="row mb-3" id="farmingOrFishingMsg" style="display: none;">
                                        <div class="col-lg-12">
                                            <p class="mb-2">@lang('labels.farmingOrFishingMsg', ['name' => $applicant_name])</p>
                                        </div>
                                    </div>

                                    <div class="row mb-3" id="otherIncomeMsg" style="display: none;">
                                        <div class="col-lg-12">
                                            <p class="mb-2">@lang('labels.otherIncomeMsg')</p>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="row mb-3 col-lg-12">
                                            <div class="row mb-3">
                                                <!-- Amount Field -->
                                                <div class="col-lg-4 d-flex flex-column mt-4" id="amountOcult"
                                                    style="display: block;">
                                                    <div class="input-group" style="width: 100%;">
                                                        <div class="input-group-text">@lang('labels.amountIncomeSymbol'):</div>
                                                        <input type="text" class="form-control w-100" name="amount3"
                                                            id="amount3" placeholder="@lang('labels.amountIncome')">
                                                    </div>
                                                </div>

                                                <!-- How Often Field -->
                                                <div class="col-lg-4 d-flex flex-column mt-4" id="howOftenOcult"
                                                    style="display: block;">
                                                    <label class="form-label mb-1">@lang('labels.howOften')</label>
                                                    <select class="form-select" name="oftenSelectOcult"
                                                        id="oftenSelectOcult">
                                                        <option value="" selected>@lang('labels.campoSelecao')</option>
                                                        @foreach ($frequency as $key => $value)
                                                            <option value="{{ $key }}">@lang('labels.' . $value)</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>



                                            <div class="col-lg-4"id="scholarshipAmountOcult" style="display: none;">
                                                <label class="form-label">@lang('labels.educationalAmount')</label>
                                                <div class="input-group">
                                                    <div class="input-group-text">@lang('labels.amountIncomeSymbol'):</div>
                                                    <input type="text" class="form-control" name="scholarshipAmount"
                                                        id="scholarshipAmount" placeholder="@lang('labels.amountIncome')">
                                                </div>
                                            </div>
                                            <div class="col-lg-4"id="scholarshipAmountOcult2" style="display: none;">
                                                <label class="form-label">@lang('labels.nonEducationalAmount')</label>
                                                <div class="input-group">
                                                    <div class="input-group-text">@lang('labels.amountIncomeSymbol'):</div>
                                                    <input type="text" class="form-control"
                                                        name="amount_non_educational" id="amount_non_educational"
                                                        placeholder="@lang('labels.amountIncome')">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                {{-- Fim da Seção "Regular Pay Income" --}}
                            </div>


                            <!-- Botão de Adicionar (com ícone '+') e Lista -->
                            <div class="card-body">
                                <button type="button" id="btnAddIncomeItem" class="btn btn-outline-secondary">
                                    @lang('labels.addIncome')
                                </button>
                            </div>




                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6 mb-3">
                                        <button type="button" id="saveBtn"
                                            class="btn btn-primary btn-lg btn-block">@lang('labels.buttonSalvar')</button>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <button type="button" id="cancelBtn" class="btn btn-secondary btn-lg btn-block"
                                            data-bs-dismiss="modal">@lang('labels.buttonCancelar')</button>
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



    {{-- 2 modal" --}}

    <div class="modal fade" id="modalIncomeDeductions" tabindex="-1" aria-labelledby="modalIncomeDeductions"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="container">
                        <div class="card">
                            <div class="card-body">
                                <div class="row row-sm">
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-lg-6">
                                        <label class="form-label">@lang('labels.incomeExpenseSelect')</label>
                                        <select class="form-select" name="typeIncomeDeductionsSelect"
                                            id="typeIncomeDeductionsSelect">
                                            <option value="" selected>@lang('labels.campoSelecao')</option>
                                            @foreach ($deductionType as $key => $value)
                                                <option value="{{ $key }}">@lang('labels.' . $value)</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3" id="alimonyModal2Msg" style="display: none;">
                                    <div class="col-lg-12">
                                        <p class="mb-2">@lang('labels.alimonyModal2Msg', ['year' => date('Y')])</p>
                                    </div>
                                </div>

                                <div class="row mb-2 mt-4" id="otherDeductionType" style="display: none;">
                                    <div class="col-lg-4">
                                        <label class="form-label">@lang('labels.otherDeductionType')</label>
                                        <input type="text" class="form-control" name="otherDeductions"
                                            id="otherDeductions">
                                    </div>
                                </div>

                                <div class="row mb-3" id="alimonyMsg3" style="display: none;">
                                    <div class="col-lg-12">
                                        <p class="mb-2">@lang('labels.alimonyMsg2', ['year' => date('Y')])</p>
                                    </div>
                                </div>


                                <div class="row mb-3 align-items-center">
                                    <!-- Amount Deductions Field -->
                                    <div class="col-lg-4 d-flex flex-column mt-4" id="amountDeductionsOcult"
                                        style="display: block;">
                                        <label class="form-label mb-1">@lang('labels.amountIncomeSymbol')</label>
                                        <div class="input-group" style="width: 100%;">
                                            <input type="text" class="form-control" name="amountDeductions"
                                                id="amountDeductions" placeholder="@lang('labels.amountIncome')">
                                        </div>
                                    </div>

                                    <!-- How Often Deductions Field -->
                                    <div class="col-lg-4 d-flex flex-column mt-4" id="howOftenDeductionsOcult"
                                        style="display: block;">
                                        <label class="form-label mb-1">@lang('labels.howOften')</label>
                                        <select class="form-select" name="oftenSelectDeductions"
                                            id="oftenSelectDeductions">
                                            <option value="" selected>@lang('labels.campoSelecao')</option>
                                            @foreach ($frequency as $key => $value)
                                                <option value="{{ $key }}">@lang('labels.' . $value)</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>



                            </div>
                            {{-- fim segunda modal " --}}

                            <button type="button" id="btnAddDeductionItem"
                                class="btn btn-outline-secondary mt-3">@lang('labels.addDeduction')</button>


                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6 mb-3">
                                        <button type="button" id="saveDeductionBtn"
                                            class="btn btn-primary btn-lg btn-block">@lang('labels.buttonSalvar')</button>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <button type="button" id="cancelDeductionBtn"
                                            class="btn btn-secondary btn-lg btn-block"
                                            data-bs-dismiss="modal">@lang('labels.buttonCancelar')</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal2 -->

    {{-- 3 modal --}}
    <div class="modal fade" id="yearlyIncomeModal" tabindex="-1" aria-labelledby="yearlyIncomeModal"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="container">
                        <div class="card">
                            <div class="card-body">
                                <div class="row row-sm">
                                </div>
                            </div>

                            <hr>

                            {{-- pergunta da modal 3  --}}

                            <div class="card-body">
                                <div class="row row-sm">
                                    <label class="col-form-label">
                                        @lang('labels.questionIncomeModal', ['year' => date('Y'), 'name' => $firstMainMember->firstname . ' ' . $firstMainMember->lastname])
                                    </label>
                                    <div class="col-lg-6 mb-3">
                                        <div class="input-group">
                                            <div class="input-group-text">
                                                <label class="rdiobox wd-16 mg-b-0">
                                                    <input class="mg-0" type="radio" name="checkIncomeingModal"
                                                        id="checkYesIncomeModalYes" value="1"
                                                        {{ $incomePredictable == 1 ? 'checked' : '' }}>
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
                                                    <input class="mg-0" type="radio" name="checkIncomeingModal"
                                                        id="checkYesIncomeModalNo" value="0"
                                                        {{ $incomePredictable == 0 ? 'checked' : '' }}>
                                                    <span></span>
                                                </label>
                                            </div>
                                            <div class="form-control">@lang('labels.checkNo')</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- Terceira pergunta --}}

                            <div class="row mb-3 ms-2" id="modal3PredictMsg" style="display: none;">
                                <div class="col-lg-12">
                                    <p class="mb-2">@lang('labels.modal3PredictMsg', ['year' => date('Y')])</p>
                                </div>
                            </div>
                            <div class="row mb-3 ms-2" id="modal3PredictMsg2" style="display: none;">
                                <div class="col-lg-12">
                                    <p class="mb-2">@lang('labels.modal3PredictMsg2', ['year' => date('Y')])</p>
                                </div>
                            </div>

                            <div class="row mb-3 col-lg-12 ms-1">
                                <div class="col-lg-4 mt-1" id="amountModal3" style="display: block;">
                                    <div class="input-group">
                                        <div class="input-group-text">@lang('labels.amountIncomeSymbol'):</div>
                                        <input type="text" class="form-control" name="amountModal3Income"
                                            id="amountModal3Income"
                                            value="{{ $incomePredictedAmount ? number_format($incomePredictedAmount, 2, '.', ',') : '' }}"
                                            placeholder="@lang('labels.amountIncome')">
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6 mb-3">
                                    <button type="button" id="saveDeductionBtnPredict"
                                        class="btn btn-primary btn-lg btn-block">@lang('labels.buttonSalvar')</button>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <button type="button" id="cancelDeductionBtn"
                                        class="btn btn-secondary btn-lg btn-block"
                                        data-bs-dismiss="modal">@lang('labels.buttonCancelar')</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- End Modal3 -->
@endsection


<!-- Vite Compilation -->
@vite('resources/assets/js/colorpicker.js')
@vite('resources/assets/js/modal.js')

@section('scripts')
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
    {{-- <script src="{{ asset('/resources/assets/js/form-elements.js') }}"></script> --}}

    <!-- Adicionando o SweetAlert2 via CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Modal Income --}}
    <script src="{{ asset('/js/income/modalIncome.js') }}"></script>




    <!-- Vite Compilation -->
    @vite('resources/assets/js/colorpicker.js')
    @vite('resources/assets/js/modal.js')


    <script>
        const additionalInformation = [];

        // Função para adicionar dados de income/deduction temporariamente ao array
        function addToIncomeMember(type) {

            const has_income = $('input[name="incomeCheck"]:checked').val() === "1" ? 1 : 0;
            const has_deduction_current_year = $('input[name="checkYesapplying"]:checked').val() === "1" ? 1 : 0;
            const income_confirmed = $('input[name="checkIncomeing"]:checked').val() === "1" ? 1 : 0;
            const income_predictable = $('input[name="checkIncomeingModal"]:checked').val() === "1" ? 1 : 0;
            const amountModal3Income = $('#amountModal3Income').val();
            const amountDeductions = $('#amountDeductions').val();
            //const amount = $('#amount').val();
            const nameEmployer = $('#nameEmployer').val() || '';
            const typeIncomeSelect = $('#typeIncomeSelect').val() || '';
            //const oftenSelect = $('#oftenSelect').val() || '';
            const oftenSelectOcult = $('#oftenSelectOcult').val() || '';
            const oftenSelectDeductions = $('#oftenSelectDeductions').val() || '';
            const phone = $('#phone').val() || '';
            const scholarshipAmount = parseCurrency($('#scholarshipAmount').val() || 0);
            const otherDeductions = $('#otherDeductions').val() || '';
            const employeBenefits = $('#employeBenefits').val() || null;
            const unemploymentJob = $('#unemploymentJob').val() || '';
            const amount2 = parseCurrency($('#amount_non_educational').val() || 0);
            const amount3 = parseCurrency($('#amount3').val() || 0);
            const typeIncomeDeductionsSelect = $('#typeIncomeDeductionsSelect').val() || '';
            const typeOfWork = $('#typeOfWork').val() || '';
            const alimonyMsg3 = $('#alimonyMsg3').val() || '';
            console.log('has_deduction_current_year', has_deduction_current_year);
            console.log('income_confirmed', income_confirmed);
            console.log('income_predictable', income_predictable);
            console.log('amountModal3Income', amountModal3Income);
            console.log('amountDeductions', amountDeductions);
            // console.log('amount', amount);
            console.log('nameEmployer', nameEmployer);
            console.log('typeIncomeSelect', typeIncomeSelect);
            //console.log('oftenSelect', oftenSelect);
            console.log('oftenSelectOcult', oftenSelectOcult);
            console.log('oftenSelectDeductions', oftenSelectDeductions);
            console.log('phone', phone);
            console.log('scholarshipAmount', scholarshipAmount);
            console.log('otherDeductions', otherDeductions);
            console.log('employeBenefits', employeBenefits);
            console.log('unemploymentJob', unemploymentJob);
            console.log('amount2', amount2);
            console.log('amount3', amount3);
            console.log('typeIncomeDeductionsSelect', typeIncomeDeductionsSelect);
            console.log('typeOfWork', typeOfWork);
            console.log('amountDeductions:', amountDeductions);



            const income_deduction_type = type === 0 ? $('#typeIncomeSelect').val() : $('#typeIncomeDeductionsSelect')
                .val();

            const member = {
                'type': type, // 0 para Income, 1 para Deduction
                'has_deduction_current_year': has_deduction_current_year,
                'has_income': has_income,
                'income_confirmed': income_confirmed,
                'income_predictable': income_predictable,
                'income_predicted_amount': parseCurrency(amountModal3Income || 0),
                'income_deduction_type': typeIncomeSelect || typeIncomeDeductionsSelect,
                //'amount': parseCurrency(amount2 || amountDeductions || amount3 || 0),
                'amount': type === 0 ? parseCurrency(amount3) : parseCurrency(amountDeductions),

                'educational_amount': parseFloat(scholarshipAmount),
                'non_educational_amount': parseFloat(amount2),
                'frequency': parseInt(oftenSelectOcult || oftenSelectDeductions, 10),
                'other_type': String(otherDeductions) || String(typeOfWork),
                'employer_name': String(nameEmployer),
                'employer_phone_number': String(phone),
                'employer_former_state': String(unemploymentJob),
                'unemployment_date': employeBenefits ? String(employeBenefits) : null
            };



            // Verifica se o item já existe para evitar duplicações
            if (!additionalInformation.some(item => JSON.stringify(item) === JSON.stringify(member))) {
                additionalInformation.push(member);
            }

            $('#modalIncomeType, #modalIncomeDeductions, #yearlyIncomeModal').find('input, select').val('').trigger(
                'change');


        }

        function parseCurrency(value) {
            if (typeof value === 'string') {
                // Remove vírgulas e outros caracteres, exceto o ponto decimal
                value = value.replace(/[^0-9.]/g, '');
            }

            // Converte a string para um número de ponto flutuante
            const parsedValue = parseFloat(value);

            // Retorna o valor formatado ou zero caso não seja válido
            return !isNaN(parsedValue) ? parsedValue : 0;
        }

        // Função para limpar itens vazios antes de enviar ao banco
        function cleanEmptyItems() {
            additionalInformation.splice(0, additionalInformation.length, ...additionalInformation.filter(
                item => (item.amount > 0 || item.educational_amount > 0 || item.non_educational_amount > 0 || item
                    .amount3 > 0) && item
                .income_deduction_type
            ));
        }




        //Função para adicionar relacionamentos ou outras informações adicionais
        function addOtherRelashionshipMember(data) {
            additionalInformation.push(data);
        }

        //Função para formatar os dados antes de enviar ao backend
        function formatHousehold() {
            const applicationId = '{{ $application_id ?? 0 }}';
            const member_id = '{{ $member_id ?? 0 }}';

            return JSON.stringify({
                'application_id': applicationId,
                'household_member_id': member_id,
                'income_data': additionalInformation
            });
        }

        // Função para enviar os dados completos ao backend via AJAX
        function sendFormHousehold(redirect = false) {
            cleanEmptyItems();
            const household = formatHousehold(); // Dados formatados a partir dos campos do formulário
            const csrf_token = '{{ csrf_token() }}';

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': csrf_token,
                    'Content-Type': 'application/json'
                },
                url: "{{ route('income.fillIncome', ['application_id' => $application_id ?? 0]) }}",
                type: "POST",
                data: household,
                contentType: "application/json",
                success: function(response) {
                    if (response.status === 'success') {
                        // Atualiza a lista de incomes após o salvamento com sucesso
                        fetchIncomeList();

                        if (redirect) {
                            window.location.href =
                                "{{ route('livewire.additional-question', ['application_id' => $application_id]) }}";
                        }

                        Swal.fire({
                            title: '@lang('labels.sucesso')!',
                            text: '@lang('labels.datasSaved')!',
                            icon: 'success',
                            confirmButtonText: 'Ok'
                        });
                    } else {
                        Swal.fire({
                            title: 'Erro!',
                            text: '@lang('labels.errorData').',
                            icon: 'error',
                            confirmButtonText: 'Ok'
                        });
                    }
                    additionalInformation.length = 0;

                },
                error: function() {
                    Swal.fire({
                        title: 'Erro!',
                        text: 'Houve um erro na requisição.',
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    });
                }
            });
        }

        // Função para salvar os dados temporários no banco ao fechar a modal
        function saveToDatabase() {
            sendFormHousehold(); // Envia todos os dados acumulados para o backend
        }

        let alreadyAdded = false;

        $(document).ready(function() {
            fetchIncomeList();
            fetchNetIncome();
            $('#employeBenefits').mask('99/99/9999');

            $('#btnAddIncomeItem').on('click', function(e) {
                e.preventDefault();
                addToIncomeMember(0);
            });

            $('#btnAddDeductionItem').on('click', function(e) {
                e.preventDefault();
                addToIncomeMember(1);
            });

            $('#saveBtn').on('click', function(e) {
                e.preventDefault();
                addToIncomeMember(0); // Garante que a entrada atual seja adicionada antes de salvar
                sendFormHousehold();
                $('#modalIncomeType').modal('hide');
                fetchNetIncome();

            });

            $('#saveDeductionBtn').on('click', function(e) {
                e.preventDefault();
                addToIncomeMember(1); // Adiciona dedução antes de salvar
                sendFormHousehold();
                $('#modalIncomeDeductions').modal('hide');
                fetchNetIncome();

            });

            $('#saveDeductionBtnPredict').on('click', function(e) {
                e.preventDefault();
                const amountModal3Income = $('#amountModal3Income').val();


                // Capture os valores específicos da `yearlyIncomeModal`
                const income_confirmed = $('input[name="checkIncomeing"]:checked').val() === "1" ? 1 : 0;
                const income_predictable = $('input[name="checkIncomeingModal"]:checked').val() === "1" ?
                    1 : 0;
                const income_predicted_amount = parseCurrency(amountModal3Income || 0);

                // Crie o objeto com os dados apenas para a `yearlyIncomeModal`
                const yearlyIncomeData = {
                    'income_confirmed': income_confirmed,
                    'income_predictable': income_predictable,
                    'income_predicted_amount': income_predicted_amount
                };

                // Envia apenas os dados específicos da `yearlyIncomeModal`
                sendYearlyIncomeData(yearlyIncomeData);
                $('#yearlyIncomeModal').modal('hide');
            });

            // Função específica para enviar apenas os dados da `yearlyIncomeModal`
            function sendYearlyIncomeData(data) {
                const applicationId = '{{ $application_id ?? 0 }}';
                const member_id = '{{ $member_id ?? 0 }}';
                const csrf_token = '{{ csrf_token() }}';

                const payload = JSON.stringify({
                    'application_id': applicationId,
                    'household_member_id': member_id,
                    'income_data': [data] // Envia como array para manter o formato esperado pelo backend
                });

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': csrf_token,
                        'Content-Type': 'application/json'
                    },
                    url: "{{ route('income.fillIncome', ['application_id' => $application_id ?? 0]) }}",
                    type: "POST",
                    data: payload,
                    contentType: "application/json",
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire({
                                title: 'Sucesso!',
                                text: '@lang('labels.datasSaved')!',
                                icon: 'success',
                                confirmButtonText: 'Ok'
                            });
                        } else {
                            Swal.fire({
                                title: 'Erro!',
                                text: '@lang('labels.errorData').',
                                icon: 'error',
                                confirmButtonText: 'Ok'
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            title: 'Erro!',
                            text: 'Houve um erro na requisição.',
                            icon: 'error',
                            confirmButtonText: 'Ok'
                        });
                    }
                });
            }

        });




        function fetchIncomeList() {
            $.ajax({
                url: "{{ route('income.list', ['application_id' => $application_id ?? 0]) }}",
                type: "GET",
                success: function(response) {
                    if (response.status === 'success' && Array.isArray(response.data)) {
                        console.log('incomes', response.data);
                        // Limpa as listas de income e deduction
                        $('#incomeItemsList').empty();
                        $('#deductionItemsList').empty();

                        // Itera sobre os dados recebidos
                        response.data.forEach(item => {
                            let itemHTML = '';

                            // Verifique a condição fora do template literal
                            if (item.amount > 0 || item.educational_amount > 0 || item
                                .non_educational_amount > 0 || item.amount3 > 0) {
                                itemHTML = `
                                    <div class="income-item border rounded p-3 mb-2">
                                        <div>
                                            <div><strong>ID:</strong> ${item.id}</div>
                                            ${item.amount > 0 ? `<div><strong>@lang('labels.amountValue'):</strong> $${parseFloat(item.amount).toFixed(2)}</div>` : ''}
                                            ${item.educational_amount > 0 ? `<div><strong>@lang('labels.educationalAmount'):</strong> $${parseFloat(item.educational_amount).toFixed(2)}</div>` : ''}
                                            ${item.non_educational_amount > 0 ? `<div><strong>@lang('labels.nonEducationalAmount'):</strong> $${parseFloat(item.non_educational_amount).toFixed(2)}</div>` : ''}
                                            ${item.frequency ? `<div><strong>@lang('labels.frequencia'):</strong> ${item.frequency.name}</div>` : ''}
                                            ${item.type_of_income_deduction && item.type_of_income_deduction.name ? `<div><strong>@lang('labels.typeIncomeDeductions'):</strong> ${item.type_of_income_deduction.name}</div>` : ''}
                                            ${item.otherIncome ? `<div><strong>@lang('labels.otherIncomeType'):</strong> ${item.otherIncome}</div>` : ''}
                                            ${item.typeOfWork ? `<div><strong>@lang('labels.typeOfWork'):</strong> ${item.typeOfWork}</div>` : ''}
                                            ${item.employer_name ? `<div><strong>@lang('labels.employerName'):</strong> ${item.employer_name}</div>` : ''}
                                            ${item.employer_phone_number ? `<div><strong>@lang('labels.employerPhoneNumber'):</strong> ${item.employer_phone_number}</div>` : ''}
                                            ${item.employer_former_state ? `<div><strong>@lang('labels.employerState'):</strong> ${item.employer_former_state}</div>` : ''}
                                            ${item.unemployment_date ? `<div><strong>@lang('labels.dataDesemprego'):</strong> ${formatDate(item.unemployment_date)}</div>` : ''}
                                        </div>
                                        <button class="btn btn-danger btn-sm delete-income-btn" data-id="${item.id}">
                                            @lang('labels.buttonExcluir')
                                        </button>
                                    </div>
                                `;
                            }


                            // Adiciona à lista correta
                            if (item.type === 0) {
                                $('#incomeItemsList').append(itemHTML);
                            } else if (item.type === 1) {
                                $('#deductionItemsList').append(itemHTML);
                            } else {
                                console.warn("Tipo de item não reconhecido:", item);
                            }
                        });

                        // Adiciona eventos ao botão de exclusão
                        $('.delete-income-btn').on('click', function() {
                            const incomeId = $(this).data('id');
                            deleteIncome(incomeId);
                        });
                    } else {
                        console.warn("Nenhum dado encontrado ou resposta inesperada", response);
                    }
                },
                error: function() {
                    console.error("Erro ao buscar a lista de incomes");
                }
            });
        }

        function formatDate(dateString) {
            // Garante que a data seja interpretada corretamente
            const dateParts = dateString.split('-'); // Divide o formato YYYY-MM-DD
            const year = parseInt(dateParts[0], 10);
            const month = parseInt(dateParts[1], 10) - 1; // Meses começam do zero em JavaScript
            const day = parseInt(dateParts[2], 10);

            const formattedDate = new Date(year, month, day);

            // Retorna no formato MM/DD/YYYY
            return formattedDate.toLocaleDateString('en-US');
        }

        function deleteIncome(incomeId) {
            const csrfToken = '{{ csrf_token() }}';
            const applicationId = '{{ $application_id }}';

            Swal.fire({
                title: '@lang('labels.confirmDeleteIncome')',
                text: '@lang('labels.confirmDeleteConfirm')',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: '@lang('labels.buttonExcluir')',
                cancelButtonText: '@lang('labels.buttonCancelar')'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        url: `/income/delete/${applicationId}/${incomeId}`,
                        type: 'DELETE',
                        success: function(response) {
                            if (response.status === 'success') {
                                Swal.fire('@lang('labels.deleted')', '@lang('labels.confirmDeleteConfirmed')', 'success');
                                fetchIncomeList(); // Atualiza a lista de incomes
                            } else {
                                Swal.fire('Erro', response.message, 'error');
                            }
                        },
                        error: function() {
                            Swal.fire('Erro', '@lang('labels.errorDeleteIncome')', 'error');
                        }
                    });
                }
            });
        }






        function formatCurrencyOnBlur(event) {
            let value = parseFloat(event.target.value.replace(/[^0-9.]/g, ''));
            if (!isNaN(value)) {
                event.target.value = value.toLocaleString('en-US', {
                    style: 'currency',
                    currency: 'USD',
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            } else {
                event.target.value = '';
            }
        }

        function formatCurrencyOnInput(event) {
            let value = event.target.value.replace(/[^0-9]/g, '');
            if (value) {
                value = (parseInt(value) / 100).toFixed(2);
                event.target.value = '$' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
            } else {
                event.target.value = '';
            }
        }

        function removeCurrencyFormat(event) {
            event.target.value = event.target.value.replace(/[^0-9.]/g, '');
        }

        document.addEventListener("DOMContentLoaded", function() {
            const amountFields = document.querySelectorAll('[id*="amount"]');
            amountFields.forEach(field => {
                field.addEventListener('focus', removeCurrencyFormat);
                field.addEventListener('input', formatCurrencyOnInput);
                field.addEventListener('blur', formatCurrencyOnBlur);
            });
            const scholarshipAmountFields = document.querySelectorAll('[id*="scholarshipAmount"]');
            scholarshipAmountFields.forEach(field => {
                field.addEventListener('focus', removeCurrencyFormat);
                field.addEventListener('input', formatCurrencyOnInput);
                field.addEventListener('blur', formatCurrencyOnBlur);
            });
        });

        function sendFormHousehold2(redirect = false) {
            const applicationId = '{{ $application_id ?? 0 }}';
            const member_id = '{{ $member_id ?? 0 }}';
            const csrf_token = '{{ csrf_token() }}';

            // Captura os valores dos três campos relevantes
            const has_income = $('input[name="incomeCheck"]:checked').val() === "1" ? 1 : 0;
            const has_deduction_current_year = $('input[name="checkYesapplying"]:checked').val() === "1" ? 1 : 0;
            const income_confirmed = $('input[name="checkIncomeing"]:checked').val() === "1" ? 1 : 0;

            // Adiciona esses valores ao array `additionalInformation`
            additionalInformation.push({
                has_income: has_income,
                has_deduction_current_year: has_deduction_current_year,
                income_confirmed: income_confirmed
            });

            // Cria o payload com `income_data` incluindo os valores específicos
            const householdData = {
                application_id: applicationId,
                household_member_id: member_id,
                income_data: additionalInformation
            };

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': csrf_token,
                    'Content-Type': 'application/json'
                },
                url: "{{ route('income.fillIncome', ['application_id' => $application_id ?? 0]) }}",
                type: "POST",
                data: JSON.stringify(householdData),
                contentType: "application/json",
                beforeSend: function() {
                    Swal.fire({
                        title: '@lang('labels.aguarde')...',
                        text: '@lang('labels.salvandoDados')...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                },
                success: function(response) {
                    Swal.close();
                    if (response.status === 'success') {
                        fetchIncomeList(); // Atualiza a lista de incomes após o salvamento
                        if (redirect) {
                            window.location.href =
                                "{{ route('livewire.additional-question', ['application_id' => $application_id]) }}";
                        }
                        Swal.fire({
                            title: '@lang('labels.sucesso')!',
                            text: '@lang('labels.datasSaved')!',
                            icon: 'success',
                            confirmButtonText: 'Ok'
                        });
                    } else {
                        Swal.fire({
                            title: 'Erro!',
                            text: '@lang('labels.errorData').',
                            icon: 'error',
                            confirmButtonText: 'Ok'
                        });
                    }
                    additionalInformation.length = 0; // Limpa o array após enviar
                },
                error: function() {
                    Swal.fire({
                        title: 'Erro!',
                        text: 'Houve um erro na requisição.',
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    });
                }

            });
            additionalInformation.splice(0, additionalInformation.length); // Limpa o array após o envio
        }


        function fetchNetIncome() {
            const memberId = '{{ $member_id }}'; // Pegue o ID do membro da forma correta

            $.ajax({
                url: "{{ route('income.getNetIncome') }}",
                type: "GET",
                data: {
                    member_id: memberId
                },
                success: function(response) {
                    if (response.netIncome !== undefined) {
                        // Atualiza o valor do total no HTML
                        $('#netIncomeTotal').text(response.netIncome.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g,
                            ','));
                    }
                },
                error: function() {
                    console.error("Erro ao buscar o netIncome");
                }
            });
        }

        $(
            function() {
                // Input Masks
                $('#phone').mask('(999) 999-9999');
            }
        );
    </script>
@endsection
