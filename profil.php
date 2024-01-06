
<?php
session_start();

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: connexion.html");
    exit();
}

// Récupérez les informations de l'utilisateur depuis la base de données
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "ecommerce_web_site";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];

// Récupérez les informations de l'utilisateur
$sql_user = "SELECT * FROM users WHERE id = $user_id";
$result_user = $conn->query($sql_user);

if ($result_user->num_rows > 0) {
    $user = $result_user->fetch_assoc();
} else {
    echo "Utilisateur introuvable.";
    exit();
}

// Récupérez l'historique des achats de l'utilisateur
$sql_purchase_history = "SELECT c.commande_id, c.date_commande, d.product_id, p.product_name, p.cheminImage, d.quantite
    FROM commande c
    JOIN details_commande d ON c.commande_id = d.commande_id
    JOIN products p ON d.product_id = p.product_id
    JOIN users u ON c.user_id = u.id
    WHERE c.user_id = $user_id
    ORDER BY c.date_commande DESC";


$result_purchase_history = $conn->query($sql_purchase_history);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil de l'utilisateur</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        img.profile-image {
            width: 150px; 
            height: 150px;
            border-radius: 50%;
            object-fit: cover; 
        }
       
        p {
            margin: 12px; 
        }

        a.modify-profile-link {
            text-decoration: none;
            color: white;
            font-weight: bold;
            margin-top: 10px;
            display: inline-block;
            padding: 8px 12px;
            margin:20px;
            background-color: #D3A29D;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        a.modify-profile-link:hover {
            background-color: #D8D8E3;
            color: #535878;
        }

        .profile-container {
            text-align: center;
            margin: 0 auto;
            max-width: 800px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #D3A29D;
            color: white;
        }
        .form{
            text-align:right;
            
        }
        .form input{
            background-color:#B23A48;
            border:none;
            padding:15px;
            border-radius:4px;
            font-weight:bold;
            color:white;

        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="profile-container">
        <h1>Profil de l'utilisateur</h1>
        
        <?php
        if (!empty($user['profile_picture'])) {
            echo '<img class="profile-image" src="' . $user['profile_picture'] . '" alt="Image de profil">';
        } else {
            echo '<img class="profile-image" src="inconnue.png" alt="Image de profil par défaut" width="250px">';
        }
        ?>

        <p>Nom: <?php echo $user['fname'] . ' ' . $user['lname']; ?></p>
        <p>Email: <?php echo $user['logemail']; ?></p>
         <br><a class="modify-profile-link" href="update_profile.php">Modifier le profil</a><br>
        <br>
        <h2>Historique des achats</h2>
        <?php
        // Afficher l'historique des achats
        if ($result_purchase_history->num_rows > 0) {
            echo "<table>";
            echo "<tr><th>Product Name</th><th>Image du Produit</th><th>Quantité</th><th>Date</th></tr>";

            while ($purchase = $result_purchase_history->fetch_assoc()) {
                echo "<tr>";
                
                echo "<td>" . $purchase['product_name'] . "</td>";
                echo "<td><img src='" . $purchase['cheminImage'] . "' alt='Image Produit' style='width: 50px; height: 50px;'></td>";
                echo "<td>" . $purchase['quantite'] . "</td>";
                echo "<td>" . $purchase['date_commande'] . "</td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "Aucun achat trouvé.";
        }
        ?>
            <br><br><br>
       
        <!-- Formulaire de déconnexion -->
        <div class="form">
        <form action="deconnexion.php" method="post">
        <input type="submit" value="Déconnexion" /><br><br>
        </form></div>

    </div>

    <?php include 'footer.php'; ?>
</body>
</html>
