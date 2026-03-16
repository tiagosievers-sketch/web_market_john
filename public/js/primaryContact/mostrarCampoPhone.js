$(document).ready(function () {
    // Mostrar os campos de telefone
    $('#showPhoneFields').click(function (event) {
        event.preventDefault(); 
        $('#phoneFields').slideDown(); 
        $('#showPhoneFields').hide(); 
        $('#hidePhoneFields').show(); 
    });

    // Esconder os campos de telefone e limpar os campos
    $('#hidePhoneFields').click(function (event) {
        event.preventDefault(); 
        $('#phoneFields').slideUp(function () {
            // Limpar os campos após o efeito de deslizamento estar completo
            $('#second_phone').val(''); 
            $('#second_extension').val(''); 
            $('#second_type').val(''); 
        });
        $('#showPhoneFields').show(); 
        $('#hidePhoneFields').hide(); 
    });
});
