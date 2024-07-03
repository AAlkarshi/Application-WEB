<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="index.css">
    <script src="https://kit.fontawesome.com/b04d3e51a0.js" crossorigin="anonymous"></script>
    <title></title>
</head>
<body>
    <nav style="width:100%; height:70px; align-items:center;">
        <ul style="display:flex; flex-direction:row; height:100%; align-items:center; justify-content: space-around; font-size: 18px;">
            <li><a href="#" style="pointer-events: none; font-size:20px; color:white;">StockTesProduits</a></li>
            <li><a href="home.php">Home</a></li>
            
			<!-- User Connecté alors AFFICHER -->
            <?php if (isset($_SESSION['ID_Utilisateur'])): ?>
                <li><a href="AjoutProduit.php">Ajouter un Produit</a></li>
                <li><a href="recap.php">Récapitulatif</a></li>
                <li><a href="logout.php">Déconnexion</a></li>
                <li style="font-size: 20px; color: white;"><?php echo $_SESSION['PrenomUtilisateur'] . ' ' . $_SESSION['NomUtilisateur']; ?></li>
            
			<!-- User Connecté alors MASQUER -->
				<?php else: ?>
					<li><a href="InscriptionForm.php">Inscription</a></li>
					<li><a href="ConnexionForm.php">Connexion</a></li>
            	<?php endif; ?>
                    
        </ul>
    </nav>
</body>
</html>
