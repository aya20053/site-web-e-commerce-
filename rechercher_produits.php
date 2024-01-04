<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats de la recherche</title>
    <link rel="stylesheet" type="text/css" href="pro.css">
    <style>
        form input[type=submit]{
    background-color: #D3A29D;
    border:none;
    padding:7px;
    border-radius:4px;
    cursor: pointer;
    color:white;
    margin-top:10px;
}

form input[type=submit]:hover{
    background-color:  #D8D8E3;
  color:#535878;

}
.imageProduit{
    width:300px;
    height: 300px;
    border-radius:20px;
    margin-bottom: 15px;
    box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;

}
    </style>
</head>

<body>

    <?php
    include 'header.php';
    ?>

    <h1>Résultats de la recherche</h1>

    <?php
    // Vérifier si le paramètre de recherche existe dans l'URL
    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $search = $_GET['search'];

        // Connexion à la base de données
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "ecommerce_web_site";
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Vérification de la connexion
        if ($conn->connect_error) {
            die("Échec de la connexion à la base de données : " . $conn->connect_error);
        }

        // Requête SQL pour récupérer les produits correspondant à la recherche
        $sql = "SELECT * FROM products WHERE product_name LIKE '%$search%'";
        $result = $conn->query($sql);

        // Vérification des résultats de la requête
        if ($result->num_rows > 0) {
            // Début du tableau
            echo "<table border='1'><tr>";

            // Boucle à travers les résultats pour afficher chaque produit
            $count = 0;
            while ($row = $result->fetch_assoc()) {
                // Afficher le produit dans une cellule
                echo "<td>";
                echo "<img src='" . $row["cheminImage"] . "' alt='Image Produit' class='imageProduit'><br>";
                echo "<strong>Nom:</strong> " . $row["product_name"] . "<br>";
                echo "<strong>Matériau:</strong> " . $row["material"] . "<br>";
                echo "<strong>Capacité:</strong> " . $row["capacity"] . "<br>";
                echo "<strong>Prix:</strong> " . $row["price"] . "<br>";

                // Ajouter le bouton "Ajouter au panier" avec un formulaire pour envoyer le produit au panier
                echo "<form method='post' action='ajouter_panier.php'>";
                echo "<input type='hidden' name='product_id' value='" . $row["product_id"] . "'>";
                echo "<input type='submit' value='Ajouter au panier'>";
                echo "</form>";

                echo "</td>";

                // Passer à la ligne suivante après chaque troisième produit
                $count++;
                if ($count % 3 == 0) {
                    echo "</tr><tr>";
                }
            }

            // Fin du tableau
            echo "</tr></table>";
        } else {
            echo "Aucun produit trouvé.";
        }

        // Fermeture de la connexion
        $conn->close();
    } else {
        echo "Aucune donnée de recherche fournie.";
    }
    ?>

</body>

</html>
