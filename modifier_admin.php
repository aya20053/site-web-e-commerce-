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
// Vérifier si l'ID de l'administrateur à modifier est passé en paramètre
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $adminId = $_GET['id'];

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

    // Requête SQL pour récupérer les informations de l'administrateur avec l'ID spécifié
    $sql = "SELECT * FROM users WHERE id = $adminId";
    $result = $conn->query($sql);

    // Vérification des résultats de la requête
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Formulaire de modification
        echo "<form action='traitement_modification_admin.php' method='post'>
                <label for='fname'>Prénom:</label>
                <input type='text' name='fname' value='" . $row["fname"] . "'><br>
                
                <label for='lname'>Nom de famille:</label>
                <input type='text' name='lname' value='" . $row["lname"] . "'><br>
                
                <label for='phonenumber'>Numéro de téléphone:</label>
                <input type='text' name='phonenumber' value='" . $row["phonenumber"] . "'><br>
                
                <label for='logemail'>Email de connexion:</label>
                <input type='text' name='logemail' value='" . $row["logemail"] . "'><br>
                
                <input type='hidden' name='id' value='" . $row["id"] . "'>
                <input type='submit' value='Enregistrer les modifications'>
              </form>";
    } else {
        echo "Aucun administrateur trouvé avec cet ID.";
    }

    // Fermeture de la connexion
    $conn->close();
} else {
    echo "ID d'administrateur non valide.";
}
?>
