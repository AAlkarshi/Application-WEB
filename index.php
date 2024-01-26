<?php 
session_start();
ob_start();

?>

<h3>Ajout d'un Produit </h3>

<?php $title = "Index"; ?>


<?php
	// Faire afficher des Messages de notifications
	if (isset($_SESSION['message'])) {
	    echo "<p>{$_SESSION['message']}</p>";

	    //unset DESACTIVE une variable
	    unset($_SESSION['message']); 
	}
?>

<div class="d-flex flex-column w-75 flex-grow-1">
	<div class="d-flex justify-content-center flex-column flex-wrap ml-5 mr-5 mb-5">

		<form action="traitement.php?action=add" method="post" enctype="multipart/form-data">
			<p>
				<label> Nom du Produit :
					<input type="text" name="produit"> 
				</label>
			</p>
			<p>
				<label> Prix du Produit :
					<input type="text" name="prix"> 
				</label>
			</p>
			<p>
				<label> Quantité voulu : 
					<input type="number" name="quantite"> 
				</label>
			</p>
			<p>
					<input type="submit" name="submit" value="Ajouter le produit">
			</p>
		</form>

	</div>
</div>



<?php

// Recupere le contenu et le stocke ds la var $content
	$content = ob_get_clean();

//Recupere le code du fichier 
	require_once "template.php";
	
?>
