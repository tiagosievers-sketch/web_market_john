// // Valida os campos da aba yourInformation
// function validateYourInformation() {
//     let isValid = true;
//     let requiredFields = ['firstname', 'lastname', 'birthdate', 'sex', 'ssn'];
    
//     requiredFields.forEach(function(fieldId) {
//         let field = document.getElementById(fieldId);
//         if (field && !field.value.trim()) {
//             field.classList.add('is-invalid');
//             isValid = false;
//         } else {
//             field.classList.remove('is-invalid');
//         }
//     });

//     return isValid;
// }

// // Valida os campos da aba homeAddress
// function validateHomeAddress() {
//     let isValid = true;
//     let requiredFields = ['street_address', 'city', 'state', 'zipcode'];
    
//     requiredFields.forEach(function(fieldId) {
//         let field = document.getElementById(fieldId);
//         if (field && !field.value.trim()) {
//             field.classList.add('is-invalid');
//             isValid = false;
//         } else {
//             field.classList.remove('is-invalid');
//         }
//     });

//     return isValid;
// }

// // Valida os campos da aba contactDetails
// function validateContactDetails() {
//     let isValid = true;
//     let requiredFields = ['phone', 'extension', 'type', 'written_lang', 'spoken_lang'];
    
//     requiredFields.forEach(function(fieldId) {
//         let field = document.getElementById(fieldId);
//         if (field && !field.value.trim()) {
//             field.classList.add('is-invalid');
//             isValid = false;
//         } else {
//             field.classList.remove('is-invalid');
//         }
//     });

//     return isValid;
// }


// function openTab(evt, tabName) {
//     // Verifica qual aba estamos tentando acessar e valida a aba anterior
//     if (tabName === 'homeAddres') {
//         if (!validateYourInformation()) {
//             alert('Preencha todos os campos obrigatórios na aba de informações pessoais.');
//             return;
//         }
//     } else if (tabName === 'contactDetails') {
//         if (!validateHomeAddress()) {
//             alert('Preencha todos os campos obrigatórios na aba de endereço.');
//             return;
//         }
//     }

//     // Oculta todas as abas
//     let tabcontent = document.getElementsByClassName("tabcontent");
//     for (let i = 0; i < tabcontent.length; i++) {
//         tabcontent[i].style.display = "none";
//     }

//     // Remove a classe 'active' de todos os botões
//     let tablinks = document.getElementsByClassName("tablinks");
//     for (let i = 0; i < tablinks.length; i++) {
//         tablinks[i].className = tablinks[i].className.replace(" active", "");
//     }

//     // Exibe a aba selecionada e adiciona a classe 'active' ao botão correspondente
//     document.getElementById(tabName).style.display = "block";
//     evt.currentTarget.className += " active";
// }


// document.getElementById("btnContinue").addEventListener("click", function (e) {
//     if (validateYourInformation()) {
//         document.getElementById("tabHomeAddress").click();
//     } else {
//         e.preventDefault(); // Previne o comportamento padrão se a validação falhar
//     }
// });

// document.getElementById("btnContinueTwo").addEventListener("click", function (e) {
//     if (validateHomeAddress()) {
//         document.getElementById("tabcontactDetails").click();
//     } else {
//         e.preventDefault();
//     }
// });

// document.getElementById("btnBack").addEventListener("click", function () {
//     document.getElementById("tabYourInformation").click();
// });

// document.getElementById("btnBackTwo").addEventListener("click", function () {
//     document.getElementById("tabHomeAddress").click();
// });
