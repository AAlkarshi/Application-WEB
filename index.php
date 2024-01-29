<?php 
session_start();
ob_start();




			if(isset($_FILES['file'])){
				$tmpName = $_FILES['file']['tmp_name'];
				$name = $_FILES['file']['name'];
				$size = $_FILES['file']['size'];
				$error = $_FILES['file']['error'];
				$destinationPath = "upload/";
				
				$tabExtension = explode('.', $name);
				$extension = strtolower(end($tabExtension));

				$extensions = ['jpg', 'png', 'jpeg', 'gif'];
				$maxSize = 400000;

				if(in_array($tabExtension, $extensions) && $size <= $maxSize && $error == 0){
					   $uniqueName = uniqid('', true);
					   $file = $uniqueName.".".$extension;

					
	   
						move_uploaded_file($tmpName, $destinationPath . $name);
				}
				else{
				    echo "Mauvaise extension ou taille trop grande";
				}

				

			}

			
?>

<h3>Ajout d'un Produit </h3>

<?php $title = "Index"; ?>


<?php
	// Faire afficher des Messages de notifications
	if (isset($_SESSION['message'])) {
	    echo "<p>{$_SESSION['message']}</p>";

	    //unset DESACTIVE une variable
	    unset($_SESSION['message']); 
	}
?>

<div class="d-flex flex-column w-75 flex-grow-1">
	<div class="d-flex justify-content-center flex-column flex-wrap ml-5 mr-5 mb-5">

		<form action="traitement.php?action=add" method="post" enctype="multipart/form-data">
			
				  <label for="file">Fichier:</label>
				    <input type="file" name="file">
				    <button type="submit" name="Enregistrer">Enregistrer</button>

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
					<input type="number" name="quantite"> 
				</label>
			</p>

			<p>
				<label> Description du produit :
					<br>
					<textarea type="text" name="description">
						
					</textarea>
				</label>
			</p>
			
			<p>
				<input type="submit" name="submit" value="Ajouter le produit">
			</p>

	</form>

	</div>
</div>






<?php

// Recupere le contenu et le stocke ds la var $content
	$content = ob_get_clean();

//Recupere le code du fichier 
	require_once "template.php";
	
?>
