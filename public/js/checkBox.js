$(document).ready(function () {
    // Adiciona um evento de clique aos campos de rádio
    $('input[type="radio"][name="checknoticiaPapel"]').click(function () {
        if ($(this).is(':checked')) {
            // Desmarca o outro campo de rádio
            $('input[type="radio"][name="checknoticiaEmail"]').prop('checked', false);
        }
    });

    $('input[type="radio"][name="checknoticiaEmail"]').click(function () {
        if ($(this).is(':checked')) {
            // Desmarca o outro campo de rádio
            $('input[type="radio"][name="checknoticiaPapel"]').prop('checked', false);
        }
    });
});



$(document).ready(function () {
    // Adiciona um evento de clique aos campos de rádio
    $('input[type="radio"][name="checkYes"]').click(function () {
        if ($(this).is(':checked')) {
            // Desmarca o outro campo de rádio
            $('input[type="radio"][name="checkNo"]').prop('checked', false);
            // Atualiza o valor do campo oculto
            $('input[name="checkYes"]').val('1');
            $('input[name="checkNo"]').val('0');
        }
    });

    $('input[type="radio"][name="checkNo"]').click(function () {
        if ($(this).is(':checked')) {
            // Desmarca o outro campo de rádio
            $('input[type="radio"][name="checkYes"]').prop('checked', false);
            // Atualiza o valor do campo oculto
            $('input[name="checkYes"]').val('0');
            $('input[name="checkNo"]').val('1');
        }
    });

    // Defina os valores iniciais dos campos ocultos com base na seleção atual dos botões de rádio
    if ($('input[type="radio"][name="checkYes"]').is(':checked')) {
        $('input[name="checkYes"]').val('1');
        $('input[name="checkNo"]').val('0');
    } else if ($('input[type="radio"][name="checkNo"]').is(':checked')) {
        $('input[name="checkYes"]').val('0');
        $('input[name="checkNo"]').val('1');
    } else {
        // Se nenhum botão estiver selecionado, defina ambos os campos ocultos como 0
        $('input[name="checkYes"]').val('0');
        $('input[name="checkNo"]').val('0');
    }
});

$(document).ready(function () {
    // Adiciona um evento de clique aos campos de rádio
    $('input[type="radio"][name="householdCheck"]').click(function () {
        // Atualiza o valor do campo oculto baseado no botão de rádio selecionado
        let selectedValue = $(this).val();
        $('input[name="applying_coverage"]').val(selectedValue);

        // Atualiza o valor do campo oculto baseado na seleção atual dos botões de rádio
        if (selectedValue === '1') {
            // "Yes" foi selecionado
            $('#householdcheckYes').prop('checked', true);
            $('#householdcheckNo').prop('checked', false);
        } else {
            // "No" foi selecionado
            $('#householdcheckYes').prop('checked', false);
            $('#householdcheckNo').prop('checked', true);
        }
    });

    // Defina os valores iniciais dos campos ocultos com base na seleção atual dos botões de rádio
    if ($('#householdcheckYes').is(':checked')) {
        $('input[name="applying_coverage"]').val('1');
    } else if ($('#householdcheckNo').is(':checked')) {
        $('input[name="applying_coverage"]').val('0');
    } else {
        // Se nenhum botão estiver selecionado, defina o campo oculto como 0
        $('input[name="applying_coverage"]').val('0');
    }
});


$(document).ready(function () {
    // Adiciona um evento de clique aos campos de rádio
    $('input[type="radio"][name="checkYesapplying"]').click(function () {
        // Atualiza o valor do campo oculto baseado no botão de rádio selecionado
        let selectedValue = $(this).val();
        $('input[name="eligible_cost_saving"]').val(selectedValue);
    });

    // Defina os valores iniciais do campo oculto com base na seleção atual dos botões de rádio
    if ($('#checkYesapplyingYes').is(':checked')) {
        $('input[name="eligible_cost_saving"]').val('1');
    } else if ($('#checkYesapplyingNo').is(':checked')) {
        $('input[name="eligible_cost_saving"]').val('0');
    } else {
        // Se nenhum botão estiver selecionado, defina o campo oculto como 0
        $('input[name="eligible_cost_saving"]').val('0');
    }
});



document.addEventListener("DOMContentLoaded", function () {
    const checknoticiaPapel = document.getElementById('checknoticiaPapel');
    const checknoticiaEmail = document.getElementById('checknoticiaEmail');
    const enviarEmailTexto = document.getElementById('enviarEmailTexto');

    checknoticiaPapel.addEventListener('change', function () {
        if (this.checked) {
            enviarEmailTexto.style.display = 'none';
        }
    });

    checknoticiaEmail.addEventListener('change', function () {
        if (this.checked) {
            enviarEmailTexto.style.display = 'block'; // or 'flex' depending on your layout needs
        }
    });
});

// document.addEventListener("DOMContentLoaded", function () {
//     const sendEmailCheckbox = document.getElementById('send_email_texts');
//     const sendTextCheckbox = document.getElementById('send_text');


//     sendEmailCheckbox.addEventListener('change', function () {
//         document.getElementById('send_email_texts').value = this.checked ? '1' : '0';
//     });

    
//     sendTextCheckbox.addEventListener('change', function () {
//         document.getElementById('send_text').value = this.checked ? '1' : '0';
//     });


//     document.getElementById('send_email_texts').value = sendEmailCheckbox.checked ? '1' : '0';
//     document.getElementById('send_text').value = sendTextCheckbox.checked ? '1' : '0';
// });