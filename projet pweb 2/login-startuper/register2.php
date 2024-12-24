<?php
$servername = "localhost";
$dbUsername = "root"; 
$dbPassword = ""; 
$database = "startupinvest";

// Connexion à la base de données
$conn = new mysqli($servername, $dbUsername, $dbPassword, $database);

// Vérifier la connexion
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
    // Récupérer les données du formulaire
    $uniqueID = generateUniqueID($conn);
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $cin = $_POST['cin'];
    $nomEntreprise = $_POST['StartupName'];
    $adresseEntreprise = $_POST['StartupAdresse']; // Assurez-vous que le nom du champ dans le formulaire HTML correspond
    $numeroRegistre = $_POST['Registernumber']; // Assurez-vous que le nom du champ dans le formulaire HTML correspond
    // La gestion de la photo nécessite un traitement de fichier, pas seulement une récupération de POST
    $userUsername = $_POST['username']; 
    $userPassword = $_POST['password'];

    // Préparation de la requête SQL
    $sql = "INSERT INTO startuper (id_startuper,nom, prenom, CIN, email, nom_entreprise, adresse_entreprise, numero_registre_commerce, pseudo, pwrd) VALUES (?,?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    if (false === $stmt) {
        die('Erreur de préparation : ' . htmlspecialchars($conn->error));
    }

    // Liaison des paramètres
    $stmt->bind_param("ssssssssss",$uniqueID, $lastName, $firstName, $cin, $email, $nomEntreprise, $adresseEntreprise, $numeroRegistre, $userUsername, $userPassword);

    // Exécution de la requête
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        header("Location: /projet pweb 2/login-startuper/login2.php");
        exit();
    } else {
        echo "Erreur lors de l'inscription : " . htmlspecialchars($stmt->error);
    }

    // Fermeture de la déclaration et de la connexion
    $stmt->close();
}

$conn->close(); 
?>










<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../login-capital/register.css">
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
                <input type="text" placeholder="Startup Name" name="StartupName" required>
                    <i class='bx bxs-building-house'></i>
            </div>
            </div>

            <div class="inputbox">
                <div class="input-field">
                    <input type="text" placeholder="StartupAdresse" name="StartupAdresse" required>
                    <i class='bx bxs-check-shield'></i>
                </div>
            </div>
            <div class="inputbox">
                <div class="input-field">
                    <input type="text" placeholder="Registernumber" name="Registernumber" required>
                    <i class='bx bxs-check-shield'></i>
                </div>
            </div>
            <div class="inputbox">
                <div class="input-field">
                <input type="file" placeholder="startupPhoto" name="startupPhoto" accept="image/*" required/>
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