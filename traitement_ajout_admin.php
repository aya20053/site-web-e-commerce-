<?php
// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $phonenumber = $_POST['phonenumber'];
    $logemail = $_POST['logemail'];
    $password = $_POST['password'];

    // Connexion à la base de données 
    $servername = "localhost";
    $username = "root";
    $password_db = "";
    $dbname = "ecommerce_web_site";

    // Création de la connexion
    $conn = new mysqli($servername, $username, $password_db, $dbname);

    // Vérification de la connexion
    if ($conn->connect_error) {
        die("Échec de la connexion à la base de données : " . $conn->connect_error);
    }

    // Requête SQL pour ajouter un administrateur
    $sql = "INSERT INTO users (fname, lname, phonenumber, logemail, logpass, isAdmin) VALUES ('$fname', '$lname', '$phonenumber', '$logemail', '$password', 1)";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('L\'administrateur a été ajouté avec succès.');
                window.location.href = 'admin.php';
              </script>";
    } else {
        echo "<script>
                alert('Erreur lors de l\'ajout de l\'administrateur : " . $conn->error . "');
                window.location.href = 'admin.php';
              </script>";
    }

    // Fermeture de la connexion
    $conn->close();
} else {
    // Si le formulaire n'a pas été soumis, rediriger vers la page admin
    header("Location: admin.php");
    exit();
}
?>
