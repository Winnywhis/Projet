<?php
// Démarrage de la session pour accéder aux variables de session
session_start();

// Inclusion du fichier de configuration pour accéder aux paramètres de connexion à la base de données
include_once "config.php";

// Récupération de l'identifiant unique de l'utilisateur connecté
$outgoing_id = $_SESSION['unique_id'];

// Requête SQL pour sélectionner tous les utilisateurs de la base de données, à l'exclusion de l'utilisateur connecté, et les trier par ordre décroissant d'identifiant
$sql = "SELECT * FROM users WHERE NOT unique_id = {$outgoing_id} ORDER BY user_id DESC";

// Exécution de la requête SQL
$query = mysqli_query($conn, $sql);

// Initialisation d'une variable pour stocker le résultat
$output = "";

// Vérification du nombre de lignes retournées par la requête
if (mysqli_num_rows($query) == 0) {
    // Si aucune ligne n'est retournée, affichage d'un message indiquant qu'aucun utilisateur n'est disponible pour discuter
    $output .= "Aucun utilisateur disponible";
} elseif (mysqli_num_rows($query) > 0) {
    // Si des lignes sont retournées, inclusion d'un autre fichier PHP pour gérer l'affichage des utilisateurs
    include_once "data.php";
}

// Affichage du résultat
echo $output;
