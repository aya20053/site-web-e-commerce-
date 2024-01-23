<?php
// Vérifier si l'ID de l'administrateur à supprimer est passé en paramètre
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

    // Requête SQL pour récupérer les informations de l'administrateur à supprimer
    $sql = "SELECT * FROM users WHERE id = $adminId";
    $result = $conn->query($sql);

    // Vérification des résultats de la requête
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Affichage de la boîte de dialogue de confirmation avec le message spécifique
        echo "<script>
            if(confirm('Êtes-vous sûr de vouloir supprimer l\'administrateur " . $row['fname'] . " " . $row['lname'] . " ?')) {
                window.location.href='traitement_suppression_admin.php?id=$adminId';
            } else {
                window.location.href='admin.php';
            }
        </script>";
    } else {
        echo "<script>alert ('ID d\'administrateur non valide.'); window.location.href='admin.php';</script>";
    }

    // Fermeture de la connexion
    $conn->close();
} else {
    echo "<script>alert ('ID d\'administrateur non valide.'); window.location.href='admin.php';</script>";
}
?>
<?php
// Vérifier si l'ID de l'administrateur à supprimer est passé en paramètre
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

    // Requête SQL pour récupérer les informations de l'administrateur à supprimer
    $sql = "SELECT * FROM users WHERE id = $adminId";
    $result = $conn->query($sql);

    // Vérification des résultats de la requête
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Affichage de la boîte de dialogue de confirmation avec le message spécifique
        echo "<script>
            if(confirm('Êtes-vous sûr de vouloir supprimer l\'administrateur " . $row['fname'] . " " . $row['lname'] . " ?')) {
                window.location.href='traitement_suppression_admin.php?id=$adminId';
            } else {
                window.location.href='admin.php';
            }
        </script>";
    } else {
        echo "<script>alert ('ID d\'administrateur non valide.'); window.location.href='admin.php';</script>";
    }

    // Fermeture de la connexion
    $conn->close();
} else {
    echo "<script>alert ('ID d\'administrateur non valide.'); window.location.href='admin.php';</script>";
}
?>