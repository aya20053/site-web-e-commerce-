<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["product_id"])) {
    $product_id = $_GET["product_id"];

    // Vérifier si le produit existe dans le panier
    if (isset($_SESSION['panier']) && in_array($product_id, $_SESSION['panier'])) {
        // Supprimer le produit du panier
        $index = array_search($product_id, $_SESSION['panier']);
        unset($_SESSION['panier'][$index]);
        
        // Supprimer la quantité associée
        unset($_SESSION['quantite'][$product_id]);

        echo "Le produit a été supprimé du panier.";

        // Redirection vers la page des produits après une courte attente (ici 2 secondes)
        header("refresh:2; url=panier.php");
        exit();
    } else {
        echo "Le produit n'existe pas dans le panier.";
    }
} else {
    echo "Requête non valide.";
}
?>


