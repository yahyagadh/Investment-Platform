<?php
$servername = "localhost";
$dbUsername = "root"; 
$dbPassword = ""; 
$database = "startupinvest";

$conn = new mysqli($servername, $dbUsername, $dbPassword, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    function generateRandomID($min = 1, $max = 1000000) {
        return mt_rand($min, $max);
    }
    function checkIDExists($id, $db) {
        // Utilisation de ? pour les placeholders avec mysqli
        $query = "SELECT COUNT(*) FROM capital_risque WHERE id_capital_risque = ?";
        $stmt = $db->prepare($query);
        
        // Vérification que la préparation de la requête n'a pas échoué
        if (false === $stmt) {
            // Gérer l'erreur ici
            die('Erreur de préparation : ' . htmlspecialchars($db->error));
        }
        
        // Liaison des paramètres. 'i' spécifie le type : integer
        $bind = $stmt->bind_param('i', $id);
        
        // Vérification que la liaison n'a pas échoué
        if (false === $bind) {
            // Gérer l'erreur ici
            die('Erreur de liaison : ' . htmlspecialchars($stmt->error));
        }
        
        // Exécution de la requête
        $exec = $stmt->execute();
        
        // Vérification que l'exécution n'a pas échoué
        if (false === $exec) {
            // Gérer l'erreur ici
            die('Erreur d\'exécution : ' . htmlspecialchars($stmt->error));
        }
        
        // Récupération des résultats
        $result = $stmt->get_result();
        $count = $result->fetch_row()[0];
        
        // Fermeture du statement
        $stmt->close();
        
        return $count > 0;
    }
    
    function generateUniqueID($conn) {
        do {
            $id = generateRandomID();
        } while (checkIDExists($id, $conn));
        return $id;
    }
    $uniqueID = generateUniqueID($conn);
    
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $cin = $_POST['cin'];
    $userUsername = $_POST['username']; 
    $userPassword = $_POST['password'];

    $sql = "INSERT INTO capital_risque (`id_capital_risque`,`prenom`, `nom`, `email`, `CIN`, `pseudo`, `pwrd`) 
            VALUES (?,?, ?, ?, ?, ?, ?)";
    $stm = $conn->prepare($sql);
    $stm->bind_param("sssssss",$uniqueID, $firstName, $lastName, $email, $cin, $userUsername, $userPassword);
    $stm->execute();

    if ($stm->affected_rows > 0) {
        header("Location: /projet pweb 2/login-capital/login1.php");
    exit();

    } else {
        echo "Erreur: " . $conn->error;
    }
}

$conn->close(); 
?>








<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="register.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    
    <div class="wrapper">
        <form method="POST">
            <h1>Registration</h1>
            <div class="inputbox">
                <div class="input-field">
                    <input type="text" placeholder="First name" name="firstName" required>
                    <i class='bx bxs-user'></i>
                </div>
            </div>
            <div class="inputbox">
                <div class="input-field">
                    <input type="text" placeholder="Family name" name="lastName" required>
                    <i class='bx bxs-user'></i>
                </div>
            </div>
            <div class="inputbox">
                <div class="input-field">
                    <input type="text" placeholder="E-mail" name="email" required>
                    <i class='bx bxs-envelope' ></i>
                </div>
            </div>
            <div class="inputbox">
                <div class="input-field">
                    <input type="text" placeholder="CIN" name="cin" required>
                    <i class='bx bxs-check-shield'></i>
                </div>
            </div>
            <div class="inputbox">
                <div class="input-field">
                    <input type="text" placeholder="Pseudo" name="username" required>
                    <i class='bx bxs-user'></i>
                </div>
            </div>
            <div class="inputbox">
                <div class="input-field">
                    <input type="password" placeholder="Password" name="password" required>
                    <i class='bx bxs-lock'></i>
                </div>
            </div>
            <button type="submit" class="btn">Sign up</button>
        </form>
    </div>
</body>
</html>