<?php
session_start();

// Récupération de l'ID utilisateur depuis la session
$id_utilisateur = $_SESSION['ID_Utilisateur'];

$servername = "localhost";
$username = "root";
$password = "changeme";
$dbname = "appweb";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("La connexion à la base de données a échoué : " . $conn->connect_error);
}

// Vérification de l'action à effectuer
if (isset($_GET['action'])) {
    // Gestion des messages de session
    if (isset($_SESSION['message'])) {
        echo "<p>{$_SESSION['message']}</p>";
        unset($_SESSION['message']);
    }


// Vérifier l'action à effectuer
$action = $_GET['action'] ?? '';


    // Switch case pour différentes actions
    switch ($_GET['action']) {
        case 'add':
            // Vérification de la soumission du formulaire d'ajout de produit
            if (isset($_POST['submit'])) {
                // Récupération et validation des données du formulaire
                $produit = filter_input(INPUT_POST, "produit", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $prix = filter_input(INPUT_POST, "prix", FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                $quantite = filter_input(INPUT_POST, "quantite", FILTER_VALIDATE_INT);
                $image = 'upload/' . $_FILES['file']['name']; // Assurez-vous de gérer correctement le téléchargement du fichier

                // Insertion du produit dans la table produit
                $sql_produit = "INSERT INTO produit (NomProduit, PrixProduit, QuantiteProduit, ImageProduit, ID_Recapitulatif) VALUES (?, ?, ?, ?, ?)";
                $stmt_produit = $conn->prepare($sql_produit);
                $stmt_produit->bind_param("sdisi", $produit, $prix, $quantite, $image, $id_utilisateur);

                if ($stmt_produit->execute()) {
                    $id_produit_insere = $stmt_produit->insert_id;

                    // Insertion de l'association dans la table choisir
                    $sql_choisir = "INSERT INTO choisir (ID_Utilisateur, ID_Produit) VALUES (?, ?)";
                    $stmt_choisir = $conn->prepare($sql_choisir);
                    $stmt_choisir->bind_param("ii", $id_utilisateur, $id_produit_insere);

                    if ($stmt_choisir->execute()) {
                        $_SESSION['message'] = "Produit ajouté avec succès.";
                    } else {
                        $_SESSION['message'] = "Erreur lors de l'ajout du produit : " . $stmt_choisir->error;
                    }
                    $stmt_choisir->close();
                } else {
                    $_SESSION['message'] = "Erreur lors de l'ajout du produit : " . $stmt_produit->error;
                }
                $stmt_produit->close();

                // Redirection après l'ajout du produit
                header("Location: recap.php");
                exit();
            }
            break;

        case 'suppProduit':
            // Suppression d'un produit du tableau de session produits
            unset($_SESSION['produits'][$id]);
            $_SESSION['message'] = "Un produit vient d'être supprimé";
            break;

        case 'viderPanier':
            // Suppression de tous les produits du tableau de session produits
            unset($_SESSION['produits']);
            $_SESSION['message'] = "Tous les produits ont été retirés de votre récapitulatif";
            break;

        case 'augmenterQuantite':
            if (isset($_POST['augmenter']) && isset($_GET['id_produit'])) {
                $id_produit = $_GET['id_produit'];
                $quantite_actuelle = $_POST['quantite_actuelle'] ?? 0;
                $nouvelle_quantite = $quantite_actuelle + 1;

                // Mettre à jour la quantité dans la base de données
                $sql_update = "UPDATE produit SET QuantiteProduit = ?, TotalProduit = PrixProduit * ? WHERE ID_Produit = ?";
                $stmt_update = $conn->prepare($sql_update);
                $stmt_update->bind_param("iii", $nouvelle_quantite, $nouvelle_quantite, $id_produit);

                if ($stmt_update->execute()) {
                    $_SESSION['message'] = "Quantité du produit mise à jour avec succès.";
                } else {
                    $_SESSION['message'] = "Erreur lors de la mise à jour de la quantité : " . $stmt_update->error;
                }

                $stmt_update->close();
            }
            break;

            case 'diminuerQuantite':
                if (isset($_POST['diminuer'], $_GET['id_produit'])) {
                    $id_produit = $_GET['id_produit'];
                    $quantite_actuelle = $_POST['quantite_actuelle'] ?? 0;
        
                    $nouvelle_quantite = max(0, $quantite_actuelle - 1);
        
                    if ($nouvelle_quantite > 0) {
                        // Mettre à jour la quantité dans la base de données
                        $sql_update = "UPDATE produit SET QuantiteProduit = ?, TotalProduit = PrixProduit * ? WHERE ID_Produit = ?";
                        $stmt_update = $conn->prepare($sql_update);
                        $stmt_update->bind_param("iii", $nouvelle_quantite, $nouvelle_quantite, $id_produit);
        
                        if ($stmt_update->execute()) {
                            $_SESSION['message'] = "Quantité du produit mise à jour avec succès.";
                        } else {
                            $_SESSION['message'] = "Erreur lors de la mise à jour de la quantité : " . $stmt_update->error;
                        }
        
                        $stmt_update->close();
                    } else {
                        // Supprimer les enregistrements de la table `choisir`
                        $sql_delete_choisir = "DELETE FROM choisir WHERE ID_Produit = ?";
                        $stmt_delete_choisir = $conn->prepare($sql_delete_choisir);
                        $stmt_delete_choisir->bind_param("i", $id_produit);
                        $stmt_delete_choisir->execute();
                        $stmt_delete_choisir->close();
        
                        // Supprimer le produit de la table `produit`
                        $sql_delete = "DELETE FROM produit WHERE ID_Produit = ?";
                        $stmt_delete = $conn->prepare($sql_delete);
                        $stmt_delete->bind_param("i", $id_produit);
        
                        if ($stmt_delete->execute()) {
                            $_SESSION['message'] = "Produit supprimé car la quantité est devenue 0 ou moins.";
                        } else {
                            $_SESSION['message'] = "Erreur lors de la suppression du produit : " . $stmt_delete->error;
                        }
        
                        $stmt_delete->close();
                    }
                } else {
                    $_SESSION['message'] = "Paramètres manquants pour diminuer la quantité du produit.";
                }
                break;
        default:
            $_SESSION['message'] = "Action non reconnue.";
            var_dump("Action non reconnue.");
            break;
    }

    // Redirection vers recap.php après traitement
    header("Location: recap.php");
    exit();
}

// Si aucune action n'est spécifiée dans $_GET['action'], rediriger également vers recap.php
header("Location: recap.php");
exit();
?>
