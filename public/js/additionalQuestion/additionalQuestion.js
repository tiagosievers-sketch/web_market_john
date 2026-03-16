document.addEventListener('DOMContentLoaded', function () {
    // Evento de clique para a terceira pergunta - exibe campos adicionais para cada membro
    document.querySelectorAll('input[name^="thirdQuestion"]').forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
            const memberId = this.getAttribute('data-member-id');
            const additionalCoverageQt = document.getElementById(`additionalCoverageQt_${memberId}`);
            if (this.checked) {
                additionalCoverageQt.style.display = 'block';
            } else {
                additionalCoverageQt.style.display = 'none';
                document.getElementById(`lastDayCoverageOcult_${memberId}`).style.display = 'none';
                document.querySelectorAll(`input[name="additionalCheck_${memberId}"]`).forEach(function (radio) {
                    radio.checked = false;
                });
            }
        });
    });

    // Controle dos radios para a terceira pergunta - exibe o campo lastDayCoverageOcult
    document.querySelectorAll('.additional-check').forEach(function (radio) {
        radio.addEventListener('change', function () {
            const memberId = this.getAttribute('data-member-id');
            const lastDayCoverageOcult = document.getElementById(`lastDayCoverageOcult_${memberId}`);
            if (this.value === '0') { // Se "No" foi selecionado
                lastDayCoverageOcult.style.display = 'block';
            } else { // Se "Yes" foi selecionado
                lastDayCoverageOcult.style.display = 'none';
            }
        });
    });

    // Evento de clique para a quarta pergunta - exibe campos adicionais para cada membro
    document.querySelectorAll('input[name^="fourthQuestion"]').forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
            const memberId = this.getAttribute('data-member-id');
            const coverageMedicaidOcult = document.getElementById(`coverageMedicaidOcult_${memberId}`);
            if (this.checked) {
                coverageMedicaidOcult.style.display = 'block';
            } else {
                coverageMedicaidOcult.style.display = 'none';
                document.getElementById(`coverageBetweenAdicional_${memberId}`).checked = false;
                document.getElementById(`applyMarketplaceAdicional_${memberId}`).checked = false;
                document.getElementById(`dentedCoverageAdditionalDate_${memberId}`).value = '';
            }
        });
    });

    // Controle do campo applyMarketplaceSection para a quarta pergunta - controla a exibição independente
    document.querySelectorAll('.applyMarketplaceCheckbox').forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
            const memberId = this.getAttribute('data-member-id');
            const applyMarketplaceSection = document.getElementById(`applyMarketplaceSection_${memberId}`);
            applyMarketplaceSection.style.display = this.checked ? 'block' : 'none';
        });
    });
});
