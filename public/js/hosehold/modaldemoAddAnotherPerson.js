document.addEventListener("DOMContentLoaded", function () {
    //const btnAddAnotherPerson = document.getElementById('btnAddAnotherPerson');
    const modaldemoAddAnotherPerson = new bootstrap.Modal(document.getElementById('modaldemoAddAnotherPerson'));

    btnAddAnotherPerson.addEventListener('click', function (event) {
        event.preventDefault();
        modaldemoAddAnotherPerson.show();
    });
});
