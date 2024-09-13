<?php
// Démarrage de la session
session_start();

// Inclusion du fichier de configuration
include_once "config.php";

// Récupération de l'ID unique de l'utilisateur en cours
$outgoing_id = $_SESSION['unique_id'];

// Récupération et échappement du terme de recherche provenant de la requête POST
$searchTerm = mysqli_real_escape_string($conn, $_POST['searchTerm']);

// Requête SQL pour sélectionner les utilisateurs dont le nom ou le prénom correspond au terme de recherche, en excluant l'utilisateur en cours
$sql = "SELECT * FROM users WHERE NOT unique_id = {$outgoing_id} AND (fname LIKE '%{$searchTerm}%' OR lname LIKE '%{$searchTerm}%') ";

// Initialisation de la variable de sortie
$output = "";

// Exécution de la requête SQL
$query = mysqli_query($conn, $sql);

// Vérification si des résultats ont été trouvés
if (mysqli_num_rows($query) > 0) {
    // Inclusion du fichier de données si des résultats ont été trouvés
    include_once "data.php";
} else {
    // Définition du message de sortie si aucun résultat n'a été trouvé
    $output .= 'Aucun utilisateur trouvé avec cet element';
}

// Affichage de la variable de sortie
echo $output;
