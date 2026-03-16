
document.addEventListener('DOMContentLoaded', function () {
    const documentoStatus = document.getElementById('documentoStatus');
    const greenCardFields = document.getElementById('greenCardFields');

    // Valor específico do `documentPermanentResidentCard` da variável PHP
    const greenCardKey = Object.keys(documentTypeMap).find(key => documentTypeMap[key] === "documentPermanentResidentCard");

    documentoStatus.addEventListener('change', function () {
        // Compara o valor selecionado com o valor específico para o campo "documentPermanentResidentCard"
        if (documentoStatus.value === greenCardKey) {
            greenCardFields.style.display = 'block';
        } else {
            greenCardFields.style.display = 'none';
        }
    });

    // Esconde inicialmente o campo do green card
    greenCardFields.style.display = 'none';
});


document.addEventListener('DOMContentLoaded', function () {
    const documentoStatus = document.getElementById('documentoStatus');
    const temporary = document.getElementById('temporary');

    // Valor específico do `documentTemporaryI551Stamp` da variável PHP
    const temporaryStampKey = Object.keys(documentTypeMap).find(key => documentTypeMap[key] === "documentTemporaryI551Stamp");

    documentoStatus.addEventListener('change', function () {
        // Compara o valor selecionado com o valor específico para o campo "documentTemporaryI551Stamp"
        if (documentoStatus.value === temporaryStampKey) {
            temporary.style.display = 'block';
        } else {
            temporary.style.display = 'none';
        }
    });

    // Esconde inicialmente o campo temporário
    temporary.style.display = 'none';
});


document.addEventListener('DOMContentLoaded', function () {
    const documentoStatus = document.getElementById('documentoStatus');
    const reentry = document.getElementById('reentry');

    // Valor específico do `documentReentryPermit` da variável PHP
    const reentryPermitKey = Object.keys(documentTypeMap).find(key => documentTypeMap[key] === "documentReentryPermit");

    documentoStatus.addEventListener('change', function () {
        // Compara o valor selecionado com o valor específico para o campo "documentReentryPermit"
        if (documentoStatus.value === reentryPermitKey) {
            reentry.style.display = 'block';
        } else {
            reentry.style.display = 'none';
        }
    });

    // Esconde inicialmente o campo de reentry
    reentry.style.display = 'none';
});


document.addEventListener('DOMContentLoaded', function () {
    const documentoStatus = document.getElementById('documentoStatus');
    const machine = document.getElementById('machine');

    // Valor específico do `documentMRIVTempI551Lang` da variável PHP
    const machineReadableVisaKey = Object.keys(documentTypeMap).find(key => documentTypeMap[key] === "documentMRIVTempI551Lang");

    documentoStatus.addEventListener('change', function () {
        // Compara o valor selecionado com o valor específico para o campo "documentMRIVTempI551Lang"
        if (documentoStatus.value === machineReadableVisaKey) {
            machine.style.display = 'block';
        } else {
            machine.style.display = 'none';
        }
    });

    // Esconde inicialmente o campo de machine readable visa
    machine.style.display = 'none';
});


document.addEventListener('DOMContentLoaded', function () {
    const documentoStatus = document.getElementById('documentoStatus');
    const employment = document.getElementById('employment');

    // Valor específico do `documentEASI766` da variável PHP
    const employmentAuthorizationKey = Object.keys(documentTypeMap).find(key => documentTypeMap[key] === "documentEASI766");

    documentoStatus.addEventListener('change', function () {
        // Compara o valor selecionado com o valor específico para o campo "documentEASI766"
        if (documentoStatus.value === employmentAuthorizationKey) {
            employment.style.display = 'block';
        } else {
            employment.style.display = 'none';
        }
    });

    // Esconde inicialmente o campo de employment authorization
    employment.style.display = 'none';
});


document.addEventListener('DOMContentLoaded', function () {
    const documentoStatus = document.getElementById('documentoStatus');
    const arrivalDepartureRecord = document.getElementById('arrivalDepartureRecord');

    // Valor específico do `documentArrivalDepartureRecI94I94A` da variável PHP
    const arrivalDepartureRecordKey = Object.keys(documentTypeMap).find(key => documentTypeMap[key] === "documentArrivalDepartureRecI94I94A");

    documentoStatus.addEventListener('change', function () {
        // Compara o valor selecionado com o valor específico para o campo "documentArrivalDepartureRecI94I94A"
        if (documentoStatus.value === arrivalDepartureRecordKey) {
            arrivalDepartureRecord.style.display = 'block';
        } else {
            arrivalDepartureRecord.style.display = 'none';
        }
    });

    // Esconde inicialmente o campo arrival/departure record
    arrivalDepartureRecord.style.display = 'none';
});



document.addEventListener('DOMContentLoaded', function () {
    const documentoStatus = document.getElementById('documentoStatus');
    const arrivalDepartureRecordPassport = document.getElementById('arrivalDepartureRecordPassport');

    // Valor específico do `documentArrivalDepartureRecUFPI94` da variável PHP
    const arrivalDepartureRecordPassportKey = Object.keys(documentTypeMap).find(key => documentTypeMap[key] === "documentArrivalDepartureRecUFPI94");

    documentoStatus.addEventListener('change', function () {
        // Compara o valor selecionado com o valor específico para o campo "documentArrivalDepartureRecUFPI94"
        if (documentoStatus.value === arrivalDepartureRecordPassportKey) {
            arrivalDepartureRecordPassport.style.display = 'block';
        } else {
            arrivalDepartureRecordPassport.style.display = 'none';
        }
    });

    // Esconde inicialmente o campo arrival/departure record in passport
    arrivalDepartureRecordPassport.style.display = 'none';
});



document.addEventListener('DOMContentLoaded', function () {
    const documentoStatus = document.getElementById('documentoStatus');
    const refugeeTravel = document.getElementById('refugeeTravel');

    // Valor específico do `documentRTDI571` da variável PHP
    const refugeeTravelKey = Object.keys(documentTypeMap).find(key => documentTypeMap[key] === "documentRTDI571");

    documentoStatus.addEventListener('change', function () {
        // Compara o valor selecionado com o valor específico para o campo "documentRTDI571"
        if (documentoStatus.value === refugeeTravelKey) {
            refugeeTravel.style.display = 'block';
        } else {
            refugeeTravel.style.display = 'none';
        }
    });

    // Esconde inicialmente o campo Refugee Travel Document
    refugeeTravel.style.display = 'none';
});



document.addEventListener('DOMContentLoaded', function () {
    const documentoStatus = document.getElementById('documentoStatus');
    const certificateEligibility = document.getElementById('certificateEligibility');

    // Valor específico do `documentCENIF1I20` da variável PHP
    const certificateEligibilityKey = Object.keys(documentTypeMap).find(key => documentTypeMap[key] === "documentCENIF1I20");

    documentoStatus.addEventListener('change', function () {
        // Compara o valor selecionado com o valor específico para o campo "documentCENIF1I20"
        if (documentoStatus.value === certificateEligibilityKey) {
            certificateEligibility.style.display = 'block';
        } else {
            certificateEligibility.style.display = 'none';
        }
    });

    // Esconde inicialmente o campo Certificate of Eligibility
    certificateEligibility.style.display = 'none';
});


document.addEventListener('DOMContentLoaded', function () {
    const documentoStatus = document.getElementById('documentoStatus');
    const certificateEligibilityExchange = document.getElementById('certificateEligibilityExchange');

    // Valor específico do `documentCEEVJ1DS2019` da variável PHP
    const certificateEligibilityExchangeKey = Object.keys(documentTypeMap).find(key => documentTypeMap[key] === "documentCEEVJ1DS2019");

    documentoStatus.addEventListener('change', function () {
        // Compara o valor selecionado com o valor específico para "documentCEEVJ1DS2019"
        if (documentoStatus.value === certificateEligibilityExchangeKey) {
            certificateEligibilityExchange.style.display = 'block';
        } else {
            certificateEligibilityExchange.style.display = 'none';
        }
    });

    // Esconde inicialmente o campo de Certificate of Eligibility Exchange
    certificateEligibilityExchange.style.display = 'none';
});


document.addEventListener('DOMContentLoaded', function () {
    const documentoStatus = document.getElementById('documentoStatus');
    const noticeAction = document.getElementById('noticeAction');

    // Valor específico do `documentNAI797` da variável PHP
    const noticeActionKey = Object.keys(documentTypeMap).find(key => documentTypeMap[key] === "documentNAI797");

    documentoStatus.addEventListener('change', function () {
        // Compara o valor selecionado com o valor específico para "documentNAI797"
        if (documentoStatus.value === noticeActionKey) {
            noticeAction.style.display = 'block';
        } else {
            noticeAction.style.display = 'none';
        }
    });

    // Esconde inicialmente o campo de Notice of Action
    noticeAction.style.display = 'none';
});



document.addEventListener('DOMContentLoaded', function () {
    const documentoStatus = document.getElementById('documentoStatus');
    const unexpiredForeign = document.getElementById('unexpiredForeign');

    // Valor específico do `documentUFPassport` da variável PHP
    const unexpiredForeignKey = Object.keys(documentTypeMap).find(key => documentTypeMap[key] === "documentUFPassport");

    documentoStatus.addEventListener('change', function () {
        // Compara o valor selecionado com o valor específico para "documentUFPassport"
        if (documentoStatus.value === unexpiredForeignKey) {
            unexpiredForeign.style.display = 'block';
        } else {
            unexpiredForeign.style.display = 'none';
        }
    });

    // Esconde inicialmente o campo de Unexpired Foreign Passport
    unexpiredForeign.style.display = 'none';
});



document.addEventListener('DOMContentLoaded', function () {
    const documentoStatus = document.getElementById('documentoStatus');
    const otherDocumentWithAlien = document.getElementById('otherDocumentWithAlien');

    // Valor específico do `documentOANI94N` da variável PHP
    const otherDocumentKey = Object.keys(documentTypeMap).find(key => documentTypeMap[key] === "documentOANI94N");

    documentoStatus.addEventListener('change', function () {
        // Compara o valor selecionado com o valor específico para "documentOANI94N"
        if (documentoStatus.value === otherDocumentKey) {
            otherDocumentWithAlien.style.display = 'block';
        } else {
            otherDocumentWithAlien.style.display = 'none';
        }
    });

    // Esconde inicialmente o campo para o outro documento com Alien/I-94
    otherDocumentWithAlien.style.display = 'none';
});



document.addEventListener('DOMContentLoaded', function () {
    const documentoStatus = document.getElementById('documentoStatus');
    const noneOfThese = document.getElementById('noneOfThese');

    // Valor específico do `documentNoneOfThese` da variável PHP
    const noneOfTheseKey = Object.keys(documentTypeMap).find(key => documentTypeMap[key] === "documentNoneOfThese");

    documentoStatus.addEventListener('change', function () {
        // Compara o valor selecionado com o valor específico para "documentNoneOfThese"
        if (documentoStatus.value === noneOfTheseKey) {
            noneOfThese.style.display = 'block';
        } else {
            noneOfThese.style.display = 'none';
        }
    });

    // Esconde inicialmente o campo "noneOfThese"
    noneOfThese.style.display = 'none';
});













