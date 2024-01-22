<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['logemail'], $_POST['logpass'])) {
        $logemail = $_POST['logemail'];
        $logpass = $_POST['logpass'];

        $servername = "127.0.0.1";
        $username = "root";
        $password = "";
        $dbname = "ecommerce_web_site";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $logemail = $conn->real_escape_string($logemail);
        $logpass = $conn->real_escape_string($logpass);

        $sql = "SELECT * FROM users WHERE logemail='$logemail' AND logpass='$logpass'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Utilisateur trouvé, connexion réussie
            $user = $result->fetch_assoc();

            // Vérifiez si l'utilisateur est un administrateur
            if ($user['isAdmin'] == 1) {
                // Redirigez vers l'interface d'administration
                header("Location: admin.php");
                exit();
            } else {
                // Enregistrez l'ID de l'utilisateur dans la session
                $_SESSION['user_id'] = $user['id'];

                // Redirigez vers la page de profil
                header("Location: profil.php");
                exit();
            }
        } else {
            echo "Erreur de connexion. Vérifiez vos informations.";
        }

        $conn->close();
    } else {
        echo "Certains champs du formulaire sont manquants.";
    }
}
?>
