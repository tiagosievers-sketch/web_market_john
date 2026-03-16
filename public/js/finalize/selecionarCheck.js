document.addEventListener("DOMContentLoaded", function () {
    const checkYesconcordo = document.getElementById('checkYesconcordo');
    const checkNodiscordo = document.getElementById('checkNodiscordo');

    function updateFieldVisibility() {
        if (checkNodiscordo.checked) {
            anos.style.display = 'flex';

        } else if (checkYesconcordo.checked) {
            anos.style.display = 'none';

        }
    }

    checkYesconcordo.addEventListener('change', updateFieldVisibility);
    checkNodiscordo.addEventListener('change', updateFieldVisibility);
});

document.addEventListener("DOMContentLoaded", function () {
    const checkYesconcordosign = document.getElementById('checkYesconcordosign');
    const checkNodiscordosign = document.getElementById('checkNodiscordosign');

    function updateFieldVisibility() {
        if (checkYesconcordosign.checked) {
            inscritoCobertura.style.display = 'flex';

        } else if (checkNodiscordosign.checked) {
            inscritoCobertura.style.display = 'none';

        }
    }

    checkYesconcordosign.addEventListener('change', updateFieldVisibility);
    checkNodiscordosign.addEventListener('change', updateFieldVisibility);
});



document.addEventListener("DOMContentLoaded", function () {
    const checkYesrequerimento = document.getElementById('checkYesrequerimento');
    const checkNorequerimento = document.getElementById('checkNorequerimento');

    function updateFieldVisibility() {
        if (checkYesrequerimento.checked) {
            assinarEtronicamente.style.display = 'flex';

        } else if (checkNorequerimento.checked)  {
            assinarEtronicamente.style.display = 'none';

        }
    }

    checkYesrequerimento.addEventListener('change', updateFieldVisibility);
    checkNorequerimento.addEventListener('change', updateFieldVisibility);
});