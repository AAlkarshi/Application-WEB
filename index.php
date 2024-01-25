<?php 
session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="stylesheet" type="text/css" href="index.css">
	<title> Application Web </title>
</head>
<body>
	
<?php
	require "nav.php";
?>

<h3>Ajout d'un Produit </h3>


<?php
	if (isset($_SESSION['message'])) {
	    echo "<p>{$_SESSION['message']}</p>";

	    //unset DESACTIVE une variable
	    unset($_SESSION['message']); 
	}
?>



	<form action="traitement.php?action=add" method="post">
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

</body>
</html>