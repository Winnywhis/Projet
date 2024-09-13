<?php
// Démarre une session.
session_start();

// Vérifie si une clé 'unique_id' existe dans la session.
// Si elle existe, redirige l'utilisateur vers 'users.php'.
if (isset($_SESSION['unique_id'])) {
  header("location: users.php");
}
?>

<!-- Inclut le fichier 'header.php'. -->
<?php include_once "header.php"; ?>

<body>
  <div class="wrapper">
    <section class="form signup">
      <header>SIGN IN</header>

      <!-- Formulaire de création de compte. -->
      <form action="#" method="POST" enctype="multipart/form-data" autocomplete="off">
        <!-- Zone d'erreur. -->
        <div class="error-text"></div>

        <!-- Champs de nom. -->
        <div class="name-details">
          <div class="field input">
            <!-- Champ de saisie pour le prénom. -->
            <label>Nom</label>
            <input type="text" name="fname" placeholder="Nom" required>
          </div>
          <div class="field input">
            <!-- Champ de saisie pour le nom. -->
            <label>Prenom</label>
            <input type="text" name="lname" placeholder="Prenom" required>
          </div>
        </div>

        <!-- Champ de saisie pour l'adresse e-mail. -->
        <div class="field input">
          <label>Email </label>
          <input type="text" name="email" placeholder="Entrez votre email" required>
        </div>

        <!-- Champ de saisie pour le mot de passe. -->
        <div class="field input">
          <label>Password</label>
          <input type="password" name="password" placeholder="Entrez votre mot de passe" required>
          <!-- Icône pour afficher/masquer le mot de passe. -->
          <i class="fas fa-eye"></i>
        </div>

        <!-- Champ de saisie pour l'image. -->
        <div class="field image">
          <label>Photo</label>
          <input type="file" name="image" accept="image/x-png,image/gif,image/jpeg,image/jpg" required>
        </div>

        <!-- Bouton pour soumettre le formulaire. -->
        <div class="field button">
          <input type="submit" name="submit" value="Créer">
        </div>
      </form>

      <!-- Lien vers la page de connexion. -->
      <div class="link">Deja un compte? <a href="login.php">Se connecter</a></div>
    </section>
  </div>

  <!-- Inclut les fichiers JavaScript. -->
  <script src="javascript/pass-show-hide.js"></script>
  <script src="javascript/signup.js"></script>
</body>

</html>