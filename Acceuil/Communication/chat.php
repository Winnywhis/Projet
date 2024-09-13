<?php
// Démarrage de la session
session_start();

// Inclusion du fichier de configuration
include_once "php/config.php";

// Vérification si l'utilisateur est connecté (unique_id dans la session)
if (!isset($_SESSION['unique_id'])) {
  // Redirection vers la page de connexion si non connecté
  header("location: login.php");
}
?>
<?php
// Inclusion du fichier d'en-tête
include_once "header.php";
?>

<body>
  <div class="wrapper">
    <section class="chat-area">
      <header>
        <?php
        // Récupération de l'ID de l'utilisateur à partir de l'URL
        $user_id = mysqli_real_escape_string($conn, $_GET['user_id']);

        // Requête pour récupérer les données de l'utilisateur à partir de la base de données
        $sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = {$user_id}");

        // Vérification si des données ont été trouvées
        if (mysqli_num_rows($sql) > 0) {
          // Récupération des données de l'utilisateur sous forme de tableau associatif
          $row = mysqli_fetch_assoc($sql);
        } else {
          // Redirection vers la page des utilisateurs si aucun utilisateur trouvé
          header("location: users.php");
        }
        ?>
        <!-- Lien de retour vers la page des utilisateurs -->
        <a href="users.php" class="back-icon">
          <i class="fas fa-arrow-left">retour</i></a>

        <!-- Affichage de l'image de l'utilisateur -->
        <img src="php/images/<?php echo $row['img']; ?>" alt="">

        <!-- Affichage des détails de l'utilisateur -->
        <div class="details">
          <span><?php echo $row['fname'] . " " . $row['lname'] ?></span>
          <p><?php echo $row['status']; ?></p>
        </div>
      </header>

      <!-- Zone de chat -->
      <div class="chat-box">
      </div>

      <!-- Formulaire pour envoyer un message -->
      <form action="#" class="typing-area">
        <!-- Champ caché pour l'ID de l'utilisateur destinataire -->
        <input type="text" class="incoming_id" name="incoming_id" value="<?php echo $user_id; ?>" hidden>

        <!-- Champ pour saisir le message -->
        <input type="text" name="message" class="input-field" placeholder="Type a message here..." autocomplete="off">

        <!-- Bouton pour envoyer le message -->
        <button><i class="fab fa-telegram-plane"></i></button>
      </form>
    </section>
  </div>

  <!-- Inclusion du fichier JavaScript pour la fonctionnalité de chat -->
  <script src="javascript/chat.js"></script>

</body>

</html>