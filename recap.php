<?php
	session_start();
	ob_start();
?>
	<h3> Récapitulatif des Produits </h3>

	<?php $title = "Récapitulatif"; ?>
	
<?php
	if(!isset($_SESSION['produits']) || empty($_SESSION['produits'])){
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

		foreach ($_SESSION['produits'] as $index => $tableau) {
		echo "<tr>",
				"<td>" . $index . "</td>",
				"<td>" . $tableau['produit'] . "</td>",

				// PRIX
				"<td>".number_format($tableau['prix'],2,",","&nbsp;")."&nbsp;€</td>",

				// BTN -
				"<td> <a href='traitement.php?action=BtnDiminution&id=$index''> - </a> </td>",
	
				//QUANTITE
				"<td>" . $tableau['quantite'] . "</td>",

				// BTN +
				"<td> <a href='traitement.php?action=BtnAugmentation&id=$index'> + </a> </td>",

				//TOTAL
				"<td>".number_format($tableau['total'],2,",","&nbsp;")."&nbsp;€</td>",

				//SUPP CE PRODUIT
				"<td> 
					<a href='traitement.php?action=suppProduit&id=$index'> Supprimer ce produit </a> 
				</td>",	
			"</tr>";
					
					$totalGeneral += $tableau['total'];
					$totalQuantite += $tableau['quantite'];
		}
			echo "<tr>",
					"<td colspan=2> Total des Quantité : </td>",
					"<td> <strong>". number_format($totalQuantite,0,",","&nbsp;")."&nbsp;</strong></td>",
					"<td colspan=2> Total géneral : </td>",
					"<td> <strong>". number_format($totalGeneral,2,",","&nbsp;")."&nbsp;€</strong> </td>" ,
			"<td> <a href='traitement.php?action=viderPanier'> Supprimer tout les produits</a> </td>",
				 "</tr>",
			 "</tbody>",
		"</table>";
	}
	




$content = ob_get_clean();
require_once "template.php";


?>

