

<?php
session_start();

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    // Redirige vers la page de connexion si l'utilisateur n'est pas connecté
    header("Location: connexion.html");
    exit();
}

// Récupère l'ID de l'utilisateur connecté
$user_id = $_SESSION['user_id'];

// Traitement du formulaire de modification de profil
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['fname'], $_POST['lname'], $_POST['phonenumber'], $_POST['logemail'])) {
        // Récupérer les nouvelles valeurs des champs
        $new_fname = $_POST['fname'];
        $new_lname = $_POST['lname'];
        $new_phonenumber = $_POST['phonenumber'];
        $new_logemail = $_POST['logemail'];

        // Connexion à la base de données
        $servername = "127.0.0.1";
        $username = "root";
        $password = "";
        $dbname = "ecommerce_web_site";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Gestion du téléchargement de l'image de profil
        $image_path = ""; 
        
        if ($_FILES['profile_image']['size'] > 0 && $_FILES['profile_image']['error'] == UPLOAD_ERR_OK) {
        $check = getimagesize($_FILES["profile_image"]["tmp_name"]);
        if ($check !== false) {
        $target_dir = "uploads/";
        $imageFileType = strtolower(pathinfo($_FILES["profile_image"]["name"], PATHINFO_EXTENSION));
        $target_file = $target_dir . $user_id . '_profile.' . $imageFileType;

        
    $timestamp = time();
    $target_file = $target_dir . $user_id . '_profile_' . $timestamp . '.' . $imageFileType;

    // Vérifier si le fichier existe déjà
    if (file_exists($target_file)) {
        // Supprimer le fichier existant
        unlink($target_file);
    }else {
            // Vérifier la taille du fichier
            if ($_FILES["profile_image"]["size"] > 500000) {
                echo "Désolé, votre fichier est trop volumineux.";
            } else {
                // Autoriser certains formats de fichiers
                $allowed_extensions = array("jpg", "jpeg", "png", "gif");
                if (in_array($imageFileType, $allowed_extensions)) {
                    if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file)) {
                        echo "Le fichier " . htmlspecialchars(basename($_FILES["profile_image"]["name"])) . " a été téléchargé.";

                        // Enregistrez le chemin de l'image dans la base de données
                        $image_path = $target_file;

                        // Exécuter la requête de mise à jour dans la base de données
                        $sql_update = "UPDATE users SET fname=?, lname=?, phonenumber=?, logemail=?, profile_picture=? WHERE id=?";
                        $stmt = $conn->prepare($sql_update);
                        $stmt->bind_param("sssssi", $new_fname, $new_lname, $new_phonenumber, $new_logemail, $image_path, $user_id);
                        $stmt->execute();
                        $stmt->close();

                    } else {
                        echo "Une erreur s'est produite lors du téléchargement de votre fichier.";
                    }
                } else {
                    echo "Désolé, seuls les fichiers JPG, JPEG, PNG et GIF sont autorisés.";
                }
            }
        }
    } else {
        echo "Le fichier n'est pas une image.";
    }
} else {
    echo "Désolé, votre fichier n'a pas été téléchargé.";

            // Enregistrez le chemin de l'image dans la variable
            $image_path = $target_file;
        }

        $sql_update = "UPDATE users SET fname=?, lname=?, phonenumber=?, logemail=?, profile_picture=? WHERE id=?";
        $stmt = $conn->prepare($sql_update);
        $stmt->bind_param("sssssi", $new_fname, $new_lname, $new_phonenumber, $new_logemail, $image_path, $user_id);
        $stmt->execute();
        
        
        if ($stmt->affected_rows > 0) {
            // Redirige après la mise à jour du profil
            header("Location: profil.php");
            exit();
        } else {
            header("Location: profil.php?error=update");
            exit();
        }
        
           

        if ($stmt) {
            $stmt->close();
        }        
        $conn->close();
    } else {
        echo "Certains champs du formulaire sont manquants.";
    }
}

// Récupère les informations actuelles de l'utilisateur depuis la base de données
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "ecommerce_web_site";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM users WHERE id = '$user_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "Utilisateur non trouvé.";
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le profil</title>

    <style>
        .btnn {
            
            color: white; 
            font-weight: bold; 
            padding: 8px 12px; 
            margin:10px;
            font-size:16px;
            background-color: #D3A29D; 
            border-radius: 5px; 
            transition: background-color 0.3s;
            border:none;
        }
       
       .btnn:hover {
            background-color: #D8D8E3; 
            color: #535878;
            
        }
        label{
            margin:20px;
        }

        .profile-container {
           
            margin: 50px 20px; 
            max-width: 600px;
        }


        label {
            display: block;
            margin: 10px 0;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 3px;
        }
    </style>
</head>
<body>

    <?php include('header.php'); ?>
    <div class="profile-container">

    <h2>Modifier le profil</h2>
<div class="center-container">
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
     <label for="fname">Prénom:</label>
        <input type="text" id="fname" name="fname" value="<?php echo htmlspecialchars($user['fname']); ?>" required>

        <label for="lname">Nom de famille:</label>
        <input type="text" id="lname" name="lname" value="<?php echo htmlspecialchars($user['lname']); ?>" required>

        <label for="phonenumber">Numéro de téléphone:</label>
        <input type="text" id="phonenumber" name="phonenumber" value="<?php echo htmlspecialchars($user['phonenumber']); ?>" required>

        <label for="logemail">Email:</label>
        <input type="email" id="logemail" name="logemail" value="<?php echo htmlspecialchars($user['logemail']); ?>" required>
        
        <label for="profile_image">Image de profil :</label>
        <input type="file" id="profile_image" name="profile_image">

        <br>
        <input class="btnn" type="submit" value="Mettre à jour le profil">
    </form></div>
</div>
    <?php include('footer.php'); ?>

</body>
</html>
