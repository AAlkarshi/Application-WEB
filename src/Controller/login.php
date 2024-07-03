<?php
session_start();

// Configuration de la base de données
$servername = "localhost";
$username = "root";
$password = "changeme";
$dbname = "appweb";

// Connexion à la base de données
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("La connexion à la base de données a échoué : " . $conn->connect_error);
}

// Limite de tentatives de connexion
$max_attempts = 3;

// Temps de blocage en secondes
$lockout_time = 60; 

// Initialisation des variables de session pour les tentatives de connexion
if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
}
if (!isset($_SESSION['last_attempt_time'])) {
    $_SESSION['last_attempt_time'] = 0;
}

// Vérifiez si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifiez si l'utilisateur est verrouillé
    if ($_SESSION['login_attempts'] >= $max_attempts && (time() - $_SESSION['last_attempt_time']) < $lockout_time) {
        $_SESSION['error_message'] = "Trop de tentatives de connexion. Réessayez dans " . ($lockout_time - (time() - $_SESSION['last_attempt_time'])) . " secondes.";
        header("Location: http://applicationweb:8080/ConnexionForm.php");
        exit();
    }
    
    if (isset($_POST['email'], $_POST['mdp'])) {
        // Récupérer les données du formulaire
        $EmailUtilisateur = $_POST['email'];
        $MDPUtilisateur = $_POST['mdp'];

        // Préparer et exécuter la requête de sélection
        $sql = "SELECT ID_Utilisateur, NomUtilisateur, PrenomUtilisateur, MDPUtilisateur FROM utilisateur WHERE EmailUtilisateur = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            $_SESSION['error_message'] = "Erreur lors de la préparation de la requête: " . $conn->error;
            header("Location: http://applicationweb:8080/ConnexionForm.php");
            exit();
        }
        $stmt->bind_param("s", $EmailUtilisateur);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($ID_Utilisateur, $NomUtilisateur, $PrenomUtilisateur, $hashedPassword);
            $stmt->fetch();

            // Vérifier le mot de passe
            if (password_verify($MDPUtilisateur, $hashedPassword)) {
                // Auth réussi, réinitialiser les tentatives limites
                $_SESSION['login_attempts'] = 0;
                $_SESSION['last_attempt_time'] = 0;

                $_SESSION['ID_Utilisateur'] = $ID_Utilisateur;
                $_SESSION['NomUtilisateur'] = $NomUtilisateur;
                $_SESSION['PrenomUtilisateur'] = $PrenomUtilisateur;
                header("Location: http://applicationweb:8080/home.php");
                exit();
            } else {
                /* Rajoute 1 par tentative*/
                $_SESSION['login_attempts']++;
                $_SESSION['last_attempt_time'] = time();
                $_SESSION['error_message'] = "Mot de passe incorrect.";
            }
        } else {
            $_SESSION['login_attempts']++;
            $_SESSION['last_attempt_time'] = time();
            $_SESSION['error_message'] = "Aucun utilisateur trouvé avec cet email.";
        }

        $stmt->close();
    } else {
        $_SESSION['error_message'] = "Tous les champs du formulaire ne sont pas définis ou sont vides.";
    }

    // Redirection vers la page de connexion
    header("Location: http://applicationweb:8080/ConnexionForm.php");
    exit();
}

// Fermer la connexion
$conn->close();
?>
