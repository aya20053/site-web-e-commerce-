<?php if (isset($_SESSION['user_id'])) : ?>
    <?php
    // Connexion à la base de données
    $servername = "127.0.0.1";
    $username = "root";
    $password = "";
    $dbname = "ecommerce_web_site";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Récupérer le chemin de l'image de profil de l'utilisateur connecté
    $user_id = $_SESSION['user_id'];
    $sql_profile_image = "SELECT profile_picture FROM users WHERE id = '$user_id'";
    $result_profile_image = $conn->query($sql_profile_image);

    if ($result_profile_image->num_rows > 0) {
        $profile_image = $result_profile_image->fetch_assoc()['profile_picture'];
    } else {
        $profile_image = "inconnue.png"; // Chemin vers l'icône par défaut
    }

    $conn->close();
    ?>
<head>
<link rel="stylesheet" type="text/css" href="pro.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
    header nav ul li a.imggg img{
  position: relative;
  top: 3px;
} 
</style>
</head>
<header>
        <a href="index.php"><img src="logo.png" alt="logo" width="70px"></a>
        <nav>
        
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="product.php">Produit</a></li>
                <li><a href="panier.php"><i class="fa-solid fa-cart-shopping"></i>  Panier </a></li>
                <li><a href="connexion.html" class="connexion"><i class="fa-solid fa-user"></i>  Connexion</a></li>
                <li> 
                    <a class="imggg" href="profil.php">
                        <img   src="<?php echo $profile_image; ?>" alt="Profil" width="30px">
                    </a>
                </li>
            </ul>
        </nav>
    </header>

<?php else : ?>

    <header>
    <a href="index.php"><img src="logo.png" alt="logo" width="70px"></a>
        <nav>
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="product.php">Produit</a></li>
                <li><a href="panier.php"><i class="fa-solid fa-cart-shopping"></i>  Panier </a></li>
                <li><a href="connexion.html" class="connexion"><i class="fa-solid fa-user"></i>  Connexion</a></li>
                <li> 
        <a href="connexion.html">
            <img src="inconnue.png" alt="Connexion" width="30px">
        </a>
        </li>
            </ul>
        </nav>
    </header>

<?php endif; ?>