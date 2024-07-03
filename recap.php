<?php
session_start();
ob_start();

// Vérification de l'ID utilisateur depuis la session
$id_utilisateur = $_SESSION['ID_Utilisateur'];

// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "changeme";
$dbname = "appweb";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("La connexion à la base de données a échoué : " . $conn->connect_error);
}

// Fonction pour supprimer un produit
function supprimerProduit($conn, $id_produit) {
    // Supprimer d'abord les enregistrements de la table `choisir`
    $sql_supprimer_choisir = "DELETE FROM choisir WHERE ID_Produit = ?";
    $stmt_supprimer_choisir = $conn->prepare($sql_supprimer_choisir);
    $stmt_supprimer_choisir->bind_param("i", $id_produit);
    $stmt_supprimer_choisir->execute();
    $stmt_supprimer_choisir->close();

    // Puis supprimer le produit de la table `produit`
    $sql_supprimer_produit = "DELETE FROM produit WHERE ID_Produit = ?";
    $stmt_supprimer_produit = $conn->prepare($sql_supprimer_produit);
    $stmt_supprimer_produit->bind_param("i", $id_produit);
    $stmt_supprimer_produit->execute();
    $stmt_supprimer_produit->close();
}

// Récupération des produits associés à l'utilisateur depuis la table choisir
$sql_recuperer_produits = "SELECT p.*, c.ID_Utilisateur FROM produit p INNER JOIN choisir c ON p.ID_Produit = c.ID_Produit WHERE c.ID_Utilisateur = ?";
$stmt_recuperer_produits = $conn->prepare($sql_recuperer_produits);
$stmt_recuperer_produits->bind_param("i", $id_utilisateur);
$stmt_recuperer_produits->execute();
$resultat = $stmt_recuperer_produits->get_result();

// Tableau pour stocker les produits à afficher
$produits = array();
$total_general = 0;
$total_quantite = 0;

// Suppression des produits avec quantité <= 0
while ($row = $resultat->fetch_assoc()) {
    if ($row['QuantiteProduit'] > 0) {
        $produits[] = $row; // Ajouter le produit au tableau des produits à afficher
        $total_general += $row['PrixProduit'] * $row['QuantiteProduit']; // Calculer le total général
        $total_quantite += $row['QuantiteProduit']; // Calculer le total des quantités
    } else {
        supprimerProduit($conn, $row['ID_Produit']);
        $_SESSION['message'] = "Produit supprimé car la quantité est devenue 0.";
    }
}
$stmt_recuperer_produits->close();

function calculerTotal($prix, $quantite) {
    return $prix * $quantite;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css">
    <title>Récapitulatif des Produits</title>
</head>
<body>
    <h2>Récapitulatif de vos Produits</h2>
    <br>
    <table>
    <thead>
        <tr>
            <th>Produit</th>
            <th>Prix</th>
            <th>Quantité</th>
            <th>Total</th>
            <th>Image</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($produits as $row) : ?>
            <tr>
                <td><?php echo $row['NomProduit']; ?></td>
                <td><?php echo $row['PrixProduit']; ?> €</td>
                <td class="quantity-container">
                    <form action="traitement.php?action=diminuerQuantite&id_produit=<?php echo $row['ID_Produit']; ?>" method="post" style="display: inline;">
                        <input type="hidden" name="quantite_actuelle" value="<?php echo $row['QuantiteProduit']; ?>">
                        <button type="submit" name="diminuer" class="btn-modif">-</button>
                    </form>
                    <span class="quantity-span"><?php echo $row['QuantiteProduit']; ?></span>
                    <form action="traitement.php?action=augmenterQuantite&id_produit=<?php echo $row['ID_Produit']; ?>" method="post" style="display: inline;">
                        <input type="hidden" name="quantite_actuelle" value="<?php echo $row['QuantiteProduit']; ?>">
                        <button type="submit" name="augmenter" class="btn-modif">+</button>
                    </form>
                </td>
                <td><?php echo calculerTotal($row['PrixProduit'], $row['QuantiteProduit']); ?> €</td>
                <td><img src="<?php echo $row['ImageProduit']; ?>" alt="<?php echo $row['NomProduit']; ?>" class="produit-img"></td>
            </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="2" style="text-align: right;"><strong>Total:</strong></td>
            <td><strong><?php echo $total_quantite . " produits" ?></strong></td>
            <td><strong><?php echo $total_general; ?> €</strong></td>
            <td></td>
        </tr>
    </tbody>
</table>

</body>
</html>

<?php
$content = ob_get_clean();
require_once "template.php";
$conn->close();
?>
