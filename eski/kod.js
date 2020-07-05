


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

function basvur() {
    const name = document.getElementById("name").value.trim();
    const surname = document.getElementById("surname").value.trim();
    const phone = document.getElementById("phone").value.trim();
    const address = document.getElementById("address").value.trim();

    if (name === undefined || name === ""
        || surname === undefined || surname === ""
        || phone === undefined || phone === ""
        || address === undefined || address === "") {
        alert("Lütfen Boşlukları doldurunuz.")
    }

    console.log(name + " " + surname + " " + phone + " " + address);
}


