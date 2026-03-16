$(document).ready(function () {
    // Verificar se o campo second_phone possui um valor ao carregar a página
    const secondPhoneValue = $('#second_phone').val()?.trim();

    if (secondPhoneValue && secondPhoneValue !== '') {
        $('#phoneFields').show(); // Mostrar os campos de telefone
        $('#showPhoneFields').hide(); // Esconder o botão "Mostrar"
        $('#hidePhoneFields').show(); // Mostrar o botão "Esconder"
    } else {
        $('#phoneFields').hide(); // Esconder os campos de telefone inicialmente
        $('#showPhoneFields').show(); // Mostrar o botão "Mostrar"
        $('#hidePhoneFields').hide(); // Esconder o botão "Esconder"
    }

    // Mostrar os campos de telefone
    $('#showPhoneFields').click(function (event) {
        event.preventDefault();
        $('#phoneFields').slideDown(); // Mostrar os campos com efeito de deslizamento
        $('#showPhoneFields').hide(); // Esconder o botão "Mostrar"
        $('#hidePhoneFields').show(); // Mostrar o botão "Esconder"
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
        $('#showPhoneFields').show(); // Mostrar o botão "Mostrar"
        $('#hidePhoneFields').hide(); // Esconder o botão "Esconder"
    });
});



