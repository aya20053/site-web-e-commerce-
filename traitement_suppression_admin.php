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

    // Requête SQL pour supprimer l'administrateur avec l'ID spécifié
    $sql = "DELETE FROM users WHERE id = $adminId";

    if ($conn->query($sql) === TRUE) {
        // Suppression réussie
        echo "<script>alert('Suppression réussie.'); window.location.href='admin.php';</script>";
    } else {
        // Erreur lors de la suppression
        echo "<script>alert('Erreur lors de la suppression de l\'administrateur : " . $conn->error . "'); window.location.href='admin.php';</script>";
    }

    // Fermeture de la connexion
    $conn->close();
} else {
    // ID d'administrateur non valide
    echo "<script>alert('ID d\'administrateur non valide.'); window.location.href='admin.php';</script>";
}
?>
