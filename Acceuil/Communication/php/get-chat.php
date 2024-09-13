<?php
// Démarrage de la session pour accéder aux variables de session
session_start();

// Vérification si l'utilisateur est connecté en vérifiant l'existence de l'ID unique dans la session
if (isset($_SESSION['unique_id'])) {
    // Inclusion du fichier de configuration pour accéder à la base de données
    include_once "config.php";

    // Récupération de l'ID unique de l'utilisateur connecté
    $outgoing_id = $_SESSION['unique_id'];

    // Récupération de l'ID de l'utilisateur avec lequel on souhaite afficher les messages
    $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);

    // Initialisation de la variable qui stockera les messages
    $output = "";

    // Requête SQL pour récupérer les messages entre les deux utilisateurs
    $sql = "SELECT * FROM messages 
                LEFT JOIN users ON users.unique_id = messages.outgoing_msg_id
                WHERE (outgoing_msg_id = {$outgoing_id} AND incoming_msg_id = {$incoming_id})
                OR (outgoing_msg_id = {$incoming_id} AND incoming_msg_id = {$outgoing_id}) 
                ORDER BY msg_id";

    // Exécution de la requête SQL
    $query = mysqli_query($conn, $sql);

    // Vérification si des messages ont été trouvés
    if (mysqli_num_rows($query) > 0) {
        // Boucle pour parcourir les messages
        while ($row = mysqli_fetch_assoc($query)) {
            // Vérification si le message est envoyé par l'utilisateur connecté
            if ($row['outgoing_msg_id'] === $outgoing_id) {
                // Ajout du message à la variable de sortie avec le style "outgoing"
                $output .= '<div class="chat outgoing">
                                <div class="details">
                                    <p>' . $row['msg'] . '</p>
                                </div>
                                </div>';
            } else {
                // Ajout du message à la variable de sortie avec le style "incoming"
                $output .= '<div class="chat incoming">
                                <img src="php/images/' . $row['img'] . '" alt="">
                                <div class="details">
                                    <p>' . $row['msg'] . '</p>
                                </div>
                                </div>';
            }
        }
    } else {
        // Si aucun message n'a été trouvé, ajout d'un message indiquant qu'aucun message n'est disponible
        $output .= '<div class="text">No messages are available. Once you send message they will appear here.</div>';
    }

    // Affichage des messages
    echo $output;
} else {
    // Si l'utilisateur n'est pas connecté, redirection vers la page de connexion
    header("location: ../login.php");
}
