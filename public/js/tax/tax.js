document.addEventListener("DOMContentLoaded", function() {
    // Simula o clique na aba "Tax Household" para abrir automaticamente
    document.getElementById("tabTaxHousehold").click();
});

document.addEventListener("DOMContentLoaded", function () {
    // Modal dependentes
    const modalDemo9 = new bootstrap.Modal(document.getElementById('modaldemo9'));
    const dependentRadios = document.querySelectorAll('input[name="dependent"]');
    dependentRadios.forEach(radio => {
        radio.addEventListener('change', function () {
            if (this.value === '1') {
                modalDemo9.show();
            } else {
                modalDemo9.hide();
            }
        });
    });

    // Pergunta 1 - Mostrar modal spouse
    const checkYesMarried = document.getElementById('checkYesMarried');
    const checkNoMarried = document.getElementById('checkNoMarried');
    const spouseSection = document.getElementById('spouseSection');

    checkYesMarried.addEventListener('change', function (event) {
        event.preventDefault();
        spouseSection.style.display = 'block';
    });

    checkNoMarried.addEventListener('change', function (event) {
        event.preventDefault();
        spouseSection.style.display = 'none';
    });

    // Pergunta 3 - Mostrar imposto conjugado
    const impostoConjugetwo = document.getElementById('impostoConjugetwo');
    const incomeTaxRadios = document.querySelectorAll('input[name="incomeTax"]');
    incomeTaxRadios.forEach(radio => {
        radio.addEventListener('change', function () {
            if (this.value === '1') {
                impostoConjugetwo.style.display = 'block';
            } else {
                impostoConjugetwo.style.display = 'none';
            }
        });
    });

    // Pergunta 4 - Dependentes no imposto
    const dependentSection = document.getElementById('dependentSection');
    const showHouseholdConjugeThree = document.querySelectorAll('input[name="showHouseholdConjugeThree"]');
    showHouseholdConjugeThree.forEach(radio => {
        radio.addEventListener('change', function () {
            if (this.value === '1') {
                dependentSection.style.display = 'block';
                dependentSectionBtnAdd.style.display = 'block';

            } else {
                dependentSection.style.display = 'none';
                dependentSectionTest.style.display = 'none';
                dependentSectionBtnAdd.style.display = 'none';
            }
        });
    });

    // Pergunta - Mostrar campos conjugados e dependentes
    const impostoConjugethree = document.getElementById('impostoConjugethree');
    const taxedspouses = document.querySelectorAll('input[name="taxedspouse"]');
    const dependentSection4Pergunta = document.getElementById('dependentSection4Pergunta');

    taxedspouses.forEach(radio => {
        radio.addEventListener('change', function () {
            if (this.value === '1') {
                impostoConjugethree.style.display = 'block';
                impostoConjuge.style.display = 'none';
                imposYou.style.display = 'none';
            } else {
                impostoConjugethree.style.display = 'none';
                impostoConjuge.style.display = 'block';
            }
        });
    });

    // Pergunta - Mostrar dependentes ou imposto
    const showHouseholdConjugeYes = document.getElementById('showHouseholdConjugeYes');
    const showHouseholdConjugeNo = document.getElementById('showHouseholdConjugeNo');
    const addDependente = document.getElementById('addDependente');
    const imposYou = document.getElementById('imposYou');
    showHouseholdConjugeYes.addEventListener('change', function () {
        addDependente.style.display = 'flex';
        imposYou.style.display = 'none';
        dependentSection4Pergunta.style.display = 'block';

    });
    showHouseholdConjugeNo.addEventListener('change', function () {
        addDependente.style.display = 'none';
        imposYou.style.display = 'block';
        dependentSection4Pergunta.style.display = 'none';
    });
});




//validacao da spouse

$(document).ready(function() {
    // Remova esta linha, pois já estamos chamando addhouseholdSpouse na função de validação
    // $('#saveSpouseBtn').on('click', function(e) {
    //    e.preventDefault();
    //    addhouseholdSpouse(0);
    //    $('#modalAddSpouse').modal('hide');
    // });

    // A função que valida e só chama addhouseholdSpouse se a validação estiver ok
    const requiredFields = ['nameSpouse', 'lastnameSpouse', 'birthdateSpouse', 'sexSpouse'];
    const saveButton = document.getElementById('saveSpouseBtn');

    function validateSpouseFields() {
        let isValid = true;

        // Valida os campos de texto
        requiredFields.forEach(function (fieldId) {
            let field = document.getElementById(fieldId);
            if (field && !field.value.trim()) {
                field.classList.add('is-invalid');
                isValid = false;
            } else {
                field.classList.remove('is-invalid');
            }
        });

        // Valida os radio buttons de "lives with you"
        let livesWithSpouseChecked = document.querySelector('input[name="liveswithyouSpouse"]:checked');
        if (!livesWithSpouseChecked) {
            document.querySelectorAll('input[name="liveswithyouSpouse"]').forEach(function (radio) {
                radio.classList.add('is-invalid');
            });
            isValid = false;
        } else {
            document.querySelectorAll('input[name="liveswithyouSpouse"]').forEach(function (radio) {
                radio.classList.remove('is-invalid');
            });
        }

        // Habilita ou desabilita o botão
        saveButton.disabled = !isValid;

        return isValid;
    }

    // Adiciona eventos de input e change nos campos para verificar a validação em tempo real
    requiredFields.forEach(function (fieldId) {
        let field = document.getElementById(fieldId);
        if (field) {
            field.addEventListener('input', validateSpouseFields);
        }
    });

    document.querySelectorAll('input[name="liveswithyouSpouse"]').forEach(function (radio) {
        radio.addEventListener('change', validateSpouseFields);
    });

    // Evento de clique no botão de salvar, verifica a validação antes de prosseguir
    saveButton.addEventListener('click', function (e) {
        e.preventDefault(); // Impede o fechamento imediato da modal

        if (validateSpouseFields()) {
            // Se a validação passar, faça a ação de adicionar o cônjuge e feche a modal
            addhouseholdSpouse(0);
            $('#modalAddSpouse').modal('hide');
        } else {
            alert('Por favor, preencha todos os campos obrigatórios.');
        }
    });

    // Validação inicial para desabilitar o botão no início
    validateSpouseFields();
});



//validacao add another person

$(document).ready(function() {
    const requiredFieldsPerson = ['namePerson', 'lastnamePerson', 'birthdatePerson', 'sexPerson', 'relationshipPerson'];
    const savePersonButton = document.getElementById('savePersonBtn');
    const livesWithYouContainer = document.querySelector('.row.mb-3.ml-3'); // Container do grupo de radio buttons

    // Função para validar os campos obrigatórios
    function validatePersonFields() {
        let isValid = true;

        // Valida os campos de texto
        requiredFieldsPerson.forEach(function(fieldId) {
            let field = document.getElementById(fieldId);
            if (field && !field.value.trim()) {
                field.classList.add('is-invalid');  // Adiciona borda vermelha ao campo vazio
                isValid = false;
            } else {
                field.classList.remove('is-invalid');  // Remove borda vermelha se preenchido
            }
        });

        // Valida os radio buttons de "lives with you"
        let livesWithPersonChecked = document.querySelector('input[name="liveswithyouPerson"]:checked');
        if (!livesWithPersonChecked) {
            // Adiciona borda vermelha ao container dos radio buttons
            livesWithYouContainer.classList.add('border', 'border-danger');
            isValid = false;
        } else {
            // Remove a borda vermelha se um radio button for selecionado
            livesWithYouContainer.classList.remove('border', 'border-danger');
        }

        // Habilita ou desabilita o botão dependendo da validação
        savePersonButton.disabled = !isValid;
        return isValid;
    }

    // Adiciona eventos de input e change nos campos para verificar a validação em tempo real
    requiredFieldsPerson.forEach(function(fieldId) {
        let field = document.getElementById(fieldId);
        if (field) {
            field.addEventListener('input', validatePersonFields);
        }
    });

    document.querySelectorAll('input[name="liveswithyouPerson"]').forEach(function(radio) {
        radio.addEventListener('change', validatePersonFields);
    });

    // Evento de clique no botão de salvar, verifica a validação antes de prosseguir
    savePersonButton.addEventListener('click', function(e) {
        e.preventDefault(); // Impede o fechamento imediato da modal

        if (validatePersonFields()) {
            // Se a validação passar, faça a ação de adicionar a pessoa e feche a modal
            addhouseholdPerson(0);
            $('#modaldemoAddAnotherPerson').modal('hide');
        } else {
            console.log('Por favor, preencha todos os campos obrigatórios.');

        }
    });

    // Validação inicial para desabilitar o botão no início
    validatePersonFields();
});




//validacao da modal com pergunta:document.addEventListener("DOMContentLoaded", function () {
 
document.addEventListener("DOMContentLoaded", function () {
    const addDependentButton = document.getElementById('addDependentbtn');
    const requiredFields = [
        'nameDependents',
        'lastnameDependents',
        'dateDependents',
        'sexoDependents',
        'relationshipsDependentsSomeone'
    ];

    // Desabilita o botão inicialmente
    addDependentButton.disabled = true;

    // Função para verificar se todos os campos obrigatórios estão preenchidos
    function validateDependentFields() {
        let isValid = true;

        requiredFields.forEach(function (fieldId) {
            const field = document.getElementById(fieldId);

            // Verifica se o campo está vazio
            if (!field.value.trim()) {
                field.classList.add('is-invalid'); // Adiciona borda vermelha
                isValid = false;
            } else {
                field.classList.remove('is-invalid'); // Remove borda vermelha se estiver preenchido
            }
        });

        // Verifica se o rádio "Sim" ou "Não" está selecionado
        const livesWithYouRadio = document.querySelector('input[name="liveswithyouSomeone"]:checked');
        if (!livesWithYouRadio) {
            isValid = false;
            document.querySelector('input[name="liveswithyouSomeone"]').closest('.input-group').classList.add('is-invalid');
        } else {
            document.querySelector('input[name="liveswithyouSomeone"]').closest('.input-group').classList.remove('is-invalid');
        }

        // Habilita ou desabilita o botão com base na validade dos campos
        addDependentButton.disabled = !isValid;

        return isValid;
    }

    // Adiciona eventos de input para verificar os campos conforme o usuário digita ou seleciona
    requiredFields.forEach(function (fieldId) {
        const field = document.getElementById(fieldId);
        field.addEventListener('input', validateDependentFields);
    });

    // Verifica se o rádio "Sim" ou "Não" foi selecionado
    const livesWithYouRadios = document.querySelectorAll('input[name="liveswithyouSomeone"]');
    livesWithYouRadios.forEach(function (radio) {
        radio.addEventListener('change', validateDependentFields);
    });

    // Quando o botão "Adicionar Dependente" for clicado
    addDependentButton.addEventListener('click', function (e) {
        e.preventDefault();
        if (validateDependentFields()) {
            // Se todos os campos estiverem válidos, faça a ação de adicionar o dependente
            addhouseholdDependent(0);
            $('#modalDemoAddDependents').modal('hide');
        }
    });
});


//validacao modal adddependenttax na modal sexta pergunta, will be...


document.addEventListener('DOMContentLoaded', function () {
    const addDependentButtonTax = document.getElementById('addDependentTexbtn');
    const requiredFieldsTax = [
        'nameDependentTax',
        'lastnameDependentTax',
        'dateDependentTax',
        'sexesDependentTax',
        'relationshipsDependentTax'
    ];

    const checkboxReclamante = document.querySelector('input[name="reclamanteimposto"]');

    // Função para verificar se todos os campos obrigatórios estão preenchidos
    function validateDependentTaxFields() {
        let isValid = true;

        // Se o checkbox "reclamanteimposto" estiver marcado, valida os campos
        if (checkboxReclamante.checked) {
            requiredFieldsTax.forEach(function (fieldId) {
                const field = document.getElementById(fieldId);

                // Verifica se o campo está vazio
                if (!field.value.trim()) {
                    field.classList.add('is-invalid'); // Adiciona borda vermelha
                    isValid = false;
                } else {
                    field.classList.remove('is-invalid'); // Remove borda vermelha se estiver preenchido
                }
            });

            // Verifica se o rádio "Sim" ou "Não" está selecionado
            const livesWithYouRadio = document.querySelector('input[name="liveswithyouTax"]:checked');
            if (!livesWithYouRadio) {
                isValid = false;
                document.querySelector('input[name="liveswithyouTax"]').closest('.input-group').classList.add('is-invalid');
            } else {
                document.querySelector('input[name="liveswithyouTax"]').closest('.input-group').classList.remove('is-invalid');
            }
        }

        // Habilita o botão se os campos forem válidos, ou se o checkbox não estiver marcado
        addDependentButtonTax.disabled = checkboxReclamante.checked && !isValid;

        return isValid;
    }

    // Adiciona eventos de input para verificar os campos conforme o usuário digita ou seleciona
    requiredFieldsTax.forEach(function (fieldId) {
        const field = document.getElementById(fieldId);
        field.addEventListener('input', validateDependentTaxFields);
    });

    // Verifica se o rádio "Sim" ou "Não" foi selecionado
    const livesWithYouRadiosTax = document.querySelectorAll('input[name="liveswithyouTax"]');
    livesWithYouRadiosTax.forEach(function (radio) {
        radio.addEventListener('change', validateDependentTaxFields);
    });

    // Monitora o estado do checkbox "reclamanteimposto"
    checkboxReclamante.addEventListener('change', function () {
        validateDependentTaxFields(); // Valida os campos quando o checkbox for marcado/desmarcado
    });

    // Quando o botão "Adicionar Dependente" for clicado
    addDependentButtonTax.addEventListener('click', function (e) {
        e.preventDefault();
        if (validateDependentTaxFields()) {
            // Se todos os campos estiverem válidos, faça a ação de adicionar o dependente
            addhouseholdDependentTax(1);
            $('#modaldemo9').modal('hide');
        } else {
            alert("{{ __('labels.obrigatorio') }}"); // Exibe uma mensagem se os campos obrigatórios não estiverem preenchidos
        }
    });
});
