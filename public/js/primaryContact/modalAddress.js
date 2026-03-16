document.addEventListener("DOMContentLoaded", function () {
    const checkYesAddress = document.getElementById('checkYesAddress');
    const checkNoAddress = document.getElementById('checkNoAddress');
    const mailingField = document.getElementById('mailing');
    const modalAddAddrres = new bootstrap.Modal(document.getElementById('modalAddAddrres'));

   
    checkYesAddress.addEventListener('change', function () {
        mailingField.value = this.value;
        modalAddAddrres.hide(); 
    });

    checkNoAddress.addEventListener('change', function () {
        mailingField.value = this.value;
        if (this.checked) {
            modalAddAddrres.show(); 
        }
    });

    // Adiciona um ouvinte de evento para mudanças nos botões de rádio
    const radioButtons = document.querySelectorAll('input[name="checkaddress"]');
    radioButtons.forEach(button => {
        button.addEventListener('change', function () {

            mailingField.value = this.value;
        });
    });
});
