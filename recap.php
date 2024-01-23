<?php
	session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<title> Application Web - Récapitulatif des Produits </title>
</head>
<body>
	
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
					"</tr>",
				"</thead>",
			"<tbody>";

		$totalGeneral = 0;

			foreach ($_SESSION['tableaux'] as $index => $tableau) {
				echo "<tr>",
						"<td>" . $index . "</td>",
						"<td>" . $tableau['produit'] . "</td>",
						"<td>".number_format($tableau['prix'],2,",","&nbsp;")."&nbsp;€</td>",
						"<td>" . $tableau['quantite'] . "</td>",
						"<td>".number_format($tableau['total'],2,",","&nbsp;"). "&nbsp;€ </td>",
					"</tr>";
					
					$totalGeneral += $tableau['total'];
			}

			echo "<tr>",
					"<td colspan=4> Total géneral : </td>",
					"<td> <strong>". number_format($totalGeneral,2, "," , "&nbsp;"). "&nbsp;€ </strong> </td>" ,
				 "</tr>",
			 "</tbody>",
		"</table>";
	}
	
?>


</body>
</html>

