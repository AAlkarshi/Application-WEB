<?php
	session_start();

	if (isset($_POST['submit'])){

	$produit = filter_input(INPUT_POST, "produit" , FILTER_SANITIZE_STRING);
	$prix = filter_input(INPUT_POST,"prix",FILTER_VALIDATE_FLOAT,FILTER_FLAG_ALLOW_FRACTION);
	$quantite = filter_input(INPUT_POST, "quantite" , FILTER_VALIDATE_INT);

		if ($produit && $prix && $quantite){

			$tableau = [
				"produit" => $produit,
				"prix" => $prix,
				"quantite" => $quantite,
				"total" => $prix*$quantite
			];

			$_SESSION['tableaux'][] = $tableau;
		}
}
	//Vrai si btn submit est cliqué sinon redirection vers index.php
	header("Location:recap.php");









?>