//Modal Income JS YEs
document.addEventListener("DOMContentLoaded", function () {
    const incomecheckYes = document.getElementById('incomecheckYes');
    const incomecheckNo = document.getElementById('incomecheckNo');
    const modalIncomeType = new bootstrap.Modal(document.getElementById('modalIncomeType'));


    incomecheckYes.addEventListener('change', function () {
        if (this.checked) {
            modalIncomeType.show();
        } else {
            modalIncomeType.hide();
        }
    });

    incomecheckNo.addEventListener('change', function () {
        if (this.checked) {
            modalIncomeType.hide();
            // clearModalFields();  // Limpa os campos quando "Não" é selecionado
        }
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const checkYesapplyingYes = document.getElementById('checkYesapplyingYes');
    const checkYesapplyingNo = document.getElementById('checkYesapplyingNo');
    const bntAddDeduction = document.getElementById('bntAddDeduction');

    checkYesapplyingYes.addEventListener('change', function () {
        if (this.checked) {
            bntAddDeduction.style.display = 'block';
        } else {
            bntAddDeduction.style.display = 'none';
        }
    });

    checkYesapplyingNo.addEventListener('change', function () {
        if (this.checked) {
            bntAddDeduction.style.display = 'none';
        } else {
            bntAddDeduction.style.display = 'block';
        }
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const typeIncomeDeductionsSelect = document.getElementById('typeIncomeDeductionsSelect');
    const otherDeductionType = document.getElementById('otherDeductionType');

    typeIncomeDeductionsSelect.addEventListener('change', function () {
        const selectedOptionText = this.options[this.selectedIndex].text; 
        if (selectedOptionText === 'Other') { 
            otherDeductionType.style.display = 'block'; 
        } else {
            otherDeductionType.style.display = 'none'; 
        }
    });
});


document.addEventListener("DOMContentLoaded", function () {
    const typeIncomeDeductionsSelect = document.getElementById('typeIncomeDeductionsSelect');
    const alimonyMsg3 = document.getElementById('alimonyMsg3');

    typeIncomeDeductionsSelect.addEventListener('change', function () {
        const selectedOptionText = this.options[this.selectedIndex].text; 
        if (selectedOptionText === 'Alimony') { 
            alimonyMsg3.style.display = 'block'; 
        } else {
            alimonyMsg3.style.display = 'none'; 
        }
    });
});



document.addEventListener("DOMContentLoaded", function () {
    const bntAddDeduction = document.getElementById('bntAddDeduction');
    const modalIncomeDeductions = new bootstrap.Modal(document.getElementById('modalIncomeDeductions'));

    bntAddDeduction.addEventListener('click', function () {
        modalIncomeDeductions.show();
    });
});



//Modal 3question no 
document.addEventListener("DOMContentLoaded", function () {
    const checkYesIncomeYes = document.getElementById('checkYesIncomeYes');
    const checkYesIncomeNo = document.getElementById('checkYesIncomeNo');
    const yearlyIncomeModal = new bootstrap.Modal(document.getElementById('yearlyIncomeModal'));


    checkYesIncomeYes.addEventListener('change', function () {
        if (this.checked) {
            yearlyIncomeModal.hide();
        }
    });

    checkYesIncomeNo.addEventListener('change', function () {
        if (this.checked) {
            yearlyIncomeModal.show();
            // clearModalFields();  // Limpa os campos quando "Não" é selecionado
        }
    });
});


document.addEventListener("DOMContentLoaded", function () {
    const checkYesIncomeModalYes = document.getElementById('checkYesIncomeModalYes');
    const checkYesIncomeModalNo = document.getElementById('checkYesIncomeModalNo');
    const amountModal3 = document.getElementById('amountModal3');
    const modal3PredictMsg = document.getElementById('modal3PredictMsg');
    const modal3PredictMsg2 = document.getElementById('modal3PredictMsg2');

    checkYesIncomeModalYes.addEventListener('change', function () {
        if (this.checked) {
            // Mostrar mensagens e quantidade para "Yes"
            amountModal3.style.display = 'block';
            modal3PredictMsg.style.display = 'block';
            // Esconder mensagens de "No"
            modal3PredictMsg2.style.display = 'none';
        }
    });

    checkYesIncomeModalNo.addEventListener('change', function () {
        if (this.checked) {
            // Mostrar mensagens e quantidade para "No"
            amountModal3.style.display = 'block';
            modal3PredictMsg2.style.display = 'block';
            // Esconder mensagens de "Yes"
            modal3PredictMsg.style.display = 'none';
        }
    });
});



document.addEventListener("DOMContentLoaded", function () {
    const selectIncomeType = document.getElementById('typeIncomeSelect');

    // Mapeamento de cada tipo de renda com os IDs dos elementos que devem ser exibidos
    const incomeTypeMapping = {
        'Job': ['regularPayIncome', 'employerNameOcult', 'phoneOcult'],
        'Self-Employment': ['selfEmploymentMsg', 'selfEmploymentMsg2', 'typeOfWorkOcult'],
        'Unemployment': ['unemploymentMsg', 'unemployment', 'employeBenefitsOcult'],
        'Alimony': ['alimonyMsg', 'alimonyMsg2'],
        'Social Security': ['socialSecurityMsg'],
        'Retirement': ['retirementMsg'],
        'Pension': ['pensionMsg'],
        'Cash support': ['cashSupportMsg'],
        'Capital Gains': ['capitalGainsMsg'],
        'Investment': ['investimentMsg', 'investimentMsg2'],
        'Rental or royalty': ['rentalOrRoaltyMsg'],
        'Scholarship': ['scholarshipMsg', 'scholarshipMsg2', 'scholarshipAmountOcult', 'scholarshipAmountOcult2'],
        'Prize, award, or gambling': ['prizeMsg'],
        'Count awards': ['countAwardsMsg'],
        'Jury duty pay': ['juryDutyPayMsg', 'juryDutyPayMsg2'],
        'Canceled Debt': ['canceledDebpMsg'],
        'Farming or fishing': ['farmingOrFishingMsg'],
        'Other income': ['otherIncomeType', 'otherIncomeMsg']
    };

    // Exibir o campo de Amount e How Often por padrão
    const amountField = document.getElementById('amount3').parentElement;
    // const oftenSelectField = document.getElementById('oftenSelect').parentElement;
    // amountField.style.display = 'block';
    // oftenSelectField.style.display = 'block';

    selectIncomeType.addEventListener('change', function () {
        const selectedText = selectIncomeType.options[selectIncomeType.selectedIndex].text;
        console.log('Selected Text:', selectedText);

        // Oculta todos os elementos mapeados
        Object.values(incomeTypeMapping).flat().forEach(id => {
            const element = document.getElementById(id);
            if (element) {
                element.style.display = 'none';
            }
        });

        // Exibe apenas os elementos mapeados para o tipo selecionado
        if (incomeTypeMapping[selectedText]) {
            incomeTypeMapping[selectedText].forEach(id => {
                const element = document.getElementById(id);
                if (element) {
                    element.style.display = 'block';
                }
            });
        } else {
            console.log("Nenhum elemento relevante para exibir para o texto selecionado.");
        }

        // Esconde os campos Amount e How Often apenas para Scholarship
        if (selectedText === 'Scholarship') {
            amountField.style.display = 'none';
            //oftenSelectField.style.display = 'none';
        } else {
            amountField.style.display = 'block';
            //oftenSelectField.style.display = 'block';
        }
    });
});
