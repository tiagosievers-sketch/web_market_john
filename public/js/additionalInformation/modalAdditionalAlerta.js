//Other family relationship
document.addEventListener("DOMContentLoaded", function () {
    const additional2checkYes = document.getElementById('additional2checkYes');
    const additional2checkNo = document.getElementById('additional2checkNo');
    const modalAdditionInformation = new bootstrap.Modal(document.getElementById('modalAdditionInformation'));

    // // Função para limpar os campos do modal
    // function clearModalFields() {
    //     document.getElementById('nameSpouseHouseholdTax').value = '';
    //     document.getElementById('middleSpouseHouseholdTax').value = '';
    //     document.getElementById('lastnameSpouseHouseholdTax').value = '';
    //     document.getElementById('suffixesSpouseHouseholdTax').value = '';
    //     document.getElementById('dateSpouseHouseholdTax').value = '';
    //     document.getElementById('sexesSpouseHouseholdTax').value = '';
    // }

    additional2checkYes.addEventListener('change', function () {
        if (this.checked) {
            modalAdditionInformation.show();
        } else {
            modalAdditionInformation.hide();
        }
    });

    additional2checkNo.addEventListener('change', function () {
        if (this.checked) {
            modalAdditionInformation.hide();
            // clearModalFields();  // Limpa os campos quando "Não" é selecionado
        }
    });
});


// //Children non Tax segunda tela
// document.addEventListener("DOMContentLoaded", function () {
//     const btnAddChildren = document.getElementById('btnAddChildren');
//     const modalChildrenTax = new bootstrap.Modal(document.getElementById('modalChildrenTax'));

//     // // Função para limpar os campos do modal
//     // function clearModalFields() {
//     //     document.getElementById('nameSpouseHouseholdTax').value = '';
//     //     document.getElementById('middleSpouseHouseholdTax').value = '';
//     //     document.getElementById('lastnameSpouseHouseholdTax').value = '';
//     //     document.getElementById('suffixesSpouseHouseholdTax').value = '';
//     //     document.getElementById('dateSpouseHouseholdTax').value = '';
//     //     document.getElementById('sexesSpouseHouseholdTax').value = '';
//     // }

//     btnAddChildren.addEventListener('change', function () {
//         if (this.checked) {
//             modalChildrenTax.show();
//         } else {
//             modalChildrenTax.hide();
//         }
//     });

//     // additional2checkNo.addEventListener('change', function () {
//     //     if (this.checked) {
//     //         modalChildrenTax.hide();
//     //         // clearModalFields();  // Limpa os campos quando "Não" é selecionado
//     //     }
//     // });
// });







