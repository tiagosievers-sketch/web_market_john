@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="/css/abaNavegacao.css">
    <link rel="stylesheet" href="/css/load.css">
@endsection

@section('content')
    <!-- BREADCRUMB -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <h4 class="page-title">@lang('labels.additionalQuestions')</h4>
        </div>
    </div>
    <!-- END BREADCRUMB -->



    <div id="extraHelp" class="tabcontent" style="display: block;">
        <!-- END BREADCRUMB -->
        <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="form-group row align-items-center">
                        <h1 class="col-form-label " style="font-size: 1rem;">@lang('labels.ajudaExtra')</h1>
                    </div>
                </div>
                {{-- question 1  --}}
                <div class="card-body">
                    <div class="row row-sm">
                        <label class="col-form-label">@lang('labels.primeiraPerguntaAdicional')</label>
                        <div class="col-lg-6 mb-3 mt-2">
                            @foreach ($householdMembers as $member)
                                <div class="input-group mb-2">
                                    <div class="input-group-text">
                                        <label class="ckbox wd-16 mg-b-0">
                                            <input class="mg-0 household-member-checkbox" type="checkbox"
                                                name="firstQuestion[]" value="{{ $member['id'] }}"
                                                data-question="firstQuestion" data-member-id="{{ $member['id'] }}"  {{ (int) $member->has_disability_or_mental_condition === 1 ? 'checked' : '' }}>
                                            <span></span>
                                        </label>
                                    </div>
                                    <div class="form-control">{{ $member['firstname'] }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- <input type="hidden" id="applying_coverage" name="applying_coverage" value="1"> --}}
                    {{-- end question 1 --}}

                    {{-- question 2  --}}
                    <div class="row row-sm mt-3">
                        <label class="col-form-label">@lang('labels.segundaPerguntaAdicional')</label>
                        <div class="col-lg-6 mb-3 mt-2">
                            @foreach ($householdMembers as $member)
                                <div class="input-group mb-2">
                                    <div class="input-group-text">
                                        <label class="ckbox wd-16 mg-b-0">
                                            <input class="mg-0 household-member-checkbox" type="checkbox"
                                                name="secondQuestion[]" value="{{ $member['id'] }}"
                                                data-question="secondQuestion" data-member-id="{{ $member['id'] }}" {{ $member->has_disability_or_mental_condition ? 'checked' : '' }}>
                                            <span></span>
                                        </label>
                                    </div>
                                    <div class="form-control">{{ $member['firstname'] }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    {{-- <input type="hidden" id="applying_coverage" name="applying_coverage" value="1"> --}}
                    {{-- end question 1 --}}

                    {{-- end card --}}
                    <div class="card-body">
                        <div class="form-group row align-items-center">
                            <h1 class="col-form-label " style="font-size: 1rem;">@lang('labels.additionalCoverage')</h1>
                        </div>
                    </div>
                    <div class="row row-sm mt-3">
                        <label class="col-form-label">@lang('labels.terceiraPerguntaAdicional')</label>
                        <div class="col-lg-6 mb-3 mt-2">
                            <ul style="list-style-type: circle" class="ms-4 mt-1 mb-2">
                                <li>@lang('labels.additionalCoverageFirst', ['yearMenor' => date('Y') - 1, 'year' => date('Y')])</li>
                                <li>@lang('labels.additionalCoverageSecond', ['year' => date('Y')])</li>
                            </ul>

                            @foreach ($householdMembers as $member)
                                <div class="input-group mb-2">
                                    <div class="input-group-text">
                                        <label class="ckbox wd-16 mg-b-0">
                                            <input class="mg-0 household-member-checkbox" type="checkbox"
                                                name="thirdQuestion[{{ $member['id'] }}]" value="{{ $member['id'] }}"
                                                data-member-id="{{ $member['id'] }}"
                                                {{ $member->chip_coverage_ends_between ? 'checked' : '' }}>
                                            <span></span>
                                        </label>
                                    </div>
                                    <div class="form-control">{{ $member['firstname'] }}</div>
                                </div>

                                <!-- Bloco de perguntas individuais para cada membro -->
                         <div class="card-body additional-coverage-question"
    id="additionalCoverageQt_{{ $member['id'] }}"
    style="display: none; margin-left: 20px;">
    <div class="row row-sm">
        <label class="col-form-label">@lang('labels.additionalCoverageQt', ['name' => $member['firstname']])</label>
        <div class="col-lg-6 mb-3">
            <div class="input-group">
                <div class="input-group-text">
                    <label class="rdiobox wd-16 mg-b-0">
                        <input class="mg-0 additional-check" type="radio"
                            name="additionalCheck_{{ $member['id'] }}"
                            id="additionalcheckYes_{{ $member['id'] }}" value="1"
                            {{ $member->change_income_or_household_size == 1 ? 'checked' : '' }}
                            data-member-id="{{ $member['id'] }}">
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
                        <input class="mg-0 additional-check" type="radio"
                            name="additionalCheck_{{ $member['id'] }}"
                            id="additionalcheckNo_{{ $member['id'] }}" value="0"
                            {{ $member->change_income_or_household_size == 0 ? 'checked' : '' }}
                            data-member-id="{{ $member['id'] }}">
                        <span></span>
                    </label>
                </div>
                <div class="form-control">@lang('labels.checkNo')</div>
            </div>
        </div>
    </div>
</div>


                                <!-- Campo de data para cada membro, exibido ao selecionar "No" -->
                                <div class="row row-sm last-day-coverage" id="lastDayCoverageOcult_{{ $member['id'] }}"
                                    style="display: none; margin-left: 20px;">
                                    <div class="col-lg-6 mb-3">
                                        <label class="form-label">@lang('labels.lastDayCoverageAdditional', ['name' => $member['firstname'] . '' . $member['lastname']])</label>
                                        <div class="input-group">
                                            <input class="form-control" name="lastDayCoverage_{{ $member['id'] }}"
                                                id="lastDayCoverage_{{ $member['id'] }}" placeholder="MM/DD/YYYY"
                                                type="text" value="{{ $member->last_date_coverage ? \Carbon\Carbon::createFromFormat('Y-m-d', $member->last_date_coverage)->format('m/d/Y') : '' }}">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- <input type="hidden" id="applying_coverage" name="applying_coverage" value="1"> --}}
                    {{-- end question 3 --}}

                    {{-- question 4  --}}
                    <div class="row row-sm mt-3">
                        <label class="col-form-label">@lang('labels.quartaPerguntaAdicional')</label>
                        <div class="col-lg-6 mb-3 mt-2">
                            @foreach ($householdMembers as $member)
                                <div class="input-group mb-2">
                                    <div class="input-group-text">
                                        <label class="ckbox wd-16 mg-b-0">
                                            <input class="mg-0 household-member-checkbox" type="checkbox"
                                                name="fourthQuestion[{{ $member['id'] }}]" value="{{ $member['id'] }}"                     {{ $member->ineligible_for_medicaid_or_chip_last_90_days ? 'checked' : '' }}

                                                data-member-id="{{ $member['id'] }}">
                                            <span></span>
                                        </label>
                                    </div>
                                    <div class="form-control">{{ $member['firstname'] }}</div>
                                </div>

                                <!-- Bloco de perguntas individuais para cada membro -->
                                <div class="row row-sm" id="coverageMedicaidOcult_{{ $member['id'] }}"
                                    style="display: none; margin-left: 20px;">
                                    <div class="col-lg-6 mb-3">
                                        <label class="form-label">@lang('labels.dentedCoverageAdditional', ['name' => $member['firstname'] . '' . $member['lastname']])</label>
                                        <div class="input-group">
                                            <input class="form-control"
                                                name="dentedCoverageAdditionalDate_{{ $member['id'] }}"
                                                id="dentedCoverageAdditionalDate_{{ $member['id'] }}" 
                                                placeholder="MM/DD/YYYY" type="text" value="{{ $member->date_dented_coverage ? \Carbon\Carbon::createFromFormat('Y-m-d', $member->date_dented_coverage)->format('m/d/Y') : '' }}">
    
                                        </div>
                                    </div>

                                    <!-- Pergunta coverageBetweenAdicional -->
                                    <div class="row row-sm">
                                        <label class="col-form-label">@lang('labels.coverageBetweenAdicional', ['yearMenor' => date('Y') - 1, 'yearMaior' => date('Y'), 'year' => date('Y')])</label>
                                        <div class="col-lg-6 mb-3 mt-2">
                                            <div class="input-group">
                                                <div class="input-group-text">
                                                    <label class="ckbox wd-16 mg-b-0">
                                                        <input class="mg-0" type="checkbox"
                                                            name="coverageBetweenAdicional[{{ $member['id'] }}]"
                                                            id="coverageBetweenAdicional_{{ $member['id'] }}"
                                                            value="1" data-member-id="{{ $member['id'] }}"
                                                            {{ $member->chip_coverage_ends_between ? 'checked' : '' }}>
                                                        <span></span>
                                                    </label>
                                                </div>
                                                <div class="form-control">{{ $member['firstname'] }}</div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Pergunta applyMarketplaceAdicional independente -->
                                    <div class="row row-sm mt-2">
                                        <label class="col-form-label">@lang('labels.applyMarketplaceAdicional')</label>
                                        <div class="col-lg-6 mb-3 mt-2">
                                            <div class="input-group">
                                                <div class="input-group-text">
                                                    <label class="ckbox wd-16 mg-b-0">
                                                        <input class="mg-0 applyMarketplaceCheckbox" type="checkbox"
                                                            name="applyMarketplaceAdicional[{{ $member['id'] }}]"
                                                            id="applyMarketplaceAdicional_{{ $member['id'] }}"
                                                                                {{ $member->apply_marketplace_qualifying_life_event ? 'checked' : '' }}
                                                            value="1" data-member-id="{{ $member['id'] }}">
                                                        <span></span>
                                                    </label>
                                                </div>
                                                <div class="form-control">{{ $member['firstname'] }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- botao continuar voltar  --}}
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6 mb-3">
                                <button id="btnBackTwo" class="btn btn-primary btn-lg btn-block"
                                    onclick="openTab(event, 'additionalInformation')">@lang('labels.buttonVoltar')</button>
                            </div>
                            {{-- <div class="col-lg-6 mb-3">
                            <button id="btnContinueTwo" class="btn btn-secondary btn-lg btn-block"
                                onclick="openTab(event, 'tabNonTax')">@lang('labels.buttonContinue')</button>
                        </div> --}}
                            <div class="col-lg-6 mb-3">
                                <button id="btnContinue" class="btn btn-secondary btn-lg btn-block"
                                    onclick="sendFormHousehold(this)">@lang('labels.buttonSalvar')</button>
                            </div>
                        </div>
                    </div>
                    {{-- fim botao continuar voltar --}}
                </div>

            </div>
        </div>
    </div>
@endsection




<!-- Vite Compilation -->
@vite('resources/assets/js/colorpicker.js')
@vite('resources/assets/js/modal.js')



@section('scripts')
    <!-- checkbox additional JS -->
    <script src="{{ asset('/js/additionalQuestion/additionalQuestion-edit.js') }}"></script>
    <script src="{{ asset('/build/assets/plugins/jquery.maskedinput/jquery.maskedinput.js') }}"></script>

    <script>
        function collectHouseholdData() {
            const householdMembersData = {};

            // Itera sobre cada membro
            $('.household-member-checkbox').each(function() {
                const memberId = $(this).data('member-id');

                // Verifica se alguma pergunta foi respondida para o membro
                 const hasDisabilityOrMentalCondition = $('input[name="firstQuestion[]"][value="' + memberId + '"]').is(':checked') ? 1 : 0;
                const needsHelpWithDailyActivities = $('input[name="secondQuestion[]"][value="' + memberId + '"]').is(':checked') ? 1 : 0;
                const chipCoverageEndsBetween = $('input[name="thirdQuestion[' + memberId + ']"]').is(':checked') ? 1 : 0;
                const changeIncomeOrHouseholdSize = $('input[name="additionalCheck_[' + memberId + ']"]').is(':checked') ? 1 : 0;
                const lastDateCoverage = $('#lastDayCoverage_' + memberId).val();
                const ineligibleForMedicaidOrChipLast90Days = $('input[name="fourthQuestion[' + memberId + ']"]')
                    .is(':checked') ? 1 : 0;
                const dateDentedCoverage = $('#dentedCoverageAdditionalDate_' + memberId).val();
                const coverageBetween = $('input[name="coverageBetweenAdicional[' + memberId + ']"]').is(
                    ':checked') ? 1 : 0;
                const applyMarketplaceQualifyingLifeEvent = $('input[name="applyMarketplaceAdicional[' + memberId +
                    ']"]').is(':checked') ? 1 : 0;

                // Adiciona os dados do membro somente se algum campo foi preenchido
                if (
                    hasDisabilityOrMentalCondition || needsHelpWithDailyActivities || chipCoverageEndsBetween ||
                    changeIncomeOrHouseholdSize || lastDateCoverage || ineligibleForMedicaidOrChipLast90Days ||
                    dateDentedCoverage || coverageBetween || applyMarketplaceQualifyingLifeEvent
                ) {
                    householdMembersData[memberId] = householdMembersData[memberId] || {
                        member_id: memberId,
                        has_disability_or_mental_condition: hasDisabilityOrMentalCondition,
                        needs_help_with_daily_activities: needsHelpWithDailyActivities,
                        chip_coverage_ends_between: chipCoverageEndsBetween, //ok
                        change_income_or_household_size: changeIncomeOrHouseholdSize,//ok
                        last_date_coverage: lastDateCoverage || null,
                        ineligible_for_medicaid_or_chip_last_90_days: ineligibleForMedicaidOrChipLast90Days,
                        date_dented_coverage: dateDentedCoverage || null, //ok
                        coverage_between: coverageBetween, //ok
                        apply_marketplace_qualifying_life_event: applyMarketplaceQualifyingLifeEvent //ok
                    };
                }
            });

            // Converte o objeto para um array de membros com respostas
            return Object.values(householdMembersData);
        }



        function sendFormHousehold(buttonElement) {
            const applicationId = '{{ $application_id ?? 0 }}';
            const householdMembersData = collectHouseholdData();

            const requestData = {
                application_id: applicationId,
                household_members: householdMembersData
            };

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                url: "{{ route('additionalQuestion.store', ['application_id' => $application_id ?? 0]) }}",
                type: "POST",
                data: JSON.stringify(requestData),
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
                    Swal.fire('Sucesso!', '@lang('labels.dadosSalvos').', 'success').then(() => {
                        // Redirecionar para a página de finalize passando o application_id
                        window.location.href =
                            "{{ route('livewire.finalize', ['application_id' => $application_id ?? 0]) }}";
                    });
                },
                error: function(jqXHR) {
                    Swal.close();
                    Swal.fire('Erro!', 'Erro ao salvar os dados.', 'error');
                }
            });

        }



        $(document).ready(function() {
            $('#btnContinue').on('click', function(e) {
                e.preventDefault();
                addOtherMember(0);
            });

            // Input Masks
            $('[id^=lastDayCoverage_]').mask('99/99/9999');
            $('[id^=dentedCoverageAdditionalDate_]').mask('99/99/9999');
        });
    </script>
@endsection
