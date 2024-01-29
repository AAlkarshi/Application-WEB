<?php
	session_start();
	$id = (isset($_GET["id"])) ? $_GET["id"] : null;
	
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
				$description = filter_input(INPUT_POST, "description" ,FILTER_SANITIZE_FULL_SPECIAL_CHARS);



			if (isset($_FILES['file'])) {
		         $tmpName = $_FILES['file']['tmp_name'];
		         $name = $_FILES['file']['name'];
		         $destination = __DIR__ . '/upload/' . $name;

            if (move_uploaded_file($tmpName, $destination)) {
                $file = 'upload/' . $name; 
            } else {
                echo "Échec du téléchargement.";
                exit; 
            }
        }

			
	if($produit && $prix && $quantite && $description && isset($file)){

						$tableau = [
							"file" => $file,
							"produit" => $produit,
							"prix" => $prix,
							"quantite" => $quantite,
							"total" => $prix * $quantite,
							"description" => $description,
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