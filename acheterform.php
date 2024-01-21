

<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>Panier</title>
 <link rel="stylesheet" href="pro.css">
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
 <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
 <link rel="shortcut icon" href="logo.png">
 
 <style>
       
.remercier{
    font-size: 30px;
    text-align: center;
    color: #284c60;
    font-weight: bold;
    margin: 20px;
}
.telecharger{
    background-color:#D3A29D ;
    color: white;
    padding: 10px 15px;
    border: none;
    cursor: pointer;
    border-radius: 10px;
    text-decoration: none;
    margin: 30px;
    
    
    
}

 </style>
</head>


<?php
session_start();
include('header.php');

// Vérifier si l'utilisateur est connecté
if (isset($_SESSION['user_id'])) {
 
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "ecommerce_web_site";

    // Création de la connexion à la base de données
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Vérification de la connexion
    if ($conn->connect_error) {
        die("Échec de la connexion à la base de données : " . $conn->connect_error);
    }

    // Récupérer l'ID de l'utilisateur connecté
    $user_id = $_SESSION['user_id'];

    // Récupérer l'ID de la dernière commande insérée
    $commande_id = $conn->insert_id;

    $date_commande = date("Y-m-d H:i:s");  // Utilisez la date actuelle

    $sql_commande = "INSERT INTO commande (user_id, date_commande) VALUES ($user_id, '$date_commande')";

    if ($conn->query($sql_commande) === TRUE) {
        // Récupérer l'ID de la dernière commande insérée
        $commande_id = $conn->insert_id;

        // Parcourir les produits du panier et les insérer dans la table 'details_commande'
        foreach ($_SESSION['panier'] as $product_id) {
            $quantite = isset($_SESSION['quantite'][$product_id]) ? $_SESSION['quantite'][$product_id] : 1;

            // Insérer dans la table 'details_commande'
            $sql_insert_details = "INSERT INTO details_commande (commande_id, product_id, quantite) VALUES (?, ?, ?)";
            $stmt_insert_details = $conn->prepare($sql_insert_details);
            $stmt_insert_details->bind_param("iii", $commande_id, $product_id, $quantite);
            $stmt_insert_details->execute();

            // Mettre à jour le stock du produit
            $sql_update_stock = "UPDATE products SET stock = stock - ? WHERE product_id = ?";
            $stmt_update_stock = $conn->prepare($sql_update_stock);
            $stmt_update_stock->bind_param("ii", $quantite, $product_id);
            $stmt_update_stock->execute();
        }

        // Récupérer les données du formulaire
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $telephone = $_POST['telephone'];
        $email = $_POST['email'];
        $adresse = $_POST['adresse'];
        $ville = $_POST['ville'];
        $code_postal = $_POST['code_postal'];

        // Préparer la requête SQL pour l'insertion des données personnelles avec des requêtes préparées
        $sql_personnelles = "INSERT INTO clients (commande_id, nom, prenom, telephone, adresse, email, ville, code_postal) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        // Utiliser une requête préparée pour éviter les attaques par injection SQL
        $stmt_personnelles = $conn->prepare($sql_personnelles);

        // Vérifier la préparation de la requête
        if ($stmt_personnelles === false) {
            die("Erreur lors de la préparation de la requête : " . $conn->error);
        }

        // Lier les paramètres à la requête
        $stmt_personnelles->bind_param("isssssss", $commande_id, $nom, $prenom, $telephone, $adresse, $email, $ville, $code_postal);

        // Exécuter la requête préparée pour les données personnelles
        if ($stmt_personnelles->execute()) {

    require_once('TCPDF-main/tcpdf.php');
    // Créez une instance de TCPDF
    $pdf = new TCPDF();

    // Début du contenu du PDF
    $pdf->AddPage();
 
    
    $pdf->SetFont('', '', 12);

    $pdf->SetTextColor(211, 162, 157); 
    $pdf->Cell(0, 10, 'Facture d\'achat(ZahAya)', 0, 1, 'C');
    $pdf->SetTextColor(0, 0, 0);

    $sql_customer = "SELECT nom, prenom, telephone, email, adresse, ville, code_postal
                     FROM clients
                     WHERE commande_id = $commande_id";

    $result_customer = $conn->query($sql_customer);

    if ($result_customer === false) {
        die("Error executing the query: " . $conn->error);
    }

    if ($result_customer->num_rows > 0) {
        $row_customer = $result_customer->fetch_assoc();
        $nom = $row_customer['nom'];
        $prenom = $row_customer['prenom'];
        $telephone = $row_customer['telephone'];
        $email = $row_customer['email'];
        $adresse = $row_customer['adresse'];
        $ville = $row_customer['ville'];
        $code_postal = $row_customer['code_postal'];

        // Ajout des informations du client dans le PDF
        $pdf->Cell(0, 10, 'Informations du client:', 0, 1);
        $pdf->Cell(0, 10, "Nom: $nom", 0, 1);
        $pdf->Cell(0, 10, "Prénom: $prenom", 0, 1);
        $pdf->Cell(0, 10, "Téléphone: $telephone", 0, 1);
        $pdf->Cell(0, 10, "Email: $email", 0, 1);
        $pdf->Cell(0, 10, "Adresse: $adresse", 0, 1);
        $pdf->Cell(0, 10, "Ville: $ville", 0, 1);
        $pdf->Cell(0, 10, "Code Postal: $code_postal", 0, 1);
    } else {
        die("Informations du client non disponibles. User ID: $user_id");
    }

    // Ajout des produits
    $pdf->Ln(10); // Saut de ligne
    $pdf->Cell(0, 10, 'Produits achetés:', 0, 1);

    foreach ($_SESSION['panier'] as $product_id) {
        $quantite = isset($_SESSION['quantite'][$product_id]) ? $_SESSION['quantite'][$product_id] : 1;

        // Récupérez les détails du produit depuis la base de données 
        $sql_product = "SELECT * FROM products WHERE product_id = $product_id";
        $result_product = $conn->query($sql_product);

        if ($result_product->num_rows > 0) {
            $row_product = $result_product->fetch_assoc();
            $nom_produit = $row_product['product_name'];
            $prix_unitaire = $row_product['price'];

            // Ajoutez une ligne pour chaque produit
            $pdf->Cell(0, 10, "Produit: $nom_produit | Quantité: $quantite | Prix unitaire: $prix_unitaire DH", 0, 1);
        }
    }

    // Ajout du prix total
    $pdf->Ln(10); // Saut de ligne

    $prix_total = 0;
    foreach ($_SESSION['panier'] as $product_id) {
        $quantite = isset($_SESSION['quantite'][$product_id]) ? $_SESSION['quantite'][$product_id] : 1;

        $sql_product = "SELECT price FROM products WHERE product_id = $product_id";
        $result_product = $conn->query($sql_product);

        if ($result_product->num_rows > 0) {
            $row_product = $result_product->fetch_assoc();
            $prix_total += $row_product['price'] * $quantite;
        }
    }

    $pdf->Cell(0, 10, "Prix total: $prix_total DH", 0, 1);

    // Générez le PDF
    $pdf_content = $pdf->Output('', 'S');

    // Nom du fichier PDF
    $pdf_filename = "facture_commande_$commande_id.pdf";

    // Enregistrez le contenu PDF dans un fichier
    file_put_contents($pdf_filename, $pdf_content);

    // Redirigez l'utilisateur vers la page d'achat avec le lien de téléchargement
    // Afficher le lien de téléchargement
    echo "<p class='remercier'>Merci pour votre commande </p><br>";
    echo "<p><a href='$pdf_filename' class='telecharger' download>Télécharger votre facture</a>";

            unset($_SESSION['panier']);
            unset($_SESSION['quantite']);

            echo '<script>alert("Achat réussi !");</script>';

           
        } else {
            echo "<script>alert('Erreur lors de l'enregistrement des données personnelles : " . $stmt_personnelles->error . "');location = 'acheter.php';</script>";
        }

        // Fermer la requête préparée pour les données personnelles
        $stmt_personnelles->close();
    } else {
        echo "Erreur : " . $sql_commande . "<br>" . $conn->error;
    }

    // Fermeture de la connexion
    $conn->close();
} else {
    echo "<script>alert('Vous devez être connecté pour effectuer un achat.');location = 'connexion.html';</script>";
    exit();
}
?>
