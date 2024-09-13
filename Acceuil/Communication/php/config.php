<?php
// Définition des paramètres de connexion à la base de données
$hostname = "localhost"; // Nom de l'hôte de la base de données
$username = "root"; // Nom d'utilisateur pour la connexion
$password = ""; // Mot de passe pour la connexion (vide dans cet exemple)
$dbname = "chatapp"; // Nom de la base de données à utiliser

// Établissement de la connexion à la base de données
$conn = mysqli_connect($hostname, $username, $password, $dbname);

// Vérification de la réussite de la connexion
if (!$conn) {
  // Affichage d'un message d'erreur si la connexion échoue
  echo "Database connection error" . mysqli_connect_error();
}
