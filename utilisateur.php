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

// Requête SQL pour récupérer les utilisateurs où isAdmin est égal à 0
$sql = "SELECT id, fname, lname, phonenumber, logemail FROM users WHERE isAdmin = 0";
$result = $conn->query($sql);

// Vérification des résultats de la requête
if ($result->num_rows > 0) {
    // Affichage des utilisateurs
    echo "<h2>Liste des Utilisateurs</h2>";
    echo "<table border='1'>
            <tr>
                
                <th>Prénom</th>
                <th>Nom</th>
                <th>Numéro de téléphone</th>
                <th>Email</th>
            </tr>";

    // Boucle à travers les résultats pour afficher chaque utilisateur
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                
                <td>" . $row["fname"] . "</td>
                <td>" . $row["lname"] . "</td>
                <td>" . $row["phonenumber"] . "</td>
                <td>" . $row["logemail"] . "</td>
            </tr>";
    }

    echo "</table>";
} else {
    echo "Aucun utilisateur trouvé.";
}

// Fermeture de la connexion
$conn->close();
?>
</body>
</html>