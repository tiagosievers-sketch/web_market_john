function openTab(evt, tabName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].classList.remove("active");
    }
    document.getElementById(tabName).style.display = "block";
    evt.currentTarget.classList.add("active");
}


document.getElementById("tabHosehold").click();


document.getElementById("btnContinue").addEventListener("click", function() {
    document.getElementById("tabHomeAddress").click();
});
document.getElementById("btnContinueTwo").addEventListener("click", function() {
    document.getElementById("tabcontactDetails").click();
});
document.getElementById("btnBack").addEventListener("click", function() {
    document.getElementById("tabHomeAddress").click();
});