<?php
session_start();
ob_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Formulaire de connexion</title>
</head>
<body>

<section style="display: flex; width: 100%;">
    <h4 style="flex: 1; height: 40px; padding: 35px; color: black; margin: 0; width:100%;">
        Une fois inscrit, connectez-vous !
    </h4>
</section>

<div class="form-connexion">
    <p style="font-size:20px;"> Connectez-vous ! </p>
    <form method="post" class="custom-form" action="src/Controller/login.php">
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="mdp">Mot de passe:</label>
            <input type="password" id="mdp" name="mdp" required>
        </div>
        <div class="form-group">
            <input type="submit" value="Se connecter">
        </div>

        <?php
        // Affichage des erreurs si elles existent
        if (isset($_SESSION['error_message'])) {
            echo '<p style="color: red;">' . $_SESSION['error_message'] . '</p>';
            unset($_SESSION['error_message']); 
        }
        ?>

        <a href="http://applicationweb:8080/EmailMAJ.php" style="color: blue;">Mot de passe oublié?</a>
    </form>
</div>

</body>
</html>

<?php
// Récupère le contenu et le stocke dans la variable $content
$content = ob_get_clean();

// Inclut le fichier template.php
require_once "template.php";
?>
