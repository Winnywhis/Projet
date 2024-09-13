<?php
// Démarre une nouvelle session ou reprend une session existante
session_start();

// Vérifie si l'utilisateur est connecté en vérifiant l'existence d'un identifiant unique dans la session
if (isset($_SESSION['unique_id'])) {
    // Inclut le fichier de configuration pour établir la connexion à la base de données
    include_once "config.php";

    // Récupère l'identifiant unique de l'utilisateur connecté
    $outgoing_id = $_SESSION['unique_id'];

    // Récupère l'identifiant de l'utilisateur destinataire à partir des données POST
    $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);

    // Récupère le message à envoyer à partir des données POST
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    // Vérifie si le message n'est pas vide
    if (!empty($message)) {
        // Insère le message dans la table des messages avec les identifiants de l'expéditeur et du destinataire
        $sql = mysqli_query($conn, "INSERT INTO messages (incoming_msg_id, outgoing_msg_id, msg)
                                        VALUES ({$incoming_id}, {$outgoing_id}, '{$message}')") or die();
    }
} else {
    // Si l'utilisateur n'est pas connecté, redirige vers la page de connexion
    header("location: ../login.php");
}
