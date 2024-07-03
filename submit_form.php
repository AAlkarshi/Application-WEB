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

#Concerne ID_Recapitulatif de la table utilisateur
function generateUniqueID($conn) {
    $sql = "SELECT MAX(ID_Recapitulatif) AS max_id FROM utilisateur";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    return $row['max_id'] + 1;
}

// Vérifiez si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifiez si les champs du formulaire existent et sont non vides
    if (isset($_POST['nom'], $_POST['prenom'], $_POST['email'], $_POST['mdp'])) {
        // Récupérer les données du formulaire
        $NomUtilisateur = $_POST['nom'];
        $PrenomUtilisateur = $_POST['prenom'];
        $EmailUtilisateur = $_POST['email'];
        $MDPUtilisateur = password_hash($_POST['mdp'], PASSWORD_DEFAULT); // Hacher le mot de passe
        
        // Générer un ID_Recapitulatif unique (optionnel)
         $ID_Recapitulatif = generateUniqueID($conn);

        // Insertion d'un nouvel utilisateur avec ID_Recapitulatif généré
        $sql_utilisateur = "INSERT INTO utilisateur (NomUtilisateur, PrenomUtilisateur, EmailUtilisateur, MDPUtilisateur, ID_Recapitulatif) 
                            VALUES (?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql_utilisateur);
        if ($stmt === false) {
            die("Erreur lors de la préparation de la requête pour utilisateur: " . $conn->error);
        }

        $stmt->bind_param("ssssi", $NomUtilisateur, $PrenomUtilisateur, $EmailUtilisateur, $MDPUtilisateur, $ID_Recapitulatif);

        if ($stmt->execute()) {
            // Succès de l'insertion de l'utilisateur

            // Gestion de la session et redirection
            $_SESSION['NomUtilisateur'] = $NomUtilisateur;
            $_SESSION['PrenomUtilisateur'] = $PrenomUtilisateur;
            $_SESSION['success_message'] = "Nouvel enregistrement créé avec succès";
            $stmt->close();

            // Redirection vers home.php
            header("Location: http://applicationweb:8080/home.php");
            exit();
        } else {
            echo "Erreur lors de l'insertion de l'utilisateur: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Tous les champs du formulaire ne sont pas définis ou sont vides.";
    }
}

// Fermer la connexion
$conn->close();
?>
