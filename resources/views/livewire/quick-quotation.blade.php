@extends('layouts.app')

<style>
    #birthdateContainer input[type="number"] {
        width: 100%;
        padding: 0.375rem 0.75rem;
    }

    #birthdateContainer input[type="number"]::-webkit-inner-spin-button,
    #birthdateContainer input[type="number"]::-webkit-outer-spin-button {
        opacity: 1;
    }
</style>

@section('content')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <h4 class="page-title">@lang('labels.quickQuotation')</h4>
        </div>
    </div>

    <div id="loading" style="display: none; text-align: center;">
        <h3>@lang('labels.carregandoPlano')</h3>
    </div>

    <div class="container">
        <!-- Dados do Membro Principal -->
        <form id="mainUserForm">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="firstname" class="form-label">@lang('labels.nome')</label>
                    <input type="text" class="form-control" id="firstname" name="firstname">
                </div>
                <div class="col-md-6">
                    <label for="lastname" class="form-label">@lang('labels.sobreNome') (@lang('labels.opcional'))</label>
                    <input type="text" class="form-control" id="lastname" name="lastname">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <div class="mb-2">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="birthdateType" id="typeDate"
                                value="date">
                            <label class="form-check-label" for="typeDate">
                                @lang('labels.dataNascimento')
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="birthdateType" id="typeAge"
                                value="age" checked>
                            <label class="form-check-label" for="typeAge">
                                @lang('labels.age')
                            </label>
                        </div>
                    </div>
                    <div id="birthdateContainer">
                        <input type="number" class="form-control" id="age" name="age"
                            placeholder="@lang('labels.digiteIdade')" min="0" max="120" style="display: block;">
                        <input type="text" class="form-control" id="birthdate" name="birthdate" placeholder="MM/DD/YYYY"
                            style="display: none;">
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="form-label">@lang('labels.campoSexo')</label>
                    <div class="d-flex">
                        @foreach ($sexes as $key => $value)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="sex" id="sex_{{ $key }}"
                                    value="{{ $key }}" required>
                                <label class="form-check-label" for="sex_{{ $key }}">
                                    @lang('labels.' . $value)
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="col-md-4">
                    <label class="form-label">@lang('labels.userTabaco')</label>
                    <div class="d-flex">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="tobacco" id="tobacco_no" value="0"
                                required>
                            <label class="form-check-label" for="tobacco_no">
                                @lang('labels.checkNo')
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="tobacco" id="tobacco_yes" value="1"
                                required>
                            <label class="form-check-label" for="tobacco_yes">
                                @lang('labels.checkYes')
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Campo "Parent of child under 19" -->
            <div class="row mb-3 mt-3">
                <div class="col-md-12">
                    <div class="custom-checkbox-container">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="parentOfChildUnder19"
                                name="parentOfChildUnder19" value="1">
                            <label class="form-check-label" for="parentOfChildUnder19">
                                <i class="fas fa-child me-2"></i> Parent of child under 19
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Campo "Pregnant" -->
            <div class="row mb-3" id="pregnantField">
                <div class="col-md-12">
                    <div class="custom-checkbox-container">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="pregnant" name="pregnant"
                                value="1">
                            <label class="form-check-label" for="pregnant">
                                <i class="fas fa-baby me-2"></i> Pregnant
                            </label>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="income" class="form-label">@lang('labels.yearlyIncome')</label>
                    <input type="text" class="form-control" id="income" name="income" required>
                </div>
                <div class="col-md-4">
                    <label for="zipcode" class="form-label">@lang('labels.enderecoCEP')</label>
                    <input type="text" class="form-control" id="zipcode" name="zipcode"
                        oninput="loadCounties(this, 'county')">
                </div>
                <div class="col-md-4">
                    <label for="county" class="form-label">@lang('labels.campoCounty')</label>
                    <select class="form-select" id="county" name="county" disabled>
                        <option value="">@lang('labels.campoSelecao')</option>
                    </select>
                </div>
            </div>

          <div class="row mb-3">
                <div class="col-md-4">
                    <label for="year" class="form-label">@lang('labels.ano')</label>
                    <select class="form-select" id="year" name="year" required>
                        <option value="">@lang('labels.campoSelecao')</option>
                        @foreach(($years ?? []) as $y)
                            <option value="{{ $y }}"
                                @if(isset($application) && (int)($application->year ?? 0) === (int)$y) selected @endif>
                                {{ $y }}
                            </option>
                        @endforeach
                    </select>
                </div>
           </div>

        </form>

        <!-- Botões para Adicionar Dependente e Spouse -->
        <div class="mb-4">
            <button id="btnAddDependent" class="btn btn-primary" data-bs-toggle="modal"
                data-bs-target="#addDependentModal">@lang('labels.householdAddDependente')</button>
            <button id="btnAddSpouse" class="btn btn-secondary" data-bs-toggle="modal"
                data-bs-target="#addSpouseModal">@lang('labels.householdAddConjuge')</button>
        </div>

        <!-- Accordion para Dependentes e Spouse -->
        <div class="accordion" id="householdAccordion">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingDependents">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseDependents" aria-expanded="true" aria-controls="collapseDependents">
                        @lang('labels.householdDependentesEsposa')
                    </button>
                </h2>
                <div id="collapseDependents" class="accordion-collapse collapse show"
                    aria-labelledby="headingDependents">
                    <div class="accordion-body">
                        <ul id="householdList" class="list-group"></ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Botão para Enviar Dados -->
        <div class="col-lg-6 mt-4">
            <button id="btnSubmitData" class="btn btn-success btn-lg btn-block">@lang('labels.quickQuotation')</button>
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
                        <!-- No modal de dependente -->
                        <div class="mb-3">
                            <div class="mb-2">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="dependentBirthdateType"
                                        id="dependentTypeAge" value="age" checked>
                                    <label class="form-check-label" for="dependentTypeAge">
                                        @lang('labels.age')
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="dependentBirthdateType"
                                        id="dependentTypeDate" value="date">
                                    <label class="form-check-label" for="dependentTypeDate">
                                        @lang('labels.dataNascimento')
                                    </label>
                                </div>
                            </div>
                            <div id="dependentBirthdateContainer">
                                <input type="number" class="form-control" id="dependentAge" name="dependentAge"
                                    placeholder="@lang('labels.digiteIdade')" min="0" max="120"
                                    style="display: block;">
                                <input type="text" class="form-control" id="dependentBirthdate"
                                    name="dependentBirthdate" placeholder="MM/DD/YYYY" style="display: none;">
                            </div>
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


                        <div class="row mb-3 mt-3">
                            <div class="col-md-12">
                                <div class="custom-checkbox-container">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox"
                                            id="dependentParentOfChildUnder19" name="dependentParentOfChildUnder19"
                                            value="1">
                                        <label class="form-check-label" for="dependentParentOfChildUnder19">
                                            <i class="fas fa-child me-2"></i> Parent of child under 19
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3" id="dependentPregnantField" style="display: none;">
                            <div class="col-md-12">
                                <div class="custom-checkbox-container">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="dependentPregnant"
                                            name="dependentPregnant" value="1">
                                        <label class="form-check-label" for="dependentPregnant">
                                            <i class="fas fa-baby me-2"></i> Pregnant
                                        </label>
                                    </div>
                                </div>
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

    <!-- Modal para Adicionar Spouse -->
    <div class="modal fade" id="addSpouseModal" tabindex="-1" aria-labelledby="addSpouseModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addSpouseModalLabel">@lang('labels.householdAddConjuge')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="spouseForm">
                               <div class="mb-3">
                        <div class="mb-2">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="spouseBirthdateType" id="spouseTypeAge" value="age" checked>
                                <label class="form-check-label" for="spouseTypeAge">@lang('labels.age')</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="spouseBirthdateType" id="spouseTypeDate" value="date">
                                <label class="form-check-label" for="spouseTypeDate">@lang('labels.dataNascimento')</label>
                            </div>
                            </div>
                            <div id="spouseBirthdateContainer">
                            <input type="number" class="form-control" id="spouseAge" name="spouseAge"
                                    placeholder="@lang('labels.digiteIdade')" min="0" max="120" style="display:block;">
                            <input type="text" class="form-control" id="spouseBirthdate" name="spouseBirthdate"
                                    placeholder="MM/DD/YYYY" style="display:none;">
                            </div>
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
@endsection



@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

  

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            // ===================== ESTADO & HELPERS =====================
            let householdMembers = [];
            let editingMemberId = null;

            function setRadioByName(groupName, value) {
                const radios = document.querySelectorAll(`input[name="${groupName}"]`);
                radios.forEach(r => r.checked = (String(r.value) === String(value)));
            }

            function setModalPrimaryButtonText(modalType, text) {
                if (modalType === 'dependent') {
                    const btn = document.getElementById('btnAddDependentToList');
                    if (btn) btn.textContent = text;
                } else if (modalType === 'spouse') {
                    const btn = document.getElementById('btnAddSpouseToList');
                    if (btn) btn.textContent = text;
                }
            }

            // ===================== CAMPOS: DEPENDENTE (idade/data) =====================
            setupDependentBirthdateFields();

            function setupDependentBirthdateFields() {
                const dependentTypeInputs = document.querySelectorAll('input[name="dependentBirthdateType"]');
                const dependentBirthdateInput = document.getElementById('dependentBirthdate');
                const dependentAgeInput = document.getElementById('dependentAge');

                if (dependentBirthdateInput && dependentAgeInput) {
                    dependentBirthdateInput.style.display = 'none';
                    dependentAgeInput.style.display = 'block';
                }

                dependentAgeInput.addEventListener('input', function() {
                    const age = parseInt(this.value);
                    if (!isNaN(age) && age > 0 && age <= 120) {
                        const birthdate = calculateBirthdate(age);
                        dependentBirthdateInput.value = formatDateMDY(birthdate);
                    }
                });

                dependentTypeInputs.forEach(input => {
                    input.addEventListener('change', function() {
                        if (this.value === 'age') {
                            dependentBirthdateInput.style.display = 'none';
                            dependentAgeInput.style.display = 'block';
                            dependentBirthdateInput.value = '';
                        } else {
                            dependentBirthdateInput.style.display = 'block';
                            dependentAgeInput.style.display = 'none';
                            dependentAgeInput.value = '';
                        }
                    });
                });
            }

            // ===================== CAMPOS: SPOUSE (idade/data) =====================

            setupSpouseBirthdateFields();

            function setupSpouseBirthdateFields() {
            const spouseTypeInputs = document.querySelectorAll('input[name="spouseBirthdateType"]');
            const spouseBirthdateInput = document.getElementById('spouseBirthdate');
            const spouseAgeInput = document.getElementById('spouseAge');

            if (spouseBirthdateInput && spouseAgeInput) {
                spouseBirthdateInput.style.display = 'none';
                spouseAgeInput.style.display = 'block';
            }

            spouseAgeInput.addEventListener('input', function() {
                const age = parseInt(this.value);
                if (!isNaN(age) && age > 0 && age <= 120) {
                const birthdate = calculateBirthdate(age);
                spouseBirthdateInput.value = formatDateMDY(birthdate);
                }
            });

            spouseTypeInputs.forEach(input => {
                input.addEventListener('change', function() {
                if (this.value === 'age') {
                    spouseBirthdateInput.style.display = 'none';
                    spouseAgeInput.style.display = 'block';
                    spouseBirthdateInput.value = '';
                } else {
                    spouseBirthdateInput.style.display = 'block';
                    spouseAgeInput.style.display = 'none';
                    spouseAgeInput.value = '';
                }
                });
            });
            }


            function calculateBirthdate(age) {
                const today = new Date();
                const birthYear = today.getFullYear() - age;
                const birthMonth = today.getMonth();
                const birthDay = today.getDate() - 1; // garante idade completa
                return new Date(birthYear, birthMonth, birthDay);
            }

            function formatDateMDY(date) {
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const day = String(date.getDate()).padStart(2, '0');
                const year = date.getFullYear();
                return `${month}/${day}/${year}`;
            }

            // ===================== CAMPOS: MAIN (idade/data) =====================
            const birthdateTypeInputs = document.querySelectorAll('input[name="birthdateType"]');
            const birthdateInput = document.getElementById('birthdate');
            const ageInput = document.getElementById('age');

            birthdateTypeInputs.forEach(input => {
                input.addEventListener('change', function() {
                    if (this.value === 'age') {
                        birthdateInput.style.display = 'none';
                        ageInput.style.display = 'block';
                        birthdateInput.value = '';
                    } else {
                        birthdateInput.style.display = 'block';
                        ageInput.style.display = 'none';
                        ageInput.value = '';
                    }
                });
            });

            ageInput.addEventListener('input', function() {
                const age = parseInt(this.value);
                if (!isNaN(age) && age > 0 && age <= 120) {
                    const b = calculateBirthdate(age);
                    birthdateInput.value = formatDateMDY(b);
                }
            });

            // estende validação para idade quando selecionada
            const originalValidateMainMemberFields = validateMainMemberFields;
            validateMainMemberFields = function() {
                let isValid = originalValidateMainMemberFields();
                const selectedType = document.querySelector('input[name="birthdateType"]:checked').value;
                if (selectedType === 'age') {
                    const age = parseInt(ageInput.value);
                    if (isNaN(age) || age <= 0 || age > 120) {
                        ageInput.classList.add('is-invalid');
                        isValid = false;
                    } else {
                        ageInput.classList.remove('is-invalid');
                    }
                }
                return isValid;
            };

            // ===================== CONTROLE PREGNANT (main/dependent) =====================
            const sexFields = document.querySelectorAll('input[name="sex"]');

            function handleSexChange(contextOrEvent) {
                const context = contextOrEvent?.type === 'change'
                    ? (contextOrEvent.target.name === 'dependentSex' ? 'dependent' : 'main')
                    : contextOrEvent;

                const isDependent = context === 'dependent';
                const pregnantField = document.getElementById(isDependent ? 'dependentPregnantField' : 'pregnantField');
                const pregnantCheckbox = document.getElementById(isDependent ? 'dependentPregnant' : 'pregnant');

                const selectedRadio = isDependent
                    ? document.querySelector('input[name="dependentSex"]:checked')
                    : document.querySelector('input[name="sex"]:checked');

                if (!selectedRadio) {
                    if (pregnantField) pregnantField.style.display = 'none';
                    return;
                }

                const label = document.querySelector(`label[for="${selectedRadio.id}"]`);
                const labelText = label ? label.textContent.trim().toLowerCase() : '';
                const value = selectedRadio.value;

                if (pregnantField) {
                    if (value === '14' || labelText.includes('female') || labelText.includes('feminino')) {
                        pregnantField.style.display = 'block';
                    } else {
                        pregnantField.style.display = 'none';
                        if (pregnantCheckbox) pregnantCheckbox.checked = false;
                    }
                }
            }

            document.querySelectorAll('input[name="sex"]').forEach(radio => {
                radio.addEventListener('change', handleSexChange);
            });
            document.querySelectorAll('input[name="dependentSex"]').forEach(radio => {
                radio.addEventListener('change', handleSexChange);
            });

            // verificação inicial
            const selectedSex = document.querySelector('input[name="sex"]:checked');
            if (selectedSex) handleSexChange('main');
            const selectedDependentSex = document.querySelector('input[name="dependentSex"]:checked');
            if (selectedDependentSex) handleSexChange('dependent');

            handleSexChange('main');
            handleSexChange('dependent');

            sexFields.forEach(radio => {
                radio.addEventListener('change', handleSexChange);
            });

            // ===================== VARIÁVEIS DE UI =====================
            const btnAddDependent = document.getElementById('btnAddDependentToList');
            const btnAddSpouse    = document.getElementById('btnAddSpouseToList');
            const btnSubmitData   = document.getElementById('btnSubmitData');
            const householdList   = document.getElementById('householdList');

            const addDependentModal = new bootstrap.Modal(document.getElementById('addDependentModal'));
            const addSpouseModal    = new bootstrap.Modal(document.getElementById('addSpouseModal'));

            let dependentCount = 1;

            // ===================== LIMPAR DEPENDENTE (modal) =====================
            function clearDependentFields() {
                document.getElementById('dependentBirthdate').value = '';
                document.getElementById('dependentAge').value = '';

                document.getElementById('dependentTypeAge').checked = true;
                document.querySelectorAll('input[name="dependentTobacco"]').forEach(el => el.checked = false);
                document.querySelectorAll('input[name="dependentSex"]').forEach(el => el.checked = false);

                document.getElementById('dependentParentOfChildUnder19').checked = false;
                document.getElementById('dependentPregnant').checked = false;

                document.getElementById('relationshipPerson').value = '';

                document.getElementById('dependentBirthdate').style.display = 'none';
                document.getElementById('dependentAge').style.display = 'block';
            }

            // ===================== ADD/EDIT DEPENDENTE (UPSERT) =====================
            btnAddDependent.addEventListener('click', function() {
                const selectedType = document.querySelector('input[name="dependentBirthdateType"]:checked').value;
                const birthdate = document.getElementById('dependentBirthdate').value;
                const age = document.getElementById('dependentAge').value;
                const tobacco = document.querySelector('input[name="dependentTobacco"]:checked')?.value;
                const sex = document.querySelector('input[name="dependentSex"]:checked')?.value;
                const relationship = document.getElementById('relationshipPerson').value;
                const parentOfChildUnder19 = document.getElementById('dependentParentOfChildUnder19').checked;
                const pregnant = document.getElementById('dependentPregnant').checked;

                // validações
                if (selectedType === 'age' && !age) {
                    alert("Por favor, informe a idade do dependente.");
                    return;
                }
                if (selectedType === 'date' && !birthdate) {
                    alert("Por favor, informe a data de nascimento do dependente.");
                    return;
                }
                if (!tobacco || !sex || !relationship) {
                    alert("Por favor, preencha todos os campos do dependente.");
                    return;
                }

                const conditionalFieldsDependent = {};
                if (parentOfChildUnder19) conditionalFieldsDependent.parent_of_child_under_19 = 1;
                if (pregnant) conditionalFieldsDependent.pregnant = 1;

                const newDependent = {
                    id: editingMemberId ?? `dependent-${Date.now()}`,
                    field_type: 6,
                    birthdate: (selectedType === 'age'
                        ? document.getElementById('dependentBirthdate').value
                        : birthdate),
                    tobacco,
                    sex,
                    relationship,
                    parent_of_child_under_19: parentOfChildUnder19 ? 1 : 0,
                    pregnant: pregnant ? 1 : 0,
                    ...conditionalFieldsDependent
                };

                if (editingMemberId) {
                    householdMembers = householdMembers.map(m =>
                        m.id === editingMemberId ? { ...m, ...newDependent } : m
                    );
                } else {
                    householdMembers.push(newDependent);
                }
                editingMemberId = null;

                addDependentModal.hide();
                updateHouseholdList();
                clearDependentFields();
                handleSexChange('main');
                handleSexChange('dependent');
                setModalPrimaryButtonText('dependent', 'Adicionar');
            });

            // ===================== ADD/EDIT SPOUSE (UPSERT) =====================
            const spouse = @json($spouse ?? 0);

            btnAddSpouse.addEventListener('click', function() {
            const selectedType = document.querySelector('input[name="spouseBirthdateType"]:checked')?.value;
            const birthdateInput = document.getElementById('spouseBirthdate');
            const ageInput = document.getElementById('spouseAge');
            const tobacco = document.querySelector('input[name="spouseTobacco"]:checked')?.value;
            const sex = document.querySelector('input[name="spouseSex"]:checked')?.value;
            const relationshipValue = spouse;

            let birthdate = birthdateInput.value;

            // Validações
            if (selectedType === 'age') {
                const age = parseInt(ageInput.value);
                if (isNaN(age) || age <= 0 || age > 120) {
                alert("Por favor, informe uma idade válida para o spouse.");
                return;
                }
                // Preenche birthdate calculado
                const b = calculateBirthdate(age);
                birthdate = formatDateMDY(b);
                birthdateInput.value = birthdate; // mantém coerente com o dependent
            } else {
                if (!birthdate) {
                alert("Por favor, informe a data de nascimento do spouse.");
                return;
                }
            }

            if (!tobacco || !sex) {
                alert("Por favor, preencha Tobacco e Sex do spouse.");
                return;
            }

            const newSpouse = {
                id: editingMemberId ?? `spouse-${Date.now()}`,
                field_type: 1,
                birthdate,
                tobacco,
                sex,
                relationship: relationshipValue
            };

            // Garante 1 único spouse quando adicionando
            if (!editingMemberId) {
                householdMembers = householdMembers.filter(member => member.field_type !== 1);
            }

            // upsert
            const idx = householdMembers.findIndex(m => m.id === newSpouse.id);
            if (idx >= 0) {
                householdMembers[idx] = { ...householdMembers[idx], ...newSpouse };
            } else {
                householdMembers.push(newSpouse);
            }
            editingMemberId = null;

            addSpouseModal.hide();
            updateHouseholdList();
            setModalPrimaryButtonText('spouse', 'Adicionar');
            });


            // ===================== RENDER LISTA =====================
            function formatDate(birthdate) {
                const date = new Date(birthdate);
                if (isNaN(date)) return birthdate;
                const month = date.getMonth() + 1;
                const day = date.getDate();
                const year = date.getFullYear();
                return `${month}/${day}/${year}`;
            }

            function updateHouseholdList() {
                const sortedMembers = householdMembers.slice().sort((a, b) => {
                    if (a.relationship === spouse) return -1;
                    if (b.relationship === spouse) return 1;
                    return 0;
                });

                householdList.innerHTML = sortedMembers.map(member => {
                    const extraInfo = [];
                    if (member.parent_of_child_under_19) extraInfo.push('Parent of child under 19');
                    if (member.pregnant) extraInfo.push('Pregnant');
                    const extraInfoText = extraInfo.length > 0 ? ` (${extraInfo.join(', ')})` : '';

                    return `
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>
                                ${member.relationship === spouse ? 'Spouse' : 'Dependent'} - ${formatDate(member.birthdate)}${extraInfoText}
                            </span>
                            <div class="d-flex gap-2">
                                <button class="btn btn-outline-danger btn-sm" onclick="removeMember('${member.id}')">Remover</button>
                                <button class="btn btn-outline-primary btn-sm" onclick="editMember('${member.id}')">Editar</button>
                            </div>
                        </li>
                    `;
                }).join('');
            }

            // ===================== REMOVER =====================
            window.removeMember = function(id) {
                householdMembers = householdMembers.filter(member => member.id !== id);
                updateHouseholdList();
            };

            // ===================== EDITAR (abre modal com dados) =====================
            window.editMember = function(id, fallbackType = null) {
                const member = householdMembers.find(m => m.id === id);

                if (!member) {
                    // ADICIONAR SE PRECISAR
                    editingMemberId = null;

                    if (fallbackType === 'spouse') {
                        document.getElementById('spouseBirthdate').value = '';
                        setRadioByName('spouseTobacco', '');
                        setRadioByName('spouseSex', '');
                        setModalPrimaryButtonText('spouse', 'Adicionar');
                        addSpouseModal.show();
                    } else if (fallbackType === 'dependent') {
                        clearDependentFields();
                        setModalPrimaryButtonText('dependent', 'Adicionar');
                        addDependentModal.show();
                    } else {
                        console.warn('ID não encontrado e nenhum fallbackType informado.');
                    }
                    return;
                }

                // Modo edição
                editingMemberId = id;

                if (member.field_type === 1) {
                    // SPOUSE
                    const spouseTypeDate   = document.getElementById('spouseTypeDate');
                    const spouseBirth      = document.getElementById('spouseBirthdate');
                    const spouseAge        = document.getElementById('spouseAge');

                    if (spouseTypeDate) spouseTypeDate.checked = true; 
                    if (spouseBirth) { 
                        spouseBirth.style.display = 'block';
                        spouseBirth.value = formatDateForDisplay(member.birthdate);
                    }
                    if (spouseAge) {  
                        spouseAge.style.display = 'none';
                        spouseAge.value = ''; 
                    }

                    setRadioByName('spouseTobacco', member.tobacco);
                    setRadioByName('spouseSex', member.sex);
                    handleSexChange('main'); // mantém como está (não há campo "pregnant" no spouse)
                    setModalPrimaryButtonText('spouse', 'Salvar alterações');
                    addSpouseModal.show();

                    } else {
                    // DEPENDENTE (como você já tem)
                    const typeDate        = document.getElementById('dependentTypeDate');
                    const dependentBirth  = document.getElementById('dependentBirthdate');
                    const dependentAge    = document.getElementById('dependentAge');

                    if (typeDate) typeDate.checked = true;
                    if (dependentBirth) {
                        dependentBirth.style.display = 'block';
                        dependentBirth.value = formatDateForDisplay(member.birthdate);
                    }
                    if (dependentAge) { dependentAge.style.display = 'none'; dependentAge.value = ''; }

                    setRadioByName('dependentTobacco', member.tobacco);
                    setRadioByName('dependentSex', member.sex);

                    const relationshipSel = document.getElementById('relationshipPerson');
                    if (relationshipSel) relationshipSel.value = member.relationship ?? '';

                    document.getElementById('dependentParentOfChildUnder19').checked = !!member.parent_of_child_under_19;
                    document.getElementById('dependentPregnant').checked = !!member.pregnant;

                    handleSexChange('dependent');
                    setModalPrimaryButtonText('dependent', 'Salvar alterações');
                    addDependentModal.show();
                }

            };

            // ===================== INCOME MASK =====================
            document.getElementById('income').addEventListener('input', formatCurrencyOnInput);

            // ===================== SUBMIT (AJAX) =====================
            btnSubmitData.addEventListener('click', function(event) {
                const incomeField = document.getElementById('income');
                const incomeValue = parseCurrency(incomeField.value);
                const locale = @json($locale ?? '4');

                event.preventDefault();

                if (!validateMainMemberFields()) {
                    alert("Por favor, corrija os erros nos campos do formulário.");
                    return;
                }

                const conditionalFields = {};
                if (document.getElementById('parentOfChildUnder19').checked) {
                    conditionalFields.parent_of_child_under_19 = 1;
                }
                if (document.getElementById('pregnant').checked) {
                    conditionalFields.pregnant = 1;
                }

                const mainUserData = {
                    ...conditionalFields,
                    firstname: document.getElementById('firstname').value,
                    lastname: document.getElementById('lastname').value || 'Quotation',
                    birthdate: formatDateForBackend(document.getElementById('birthdate').value),
                    sex: document.querySelector('input[name="sex"]:checked').value,
                    use_tobacco: document.querySelector('input[name="tobacco"]:checked').value,
                    income_predicted_amount: incomeValue,
                    county: document.getElementById('county').value,
                    zipcode: document.getElementById('zipcode').value,
                    written_lang: locale,
                    spoken_lang: locale,
                    notices_mail_or_email: false,
                    year: Number(document.getElementById('year').value)
                };

                if (mainUserData.firstname && mainUserData.lastname && mainUserData.birthdate &&
                    mainUserData.sex && mainUserData.use_tobacco && mainUserData.income_predicted_amount &&
                    mainUserData.county
                ) {
                    const requestData = {
                        mainUser: mainUserData,
                        dependents: householdMembers.filter(member => member.field_type === 6),
                        spouse: householdMembers.find(member => member.field_type === 1) || null
                    };

                    $.ajax({
                        url: '{{ route('household.ajax.storequickquotation') }}',
                        type: 'POST',
                        contentType: 'application/json',
                        data: JSON.stringify(requestData),
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        beforeSend: function() {
                            // Mostra o modal de carregamento
                            Swal.fire({
                                title: '@lang('labels.carregando')',
                                text: '@lang('labels.carregandoDados').',
                                allowOutsideClick: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                }
                            });
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                console.log(response);
                                window.location.href = '/quotation/' + response.application_id;
                            } else {
                                Swal.close();
                                alert('Erro ao salvar os dados: ' + response.message);
                            }
                        },
                        error: function(error) {
                            Swal.close();
                            console.error('Erro ao enviar dados:', error);
                            alert('Erro ao salvar os dados. Verifique o console para mais detalhes.');
                        }
                    });

                } else {
                    alert("Por favor, preencha todos os dados do membro principal.");
                }
            });

            // ===================== RESET AO FECHAR MODAIS =====================
            document.getElementById('addDependentModal')?.addEventListener('hidden.bs.modal', () => {
                editingMemberId = null;
                setModalPrimaryButtonText('dependent', 'Adicionar');
            });
            document.getElementById('addSpouseModal')?.addEventListener('hidden.bs.modal', () => {
                editingMemberId = null;
                setModalPrimaryButtonText('spouse', 'Adicionar');
            });

        }); // acaba o DOMContentLoaded


        // ===================== FUNÇÕES GLOBAIS (já existiam) =====================
        function formatDateForDisplay(dateString) {
            const date = new Date(dateString);
            if (isNaN(date)) return dateString;
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            const year = date.getFullYear();
            return `${month}/${day}/${year}`;
        }

        function formatDateForBackend(dateString) {
            const date = new Date(dateString);
            if (isNaN(date)) return dateString;
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            const year = date.getFullYear();
            return `${month}/${day}/${year}`;
        }

        // Atualizar o valor da data no campo input
        function updateDateFields() {
            const mainBirthdate = document.getElementById('birthdate');
            const dependentBirthdate = document.getElementById('dependentBirthdate');
            const spouseBirthdate = document.getElementById('spouseBirthdate');

            if (mainBirthdate) mainBirthdate.value = formatDateForDisplay(mainBirthdate.value);
            if (dependentBirthdate) dependentBirthdate.value = formatDateForDisplay(dependentBirthdate.value);
            if (spouseBirthdate) spouseBirthdate.value = formatDateForDisplay(spouseBirthdate.value);
        }
        updateDateFields();

        $(function() {
            $('#birthdate').mask('99/99/9999');
            $('#dependentBirthdate').mask('99/99/9999');
            $('#spouseBirthdate').mask('99/99/9999');
        });

        function loadCounties(element, targetElem) {
            const csrf_token = '{{ csrf_token() }}';
            const selectElem = $('#' + targetElem);
            selectElem.prop('disabled', true);

            if ('value' in element && element.value.trim() !== '') {
                let zipcode = element.value.trim();

                selectElem.find('option[value=""]').remove();
                selectElem.empty();

                $.ajax({
                    headers: { 'X-CSRF-TOKEN': csrf_token },
                    url: "{{ route('geography.counties', '') }}/" + zipcode,
                    type: "GET",
                    success: function(response) {
                        if ('status' in response && 'data' in response) {
                            if (response.status === 'success' && response.data.length > 0) {
                                response.data.forEach((county) => {
                                    let optionElement = document.createElement('option');
                                    optionElement.value = county;
                                    optionElement.innerHTML = county;
                                    document.getElementById(targetElem).appendChild(optionElement);
                                });
                                selectElem.val(response.data[0]);
                            } else {
                                console.log('Nenhum condado encontrado');
                            }
                        } else {
                            console.log('Resposta inesperada:', response);
                        }
                        selectElem.prop('disabled', false);
                    },
                    error: function(error) {
                        console.error('Erro na requisição:', error);
                        selectElem.prop('disabled', false);
                    }
                });
            } else {
                selectElem.empty();
                let defaultOption = document.createElement('option');
                defaultOption.value = '';
                defaultOption.innerHTML = '@lang('labels.campoSelecao')';
                document.getElementById(targetElem).appendChild(defaultOption);
                selectElem.prop('disabled', false);
            }
        }

        // Formatação em tempo real para o campo 'income'
        function formatCurrencyOnInput(event) {
            let value = event.target.value.replace(/[^0-9]/g, '');
            if (value) {
                value = (parseInt(value) / 100).toFixed(2);
                event.target.value = '$' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
            } else {
                event.target.value = '';
            }
        }

        function parseCurrency(value) {
            if (typeof value === 'string') {
                value = value.replace(/[^0-9.]/g, '');
            }
            return parseFloat(value) || 0;
        }

        // Validação principal (original)
        function validateMainMemberFields() {
            let isValid = true;

            const firstname = document.getElementById('firstname');
            if (!firstname.value.trim() || firstname.value.length < 3) {
                firstname.classList.add('is-invalid');
                isValid = false;
            } else {
                firstname.classList.remove('is-invalid');
            }

            const birthdate = document.getElementById('birthdate');
            if (!/^\d{2}\/\d{2}\/\d{4}$/.test(birthdate.value)) {
                birthdate.classList.add('is-invalid');
                isValid = false;
            } else {
                birthdate.classList.remove('is-invalid');
            }

            const sex = document.querySelector('input[name="sex"]:checked');
            if (!sex) {
                document.querySelectorAll('input[name="sex"]').forEach(input => input.classList.add('is-invalid'));
                isValid = false;
            } else {
                document.querySelectorAll('input[name="sex"]').forEach(input => input.classList.remove('is-invalid'));
            }

            const tobacco = document.querySelector('input[name="tobacco"]:checked');
            if (!tobacco) {
                document.querySelectorAll('input[name="tobacco"]').forEach(input => input.classList.add('is-invalid'));
                isValid = false;
            } else {
                document.querySelectorAll('input[name="tobacco"]').forEach(input => input.classList.remove('is-invalid'));
            }

            const income = document.getElementById('income');
            if (!income.value.trim() || isNaN(parseCurrency(income.value)) || parseCurrency(income.value) <= 0) {
                income.classList.add('is-invalid');
                isValid = false;
            } else {
                income.classList.remove('is-invalid');
            }

            const county = document.getElementById('county');
            if (!county.value.trim()) {
                county.classList.add('is-invalid');
                isValid = false;
            } else {
                county.classList.remove('is-invalid');
            }

            const zipcode = document.getElementById('zipcode');
            if (!zipcode.value.trim()) {
                zipcode.classList.add('is-invalid');
                isValid = false;
            } else {
                zipcode.classList.remove('is-invalid');
            }

            return isValid;
        }
</script>

@endsection
