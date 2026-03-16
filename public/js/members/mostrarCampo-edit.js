//mostar campos 
document.addEventListener("DOMContentLoaded", function () {
    const checkYescigarro = document.getElementById('checkYescigarro');
    const checkNocigarro = document.getElementById('checkNocigarro');
    const fieldToShow = document.getElementById('fieldToShow');

    // Função para atualizar a visibilidade do campo
    function updateFieldVisibility() {
        if (checkYescigarro.checked) {
            fieldToShow.style.display = 'flex';
        } else {
            fieldToShow.style.display = 'none';
        }
    }

    // Chama a função inicialmente para ajustar a visibilidade com base no valor atual
    updateFieldVisibility();

    // Adiciona os ouvintes de eventos
    checkYescigarro.addEventListener('change', updateFieldVisibility);
    checkNocigarro.addEventListener('change', updateFieldVisibility);
});



document.addEventListener("DOMContentLoaded", function () {
    const checkYesamericano = document.getElementById('checkYesamericano');
    const checkNoamericano = document.getElementById('checkNoamericano');
    const editModalButton = document.getElementById('editModalButton');

    // Função para atualizar a visibilidade do botão
    function updateFieldVisibility() {
        if (checkNoamericano.checked) {
            editModalButton.style.display = 'block'; // Mostra o botão "Editar Dados"
        } else {
            editModalButton.style.display = 'none'; // Esconde o botão se "Yes" for marcado
        }
    }

    // Inicializa a visibilidade do botão sem abrir a modal
    updateFieldVisibility();

    // Adiciona eventos de mudança para os botões de rádio
    checkYesamericano.addEventListener('change', updateFieldVisibility);
    checkNoamericano.addEventListener('change', function () {
        updateFieldVisibility();

        // Abre a modal apenas quando "No" é marcado manualmente
        if (checkNoamericano.checked) {
            $('#ModalStatusImigracao').modal('show');
        }
    });

    // Abre a modal ao clicar no botão "Editar Dados"
    editModalButton.addEventListener('click', function () {
        $('#ModalStatusImigracao').modal('show');
    });
});



document.addEventListener("DOMContentLoaded", function () {
    const checkYesnomedocumento = document.getElementById('checkYesnomedocumento');
    const checkNonomedocumento = document.getElementById('checkNonomedocumento');

    checkYesnomedocumento.addEventListener('change', updateFieldVisibility);
    checkNonomedocumento.addEventListener('change', updateFieldVisibility);
});

document.addEventListener("DOMContentLoaded", function () {
    const checkYesmoranoeua = document.getElementById('checkYesnomedocumento');
    const checkNomoranoeua = document.getElementById('checkNomoranoeua');

    checkYesmoranoeua.addEventListener('change', updateFieldVisibility);
    checkNomoranoeua.addEventListener('change', updateFieldVisibility);
});


document.addEventListener("DOMContentLoaded", function () {
    const checkYesinformacoesEstudante = document.getElementById('checkYesinformacoesEstudante');
    const checkiNoinformacoesEstudante = document.getElementById('checkiNoinformacoesEstudante');

    function updateFieldVisibility() {
        if (checkYesinformacoesEstudante.checked) {
            sevisID.style.display = 'flex';
        } else {
            sevisID.style.display = 'none';
        }
    }

    checkYesinformacoesEstudante.addEventListener('change', updateFieldVisibility);
    checkiNoinformacoesEstudante.addEventListener('change', updateFieldVisibility);
});


document.addEventListener("DOMContentLoaded", function () {
    const checkYesinformacoesEstudanteArrival = document.getElementById('checkYesinformacoesEstudanteArrival');
    const checkiNoinformacoesEstudanteArrival = document.getElementById('checkiNoinformacoesEstudanteArrival');

    function updateFieldVisibility() {
        if (checkYesinformacoesEstudanteArrival.checked) {
            sevisIDArrival.style.display = 'flex';
        } else {
            sevisIDArrival.style.display = 'none';
        }
    }

    updateFieldVisibility();

    checkYesinformacoesEstudanteArrival.addEventListener('change', updateFieldVisibility);
    checkiNoinformacoesEstudanteArrival.addEventListener('change', updateFieldVisibility);
});


document.addEventListener("DOMContentLoaded", function () {
    const checkAlienNumber = document.getElementById('checkAlienNumber');
    const checkl94Number = document.getElementById('checkl94Number');

    function updateFieldVisibility() {
        if (checkAlienNumber.checked) {
            alienNumber.style.display = 'flex';
            l94Number.style.display = 'none';
        } else if (checkl94Number.checked) {
            l94Number.style.display = 'flex';
            alienNumber.style.display = 'none';

        }
    }

    checkAlienNumber.addEventListener('change', updateFieldVisibility);
    checkl94Number.addEventListener('change', updateFieldVisibility);
});


document.addEventListener("DOMContentLoaded", function () {
    const checkYesinformacoesPassaporte = document.getElementById('checkYesinformacoesPassaporte');
    const checkiNoinformacoesPassaporte = document.getElementById('checkiNoinformacoesPassaporte');

    function updateFieldVisibility() {
        if (checkYesinformacoesPassaporte.checked) {
            sevisIDPassaporte.style.display = 'flex';
        } else {
            sevisIDPassaporte.style.display = 'none';
        }
    }

    checkYesinformacoesPassaporte.addEventListener('change', updateFieldVisibility);
    checkiNoinformacoesPassaporte.addEventListener('change', updateFieldVisibility);
});



document.addEventListener("DOMContentLoaded", function () {
    const checkYesnomedocumento = document.getElementById('checkYesnomedocumento');
    const checkNonomedocumento = document.getElementById('checkNonomedocumento');

    function updateFieldVisibility() {
        if (checkNonomedocumento.checked) {
            documentFirstName.style.display = 'flex';
            documentMiddle.style.display = 'flex';
            documentLastName.style.display = 'flex';
            documentSuffix.style.display = 'flex';
            documentLabel.style.display = 'flex';

        } else {
            documentFirstName.style.display = 'none';
            documentMiddle.style.display = 'none';
            documentLastName.style.display = 'none';
            documentSuffix.style.display = 'none';
            documentLabel.style.display = 'none';

        }
    }
    updateFieldVisibility();


    checkYesnomedocumento.addEventListener('change', updateFieldVisibility);
    checkNonomedocumento.addEventListener('change', updateFieldVisibility);
});


document.addEventListener("DOMContentLoaded", function () {
    const checkYesencarcerado = document.getElementById('checkYesnomedocumento');
    const checkNoencarcerado = document.getElementById('checkNoencarcerado');

    checkYesencarcerado.addEventListener('change', updateFieldVisibility);
    checkNoencarcerado.addEventListener('change', updateFieldVisibility);
});


document.addEventListener("DOMContentLoaded", function () {
    const checkYesaguardandoDecisao = document.getElementById('checkYesnomedocumento');
    const checkNoaguardandoDecisao = document.getElementById('checkNoaguardandoDecisao');

    checkYesaguardandoDecisao.addEventListener('change', updateFieldVisibility);
    checkNoaguardandoDecisao.addEventListener('change', updateFieldVisibility);
});

document.addEventListener("DOMContentLoaded", function () {
    const checkYesorigem = document.getElementById('checkYesorigem');
    const checkNoorigem = document.getElementById('checkNoorigem');
    const checkNoAnswer = document.getElementById('checkNoAnswer');

    function updateFieldVisibility() {
        if (checkYesorigem.checked) {
            especificacaoTitulo.style.display = 'flex';
            entinia.style.display = 'flex';

        } else {
            especificacaoTitulo.style.display = 'none';
            entinia.style.display = 'none';

        }
    }

    updateFieldVisibility();

    checkYesorigem.addEventListener('change', updateFieldVisibility);
    checkNoorigem.addEventListener('change', updateFieldVisibility);
    checkNoAnswer.addEventListener('change', updateFieldVisibility);
});


document.addEventListener("DOMContentLoaded", function () {
    const checkYesindioAmericano = document.getElementById('checkYesindioAmericano');
    const checkNoindioAmericano = document.getElementById('checkNoindioAmericano');

    checkYesindioAmericano.addEventListener('change', updateFieldVisibility);
    checkNoindioAmericano.addEventListener('change', updateFieldVisibility);
});


document.addEventListener("DOMContentLoaded", function () {
    const checkStatusImigracaoLegivel = document.getElementById('checkStatusImigracaoLegivel');
    const documentoStatusWrapper = document.getElementById('documentoStatusWrapper');

    function updateFieldVisibility() {
        if (checkStatusImigracaoLegivel.checked) {
            documentoStatusWrapper.style.display = 'block'; 
        } else {
            documentoStatusWrapper.style.display = 'none';  
        }
    }
    checkStatusImigracaoLegivel.addEventListener('change', updateFieldVisibility);

    updateFieldVisibility();
});


document.addEventListener("DOMContentLoaded", function () { 
    // Seleciona os botões de rádio e o campo babiesExpectedField
    const isPregnantYes = document.getElementById('isPregnantYes');
    const isPregnantNo = document.getElementById('isPregnantNo');
    const babiesExpectedField = document.getElementById('babiesExpectedField');

    function updatePregnancyFieldVisibility() {
        // Verifica se o "Sim" está selecionado e mostra ou oculta o campo conforme o valor selecionado
        if (isPregnantYes.checked) {
            babiesExpectedField.style.display = 'flex';
        } else {
            babiesExpectedField.style.display = 'none';
        }
    }

    // Adiciona o evento `change` para os botões de rádio
    isPregnantYes.addEventListener('change', updatePregnancyFieldVisibility);
    isPregnantNo.addEventListener('change', updatePregnancyFieldVisibility);

    // Chama a função no carregamento inicial para garantir a visibilidade correta do campo
    updatePregnancyFieldVisibility();
});










