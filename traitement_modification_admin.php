<?php
// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $adminId = $_POST['id'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $phonenumber = $_POST['phonenumber'];
    $logemail = $_POST['logemail'];

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

    // Requête SQL pour mettre à jour les informations de l'administrateur
    $sql = "UPDATE users SET fname='$fname', lname='$lname', phonenumber='$phonenumber', logemail='$logemail' WHERE id=$adminId";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Les modifications ont été enregistrées avec succès.');";
        echo "window.location.href='admin.php';</script>";
    } else {
        echo "<script>alert('Erreur lors de l\'enregistrement des modifications : " . $conn->error . "');</script>";
    }

    // Fermeture de la connexion
    $conn->close();
} else {
    echo "Accès non autorisé.";
}
?>
