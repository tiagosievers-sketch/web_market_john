//mostar modal
document.addEventListener('DOMContentLoaded', function () {
    const ssnFieldContainer = document.getElementById('ssnFieldContainer');

    ssnFieldContainer.addEventListener('click', function () {
        $('#modalSSN').modal('show');
    });
});


