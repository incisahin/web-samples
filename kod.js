


function gosterVeYonlendir(sectionId) {
    butunSectionKapat();
    var section = document.getElementById(sectionId);
    section.style.display = "block";
}
function butunSectionKapat() {
    document.getElementById('vodafone-kampanya').style.display = "none";
    document.getElementById('dsmart-kampanya').style.display = "none";
    document.getElementById('TT-kampanya').style.display = "none";
    document.getElementById('turkcell-kampanya').style.display = "none";
    document.getElementById('millenicom-kampanya').style.display = "none";

}

function basvuruFormunaGit() {

    window.location.href = "#form-basvuru";
}



