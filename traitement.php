<?php
	session_start();

if(isset($_GET['action'])){

	switch ($_GET['action']) { 

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


		case 'suppProduit':
			unset($_SESSION[$tableau][$produit]);
			header("Location:recap.php");
			$_SESSION['message'] = "Un produit vient d'être supprimer";
			break;
		

		case 'viderPanier':
			// Supp tt les produits
			unset($_SESSION['produits']);
			echo "Tout les produits viennent d'être retirer de votre Récapitulatif";
			header("Location:recap.php");
			break;


		case 'BtnAugmentation':
			 if (isset($_SESSION['produits']['BtnAugmentation'])) {
					$tableau['quantite'] ++ ;
				echo "Un produit viens d'être rajouter à la quantité";
            }
			break;

		case 'BtnDiminution':
			 if (isset($_SESSION['produits']['BtnDiminution'])) {
				$tableau['quantite'] -- ;
					if ($_SESSION['produits'] ['quantite'] == 0){
						unset($_SESSION['produits']);
					}
            echo "Un produit viens d'être retirer de la quantité";    
            }
			break;

	}
}







	

?>