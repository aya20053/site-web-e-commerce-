<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commande</title>
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

    <?php
    session_start();

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "ecommerce_web_site";

    // Création de la connexion à la base de données
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Vérification de la connexion
    if ($conn->connect_error) {
        die("Échec de la connexion à la base de données : " . $conn->connect_error);
    }

    //  requête pour récupérer les commandes avec les product_id correspondants 
        $sql = "SELECT c.commande_id, CONCAT(u.fname, ' ', u.lname) AS user_name, cl.telephone, cl.ville, cl.adresse, d.product_id, p.product_name, p.cheminImage, d.quantite, c.date_commande 
        FROM commande c
        JOIN details_commande d ON c.commande_id = d.commande_id
        JOIN products p ON d.product_id = p.product_id
        JOIN clients cl ON c.commande_id = cl.commande_id
        JOIN users u ON c.user_id = u.id
        ORDER BY c.date_commande DESC";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Afficher les commandes avec les product_id
        echo "<h2>Liste des commandes</h2>";
        echo "<table border='1'>
        <tr>
        <th>Commande ID</th>
        <th>Nom de l'Utilisateur</th>
        <th>Num telephone du client</th>
        <th>Ville du client</th>
        <th>Adresse du client</th>
        <th>Product ID</th>
        <th>Product Name</th>
        <th>Image du Produit</th>
        <th>Quantité</th>
        <th>Date de commande</th>
    </tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                        <td>" . $row["commande_id"] . "</td>
                        <td>" . $row["user_name"] . "</td>
                        <td>" . $row["telephone"] . "</td>
                        <td>" . $row["ville"] . "</td>
                        <td>" . $row["adresse"] . "</td>
                        <td>" . $row["product_id"] . "</td>
                        <td>" . $row["product_name"] . "</td>
                        <td><img src='" . $row["cheminImage"] . "' alt='Image Produit' style='width: 50px; height: 50px;'></td>
                        <td>" . $row["quantite"] . "</td>
                        <td>" . $row["date_commande"] . "</td>
                    </tr>";
        }

        echo "</table>";
    } else {
        echo "Aucune commande trouvée.";
    }

    // Fermeture de la connexion
    $conn->close();

    ?>
</body>

</html>
