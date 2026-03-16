document.addEventListener('DOMContentLoaded', function () {
    const documentoStatus = document.getElementById('documentoStatus');
    const fieldsMap = {
        "documentPermanentResidentCard": "greenCardFields",
        "documentTemporaryI551Stamp": "temporary",
        "documentReentryPermit": "reentry",
        "documentMRIVTempI551Lang": "machine",
        "documentEASI766": "employment",
        "documentArrivalDepartureRecI94I94A": "arrivalDepartureRecord",
        "documentArrivalDepartureRecUFPI94": "arrivalDepartureRecordPassport",
        "documentRTDI571": "refugeeTravel",
        "documentCENIF1I20": "certificateEligibility",
        "documentCEEVJ1DS2019": "certificateEligibilityExchange",
        "documentNAI797": "noticeAction",
        "documentUFPassport": "unexpiredForeign",
        "documentOANI94N": "otherDocumentWithAlien",
        "documentNoneOfThese": "noneOfThese"
    };

    // Função para verificar o valor inicial e ajustar os campos
    function initializeFields() {
        Object.keys(fieldsMap).forEach(documentKey => {
            const fieldId = fieldsMap[documentKey];
            const fieldElement = document.getElementById(fieldId);

            if (fieldElement) {
                const documentKeyValue = Object.keys(documentTypeMap).find(key => documentTypeMap[key] === documentKey);

                // Exibe ou oculta o campo com base no valor atual
                if (documentoStatus.value === documentKeyValue) {
                    fieldElement.style.display = 'block';
                } else {
                    fieldElement.style.display = 'none';
                }
            }
        });
    }

    // Inicializa os campos ao carregar
    initializeFields();

    // Atualiza dinamicamente ao mudar o valor do `documentoStatus`
    documentoStatus.addEventListener('change', function () {
        initializeFields();
    });
});
