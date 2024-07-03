<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- FRAMEWORK BOOTSTRAP-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="index.css"> 
    <title><?php echo $title; ?></title>
</head>
<body>
    <!-- Récupere le fichier nav.php et l'affichera ds toutes les pages-->
    <?php require "nav.php"; ?>

    <!-- Affiche le contenu  $content -->
    <div style="width:100%;">
        <?= $content ?>    
    </div>

    <!-- FOOTER -->
    <footer>
            <div class="row">
                <div class="col-sm">
                    <!-- Icone et lien LINKEDIN-->
                    <div class="d-flex justify-content-around justify-content-center bg-dark fs-3">
                        <a href="https://www.linkedin.com/in/abdullrahman-al-karshi-a11b7b204/">
                            <i class="fa fa-linkedin-square" aria-hidden="true" style="color:white;"></i>
                        </a>
                    <!-- Icone et lien PORTFOLIO-->
                        <p class="d-flex justify-content-center text-light fs-5 m-0 bg-dark" style="color:white;">
                            &copy; 2024 Portfolio Al karshi Abdullrahman
                            <br>
                        </p>
                    <!-- Icone et lien GITHUB-->
                        <a href="https://github.com/AAlkarshi">
                            <i class="fa-brands fa-square-github" style="color:white;"></i>
                        </a>
                    </div>
                </div>
            </div>
    </footer>
</body>
</html>
