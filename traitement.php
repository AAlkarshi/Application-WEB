<?php
	session_start();
	$id = (isset($_GET["id"])) ? $_GET["id"] : null;
	$quantite = (isset($_GET["quantite"])) ? $_GET["quantite"] : null;

if(isset($_GET['action'])){

	switch ($_GET['action']) { 

		//AJOUTER UN PRODUIT
		case "add":
			if (isset($_POST['submit'])){
				$produit = filter_input(INPUT_POST, "produit" ,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
				$prix = filter_input(INPUT_POST,"prix",FILTER_VALIDATE_FLOAT,FILTER_FLAG_ALLOW_FRACTION);
				$quantite = filter_input(INPUT_POST, "quantite",FILTER_VALIDATE_INT);
			
					if ($produit && $prix && $quantite){

						$tableau = [
							"produit" => $produit,
							"prix" => $prix,
							"quantite" => $quantite,
							"total" => $prix * $quantite,
						];

						$_SESSION['produits'][] = $tableau;						
					}
				//Vrai si btn submit est cliqué sinon redirection recap.php
				header("Location:recap.php");
				$_SESSION['message'] = "Produit ajouté";
			}
			break;

		//SUPPRIMER UN PRODUIT
		case 'suppProduit':
			unset($_SESSION['produits'][$id]);
			header("Location:recap.php");
			echo "Un produit vient d'être supprimer";
			break;



		// SUPPRIMER TOUT LES PRODUITS
		case 'viderPanier':
			unset($_SESSION['produits']);
			echo "Tout les produits viennent d'être retirer de votre Récapitulatif";
			header("Location:recap.php");
			break;



			
		// Augmentations des quantités
		case 'BtnAugmentation':
			if (isset($_SESSION['produits'] [$id][$quantite])){
				$_SESSION['produits'][$id][$quantite]++;
			}
			header("Location:recap.php");
			break;





		// Diminutions des quantités
		case 'BtnDiminution':
			  
			break;

	}
}







	

?>