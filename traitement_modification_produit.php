<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    // Récupérer les données du formulaire
    $product_id = $_POST["product_id"];
    $product_name = $_POST["product_name"];
    $material = $_POST["material"];
    $capacity = $_POST["capacity"];
    $price = $_POST["price"];
    $stock = $_POST["stock"];

    // Gestion de l'image du produit
    $target_dir = "images/";
    $uploadOk = 1;

    // Vérifier si une nouvelle image a été téléchargée
    if ($_FILES["imageProduit"]["size"] > 0) {
        $target_file = $target_dir . basename($_FILES["imageProduit"]["name"]);

        // Supprimer l'ancienne image si elle existe
        $sql_select_image = "SELECT cheminImage FROM products WHERE product_id = $product_id";
        $result_select_image = $conn->query($sql_select_image);

        if ($result_select_image->num_rows == 1) {
            $row = $result_select_image->fetch_assoc();
            $old_image_path = $row["cheminImage"];

            // Supprimer l'ancienne image
            if (file_exists($old_image_path)) {
                unlink($old_image_path);
            }
        }

        // Télécharger la nouvelle image
        if (move_uploaded_file($_FILES["imageProduit"]["tmp_name"], $target_file)) {
            echo "Le fichier " . htmlspecialchars(basename($_FILES["imageProduit"]["name"])) . " a été téléchargé.";
        } else {
            echo "Désolé, une erreur s'est produite lors du téléchargement de votre fichier.";
            $uploadOk = 0;
        }
    }

    // Si l'image a été téléchargée avec succès ou si aucune image n'a été téléchargée
    if ($uploadOk != 0) {
        // Préparer la requête SQL pour la mise à jour
        $sql_update = "UPDATE products SET product_name=?, material=?, capacity=?, price=?, stock=?";

        // Ajouter la colonne "cheminImage" à la requête si une nouvelle image a été téléchargée
        if ($_FILES["imageProduit"]["size"] > 0) {
            $sql_update .= ", cheminImage=?";
        }

        $sql_update .= " WHERE product_id=?";
        $stmt = $conn->prepare($sql_update);

        // Lier les paramètres de la requête
        if ($_FILES["imageProduit"]["size"] > 0) {
            $stmt->bind_param("ssdidsi", $product_name, $material, $capacity, $price, $stock, $target_file, $product_id);
        } else {
            $stmt->bind_param("ssdisi", $product_name, $material, $capacity, $price, $stock, $product_id);
        }

        // Exécuter la requête
        if ($stmt->execute()) {
            echo "Produit mis à jour avec succès!";
            // Rediriger vers la page des produits après une courte attente (ici 2 secondes)
            header("refresh:2; url=produit.php");

            // Assurer que le reste du script ne s'exécute pas après la redirection
            exit();
        } else {
            echo "Erreur lors de la mise à jour du produit: " . $stmt->error;
        }

        // Fermer la connexion
        $stmt->close();
    }

    // Fermer la connexion
    $conn->close();
}
?>
