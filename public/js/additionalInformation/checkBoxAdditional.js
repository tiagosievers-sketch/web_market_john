$(document).ready(function () {
    // Adiciona um evento de clique aos campos de rádio
    $('input[type="radio"][name="additionalInformationcheckYes"]').click(function () {
        // Atualiza o valor do campo oculto baseado no botão de rádio selecionado
        // let selectedValue = $(this).val();
        // $('input[name="eligible_cost_saving"]').val(selectedValue);
        
    });

});




document.addEventListener("DOMContentLoaded", function () {
    const additionalInformationcheckYes = document.getElementById('additionalInformationcheckYes');
    const additionalInformationcheckNo = document.getElementById('additionalInformationcheckNo');
    const additionalInformation2 = document.getElementById('additionalInformation2');
    const additionalInformation2checkYes = document.getElementById('additionalInformation2checkYes');
    const additionalInformation2checkNo = document.getElementById('additionalInformation2checkNo');


    additionalInformationcheckNo.addEventListener('change', function () {
        if (this.checked) {
            additionalInformation2.style.display = 'none';
            additionalInformation2checkYes.checked = false;
            additionalInformation2checkNo.checked = false;
        }
    });

    additionalInformationcheckYes.addEventListener('change', function () {
        if (this.checked) {
            additionalInformation2.style.display = 'block'; 
        }
    });
   
});




