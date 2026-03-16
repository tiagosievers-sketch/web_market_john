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




document.getElementById("btnContinue").addEventListener("click", function() {
    document.getElementById("tabNonTax").click();
});
// document.getElementById("btnBack").addEventListener("click", function() {
//     document.getElementById("tabOtherFamily").click();
// });
document.getElementById("btnBackTwo").addEventListener("click", function() {
    document.getElementById("tabOtherFamily").click();
});