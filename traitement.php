<?php
	session_start();
	$id = (isset($_GET["id"])) ? $_GET["id"] : null;
	$quantite = (isset($_GET["quantite"])) ? $_GET["quantite"] : null;



if(isset($_GET['action'])){

	if (isset($_SESSION['message'])) {
	    echo "<p>{$_SESSION['message']}</p>";

	    //unset DESACTIVE une variable
	    unset($_SESSION['message']); 
	}

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
			$_SESSION['message'] = "Un produit vient d'être supprimer";
			break;



		// SUPPRIMER TOUT LES PRODUITS
		case 'viderPanier':
			unset($_SESSION['produits']);
			header("Location:recap.php");
			$_SESSION['message'] = "Tout les produits viennent d'être retirer de votre Récapitulatif";
			break;



			
		// Augmentations des quantités
		case 'BtnAugmentation':
    		if (isset($_SESSION['produits'] [$id])) {
        		$_SESSION['produits'][$id]['quantite']++;
        		$_SESSION['produits'][$id]['total'] = 
        			$_SESSION['produits'][$id]['prix'] * $_SESSION['produits'][$id]['quantite'];
    		}
    	header("Location:recap.php");
    	$_SESSION['message'] = "Un produit vient d'être rajouter au stock";
    	break;





		// Diminutions des quantités
		case 'BtnDiminution':
			 if (isset($_SESSION['produits'] [$id])) {
			 	if ($_SESSION['produits'][$id]['quantite'] > 1) {
	        		$_SESSION['produits'][$id]['quantite']--;
	        		
	        		$_SESSION['produits'][$id]['total'] = 
	        		$_SESSION['produits'][$id]['prix'] * $_SESSION['produits'][$id]['quantite'];
    			}
    			else {
    			unset($_SESSION['produits'][$id]);
				$_SESSION['message'] = "Un produit vient d'être supprimer totalement du récapitulatif";
    			}
    		
    	
    	header("Location:recap.php");
    	$_SESSION['message'] = "Un produit vient d'être retirer du stock";
		break;
	}
	}
}







	

?>