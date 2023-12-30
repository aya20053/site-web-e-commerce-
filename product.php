
<?php
// Démarrez la session
session_start();

// Vérifiez la méthode de la requête (POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifiez si les champs du formulaire sont définis
    if (isset($_POST['logemail'], $_POST['logpass'])) {
        $logemail = $_POST['logemail'];
        $logpass = $_POST['logpass'];

        $servername = "127.0.0.1";
        $username = "root";
        $password = "";
        $dbname = "ecommerce_web_site";

        $conn = new mysqli($servername, $username, $password, $dbname);

        // Vérifiez la connexion à la base de données
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } else {
        }
    } else {
        echo "Certains champs du formulaire sont manquants.";
    }
}

include('header.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produits</title>
    <link rel="stylesheet" type="text/css" href="pro.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        form input[type=submit] {
            background-color: #D3A29D;
            border: none;
            padding: 7px;
            border-radius: 4px;
            cursor: pointer;
            color: white;
            margin-top: 10px;
        }

        form input[type=submit]:hover {
            background-color: #D8D8E3;
            color: #535878;
        }

        .imageProduit {
            width: 300px;
            height: 300px;
            border-radius: 20px;
            margin-bottom: 15px;
            box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
        }

        .search-container {
            margin-top: 20px; 
        }

        .search-container input[type=texte] {
            width:250px; 
        }


        .search-categorie{
            text-align:center;
            margin-top: 20px; 
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            table-layout: fixed;
        }
        td img {
    max-width: 100%; 
    height: auto;
    border-radius: 20px;
}


        .search-categorie select{
            padding: 10px;
            width:200px;
            border-radius:5px;
        }
        body {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

main {
    flex: 1;
}

footer {
    margin-top: auto;
}


    </style>
</head>
<body>

<?php


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

// Requête SQL pour récupérer les catégories depuis la base de données
$categories_sql = "SELECT DISTINCT categorie FROM products";
$categories_result = $conn->query($categories_sql);
?>

<!-- Formulaire de recherche par catégorie -->
<div class="search-categorie">
<form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <label for="categorie">Rechercher par catégorie :</label>
    <select name="categorie" id="categorie">
        <option value="">Toutes les catégories</option>
        <?php
        // Affichage des catégories
        if ($categories_result->num_rows > 0) {
            while ($cat_row = $categories_result->fetch_assoc()) {
                $selected = (isset($_GET['categorie']) && $_GET['categorie'] === $cat_row["categorie"]) ? 'selected' : '';
                echo "<option value='" . $cat_row["categorie"] . "' $selected>" . $cat_row["categorie"] . "</option>";
            }
        }
        ?>
    </select>
    <input type="submit" value="Rechercher par catégorie">
</form></div>

<!-- Formulaire de recherche -->
<div class="search-container">
    <form method="get" action="rechercher_produits.php">
        <label for="search">Recherche:</label>
        <input type="text" id="search" name="search" placeholder="Nom du produit...">
        <input type="submit" value="Rechercher">
    </form>
</div>



<?php
// Requête SQL pour récupérer tous les produits
$sql = "SELECT * FROM products";

if (isset($_GET['categorie']) && $_GET['categorie'] !== '') {
    $categorie = $conn->real_escape_string($_GET['categorie']);
    $sql .= " WHERE categorie = '$categorie'";
}

$result = $conn->query($sql);

// Vérification des résultats de la requête
if ($result) {
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
            echo "<strong>Capacité:</strong> " . $row["capacity"] . " ml<br>";
            echo "<strong>Prix:</strong> " . $row["price"] . " DH<br>";

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
} else {
    echo "Erreur de requête : " . $conn->error;
}

include('footer.php');

// Fermeture de la connexion
$conn->close();
?>
</body>
</html>