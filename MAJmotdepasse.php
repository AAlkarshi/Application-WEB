<?php
session_start();
ob_start();

// Vérifier si l'e-mail est présent dans l'URL
if (!isset($_GET['email'])) {
    $_SESSION['reset_message'] = "L'email est requis pour la réinitialisation du mot de passe.";
    header("Location: InscriptionForm.php");
    exit();
}

$email = $_GET['email'];

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['new_password']) && isset($_POST['confirm_password'])) {
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        // Valider que les deux mots de passe correspondent
        if ($new_password !== $confirm_password) {
            $_SESSION['reset_message'] = "Les mots de passe ne correspondent pas.";
        } else {
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

            // Hasher le nouveau MDP
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            // MAJ le MDP dans BDD
            $update_sql = "UPDATE utilisateur SET MDPUtilisateur = ? WHERE EmailUtilisateur = ?";
            $update_stmt = $conn->prepare($update_sql);
            if ($update_stmt === false) {
                die("Erreur lors de la préparation de la requête de mise à jour: " . $conn->error);
            }

            $update_stmt->bind_param("ss", $hashed_password, $email);
            if ($update_stmt->execute()) {
                var_dump("Mot de passe mis à jour avec succès pour l'email : " . $email);
                $_SESSION['reset_message'] = "Le mot de passe a été réinitialisé avec succès.";
                header("Location: ConnexionForm.php");
                exit();
            } else {
                $_SESSION['reset_message'] = "Erreur lors de la réinitialisation du mot de passe.";
            }

            $update_stmt->close();
            $conn->close();
        }
    } else {
        $_SESSION['reset_message'] = "Veuillez remplir tous les champs.";
    }
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation du mot de passe</title>
    <link rel="stylesheet" href="index.css">
</head>



<body style="display: flex;justify-content: center;align-items: center;height: 100vh; margin: 0;background-color: #f0f0f0;">
    <div class="form-reset" style="width: 100%; max-width: 600px; margin-left: auto;margin-right: auto; padding: 20px;border: 2px solid #ffffff;background-color: #ffffff;border-radius: 10px;box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);text-align: center;">
        <h2 style="font-size:20px; padding:15px 15px; display:flex; width:100%; justify-content:center;">Réinitialisation du mot de passe</h2>
        <?php echo isset($_SESSION['reset_message']) ? "<div class='message'>{$_SESSION['reset_message']}</div>" : ''; ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?email=" . urlencode($email); ?>" method="post" style="width: 100%;">
            <div class="form-group" style="margin-bottom: 15px;">
                <label for="new_password" style=" display: block;margin-bottom: 5px;">Nouveau mot de passe :</label>
                <input type="password" style="width: calc(100% - 22px); padding: 10px;border: 1px solid #ccc;border-radius: 5px;" id="new_password" name="new_password" required minlength="12" 
                       pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+"
                       title="Votre mot de passe doit contenir au moins 12 caractères, une lettre majuscule, une lettre minuscule, un chiffre et un caractère spécial.">
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirmer le mot de passe :</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            <div class="form-group">
                <input type="submit" value="Réinitialiser le mot de passe" style="width: 100%;
                background-color: #007bff;color: white;border: none;padding: 10px;cursor: pointer;border-radius: 5px;">
            </div>
        </form>
    </div>
</body>
</html>

<?php
// Effacer le message de la session après l'avoir affiché
unset($_SESSION['reset_message']);
$content = ob_get_clean();

// Inclut le fichier template.php
require_once "template.php";
?>
