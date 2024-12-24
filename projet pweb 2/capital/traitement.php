<?php
// Démarrez la session
session_start();

// Vérifiez si l'ID du projet a été envoyé
if (isset($_POST['id_projet'])) {
    // Récupérez l'ID du projet depuis la requête AJAX
    $idProjet = $_POST['id_projet'];
    
    // Enregistrez la valeur dans une variable de session
    $_SESSION['id_projet'] = $idProjet;

    // Connectez-vous à votre base de données
    $connexion = mysqli_connect('localhost', 'root', '', 'startupinvest');

    // Vérifiez la connexion à la base de données
    if (!$connexion) {
        die("La connexion à la base de données a échoué : " . mysqli_connect_error());
    }

    // Échappez l'ID du projet pour éviter les attaques par injection SQL
    $idProjet = mysqli_real_escape_string($connexion, $idProjet);

    // Requête SQL pour récupérer les informations du projet correspondant à l'ID
    $requete = "SELECT * FROM projet WHERE id_projet = $idProjet";
    $resultat = mysqli_query($connexion, $requete);

    // Vérifiez si des résultats ont été trouvés
    if ($resultat && mysqli_num_rows($resultat) > 0) {
        // Récupérez les informations du projet
        $projet = mysqli_fetch_assoc($resultat);

        // Affichez les informations du projet
        echo json_encode($projet);
    } else {
        // Aucun projet trouvé avec cet ID
        echo "Aucun projet trouvé avec l'ID : $idProjet";
    }

    // Fermez la connexion à la base de données
    mysqli_close($connexion);
} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['id_projet']))  {
    // Récupérez les données du formulaire
    $idProjet = $_SESSION['id_projet'];
    $actionsAcheter = $_POST['actionsAcheter'];

    // Connexion à la base de données
    $connexion = mysqli_connect('localhost', 'root', '', 'startupinvest');

    // Vérifiez la connexion à la base de données
    if (!$connexion) {
        die("La connexion à la base de données a échoué : " . mysqli_connect_error());
    }

    // Échappez les valeurs pour éviter les attaques par injection SQL
    $idProjet = mysqli_real_escape_string($connexion, $idProjet);
    $actionsAcheter = mysqli_real_escape_string($connexion, $actionsAcheter);

    // Requête SQL pour mettre à jour les colonnes nombre_actions_a_vendre et nombre_actions_vendues
    $requete1 = "UPDATE projet SET nombre_actions_a_vendre = nombre_actions_a_vendre - $actionsAcheter, nombre_actions_vendues = nombre_actions_vendues + $actionsAcheter WHERE id_projet = $idProjet";

    // Exécutez la requête SQL
    if (mysqli_query($connexion, $requete1)) {
        echo "Mise à jour effectuée avec succès.";
    } else {
        echo "Erreur lors de la mise à jour : " . mysqli_error($connexion);
    }
    $id_capital= $_SESSION['capital_risque_id'];

    $requeteExistence = "SELECT * FROM capital_risque_projet WHERE id_projet = $idProjet and id_capital_risque=$id_capital";
    $resultatExistence = mysqli_query($connexion, $requeteExistence);

    if ($resultatExistence && mysqli_num_rows($resultatExistence) > 0) {
        // Si une entrée existe déjà, effectuez une mise à jour
        $requeteUpdate = "UPDATE capital_risque_projet SET nombre_actions_achetees = nombre_actions_achetees + $actionsAcheter WHERE id_projet = $idProjet and id_capital_risque=$id_capital";
        
        if (mysqli_query($connexion, $requeteUpdate)) {
            echo "Mise à jour effectuée avec succès.";
        } else {
            echo "Erreur lors de la mise à jour : " . mysqli_error($connexion);
        }
    } else {
        // Si aucune entrée n'existe, insérez une nouvelle entrée
        $requeteInsertion = "INSERT INTO capital_risque_projet(id_projet, id_capital_risque, nombre_actions_achetees) VALUES ($idProjet, $id_capital, $actionsAcheter)";
        
        if (mysqli_query($connexion, $requeteInsertion)) {
            echo "Insertion effectuée avec succès.";
        } else {
            echo "Erreur lors de l'insertion : " . mysqli_error($connexion);
        }
    }




    // Fermez la connexion à la base de données
    mysqli_close($connexion);
} else {
    // L'ID du projet n'a pas été envoyé
    echo "L'ID du projet n'a pas été envoyé.";
}
?>
