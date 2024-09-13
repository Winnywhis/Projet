<?php
// Boucle pour récupérer chaque ligne de la requête
while ($row = mysqli_fetch_assoc($query)) {
    // Requête pour récupérer le dernier message entre l'utilisateur et l'utilisateur courant
    $sql2 = "SELECT * FROM messages WHERE (incoming_msg_id = {$row['unique_id']}
                OR outgoing_msg_id = {$row['unique_id']}) AND (outgoing_msg_id = {$outgoing_id} 
                OR incoming_msg_id = {$outgoing_id}) ORDER BY msg_id DESC LIMIT 1";
    // Exécution de la requête
    $query2 = mysqli_query($conn, $sql2);
    // Récupération du résultat de la requête
    $row2 = mysqli_fetch_assoc($query2);

    // Vérification si un message existe, sinon affichage d'un message par défaut
    (mysqli_num_rows($query2) > 0) ? $result = $row2['msg'] : $result = "No message available";

    // Troncature du message si il dépasse 28 caractères
    (strlen($result) > 28) ? $msg =  substr($result, 0, 28) . '...' : $msg = $result;

    // Vérification si le message a été envoyé par l'utilisateur courant
    if (isset($row2['outgoing_msg_id'])) {
        // Ajout d'un préfixe "You: " si le message a été envoyé par l'utilisateur courant
        ($outgoing_id == $row2['outgoing_msg_id']) ? $you = "You: " : $you = "";
    } else {
        $you = "";
    }

    // Vérification du statut de l'utilisateur
    ($row['status'] == "Hors ligne") ? $offline = "Hors ligne" : $offline = "";

    // Vérification si l'utilisateur courant est l'utilisateur actuel
    ($outgoing_id == $row['unique_id']) ? $hid_me = "hide" : $hid_me = "";

    // Génération du HTML pour afficher l'utilisateur et son dernier message
    $output .= '<a href="chat.php?user_id=' . $row['unique_id'] . '">
                    <div class="content">
                    <img src="php/images/' . $row['img'] . '" alt="">
                    <div class="details">
                        <span>' . $row['fname'] . " " . $row['lname'] . '</span>
                        <p>' . $you . $msg . '</p>
                    </div>
                    </div>
                    <div class="status-dot ' . $offline . '"><i class="fas fa-circle"></i></div>
                </a>';
}
