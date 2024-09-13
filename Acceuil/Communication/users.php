<?php
// Démarrage de la session
session_start();

// Inclusion du fichier de configuration
include_once "php/config.php";

// Vérification de l'existence d'un ID utilisateur unique en session
if (!isset($_SESSION['unique_id'])) {
  // Redirection vers la page de connexion si l'ID utilisateur n'est pas défini
  header("location: login.php");
}
?>
<?php
// Inclusion du fichier d'en-tête
include_once "header.php";
?>

<body>
  <!-- Conteneur principal de la page -->
  <div class="wrapper">
    <!-- Section des utilisateurs -->
    <section class="users">
      <!-- En-tête de la section -->
      <header>
        <!-- Conteneur de contenu -->
        <div class="content">
          <?php
          // Requête SQL pour récupérer les données de l'utilisateur en fonction de son ID unique
          $sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = {$_SESSION['unique_id']}");

          // Vérification de l'existence de résultats
          if (mysqli_num_rows($sql) > 0) {
            // Récupération des données de l'utilisateur
            $row = mysqli_fetch_assoc($sql);
          }
          ?>
          <!-- Affichage de la photo de profil de l'utilisateur -->
          <img src="php/images/<?php echo $row['img']; ?>" alt="">
          <!-- Conteneur de détails de l'utilisateur -->
          <div class="details">
            <!-- Affichage du nom et prénom de l'utilisateur -->
            <span><?php echo $row['fname'] . " " . $row['lname'] ?></span>
            <!-- Affichage du statut de l'utilisateur -->
            <p><?php echo $row['status']; ?></p>
          </div>
        </div>
        <!-- Lien de déconnexion -->
        <a href="php/logout.php?logout_id=<?php echo $row['unique_id']; ?>" class="logout">Deconnexion</a>
      </header>
      <!-- Conteneur de recherche -->
      <div class="search">
        <!-- Texte de recherche -->
        <span class="text">Selectionnez un utilisateur pour commencer le chat</span>
        <!-- Champ de recherche -->
        <input type="text" placeholder="Entrez le nom à rechercher...">
        <!-- Bouton de recherche -->
        <button><i class="fas fa-search"></i></button>
      </div>
      <!-- Conteneur de liste d'utilisateurs -->
      <div class="users-list">

      </div>
    </section>
  </div>

  <!-- Inclusion du fichier JavaScript -->
  <script src="javascript/users.js"></script>

</body>

</html>