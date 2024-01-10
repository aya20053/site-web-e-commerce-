<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['product_id'])) {
        $product_id = $_POST['product_id'];

        // Vérifier si la variable de session 'panier' existe
        if (!isset($_SESSION['panier'])) {
            $_SESSION['panier'] = array();
        }

        // Ajouter le produit au panier
        if (!in_array($product_id, $_SESSION['panier'])) {
            $_SESSION['panier'][] = $product_id;
            echo "<script>alert('Produit ajouté au panier avec succès!');</script>";
            header("Location: product.php");
            exit();
        } else {
            echo "<script>alert('Le produit est déjà dans le panier.');</script>";
            header("Location: product.php");
            exit();
        }
    } else {
        echo "L'ID du produit n'est pas défini.";
    }
} else {
    echo "Requête invalide.";
}
?>
