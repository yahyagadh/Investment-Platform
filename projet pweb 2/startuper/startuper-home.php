<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "startupinvest";


$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}
session_start();
if(isset($_SESSION['startuper_id'])) {
    // Récupérez l'ID du startuper depuis la session    
    $startuper_id = $_SESSION['startuper_id'];
$nom = "";
$prenom = "";
$cin = "";
$email = "";
$nomEntreprise = "";
$adresseEntreprise = "";
$numeroRegistre = "";
$pseudo = "";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Utilisation de requêtes préparées pour éviter les injections SQL
    $stmt = $conn->prepare("SELECT nom, prenom, CIN, email, nom_entreprise, adresse_entreprise, numero_registre_commerce, pseudo FROM startuper WHERE id_startuper=?");
    $stmt->bind_param("i", $startuper_id); // "i" signifie que le paramètre est un integer (ID du startuper)
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Récupération des données du startuper
        while ($row = $result->fetch_assoc()) {
            $nom = $row['nom'];
            $prenom = $row['prenom'];
            $cin = $row['CIN'];
            $email = $row['email'];
            $nomEntreprise = $row['nom_entreprise'];
            $adresseEntreprise = $row['adresse_entreprise'];
            $numeroRegistre = $row['numero_registre_commerce'];
            $pseudo = $row['pseudo'];
        }
    } else {
        echo "Aucun startuper trouvé avec cet identifiant.";
    }
}
// Si la méthode de requête est POST, cela signifie que le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addProject'])){
    // Récupération des nouvelles valeurs depuis le formulaire
    $projectTitles = $_POST['projectTitle'];
    $projectDescriptions = $_POST['projectDescription'];
    $numberOfShares = $_POST['numberOfShares'];
    $shareValues = $_POST['shareValue'];

    // Vérifiez d'abord si les tableaux ont la même longueur
    if (count($projectTitles) === count($projectDescriptions) && count($projectTitles) === count($numberOfShares) && count($projectTitles) === count($shareValues)) {
        // Utilisation d'une boucle pour insérer chaque projet dans la base de données
        for ($i = 0; $i < count($projectTitles); $i++) {
            // Récupération des valeurs pour le projet actuel
            $projectTitle = $projectTitles[$i];
            $projectDescription = $projectDescriptions[$i];
            $numberOfShare = $numberOfShares[$i];
            $shareValue = $shareValues[$i];

            // Utilisation d'une requête préparée pour insérer les valeurs dans la base de données
            $stmt = $conn->prepare("INSERT INTO projet (titre, description, nombre_actions_a_vendre, prix_action, id_startuper) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("ssiii", $projectTitle, $projectDescription, $numberOfShare, $shareValue, $startuper_id); // "ssiii" signifie string, string, integer, integer, integer pour les types des paramètres
            $stmt->execute();

            // Vérification si l'insertion a réussi
            if ($stmt->affected_rows > 0) {
                echo "Projet ajouté avec succès!";
            } else {
                echo "Erreur lors de l'ajout du projet.";
            }
        }
    } else {
        echo "Les tableaux de données du formulaire ne sont pas de même longueur.";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deleteProjectBtn'])) {
    // Vérifiez d'abord si l'ID du projet à supprimer est défini dans la requête POST
    if(isset($_POST['deleteProjectId'])) {
        // Récupérer l'ID du projet à supprimer
        $projectId = $_POST['deleteProjectId'];

        // Connexion à la base de données
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Vérifier la connexion
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Requête SQL pour supprimer le projet de la base de données
        $stmt = $conn->prepare("DELETE FROM projet WHERE id_projet = ?");
        $stmt->bind_param("i", $projectId);
        $stmt->execute();

        // Vérifier si la suppression a réussi
        if ($stmt->affected_rows > 0) {
            // Projet supprimé avec succès
            echo "Projet supprimé avec succès!";
        } else {
            // Échec de la suppression du projet
            echo "Erreur lors de la suppression du projet.";
        }
    } else {
        // Si l'ID du projet à supprimer n'est pas défini dans la requête POST
        echo "ID du projet à supprimer non spécifié.";
    }
}
}
?>



























<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Startuper</title>
    <link rel="stylesheet" href="startuper-home.css">
</head>
<body>

<header class="header">
    <a href="home" class="logo">INVEST.</a>
    <nav class="navbar">
        <a href="#mesprojets">Liste mes Projets</a>
        <a href="#ajout">Ajouter projet</a>
        <a href="#profil">Profil</a>
        <a href="../home\home.html">Déconnexion</a>
    </nav>
</header>  


                                           <!-- home  section -->






<section class="home">
    <div class="home-content">
        <h1>Welcome to our Website</h1>
        <h3>Where the best investments be found</h3>
        <p>Investing in capital risk holds the key to unlocking immense potential.
             It's not just about financial gain; it's about fueling innovation and driving progress.
              By taking calculated risks in diverse projects, investors position themselves at the forefront of opportunity.
               Embrace the future, embrace capital risk, and pave the way for unprecedented growth and success.</p>
        <div class="btn-box">
            <a href="../login-startuper/login2.php">Login as Startuper</a>
            <a href="../login-capital/login1.html">Login as Capital risk</a>
        </div>
    </div>
</section>



                                           <!-- profil  section -->




<div class="wrapper" id="profileWrapper">
    <form method="POST">
        <h1>Profil</h1>
        <div class="inputbox">
            <div class="input-field">
                <input type="text" placeholder="First name" name="firstName" value="<?php echo $nom; ?>" disabled required>
                <i class='bx bxs-user'></i>
            </div>
        </div>
        <div class="inputbox">
            <div class="input-field">
                <input type="text" placeholder="Family name" name="lastName" value="<?php echo $prenom; ?>" disabled required>
                <i class='bx bxs-user'></i>
            </div>
        </div>
        <div class="inputbox">
            <div class="input-field">
                <input type="text" placeholder="E-mail" name="email" value="<?php echo $email; ?>" disabled required>
                <i class='bx bxs-envelope'></i>
            </div>
        </div>
        <div class="inputbox">
            <div class="input-field">
                <input type="text" placeholder="CIN" name="cin" value="<?php echo $cin; ?>" disabled required>
                <i class='bx bxs-check-shield'></i>
            </div>
        </div>
        <div class="inputbox">
            <div class="input-field">
                <input type="text" placeholder="Startup Name" name="StartupName" value="<?php echo $nomEntreprise; ?>" disabled required>
                <i class='bx bxs-building-house'></i>
            </div>
        </div>
        <div class="inputbox">
            <div class="input-field">
                <input type="text" placeholder="StartupAdresse" name="StartupAdresse" value="<?php echo $adresseEntreprise; ?>" disabled required>
                <i class='bx bxs-check-shield'></i>
            </div>
        </div>
        <div class="inputbox">
            <div class="input-field">
                <input type="text" placeholder="Registernumber" name="Registernumber" value="<?php echo $numeroRegistre; ?>" disabled required>
                <i class='bx bxs-check-shield'></i>
            </div>
        </div>
        <div class="inputbox">
            <div class="input-field">
                <input type="text" placeholder="Pseudo" name="username" value="<?php echo $pseudo; ?>" disabled required>
                <i class='bx bxs-user'></i>
            </div>
        </div>
        <button type="button" class="btn" id="editButton">Modifier</button>
        <!-- Bouton de confirmation (initialement caché) -->
        <button type="submit" name="updateProfile" class="btn" id="confirmButton" style="display: none;">Confirm</button>
    </form>
</div>






                                           <!-- ajout  section -->






<div class="wrapper2" id="wrapper2">
        <form method="POST">
            <h1>Ajouter Projet</h1>
            <div class="inputbox2">
            <div class="input-field2">
                <input type="text" placeholder="Titre du projet" name="projectTitle[]" required>
                <i class='bx bxs-file'></i>
            </div>
        </div>
        <div class="inputbox2">
            <div class="input-field2">
                <textarea placeholder="Description du projet" name="projectDescription[]" required></textarea>
                <i class='bx bxs-edit'></i>
            </div>
        </div>
        <div class="inputbox2">
            <div class="input-field2">
                <input type="number" class="nbractions" placeholder="Nombre d'actions" name="numberOfShares[]" required>
                <i class='bx bxs-currency-dollar'></i>
            </div>
        </div>
        <div class="inputbox2">
            <div class="input-field2">
                <input type="number" placeholder="Valeur de l'action" name="shareValue[]" required>
                <i class='bx bxs-currency-dollar'></i>
            </div>
        </div>
        <div id="newProjectFields"></div>
        <button type="submit" name="addProject" onclick="addProjectField()">Ajouter un projet</button>
        </form>
    </div>








                                           <!-- Mes projets  section -->


 <div class="myprojects" id="myprojects">
<form method="POST">
<table class="container">
        <thead>
            <tr>
                <th><h1>Titre</h1></th>
                <th><h1>Description</h1></th>
                <th><h1>Actions Disponibles</h1></th>
                <th><h1>Actions Vendues</h1></th>
                <th><h1>Montant Collecté</h1></th>
                <th><h1>Prix par Action</h1></th>
                <th><h1>Supprimer</h1></th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Récupérer les données de la base de données
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "startupinvest";

            // Connexion à la base de données
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Vérifier la connexion
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Requête SQL pour sélectionner les données
            $stmt = $conn->prepare ("SELECT id_projet ,titre, description, nombre_actions_a_vendre, nombre_actions_vendues,prix_action FROM projet where id_startuper=? ");
            $stmt->bind_param("i", $startuper_id); // "i" signifie que le paramètre est un integer (ID du startuper)
            $stmt->execute();

            $result = $stmt->get_result();

            // Vérification s'il y a des données dans la base de données
            if ($result !== false && $result->num_rows > 0) {
                // Afficher les données dans les lignes du tableau
                while($row = $result->fetch_assoc()) {
                    $montant_collecte = $row["nombre_actions_vendues"] * $row["prix_action"];
            ?>
            <tr>
                <td><?php echo $row["titre"]; ?></td>
                <td><?php echo $row["description"]; ?></td>
                <td><?php echo $row["nombre_actions_a_vendre"]; ?></td>
                <td><?php echo $row["nombre_actions_vendues"]; ?></td>
                <td><?php echo $montant_collecte; ?></td>
                <td><?php echo $row["prix_action"]; ?></td>
                <input type="hidden" name="deleteProjectId" value="<?php echo $row['id_projet']; ?>">
                <td><button type="submit" name="deleteProjectBtn">Supprimer</button></td>
            </tr>
            <?php
}
} else {
echo "<tr><td colspan='8'>Aucun projet trouvé.</td></tr>";
}

// Fermer la connexion à la base de données
$conn->close();
?>
        </tbody>
    </table>
</form>
</div>












<script>
        document.addEventListener("DOMContentLoaded", function() {
    const profileLink = document.querySelector('.navbar a[href="#profil"]');
    const addProjectLink = document.querySelector('.navbar a[href="#ajout"]');
    const mesprojets = document.querySelector('.navbar a[href="#mesprojets"]');
    const homeSection = document.querySelector('.home');
    const profileWrapper = document.getElementById('profileWrapper');
    const wrapper2 = document.getElementById('wrapper2');
    const myprojects= document.getElementById('myprojects');
    homeSection.style.display = 'block';
    wrapper2.style.display = 'none';
    profileWrapper.style.display = 'none';
    myprojects.style.display='none'
    profileLink.addEventListener('click', function(event) {
        event.preventDefault();
        homeSection.style.display = 'none';
        wrapper2.style.display = 'none';
        myprojects.style.display='none'
        profileWrapper.style.display = 'block';
    });

    addProjectLink.addEventListener('click', function(event) {
        event.preventDefault();
        homeSection.style.display = 'none';
        profileWrapper.style.display = 'none';
        myprojects.style.display='none'
        wrapper2.style.display = 'block';
    });

    mesprojets.addEventListener('click',function(event){
    event.preventDefault();
        homeSection.style.display = 'none';
        profileWrapper.style.display = 'none';
        myprojects.style.display='block'
        wrapper2.style.display = 'none';});
});


// Récupération des éléments du formulaire
const editButton = document.getElementById('editButton');
    const confirmButton = document.getElementById('confirmButton');
    const inputFields = document.querySelectorAll('.input-field input');

    // Fonction pour activer/désactiver les champs d'entrée
    function toggleInputFields(disabled) {
        inputFields.forEach(input => {
            input.disabled = disabled;
        });
    }

    // Gestionnaire d'événement pour le bouton "Modifier"
    editButton.addEventListener('click', function() {
        // Activer les champs d'entrée
        toggleInputFields(false);
        // Afficher le bouton "Confirm"
        confirmButton.style.display = 'block';
    });

</script>

</body>
</html>
