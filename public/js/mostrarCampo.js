
document.addEventListener("DOMContentLoaded", function () {
    const showPhoneFields = document.getElementById('showPhoneFields');
    const hideButton = document.getElementById('hidePhoneFields');
    const phoneFields = document.getElementById('phoneFields');

    showPhoneFields.addEventListener('click', function (event) {
        event.preventDefault();

        phoneFields.style.display = 'flex'; // Mostra os campos
        showPhoneFields.style.display = 'none'; // Esconde o botão "Mostrar"
        hideButton.style.display = 'inline-block'; // Mostra o botão "Esconder"
    });

    hideButton.addEventListener('click', function (event) {
        event.preventDefault();

        phoneFields.style.display = 'none'; // Esconde os campos
        showPhoneFields.style.display = 'inline-block'; // Mostra o botão "Mostrar"
        hideButton.style.display = 'none'; // Esconde o botão "Esconder"
    });
});


// document.addEventListener("DOMContentLoaded", function () {
//     const showHouseholdYes = document.getElementById('showHouseholdYes');
//     const showHouseholdNo = document.getElementById('showHouseholdNo');
//     const impostoConjugetwo = document.getElementById('impostoConjugetwo');


//     showHouseholdYes.addEventListener('change', function () {
//         if (this.checked) {
//             impostoConjugetwo.style.display = 'flex';
//         }
//     });


//     showHouseholdNo.addEventListener('change', function () {
//         if (this.checked) {
//             impostoConjugetwo.style.display = 'none';
//         }
//     });

// });

document.addEventListener("DOMContentLoaded", function () {
    const showHouseholdYes = document.getElementById('showHouseholdYes');
    const showHouseholdNo = document.getElementById('showHouseholdNo');
    // const showHouseholdConjugeYes = document.getElementById('showHouseholdConjugeYes');
    const showHouseholdConjugeNo = document.getElementById('showHouseholdConjugeNo');
    const imposYou = document.getElementById('imposYou');

    showHouseholdYes.addEventListener('change', function () {
        if (this.checked) {
            imposYou.style.display = 'none';
        }
    });

    showHouseholdNo.addEventListener('change', function () {
        if (this.checked) {
            imposYou.style.display = 'none';
        }
    });

    // showHouseholdConjugeYes.addEventListener('change', function () {
    //     if (this.checked) {
    //         imposYou.style.display = 'none';
    //     }
    // });

    showHouseholdConjugeNo.addEventListener('change', function () {
        if (this.checked) {
            imposYou.style.display = 'flex';
        } else {
            imposYou.style.display = 'none';
        }
    });

});



// document.addEventListener("DOMContentLoaded", function () {
//     const showHouseholdConjugeYestwo = document.getElementById('showHouseholdConjugeYestwo');
//     const showHouseholdConjugeNotwo = document.getElementById('showHouseholdConjugeNotwo');
//     const impostoConjugethree = document.getElementById('impostoConjugethree');
//     const addDependente = document.getElementById('addDependente');

//     showHouseholdConjugeNotwo.addEventListener('change', function () {
//         if (this.checked) {
//             impostoConjuge.style.display = 'flex';
//         } else {
//             impostoConjuge.style.display = 'none';
//             addDependente.style.display = 'none';
//         }

//     });

//     showHouseholdConjugeYestwo.addEventListener('change', function () {
//         impostoConjuge.style.display = 'none';
//     });

//     showHouseholdConjugeYestwo.addEventListener('change', function () {
//         if (this.checked) {
//             impostoConjugethree.style.display = 'flex';
//         } else {
//             impostoConjugethree.style.display = 'none';
//         }
//     });

    showHouseholdConjugeNotwo.addEventListener('change', function () {
        impostoConjugethree.style.display = 'none';
    });



document.addEventListener("DOMContentLoaded", function () {
    const showHouseholdConjugeYesthree = document.getElementById('showHouseholdConjugeYesthree');
    const showHouseholdConjugeNothree = document.getElementById('showHouseholdConjugeNothree');
    const addDependente = document.getElementById('addDependente');

    showHouseholdConjugeYesthree.addEventListener('change', function () {
        if (this.checked) {
            addDependente.style.display = 'flex';
        } else {
            addDependente.style.display = 'none';
        }
    });

    showHouseholdConjugeNothree.addEventListener('change', function () {
        addDependente.style.display = 'none';
    });
});



document.addEventListener("DOMContentLoaded", function () {
    // const showHouseholdConjugeYes = document.getElementById('showHouseholdConjugeYes');
    const showHouseholdConjugeNo = document.getElementById('showHouseholdConjugeNo');
    const addDependente = document.getElementById('addDependente');

    showHouseholdConjugeYes.addEventListener('change', function () {
        if (this.checked) {
            addDependente.style.display = 'flex';
        } else {
            addDependente.style.display = 'none';
        }
    });

    showHouseholdConjugeNo.addEventListener('change', function () {
        addDependente.style.display = 'none';
    });
});



document.addEventListener("DOMContentLoaded", function () {
    const showHouseholdImposYouYes = document.getElementById('showHouseholdImposYouYes');
    const showHouseholdImposYouNo = document.getElementById('showHouseholdImposYouNo');
    const modaldemo9 = new bootstrap.Modal(document.getElementById('modaldemo9'));

    showHouseholdImposYouYes.addEventListener('change', function () {
        if (this.checked) {
            modaldemo9.show();
        } else {
            modaldemo9.hide();
        }
    });

    showHouseholdImposYouNo.addEventListener('change', function () {
        modaldemo9.hide();
    });
});


// document.addEventListener("DOMContentLoaded", function () {
//     const ssnToggle = document.getElementById('ssnToggle');
//     const ssnMaskContainer = document.getElementById('ssnMaskContainer');

//     ssnToggle.addEventListener('click', function (event) {
//         event.preventDefault();

//         if (ssnMaskContainer.style.display === 'none') {
//             ssnMaskContainer.style.display = 'block';
//         } else {
//             ssnMaskContainer.style.display = 'none';
//         }
//     });
// });




// document.addEventListener("DOMContentLoaded", function () {
//     const checkYesAddress = document.getElementById('checkYesAddress');
//     const checkNoAddress = document.getElementById('checkNoAddress');
//     const modalAddAddrres = new bootstrap.Modal(document.getElementById('modalAddAddrres'));

//     checkNoAddress.addEventListener('change', function () {
//         if (this.checked) {
//             modalAddAddrres.show();
//         } else {
//             modalAddAddrres.hide();
            
//         }
//     });

//     checkYesAddress.addEventListener('change', function () {
//         modalAddAddrres.hide();
//     });
// });

