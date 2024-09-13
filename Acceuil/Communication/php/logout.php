<?php
// Démarrage de la session
session_start();

// Vérification si l'utilisateur est connecté (unique_id est défini dans la session)
if (isset($_SESSION['unique_id'])) {
    // Inclusion du fichier de configuration
    include_once "config.php";

    // Récupération de l'ID de déconnexion depuis l'URL et échappement pour prévenir les injections SQL
    $logout_id = mysqli_real_escape_string($conn, $_GET['logout_id']);

    // Vérification si l'ID de déconnexion est défini
    if (isset($logout_id)) {
        // Définition du statut de l'utilisateur à "Offline now"
        $status = "Hors ligne";

        // Mise à jour du statut de l'utilisateur dans la base de données
        $sql = mysqli_query($conn, "UPDATE users SET status = '{$status}' WHERE unique_id={$_GET['logout_id']}");

        // Vérification si la mise à jour a réussi
        if ($sql) {
            // Suppression des variables de session
            session_unset();

            // Destruction de la session
            session_destroy();

            // Redirection vers la page de connexion
            header("location: ../login.php");
        }
    } else {
        // Redirection vers la page des utilisateurs si l'ID de déconnexion n'est pas défini
        header("location: ../users.php");
    }
} else {
    // Redirection vers la page de connexion si l'utilisateur n'est pas connecté
    header("location: ../login.php");
}
