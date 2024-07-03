<?php
session_start();
ob_start();
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
                // Email trouvé dans la base de données : rediriger vers MAJmotdepasse.php
                header("Location: http://applicationweb:8080/MAJmotdepasse.php?email=" . urlencode($email));
                exit();
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
}

// Fermer la connexion
$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation du mot de passe</title>
</head>
<body style="height:100%;">
    <div class="form-reset" style="height:100%; align-items:center;margin-left: auto;margin-right: auto;">
        <h2 style="font-size:20px; padding:15px 15px; display:flex; width:100%; justify-content:center;">Réinitialisation du mot de passe</h2>
        <br>
        <p style="font-size:20px;"> Veuillez y entrer votre Email.</p>
        <br>
        <?php echo isset($_SESSION['reset_message']) ? "<div class='message'>{$_SESSION['reset_message']}</div>" : ''; ?>
        <form style="height:100%; action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label for="email">Email :</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <input type="submit" value="Réinitialiser le mot de passe">
            </div>
        </form>
    </div>
</body>
</html>

<?php
// Effacer le message de la session après l'avoir affiché
unset($_SESSION['reset_message']);

$content = ob_get_clean();

// Inclut template.php
require_once "template.php";
?>
