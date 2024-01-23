<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<title> Application Web </title>
</head>
<body>
	<h3>Ajout d'un Produit </h3>


	<form action="traitement.php" method="post">
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
				<input type="text" name="quantite"> 
			</label>
		</p>
		<p>
				<input type="submit" name="submit" value="Ajouter le produit">
		</p>
	</form>











</body>
</html>