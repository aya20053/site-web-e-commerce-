<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Produit</title>
    <link rel="stylesheet" type="text/css" href="admin.css">
</head>
<body>

<?php
// Traitement du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_name = htmlspecialchars($_POST["product_name"]);
    $material = htmlspecialchars($_POST["material"]);
    $capacity = htmlspecialchars($_POST["capacity"]);
    $price = floatval($_POST["price"]);
    $categorie = htmlspecialchars($_POST["categorie"]); // Ajout de la catégorie
    $stock = intval($_POST["stock"]);

    // Upload de l'image
    $target_dir = "uploadss/"; // Répertoire de destination
    $target_file = $target_dir . basename($_FILES["imageProduit"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Vérifier si le fichier image est une image réelle ou une fausse image
    $check = getimagesize($_FILES["imageProduit"]["tmp_name"]);
    if ($check === false) {
        echo "Le fichier n'est pas une image.";
        $uploadOk = 0;
    }

    // Vérifier la taille du fichier
    if ($_FILES["imageProduit"]["size"] > 500000) {
        echo "Désolé, votre fichier est trop volumineux.";
        $uploadOk = 0;
    }

    // Autoriser certains formats de fichiers
    $allowedExtensions = array("jpg", "jpeg", "png", "gif");
    if (!in_array($imageFileType, $allowedExtensions)) {
        echo "Désolé, seuls les fichiers JPG, JPEG, PNG et GIF sont autorisés.";
        $uploadOk = 0;
    }

    // Vérifier si $uploadOk est défini à 0 par une erreur
    if ($uploadOk == 0) {
        echo "Désolé, votre fichier n'a pas été téléchargé.";
    } else {
        // Si tout est ok, essayer d'upload le fichier
        if (move_uploaded_file($_FILES["imageProduit"]["tmp_name"], $target_file)) {
            // Effectuer la connexion à la base de données
            $servername = "127.0.0.1";
            $username = "root";
            $password = "";
            $dbname = "ecommerce_web_site";

            $conn = new mysqli($servername, $username, $password, $dbname);

            // Vérifier la connexion
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Préparer la requête SQL
            $sql = "INSERT INTO products (product_name, material, capacity, price, categorie, stock, cheminImage) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssidsis", $product_name, $material, $capacity, $price, $categorie, $stock, $target_file);

            // Exécuter la requête
            if ($stmt->execute()) {
                echo "<script>alert('Produit ajouté avec succès!');</script>";
            } else {
                echo "<script>alert('Erreur lors de l\'ajout du produit: " . $stmt->error . "');</script>";
            }

            // Fermer la connexion
            $stmt->close();
            $conn->close();
        } else {
            echo "<script>alert('Désolé, une erreur s'est produite lors du téléchargement de votre fichier.');</script>";
        }
    }
}
?>

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

<h2>Ajouter un Produit</h2>
<div class="container"></div>

<!-- Formulaire d'ajout de produit -->
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
    <label for="product_name">Nom du Produit:</label>
    <input type="text" name="product_name" required><br>

    <label for="material">Matériau:</label>
    <input type="text" name="material" required><br>

    <label for="capacity">Capacité:</label>
    <input type="text" name="capacity" required><br>

    <label for="price">Prix:</label>
    <input type="number" name="price" step="0.01" required><br>

    <label for="categorie">Catégorie:</label>
    <input type="text" name="categorie" required><br>

    <label for="stock">Stock:</label>
    <input type="number" name="stock" min="0" required><br>

    <label for="imageProduit">Image du produit :</label>
    <input type="file" name="imageProduit" id="imageProduit">
    <div class="btttn">
        <input type="submit" value="Ajouter le Produit">
    </div>
</form>

</body>
</html>