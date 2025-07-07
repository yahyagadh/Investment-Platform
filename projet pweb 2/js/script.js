 // JavaScript pour gérer l'affichage du formulaire d'inscription en tant que capital risque
    document.querySelector(".registerVCBtn").addEventListener("click", function () {
    document.getElementById("loginForm").style.display = "none";
    document.getElementById("registerVCForm").style.display = "block";
});

// JavaScript pour gérer l'affichage du formulaire d'inscription en tant que startuper
    document.querySelector(".registerStartupBtn").addEventListener("click", function () {
    document.getElementById("loginForm").style.display = "none";
    document.getElementById("registerStartupForm").style.display = "block";
});








// Validation du formulaire d'inscription en tant que capital risque
document.getElementById('registerVCForm').addEventListener('submit', function(event) {
    var firstName = document.getElementById('firstName').value.trim();
    var lastName = document.getElementById('lastName').value.trim();
    var email = document.getElementById('email').value.trim();
    var cin = document.getElementById('cin').value.trim();
    var pseudo = document.getElementById('pseudo').value.trim();
    var newPassword = document.getElementById('newPassword').value.trim();

    // Expression régulière pour vérifier que le numéro CIN est composé de 8 chiffres
    var cinPattern = /^\d{8}$/;

    // Expression régulière pour vérifier le format de l'adresse e-mail
    var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    // Vérification du format du mot de passe
    var passwordPattern = /^(?=.*[A-Za-z0-9])[A-Za-z0-9$#]{8,}$/;

    if (firstName === '' || lastName === '' || email === '' || cin === '' || pseudo === '' || newPassword === '') {
        alert('Veuillez remplir tous les champs.');
        event.preventDefault();
    } else if (!cinPattern.test(cin)) {
        alert('Le numéro CIN doit être composé de 8 chiffres.');
        event.preventDefault();
    } else if (!emailPattern.test(email)) {
        alert("Veuillez entrer une adresse e-mail valide.");
        event.preventDefault();
    } else if (!passwordPattern.test(newPassword)) {
        alert('Le mot de passe doit avoir au moins 8 caractères et se terminer par $ ou #.');
        event.preventDefault();
    }
});









// Validation du formulaire d'inscription en tant que startuper
document.getElementById('registerStartupForm').addEventListener('submit', function(event) {
    var startupFirstName = document.getElementById('startupFirstName').value.trim();
    var startupLastName = document.getElementById('startupLastName').value.trim();
    var startupEmail = document.getElementById('startupEmail').value.trim();
    var startupCIN = document.getElementById('startupCIN').value.trim();
    var startupCompanyName = document.getElementById('startupCompanyName').value.trim();
    var startupCompanyAddress = document.getElementById('startupCompanyAddress').value.trim();
    var startupCompanyRegNum = document.getElementById('startupCompanyRegNum').value.trim();
    var startupPseudo = document.getElementById('startupPseudo').value.trim();
    var startupPassword = document.getElementById('startupPassword').value.trim();

    // Expression régulière pour vérifier que le numéro CIN est composé de 8 chiffres
    var cinPattern = /^\d{8}$/;

    // Expression régulière pour vérifier le format de l'adresse e-mail
    var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    // Expression régulière pour vérifier le format du numéro de registre de commerce
    var regNumPattern = /^[A-Z]\d{10}$/;

    // Vérification du format du mot de passe
    var passwordPattern = /^(?=.*[A-Za-z0-9])[A-Za-z0-9$#]{8,}$/;

    if (startupFirstName === '' || startupLastName === '' || startupEmail === '' || startupCIN === '' || startupCompanyName === '' || startupCompanyAddress === '' || startupCompanyRegNum === '' || startupPseudo === '' || startupPassword === '') {
        alert('Veuillez remplir tous les champs.');
        event.preventDefault();
    } else if (!cinPattern.test(startupCIN)) {
        alert('Le numéro CIN doit être composé de 8 chiffres.');
        event.preventDefault();
    } else if (!emailPattern.test(startupEmail)) {
        alert("Veuillez entrer une adresse e-mail valide.");
        event.preventDefault();
    } else if (!regNumPattern.test(startupCompanyRegNum)) {
        alert('Le numéro du registre de commerce doit commencer par une lettre majuscule suivie de 10 chiffres.');
        event.preventDefault();
    } else if (!passwordPattern.test(startupPassword)) {
        alert('Le mot de passe doit avoir au moins 8 caractères et se terminer par $ ou #.');
        event.preventDefault();
    }
});

