<?php
// Démarre une session
session_start();

// Inclut le fichier de configuration
include_once "config.php";

// Récupère les valeurs des champs de formulaire et les sanitize pour éviter les injections SQL
$fname = mysqli_real_escape_string($conn, $_POST['fname']);
$lname = mysqli_real_escape_string($conn, $_POST['lname']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

// Vérifie si tous les champs obligatoires sont remplis
if (!empty($fname) && !empty($lname) && !empty($email) && !empty($password)) {
    // Vérifie si l'adresse e-mail est valide
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Recherche si l'adresse e-mail existe déjà dans la base de données
        $sql = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
        if (mysqli_num_rows($sql) > 0) {
            // Si l'adresse e-mail existe déjà, affiche un message d'erreur
            echo "$email - Cet Email existe déjà!";
        } else {
            // Si l'adresse e-mail n'existe pas, vérifie si un fichier image a été uploadé
            if (isset($_FILES['image'])) {
                // Récupère les informations sur le fichier image
                $img_name = $_FILES['image']['name'];
                $img_type = $_FILES['image']['type'];
                $tmp_name = $_FILES['image']['tmp_name'];

                // Récupère l'extension du fichier image
                $img_explode = explode('.', $img_name);
                $img_ext = end($img_explode);

                // Définit les extensions de fichiers images autorisées
                $extensions = ["jpeg", "png", "jpg"];
                if (in_array($img_ext, $extensions) === true) {
                    // Définit les types de fichiers images autorisés
                    $types = ["image/jpeg", "image/jpg", "image/png"];
                    if (in_array($img_type, $types) === true) {
                        // Génère un nom de fichier unique pour l'image
                        $time = time();
                        $new_img_name = $time . $img_name;
                        // Déplace le fichier image dans le répertoire des images
                        if (move_uploaded_file($tmp_name, "images/" . $new_img_name)) {
                            // Génère un ID unique pour l'utilisateur
                            $ran_id = rand(time(), 100000000);
                            // Définit le statut de l'utilisateur
                            $status = "En ligne";
                            // Crypte le mot de passe
                            $encrypt_pass = md5($password);
                            // Insère les informations de l'utilisateur dans la base de données
                            $insert_query = mysqli_query($conn, "INSERT INTO users (unique_id, fname, lname, email, password, img, status)
                                VALUES ({$ran_id}, '{$fname}','{$lname}', '{$email}', '{$encrypt_pass}', '{$new_img_name}', '{$status}')");
                            if ($insert_query) {
                                // Recherche l'utilisateur dans la base de données pour récupérer son ID
                                $select_sql2 = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
                                if (mysqli_num_rows($select_sql2) > 0) {
                                    // Récupère les informations de l'utilisateur
                                    $result = mysqli_fetch_assoc($select_sql2);
                                    // Définit l'ID de l'utilisateur dans la session
                                    $_SESSION['unique_id'] = $result['unique_id'];
                                    // Affiche un message de succès
                                    echo "success";
                                } else {
                                    // Si l'utilisateur n'est pas trouvé, affiche un message d'erreur
                                    echo "Cet Email n'existe pas!";
                                }
                            } else {
                                // Si l'insertion des informations de l'utilisateur échoue, affiche un message d'erreur
                                echo "Quelque chose n'a pas fonctionné, veillez réessayer!";
                            }
                        }
                    } else {
                        // Si le type de fichier image n'est pas autorisé, affiche un message d'erreur
                        echo "Veillez importer une image - jpeg, png, jpg";
                    }
                } else {
                    // Si l'extension de fichier image n'est pas autorisée, affiche un message d'erreur
                    echo "Importez une image avec les formats suivant - jpeg, png, jpg";
                }
            }
        }
    } else {
        // Si l'adresse e-mail n'est pas valide, affiche un message d'erreur
        echo "$email n'est pas valide!";
    }
} else {
    // Si les champs obligatoires ne sont pas remplis, affiche un message d'erreur
    echo "Veillez remplir tous les champs!";
}
