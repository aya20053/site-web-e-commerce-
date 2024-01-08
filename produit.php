<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>Produit</title>
 <link  rel="stylesheet" type="text/css" href="admin.css">
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

<br><br>
<a href="ajouterProduit.php" id=product>Ajouter un Produit</a><br><br>
<h1>Liste des Produits</h1>


<?php
    // Connexion à la base de données 
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


    // Vérifier si la suppression d'un produit est demandée
    if (isset($_GET['product_id'])) {
        $idProduit = $_GET['product_id'];

        // Requête SQL pour supprimer le produit
        $sql = "DELETE FROM products WHERE product_id = $idProduit";
        $result = $conn->query($sql);

        // Fermeture de la connexion
        $conn->close();

        // Rediriger vers produit.php après la suppression
        header("Location: produit.php");
        exit();
}
    // Requête SQL pour récupérer tous les produits
    $sql = "SELECT * FROM products";
    $result = $conn->query($sql);

    // Vérification des résultats de la requête
    if ($result->num_rows > 0) {
        // Affichage du tableau
        echo "<table border='1'>
                <tr>
                    <th>Produit</th>
                </tr>";

        while($row = $result->fetch_assoc()) {
         echo "
         <tr id='row_" . $row["product_id"]."'>
         <td>
            
            <img src='" . $row["cheminImage"] . "' alt='Image Produit' width='50'><br>
             <strong>Nom:</strong> " . $row["product_name"] . "<br>
             <strong>Matériau:</strong> " . $row["material"] . "<br>
             <strong>Capacité:</strong> " . $row["capacity"] . " ml<br>
             <strong>Prix:</strong> " . $row["price"] . " DH<br>
             <strong>Stock:</strong> " . $row["stock"] . "<br>
             <div >
             <a href='update_product.php?id=" . $row["product_id"] . "'>Modifier</a>
             <a href='javascript:void(0);' onclick='supprimerProduit(" . $row["product_id"] . ")'>Supprimer</a> </div>        </td>
     </tr>";
        }

        echo "</table>";
    } else {
        echo "Aucun produit trouvé.";
    }

    // Fermeture de la connexion
    $conn->close();
    ?>

<script>
    function supprimerProduit(idProduit) {
        if (confirm("Êtes-vous sûr de vouloir supprimer ce produit ?")) {
            // Effectuer une requête AJAX pour supprimer le produit de la base de données
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "supprimer_produit.php?product_id=" + idProduit, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Si la suppression réussit, supprimer la ligne correspondante de la page
                    var rowToRemove = document.getElementById("row_" + idProduit);
                    if (rowToRemove) {
                        rowToRemove.remove();
                    } else {
                        alert("Erreur lors de la suppression de la ligne sur la page.");
                    }
                }
            };
            xhr.send();
        }
    }
</script>

</body>
</html>