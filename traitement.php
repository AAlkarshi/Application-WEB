<?php
	session_start();

if(isset($_GET['action'])){
	switch ($_GET['action']) { 
	$produit = $_POST['produit'];
	
		case 'BtnSuppCeProduit':
		 if (isset($_POST['tableaux']['produit'])) {
			// $produit = $_POST['produit'];

			 if (isset($_SESSION['tableaux'][$produit])) {
                    unset($_SESSION['tableaux'][$produit]);
            }
		 }
			break;

		case 'BtnSuppTOUTlesProduits':
			unset($_SESSION['tableaux']);
			break;

		case 'BtnAugmentation':
			 if (isset($_POST['produit'])) {
					if (isset($_SESSION['tableaux'][$produit])) {
	                    unset($_SESSION['tableaux'][$produit]);
	                }
            }
			break;

		case 'BtnDiminution':
		  if (isset($_POST['produit'])) {
			 if (isset($_SESSION['tableaux'][$produit])) {
                    unset($_SESSION['tableaux'][$produit]);
            }
         }
		break;

	}
}




	if (isset($_POST['submit'])){

	$produit = filter_input(INPUT_POST, "produit" , FILTER_SANITIZE_STRING);
	$prix = filter_input(INPUT_POST,"prix",FILTER_VALIDATE_FLOAT,FILTER_FLAG_ALLOW_FRACTION);
	$quantite = filter_input(INPUT_POST, "quantite" , FILTER_VALIDATE_INT);

	$suppression = filter_input(INPUT_POST, "suppression" , FILTER_VALIDATE_INT);

		if ($produit && $prix && $quantite){

			$tableau = [
				"produit" => $produit,
				"prix" => $prix,
				"quantite" => $quantite,
				"total" => $prix*$quantite,
				"suppression" =>  $suppression,
			];

			$_SESSION['tableaux'][] = $tableau;
		}
		//Vrai si btn submit est cliqué sinon redirection recap.php
	header("Location:recap.php");
	$_SESSION['message'] = "ERREUR le produit n'à pas été ajouter";
}
	//Faux redirection vers index.php
	header("Location:index.php");
	$_SESSION['message'] = "Succès ! L'ajout du produit à bien été ajouter";

?>