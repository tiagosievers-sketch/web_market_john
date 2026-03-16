document.addEventListener('DOMContentLoaded', function () {
    // Função para exibir/ocultar elementos com base no estado inicial
    function toggleDisplay(element, show) {
        if (element) {
            element.style.display = show ? 'block' : 'none';
        }
    }

    // Gerenciar exibição inicial e eventos para a terceira pergunta
    document.querySelectorAll('input[name^="thirdQuestion"]').forEach(function (checkbox) {
        const memberId = checkbox.getAttribute('data-member-id');
        const additionalCoverageQt = document.getElementById(`additionalCoverageQt_${memberId}`);
        const lastDayCoverageOcult = document.getElementById(`lastDayCoverageOcult_${memberId}`);

        // Exibição inicial - apenas se estiver marcado
        toggleDisplay(additionalCoverageQt, checkbox.checked);

        // Adicionar eventos
        checkbox.addEventListener('change', function () {
            const isChecked = this.checked;
            toggleDisplay(additionalCoverageQt, isChecked);

            if (!isChecked) {
                toggleDisplay(lastDayCoverageOcult, false);
                document.querySelectorAll(`input[name="additionalCheck_${memberId}"]`).forEach(function (radio) {
                    radio.checked = true;
                });
            }
        });
    });

    // Controle inicial e eventos para radios adicionais da terceira pergunta
    document.querySelectorAll('.additional-check').forEach(function (radio) {
        const memberId = radio.getAttribute('data-member-id');
        const lastDayCoverageOcult = document.getElementById(`lastDayCoverageOcult_${memberId}`);

        // Exibição inicial - apenas se o radio estiver marcado como "No"
        toggleDisplay(lastDayCoverageOcult, radio.checked && radio.value === '0');

        // Adicionar eventos
        radio.addEventListener('change', function () {
            toggleDisplay(lastDayCoverageOcult, this.value === '0');
        });
    });

    // Gerenciar exibição inicial e eventos para a quarta pergunta
    document.querySelectorAll('input[name^="fourthQuestion"]').forEach(function (checkbox) {
        const memberId = checkbox.getAttribute('data-member-id');
        const coverageMedicaidOcult = document.getElementById(`coverageMedicaidOcult_${memberId}`);

        // Exibição inicial - apenas se estiver marcado
        toggleDisplay(coverageMedicaidOcult, checkbox.checked);

        // Adicionar eventos
        checkbox.addEventListener('change', function () {
            const isChecked = this.checked;
            toggleDisplay(coverageMedicaidOcult, isChecked);

            if (!isChecked) {
                document.getElementById(`coverageBetweenAdicional_${memberId}`).checked = false;
                document.getElementById(`applyMarketplaceAdicional_${memberId}`).checked = false;
                document.getElementById(`dentedCoverageAdditionalDate_${memberId}`).value = '';
            }
        });
    });

    // Gerenciar exibição inicial e eventos para applyMarketplaceSection
    document.querySelectorAll('.applyMarketplaceCheckbox').forEach(function (checkbox) {
        const memberId = checkbox.getAttribute('data-member-id');
        const applyMarketplaceSection = document.getElementById(`applyMarketplaceSection_${memberId}`);

        // Exibição inicial - apenas se o checkbox estiver marcado
        toggleDisplay(applyMarketplaceSection, checkbox.checked);

        // Adicionar eventos
        checkbox.addEventListener('change', function () {
            toggleDisplay(applyMarketplaceSection, this.checked);
        });
    });
});
