<?php
session_start();

// Configuration de la base de données
$servername = "localhost";
$username = "root";
$password = "changeme";
$dbname = "appweb";

// Créer une connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("La connexion a échoué: " . $conn->connect_error);
}

// Vérifiez si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['email'])) {
        $email = $_POST['email'];

        // Vérifier si l'email existe dans la base de données
        $sql = "SELECT ID_Recapitulatif FROM utilisateur WHERE EmailUtilisateur = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die("Erreur lors de la préparation de la requête: " . $conn->error);
        }

        $stmt->bind_param("s", $email);
        if ($stmt->execute()) {
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                // Générer un mot de passe aléatoire
                $new_password = generateRandomPassword();

                // Hasher le mot de passe
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

                // Mettre à jour le mot de passe dans la base de données
                $update_sql = "UPDATE utilisateur SET MDPUtilisateur = ? WHERE EmailUtilisateur = ?";
                $update_stmt = $conn->prepare($update_sql);
                if ($update_stmt === false) {
                    die("Erreur lors de la préparation de la requête de mise à jour: " . $conn->error);
                }

                $update_stmt->bind_param("ss", $hashed_password, $email);
                if ($update_stmt->execute()) {
                    // Envoyer le nouveau mot de passe par email (simulation ici)
                    $subject = "Réinitialisation de votre mot de passe";
                    $message = "Votre nouveau mot de passe est : " . $new_password;
                    $headers = "From: no-reply@applicationweb.com";

                    if (mail($email, $subject, $message, $headers)) {
                        $_SESSION['reset_message'] = "Un nouveau mot de passe a été envoyé à votre adresse email.";
                    } else {
                        $_SESSION['reset_message'] = "Erreur lors de l'envoi de l'email.";
                    }
                } else {
                    $_SESSION['reset_message'] = "Erreur lors de la réinitialisation du mot de passe.";
                }

                $update_stmt->close();
            } else {
                $_SESSION['reset_message'] = "Cet email n'est pas enregistré dans notre système.";
            }
        } else {
            $_SESSION['reset_message'] = "Erreur lors de la recherche de l'email dans la base de données.";
        }

        $stmt->close();
    } else {
        $_SESSION['reset_message'] = "Email non fourni.";
    }

    // Rediriger vers la page de réinitialisation
    header("Location: MAJmotdepasse.php");
    exit();
}

// Fermer la connexion
$conn->close();

// Fonction pour générer un mot de passe aléatoire
function generateRandomPassword($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()_+';
    $password = '';
    $max = strlen($characters) - 1;

    for ($i = 0; $i < $length; $i++) {
        $password .= $characters[random_int(0, $max)];
    }

    return $password;
}
?>
