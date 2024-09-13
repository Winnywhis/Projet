<?php
// Démarrage de la session
session_start();

// Vérification si un utilisateur est déjà connecté (identifié par un unique_id dans la session)
if (isset($_SESSION['unique_id'])) {
  // Si oui, redirection vers la page users.php
  header("location: users.php");
}
?>

<?php
// Inclusion du fichier header.php
include_once "header.php";
?>

<body>
  <!-- Conteneur principal de la page -->
  <div class="wrapper">
    <!-- Section de la page pour le formulaire de connexion -->
    <section class="form login">
      <!-- En-tête de la section -->
      <header>LOGIN</header>

      <!-- Formulaire de connexion -->
      <form action="#" method="POST" enctype="multipart/form-data" autocomplete="off">
        <!-- Message d'erreur (vide par défaut) -->
        <div class="error-text"></div>

        <!-- Champ de saisie pour l'adresse e-mail -->
        <div class="field input">
          <label>Email </label>
          <input type="text" name="email" placeholder="Entrez votre email" required>
        </div>

        <!-- Champ de saisie pour le mot de passe -->
        <div class="field input">
          <label>Password</label>
          <input type="password" name="password" placeholder="Entrez votre mot de passe" required>
          <!-- Icône pour afficher/masquer le mot de passe -->
          <i class="fas fa-eye"></i>
        </div>

        <!-- Bouton de soumission du formulaire -->
        <div class="field button">
          <input type="submit" name="submit" value="Connexion">
        </div>
      </form>

      <!-- Lien vers la page d'inscription -->
      <div class="link">Pas de compte? <a href="index.php">S'inscrire</a></div>
    </section>
  </div>

  <!-- Inclusion de fichiers JavaScript pour la gestion de la visibilité du mot de passe et la soumission du formulaire -->
  <script src="javascript/pass-show-hide.js"></script>
  <script src="javascript/login.js"></script>

</body>

</html>