<?php
// Démarrez la session PHP
session_start();

// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$database = "startupinvest";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    // Configuration de PDO pour qu'il lance des exceptions en cas d'erreur
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Échec de la connexion : " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username']; // Assurez-vous que 'username' correspond au 'name' de votre input dans le formulaire HTML
    $password = $_POST['password']; // Assurez-vous que 'password' correspond au 'name' de votre input dans le formulaire HTML

    // Utilisation de requêtes préparées pour éviter les injections SQL
    $sql = "SELECT id_capital_risque FROM capital_risque WHERE pseudo=? AND pwrd=?"; // Remplacez 'utilisateurs' par le nom réel de votre table et ajustez les noms des colonnes

    $stmt = $conn->prepare($sql);
    $stmt->execute([$username, $password]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        echo "login succceded bravo bvejdcbujkcez !";
        $capital_risque_id = $result['id_capital_risque']; // Utilisez le bon nom de colonne
        
        // Enregistrez l'ID du startuper dans une session
        $_SESSION['capital_risque_id'] = $capital_risque_id;
        
        // Redirection vers la page suivante
        header("Location: /projet pweb 2/capital/capital-home.php");
        exit(); // Assurez-vous de terminer le script après la redirection
    } else {
        echo "Nom d'utilisateur ou mot de passe incorrect!";
    }
}
?>







<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="login.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <div class="wrapper">
        <span class="bg-animate"></span>
        <div class="form-box login">
            <h2>Login as Capital Risk</h2>
            <form method="post">
                <div class="input-box">
                    <input type="text" name="username" required>
                    <label for="username">Username</label>
                    <i class='bx bxs-user'></i>
            </div>
            <div class="input-box">
                    <input type="password" name="password" required>
                    <label for="password">Password</label>
                    <i class='bx bxs-lock-alt' ></i>
            </div>
            <button type="submit" class="btn"  >Login</button>
            <div class="logreg-link">
                <p>Don't have an account?<a href="#" class="register-link" >Sign up</a></p>
            </div>
            </form>

        </div>
        <div class="info-text login">
            <h2>Welcome back!</h2>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
        </div>
    </div>
</body>
</html>