document.addEventListener("DOMContentLoaded", function () {
    const checkYesapplyingYes = document.getElementById('checkYesapplyingYes');
    const checkYesapplyingNo = document.getElementById('checkYesapplyingNo');
    const modaldemoAlerta = new bootstrap.Modal(document.getElementById('modaldemoAlerta'));

    checkYesapplyingNo.addEventListener('change', function () {
        if (this.checked) {
            modaldemoAlerta.show(); 
        }
    });

    checkYesapplyingYes.addEventListener('change', function () {
        if (this.checked) {
            modaldemoAlerta.hide(); 
        }
    });
});
