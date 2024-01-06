<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>ADMINE</title>
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


         <h1>Liste des Admins</h1>
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

    // Requête SQL pour récupérer tous les administrateurs triés par prénom décroissant
    $sql = "SELECT * FROM users WHERE isAdmin = 1 ORDER BY fname DESC";
    $result = $conn->query($sql);

    // Vérification des résultats de la requête
    if ($result->num_rows > 0) {
        // Affichage du tableau
        echo "<table border='1'>
                <tr>
                    <th>Prénom</th>
                    <th>Nom de famille</th>
                    <th>Numéro de téléphone</th>
                    <th>Email de connexion</th>
                    <th>Actions</th>
                </tr>";

        // Boucle à travers les résultats pour afficher chaque administrateur
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row["fname"] . "</td>
                    <td>" . $row["lname"] . "</td>
                    <td>" . $row["phonenumber"] . "</td>
                    <td>" . $row["logemail"] . "</td>
                    <td>
                    <a href='modifier_admin.php?id=" . $row["id"] . "'>Modifier</a>
                    <a href='supprimer_admin.php?id=" . $row["id"] . "'>Supprimer</a>
                    </td>
                  </tr>";
        }

        echo "</table>";
    } else {
        echo "Aucun administrateur trouvé.";
    }

    // Fermeture de la connexion
    $conn->close();
    ?>



<h1>Ajouter un Administrateur</h1>
<form action="traitement_ajout_admin.php" method="post">
    <label for="fname">Prénom:</label>
    <input type="text" name="fname" required><br>

    <label for="lname">Nom de famille:</label>
    <input type="text" name="lname" required><br>

    <label for="phonenumber">Numéro de téléphone:</label>
    <input type="text" name="phonenumber" required><br>

    <label for="logemail">Email de connexion:</label>
    <input type="email" name="logemail" required><br>

    <label for="password">Mot de passe:</label>
    <input type="password" name="password" required><br>

    <input type="submit" value="Ajouter l'Administrateur">
    
    <br>
    
</body>
</html>
