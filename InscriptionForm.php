<?php
session_start();
ob_start();

// Définir le titre de la page
$title = "Formulaire d'inscription";



?>


<h3 style="font-size:25px; padding:15px 15px; display:flex; width:100%; justify-content:center;"> 
    Je m'inscris 
</h3>
        
<div>
    <h4 style="font-size:20px; color:black; padding:15px 15px; display:flex; width:100%; justify-content:center;">Veuillez remplir ce formulaire afin de vous inscrire</h4>
</div>


<div class="form-inscription" style="width: 100%; margin-left: auto;margin-right: auto; max-width:600px;
padding: 20px;border: 2px solid #ffffff; background-color: #ffffff;border-radius: 10px;box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);text-align: center;">
    <h2 style="font-size:20px; padding:15px 15px; display:flex; width:100%; height:100%; justify-content:center;">Formulaire d'inscription</h2>
    <form action="submit_form.php" method="post" class="formulaireinscription">
        <div class="form-group" style="padding:15px 15px;">
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" required>
        </div>
        <div class="form-group" style="padding:15px 15px;">
            <label for="prenom">Prénom :</label>
            <input type="text" id="prenom" name="prenom" required>
        </div>
        <div class="form-group" style="padding:15px 15px;">
            <label for="email">Email :</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group" style="padding:15px 15px;">
            <label for="mdp">Mot de passe :</label>
            <input type="password" id="mdp" name="mdp" required minlength="12" 
                pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+"
                title="Votre mot de passe doit contenir au moins 12 caractères, une lettre majuscule, une lettre minuscule, un chiffre et un caractère spécial.">
        </div>
        <input type="hidden" name="ID_Recapitulatif" value="1">
        <div class="form-group">
            <input type="submit" value="Valider">
        </div>
        <small style="color:red; padding:10px 10px;"> * Votre mot de passe doit contenir au moins 12 caractères, une lettre majuscule, une lettre minuscule, un chiffre et un caractère spécial. </small>
    </form>
    <div style="padding:15px;">
    <a href="http://applicationweb:8080/EmailMAJ.php" style="color: blue;">Mot de passe oublié?</a>
</div>

</div>


<?php
// Récupère le contenu et le stocke dans la variable $content
$content = ob_get_clean();

// Inclut le fichier template.php
require_once "template.php";
?>
