<?php
session_start();
ob_start();

?>

<?php $title = "Home"; ?>

<header style="display:flex; flex-direction:column; text-align:center; width:100%; justify-content:center; font-size:20px; background-color:#CFD5D6;">
        <div>
            <h4 style="text-align: center; padding:15px 15px;">Bienvenue sur notre site StockTesProduits.</h4>
        </div> 
        <div style="display:flex; justify-content:center; text-decoration: underline; ">
            <h4>Plateforme pour la gestion personnelle de produits, simple et efficace.</h4> 
        </div>
		<br>
        <p>
            Notre site permet aux utilisateurs de créer un compte, ajouter et gérer des produits, et voir une page récapitulative. Le processus d'inscription est simple et sécurisé. Après connexion, les utilisateurs peuvent ajouter des produits avec leur nom, description, image, prix unitaire et quantité. Tous les produits sont visibles sur une page récapitulative avec calcul du prix total. Les utilisateurs peuvent ajuster les quantités et attribuer des notes.
        </p>
        <div style="display:flex; justify-content:center;">
            <p>Notre site offre une gestion intuitive des produits.</p>
        </div>
        <div style="display:flex; justify-content:center;">
            <p style="width:100%;"> 
                Idéal pour garder une trace de vos possessions, évaluer des produits et organiser vos affaires. Inscrivez-vous et transformez votre gestion de produits.
            </p>
        </div>
</header>


<main>
        <div class="faq-container">
            <h2 style="width:100%; display:flex; flex-direction: row; justify-content: center; background-color:grey; padding:15px 15px;">FAQ - Questions Fréquemment Posées</h2>
            <details class="faq-item">
                <summary class="faq-question">Comment puis-je m'inscrire ?</summary>
                <div class="faq-answer">
                    <p>Pour vous inscrire, cliquez sur le bouton "Inscription" en haut à droite de la page d'accueil. Remplissez les informations nécessaires, puis cliquez sur "Valider".</p>
                </div>
            </details>
            <details class="faq-item">
                <summary class="faq-question">Comment puis-je ajouter un produit ?</summary>
                <div class="faq-answer">
                    <p>Une fois connecté, allez à la page "Ajouter un produit". Remplissez les informations du produit et cliquez sur "Ajouter".</p>
                </div>
            </details>
            <details class="faq-item">
                <summary class="faq-question">Comment puis-je voir la liste de mes produits ?</summary>
                <div class="faq-answer">
                    <p>Pour voir la liste de vos produits, allez à la page "Récapitulatif". Vous y trouverez une liste complète de tous vos produits.</p>
                </div>
            </details>
            <details class="faq-item">
                <summary class="faq-question">Comment puis-je noter un produit ?</summary>
                <div class="faq-answer">
                    <p>Vous pouvez noter un produit directement sur la page récapitulative en cliquant sur l'option de notation à côté du produit.</p>
                </div>
            </details>
            <details class="faq-item">
                <summary class="faq-question">Comment puis-je modifier ou supprimer un produit ?</summary>
                <div class="faq-answer">
                    <p>Pour modifier ou supprimer un produit, allez à la page récapitulative et utilisez les options disponibles à côté de chaque produit.</p>
                </div>
            </details>
        </div>
    </main>


	




<?php

if (isset($_SESSION['success_message'])) {
	echo "<p>" . $_SESSION['success_message'] . "</p>";
	// Supprimer le message de la session pour ne pas l'afficher à chaque fois
	unset($_SESSION['success_message']);
}


// Recupere le contenu et le stocke ds la var $content
	$content = ob_get_clean();

//Recupere le code du fichier 
	require_once "template.php";
	
?>