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

// Requête SQL pour récupérer les données des clients
$sql = "SELECT id, nom, prenom, telephone, adresse, email, ville, code_postal, commande_id FROM clients ORDER BY id DESC";

// Exécution de la requête
$result = $conn->query($sql);

// Vérification des résultats
if ($result->num_rows > 0) {

    echo "<h2>Liste des clients</h2>";
    // Affichage des en-têtes du tableau
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Nom</th><th>Prénom</th><th>Téléphone</th><th>Adresse</th><th>Email</th><th>Ville</th><th>Code Postal</th><th>Commande ID</th></tr>";

    // Affichage des données des clients
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["id"] . "</td>";
        echo "<td>" . $row["nom"] . "</td>";
        echo "<td>" . $row["prenom"] . "</td>";
        echo "<td>" . $row["telephone"] . "</td>";
        echo "<td>" . $row["adresse"] . "</td>";
        echo "<td>" . $row["email"] . "</td>";
        echo "<td>" . $row["ville"] . "</td>";
        echo "<td>" . $row["code_postal"] . "</td>";
        echo "<td>" . $row["commande_id"] . "</td>";
        echo "</tr>";
    }

    // Fin du tableau
    echo "</table>";
} else {
    echo "Aucun résultat trouvé.";
}

// Fermeture de la connexion
$conn->close();
?>
