document.addEventListener("DOMContentLoaded", function () {
    const btnAddSpouse = document.getElementById('btnAddSpouse');
    const modalAddSpouse = new bootstrap.Modal(document.getElementById('modalAddSpouse'));

    btnAddSpouse.addEventListener('click', function (event) {
        event.preventDefault();
        modalAddSpouse.show();
    });
});
