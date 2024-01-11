<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier si le panier existe
    if (isset($_SESSION['panier'])) {
        // Récupérer les données du formulaire
        $product_id = $_POST["product_id"];
        $quantite = $_POST["quantite"];

        // Vérifier si la quantité est valide
        if ($quantite > 0) {
            // Mettre à jour la quantité dans le panier
            $_SESSION['quantite'][$product_id] = $quantite;

            // Rediriger vers la page du panier
            header("Location: panier.php");
            exit();
        } else {
            // Si la quantité n'est pas valide, vous pouvez gérer l'erreur ici
            echo "La quantité n'est pas valide.";
        }
    }
}
?>
