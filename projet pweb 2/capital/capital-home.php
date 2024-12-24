<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>HTML 5 Boilerplate</title>
  <link rel="stylesheet" href="capital-home.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
</head>
<body>
  <header>
    <nav class="navbar navbar-expand-lg navigation text-white">
      <div class="navbar-brand d-flex align-items-center">
        <a href="#" class="d-flex align-items-center text-decoration-none">
          <span class="ms-2 d-none d-md-inline">
            <span class="text-dark text-decoration-none fs-3 logo1">INVEST.</span>
          </span>
        </a>
      </div>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <img class="navbar-toggler-icon ms-auto" src="align-justify (1).svg" alt="menu">
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav d-flex justify-content-around mb-2 mx-sm-auto mb-lg-0 text-center">
          <li class="nav-item me-5">
            <a class="nav-link text-dark" href="#" id="projetsAFinancer">Projets à financer</a>
          </li>
          <li class="nav-item me-5">
            <a class="nav-link text-dark" href="#" id="projetsFinancer">Projets financés</a>
          </li>
          <li class="nav-item me-5">
            <a class="nav-link text-dark" href="#"></a>
          </li>
        </ul>
      </div>
    </nav>
  </header>









<body>

<!-- Div pour contenir le tableau (masqué par défaut) -->
<div id="tableauProjet2">
    <!-- Insérez votre tableau ici -->
    <table class="container">
        <thead>
            <tr>
                <th><h1>Titre</h1></th>
                <th><h1>Description</h1></th>
                <th><h1>Actions Achetés</h1></th>
                <th><h1>Total Investisement</h1></th>
  
            </tr>
        </thead>
        <tbody>
            <?php
            // Récupérer les données de la base de données
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "startupinvest";
            session_start();
            $id_capital=$_SESSION['capital_risque_id'];
            // Connexion à la base de données
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Vérifier la connexion
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Requête SQL pour sélectionner les données
            $projects_query = "SELECT p.id_projet, p.titre, p.description ,p.prix_action, pcr.nombre_actions_achetees
            FROM projet p
            INNER JOIN capital_risque_projet pcr ON p.id_projet = pcr.id_projet
            WHERE pcr.id_capital_risque = $id_capital";
            $projects_result = mysqli_query($conn, $projects_query);

            // Vérification s'il y a des données dans la base de données
            if ($projects_result !== false && $projects_result->num_rows > 0) {
                // Afficher les données dans les lignes du tableau
                while($row = $projects_result->fetch_assoc()) {
                    $total_investment = $row["nombre_actions_achetees"] * $row["prix_action"];
            ?>
            <tr>
                <td><?php echo $row["titre"]; ?></td>
                <td><?php echo $row["description"]; ?></td>
                <td><?php echo $row["nombre_actions_achetees"]; ?></td>
                <td><?php echo $total_investment; ?></td>
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
  </div>






















  <!-- Div pour contenir le tableau (masqué par défaut) -->
  <div id="tableauProjet" class="container1" style="display: none;">
    <!-- Insérez votre tableau ici -->
    <h2>Projets à financer</h2>
    <table class="table">
      <thead>
        <tr>
          <th scope="col">Titre</th>
          <th scope="col">Description</th>
          <th scope="col">Actions restantes</th>
          <th scope="col">Editer</th>
        </tr>
      </thead>
      <tbody>
        <?php
          // Connexion à la base de données
          $connexion = mysqli_connect('localhost', 'root', '', 'startupinvest');

          // Vérifier la connexion
          if (!$connexion) {
            die("La connexion à la base de données a échoué : " . mysqli_connect_error());
          }

          // Requête SQL pour récupérer les projets
          $requete = "SELECT * FROM projet";
          $resultat = mysqli_query($connexion, $requete);

          // Vérifier si des résultats ont été trouvés
          if (mysqli_num_rows($resultat) > 0) {
            // Afficher les données dans le tableau
            while ($row = mysqli_fetch_assoc($resultat)) {
              echo "<tr>";
              echo "<td>" . $row['titre'] . "</td>";
              echo "<td>" . $row['description'] . "</td>";
              echo "<td>" . $row['nombre_actions_a_vendre'] . "</td>";
              echo "<td>";
// À l'intérieur de votre boucle while qui génère les boutons "Editer"
              echo '<button type="button" class="btn btn-primary btn-editer" data-bs-toggle="modal" data-bs-target="#modalEditer" data-id="' . $row['id_projet'] . '">Editer</button>';
              echo "</td>";
              echo "</tr>";
            }
          } else {
            echo "<tr><td colspan='4'>Aucun projet trouvé</td></tr>";
          }

          // Fermer la connexion à la base de données
          mysqli_close($connexion);
        ?>
      </tbody>
    </table>
  </div>







<!-- Modal pour l'édition -->
<form id="formEdition" method="POST" action="traitement.php">
<div class="modal fade" id="modalEditer" tabindex="-1" aria-labelledby="modalEditerLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalEditerLabel">Editer</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Contenu du modal -->
        <!-- Paragraphes pour les zones de texte -->
        <p class="mb-3">
        <strong>Titre:</strong> <span id="titre"></span>
    </p>
    <p class="mb-3">
        <strong>Description:</strong> <span id="description"></span>
    </p>
    <p class="mb-3">
        <strong>Nombre d'actions restantes:</strong> <span id="nombreActionsRestantes"></span>
    </p>
    <p class="mb-3">
        <strong>Prix d'action:</strong> <span id="prixAction"></span>
    </p>
    <label for="actionsAcheter" class="form-label">Nombre d'actions à acheter</label>
  <input type="number" class="form-control" id="actionsAcheter" name="actionsAcheter" placeholder="Nombre d'actions à acheter">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
        <button type="button" class="btn btn-primary btn-confirmer">Confirmer</button>
      </div>
    </div>
  </div>
</div>
</form>












<script>
  // Sélectionnez le bouton "Editer"
  const boutonsEditer = document.querySelectorAll('.btn-editer');

  // Ajoutez un écouteur d'événements à chaque bouton "Editer"
  boutonsEditer.forEach(bouton => {
    bouton.addEventListener('click', () => {
      // Récupérez l'ID du projet à partir de l'attribut data-id
      const idProjet = bouton.getAttribute('data-id');

      // Effectuez une requête AJAX pour récupérer les informations du projet correspondant à l'ID
      fetch('traitement.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'id_projet=' + encodeURIComponent(idProjet)
      })
      .then(response => {
        if (!response.ok) {
          throw new Error('Erreur lors du traitement des données.');
        }
        return response.json(); // Attendu que les données retournées soient JSON
      })
      .then(data => {
        // Mettez à jour les paragraphes de la modal avec les informations du projet
        document.querySelector('#modalEditer .modal-body #titre').textContent = data.titre;
        document.querySelector('#modalEditer .modal-body #description').textContent = data.description;
        document.querySelector('#modalEditer .modal-body #nombreActionsRestantes').textContent = data.nombre_actions_a_vendre;
        document.querySelector('#modalEditer .modal-body #prixAction').textContent = data.prix_action;
        document.querySelector('#modalEditer .modal-body #actionsAcheter').value = ''; // Réinitialisez la valeur du champ actionsAcheter si nécessaire
      })
      .catch(error => {
        console.error('Erreur :', error);
      });
    });
  });


// Sélectionnez le bouton "Confirmer"
const boutonConfirmer = document.querySelector('#modalEditer .btn-confirmer');

// Ajoutez un écouteur d'événements au bouton "Confirmer"
boutonConfirmer.addEventListener('click', () => {
  // Soumettez le formulaire
  document.getElementById('formEdition').submit();
});
</script>










  <!-- JavaScript pour afficher le tableau lorsque vous cliquez sur "Projets à financer" -->
  <script>
    // Sélectionnez le lien "Projets à financer"
    const lienProjetsAFinancer = document.getElementById('projetsAFinancer');
    // Sélectionnez le div contenant le tableau
    const divTableauProjet = document.getElementById('tableauProjet');

    // Ajoutez un écouteur d'événements pour le clic sur le lien "Projets à financer"
    lienProjetsAFinancer.addEventListener('click', () => {
      // Affichez le div contenant le tableau
      divTableauProjet.style.display = 'block';
      divTableauProjetFianances.style.display = 'none';
    });

    // Sélectionnez le lien "Projets à financer"
    const lienProjetsFinancer = document.getElementById('projetsFinancer');
    // Sélectionnez le div contenant le tableau
    const divTableauProjetFianances = document.getElementById('tableauProjet2');

    // Ajoutez un écouteur d'événements pour le clic sur le lien "Projets à financer"
    lienProjetsFinancer.addEventListener('click', () => {
      // Affichez le div contenant le tableau
      divTableauProjet.style.display = 'none';
      divTableauProjetFianances.style.display = 'block';
    });

  </script>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
  <script src="mynewwfile.js"></script>
</body>
</html>



<style>
  .navigation{
  background-color:  #E7E7E7
}
.image{
    width: 50px; 
    border-radius:50%;
}
.navbar-nav .nav-item {
    border: 1px solid transparent;
    transition: border-color 0.3s ease-in-out;
  }
  
  .navbar-nav .nav-item:hover {
    border-color: #201e1e;
  }
  
</style>