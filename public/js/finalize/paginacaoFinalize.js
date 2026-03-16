function openTab(evt, tabName) {
    var i, tabcontent, tablinks;

    // Ocultar todas as abas
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }

    // Remover a classe "active" de todos os botões
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].classList.remove("active");
    }

    // Mostrar a aba atual e adicionar a classe "active" ao botão clicado
    document.getElementById(tabName).style.display = "block";
    evt.currentTarget.classList.add("active");

    // Controlar visibilidade do #timerReview
    const timerReview = document.getElementById("timerReview");
    if (tabName === "review") {
        timerReview.style.display = "inline"; // Exibe na aba "Review"
    } else {
        timerReview.style.display = "none"; // Oculta em outras abas
    }
}

// Eventos ajustados
document.getElementById("btnContinue").addEventListener("click", function () {
    document.getElementById("campoAgreements").click();
});

document.getElementById("btnContinueTwo").addEventListener("click", function () {
    document.getElementById("campoSign").click();
});

document.getElementById("btnBack").addEventListener("click", function () {
    document.getElementById("camposReview").click();
    document.getElementById("timerReview").style.display = "inline"; // Garante que o timer apareça
});

document.getElementById("btnBackTree").addEventListener("click", function () {
    document.getElementById("campoAgreements").click();
});
