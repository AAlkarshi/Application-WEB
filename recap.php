<?php
	session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="stylesheet" type="text/css" href="index.css">
	<title> Application Web - Récapitulatif des Produits </title>
</head>
<body>

	<h3> Récapitulatif des Produits </h3>

	<?php require "nav.php";  ?>
	
<?php
	if(!isset($_SESSION['tableaux']) || empty($_SESSION['tableaux'])){
		echo "<p> Aucun produit en session...</p>";
	}
	else{
		echo "<table>",
				"<thead>",
					"<tr>",
						"<th>#</th>",
						"<th>Nom</th>",
						"<th>Prix</th>",
						"<th>Quantité</th>",
						"<th>Total</th>",
						"<th>Suppression</th>",
					"</tr>",
				"</thead>",
			"<tbody>";

		$totalGeneral = 0;
		$totalQuantite = 0;

		foreach ($_SESSION['tableaux'] as $index => $tableau) {
		echo "<tr>",
				"<td>" . $index . "</td>",
				"<td>" . $tableau['produit'] . "</td>",

				// PRIX
				"<td>".number_format($tableau['prix'],2,",","&nbsp;")."&nbsp;€</td>",

				// BTN -
				"<td name='BtnDiminution'> <a href=> - </a> </td>",
	
				//QUANTITE
				"<td>" . $tableau['quantite'] . "</td>",

				// BTN +
				"<td name='BtnAugmentation'> <a href=> + </a> </td>",

				//TOTAL
				"<td>".number_format($tableau['total'],2,",","&nbsp;")."&nbsp;€</td>",

				//SUPP CE PRODUIT
				"<td > 
					<a name='BtnSuppCeProduit' href=> Supprimer ce produit </a> 
				</td>",

					
			"</tr>";
					
					$totalGeneral += $tableau['total'];
					$totalQuantite += $tableau['quantite'];
			}

			echo "<tr>",
					"<td colspan=4> Total des Quantité : </td>",
					"<td> <strong>". number_format($totalQuantite,0,",","&nbsp;")."&nbsp;</strong></td>",
					"<td colspan=4> Total géneral : </td>",
					"<td> <strong>". number_format($totalGeneral,2,",","&nbsp;")."&nbsp;€</strong> </td>" ,

	
			"<td > 
			<a name='BtnSuppTOUTlesProduits'href=> Supprimer tout les produits</a>
			</td>",

				 "</tr>",
			 "</tbody>",
		"</table>";
	}
	
?>


</body>
</html>

