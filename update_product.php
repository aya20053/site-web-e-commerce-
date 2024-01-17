<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un Produit</title>
    <link rel="stylesheet" type="text/css" href="admin.css">
</head>
<body>

<header>
    
<div class="logo">
    <a href="index.php"><img src="logo.png" alt="Logo"></a>
</div>
    <nav>
        <ul>
            <li><a href="admin.php">Admin</a></li>
            <li><a href="produit.php">Produits</a></li>
            <li><a href="commande.php">Commandes</a></li>
            <li><a href="client.php">Clients</a></li>
            <li><a href="utilisateur.php">Utilisateurs</a></li>
        </ul>
    </nav>
</header>

<h1>Modifier un Produit</h1>

<?php
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

// Vérifier si l'ID du produit est passé en paramètre
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $product_id = $_GET['id'];

    // Requête SQL pour récupérer les détails du produit
    $sql = "SELECT * FROM products WHERE product_id = $product_id";
    $result = $conn->query($sql);

    // Vérification des résultats de la requête
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        // Affichage du formulaire de modification avec les valeurs actuelles
        echo "<form method='post' action='traitement_modification_produit.php' enctype='multipart/form-data'>
                <input type='hidden' name='product_id' value='" . $row["product_id"] . "'>
                <label for='product_name'>Nom du Produit:</label>
                <input type='text' name='product_name' value='" . $row["product_name"] . "' required><br>

                <label for='material'>Matériau:</label>
                <input type='text' name='material' value='" . $row["material"] . "' required><br>

                <label for='capacity'>Capacité:</label>
                <input type='text' name='capacity' value='" . $row["capacity"] . "' required><br>

                <label for='price'>Prix:</label>
                <input type='number' name='price' step='0.01' value='" . $row["price"] . "' required><br>

                <label for='stock'>Stock:</label>
                <input type='number' name='stock' min='0' value='" . $row["stock"] . "' required><br>

                <label for='categorie'>Catégorie:</label>
                <input type='text' name='categorie' value='" . $row["categorie"] . "' required><br>

                <label for='imageProduit'>Image du produit :</label>
                <input type='file' name='imageProduit' id='imageProduit' accept='image/*'><br>
                <img src='" . $row["cheminImage"] . "' alt='Image Produit' width='50'><br>

                <input type='submit' value='Modifier le Produit'>
            </form>";
    } else {
        echo "Aucun produit trouvé avec cet identifiant.";
    }
} else {
    echo "Identifiant du produit non spécifié.";
}

// Fermeture de la connexion
$conn->close();
?>
</body>
</html>
