document.addEventListener("DOMContentLoaded", function () {
    const btnAddChildrenSubmit = document.getElementById('btnAddChildrenSubmit');
    const modalChildrenTax = new bootstrap.Modal(document.getElementById('modalChildrenTax'));

    btnAddChildrenSubmit.addEventListener('click', function (event) {
        event.preventDefault();
        modalChildrenTax.show();
    });
});