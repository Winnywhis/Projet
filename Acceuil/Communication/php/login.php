<?php
// Démarre une session pour stocker des informations utilisateur
session_start();

// Inclut le fichier de configuration pour accéder à la base de données
include_once "config.php";

// Récupère l'email et le mot de passe du formulaire de connexion
$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

// Vérifie si les champs email et mot de passe sont remplis
if (!empty($email) && !empty($password)) {
    // Recherche l'utilisateur dans la base de données en fonction de l'email
    $sql = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");

    // Vérifie si l'utilisateur existe
    if (mysqli_num_rows($sql) > 0) {
        // Récupère les informations de l'utilisateur
        $row = mysqli_fetch_assoc($sql);

        // Hash le mot de passe pour le comparer avec celui stocké en base
        $user_pass = md5($password);
        $enc_pass = $row['password'];

        // Vérifie si les mots de passe correspondent
        if ($user_pass === $enc_pass) {
            // Met à jour le statut de l'utilisateur en "En ligne"
            $status = "En ligne";
            $sql2 = mysqli_query($conn, "UPDATE users SET status = '{$status}' WHERE unique_id = {$row['unique_id']}");

            // Vérifie si la mise à jour a réussi
            if ($sql2) {
                // Stocke l'ID unique de l'utilisateur en session
                $_SESSION['unique_id'] = $row['unique_id'];
                // Affiche un message de succès
                echo "success";
            } else {
                // Affiche un message d'erreur
                echo "Quelque chose n'a pas fonctionné, veillez réessayer";
            }
        } else {
            // Affiche un message d'erreur si les mots de passe ne correspondent pas
            echo "Email ou Mot de passe incorrect!";
        }
    } else {
        // Affiche un message d'erreur si l'utilisateur n'existe pas
        echo "$email - Cet Email n'existe pas!";
    }
} else {
    // Affiche un message d'erreur si les champs ne sont pas remplis
    echo "Veillez remplir tous les champs!";
}
