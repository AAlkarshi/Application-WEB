<?php
session_start();
ob_start();

// Vérification si le formulaire d'ajout de produit a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['produit'], $_POST['prix'], $_POST['quantite'])) {
        // Récupérer les données du formulaire
        $produit = filter_input(INPUT_POST, "produit", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $prix = filter_input(INPUT_POST, "prix", FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $quantite = filter_input(INPUT_POST, "quantite", FILTER_VALIDATE_INT);

        // Vérifier si les données sont valides
        if ($produit && $prix !== false && $quantite !== false) {
            // Connexion à la BDD
            $servername = "localhost";
            $username = "root";
            $password = "changeme";
            $dbname = "appweb";

            $conn = new mysqli($servername, $username, $password, $dbname);
            if ($conn->connect_error) {
                die("La connexion à la base de données a échoué : " . $conn->connect_error);
            }

            // Insertion du produit dans la table `produit`
            $sql_produit = "INSERT INTO produit (NomProduit, PrixProduit, QuantiteProduit) VALUES (?, ?, ?)";
            $stmt_produit = $conn->prepare($sql_produit);
            $stmt_produit->bind_param("sdi", $produit, $prix, $quantite);

            if ($stmt_produit->execute()) {
                $id_produit_insere = $stmt_produit->insert_id;

                // Récupérer l'ID de l'utilisateur depuis la session
                $id_utilisateur = $_SESSION['ID_Utilisateur'];

                // Insertion dans table `choisir`
                $sql_choisir = "INSERT INTO choisir (ID_Utilisateur, ID_Produit) VALUES (?, ?)";
                $stmt_choisir = $conn->prepare($sql_choisir);
                $stmt_choisir->bind_param("ii", $id_utilisateur, $id_produit_insere);

                if ($stmt_choisir->execute()) {
                    $_SESSION['message'] = "Produit ajouté.";
                } else {
                    $_SESSION['message'] = "Erreur lors de l'ajout : " . $stmt_choisir->error;
                }

                $stmt_choisir->close();
            } else {
                $_SESSION['message'] = "Erreur lors de l'insertion du produit : " . $stmt_produit->error;
            }

            // Fermer la connexion
            $stmt_produit->close();
            $conn->close();
			header("Location: recap.php");
            exit();
        } else {
            $_SESSION['message'] = "Données du formulaire invalides ou incomplètes.";
			header("Location: ajoutProduit.php");
            exit();
        }

        header("Location: recap.php");
        exit();
    } else {
        $_SESSION['message'] = "Tous les champs du formulaire ne sont pas définis ou sont vides.";
        header("Location: ajoutProduit.php");
        exit();
    }
}

?>



<?php $title = "Index"; ?>

<?php
// Affichage des messages de notifications
if (isset($_SESSION['message'])) {
    echo "<p>{$_SESSION['message']}</p>";
    unset($_SESSION['message']);
}
?>

<div class="formajoutproduit" style="margin-left: auto;margin-right: auto;">
    <h2 style="font-size: 20px; padding: 15px; display: flex; justify-content: center;">
        Ajouter un produit
    </h2>

    <form action="traitement.php?action=add" method="post" enctype="multipart/form-data" class="custom-form" 
    style="width:100%; margin-left: auto;margin-right: auto; width:100%; ">
        <div class="form-group">
            <label for="file">Fichier :</label>
            <input type="file" name="file" class="form-control" required>
        </div>

        <div class="form-group" style="padding:15px;">
            <label>Nom du Produit :</label>
            <input type="text" name="produit" class="form-control" required>
        </div>

        <div class="form-group" style="padding:15px;">
            <label>Prix du Produit :</label>
            <input type="text" name="prix" class="form-control" required>
        </div>

        <div class="form-group" style="padding:15px;">
            <label>Quantité voulue :</label>
            <input type="number" name="quantite" class="form-control" required>
        </div>

        <div class="form-group" style="padding:15px;">
            <input type="submit" name="submit" value="Ajouter le produit" class="btn btn-primary">
        </div>
    </form>
</div>




<?php
// Récupération du contenu et stockage dans la variable $content
$content = ob_get_clean();
require_once "template.php";
?>
