<?php
if (isset($_GET['product_id'])) {
    $idProduit = $_GET['product_id'];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "ecommerce_web_site";

    // Création de la connexion
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Vérification de la connexion
    if ($conn->connect_error) {
        die("Échec de la connexion à la base de données : " . $conn->connect_error);
    }

    // Requête SQL pour supprimer le produit
    $sql = "DELETE FROM products WHERE product_id = $idProduit";
    $result = $conn->query($sql);

    // Fermeture de la connexion
    $conn->close();

    // Répondre à la requête AJAX 
    echo "Suppression réussie";
} else {
    echo "ID du produit non spécifié";
}
?>