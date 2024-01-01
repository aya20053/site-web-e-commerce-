<?php
// Démarrez la session
session_start();

// Vérifiez la méthode de la requête (POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifiez si les champs du formulaire sont définis
    if (isset($_POST['logemail'], $_POST['logpass'])) {
        $logemail = $_POST['logemail'];
        $logpass = $_POST['logpass'];

        $servername = "127.0.0.1";
        $username = "root";
        $password = "";
        $dbname = "ecommerce_web_site";

        $conn = new mysqli($servername, $username, $password, $dbname);

        // Vérifiez la connexion à la base de données
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } else {
            
        }
    } else {
        echo "Certains champs du formulaire sont manquants.";
    }
}

include('header.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panier</title>
    <link rel="stylesheet" type="text/css" href="pro.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
     h1 {
    text-align: center;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

th{
    border-bottom:black 2px solid;
}

th, td {
    padding: 10px;
    text-align: center;
}
td img{
    width:130px;
    height: auto;
    border-radius:20px;
}
form input[type=submit]{
    background-color: #D3A29D;
    border:none;
    padding:7px;
    border-radius:4px;
    cursor: pointer;
    color:white;
}

form input[type=submit]:hover{
    background-color:  #D8D8E3;
  color:#535878;

}

#confirmerAchat{
    background-color: #D3A29D;
    color:white;
    padding:10px;
    width:150px;    
    margin-left:20px;
    margin-bottom:20px;
    text-align: center;
    text-decoration:none;
    border-radius:4px;

}
#confirmerAchat:hover{
    background-color:  #D8D8E3;
    color:#535878;

}
.total{
    margin-bottom:30px;
    margin-left:10px;
}
body {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

main {
    flex: 1;
}

footer {
    margin-top: auto;
}

</style>
</head>
<body>


    <h1>Panier</h1>

<?php
 

    // Vérifier si le panier existe et n'est pas vide
    if (isset($_SESSION['panier']) && !empty($_SESSION['panier'])) {
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

        // Récupérer les produits du panier
        $product_ids = implode(",", $_SESSION['panier']);
        $sql = "SELECT * FROM products WHERE product_id IN ($product_ids)";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Afficher les produits dans le panier
            echo "<table border='1'>
                    <tr>
                        <th>Produit</th>
                        <th>Quantité</th>
                        <th>Prix unitaire</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>";

            $total_prix = 0;

            while ($row = $result->fetch_assoc()) {
                $id_produit = $row['product_id'];
                $quantite = isset($_SESSION['quantite'][$id_produit]) ? $_SESSION['quantite'][$id_produit] : 1;
                $prix_unitaire = $row['price'];
                $total_produit = $quantite * $prix_unitaire;

                echo "<tr>
                        <td>
                            <img src='" . $row["cheminImage"] . "' alt='Image Produit' width='50'><br>
                            " . $row['product_name'] . "
                        </td>
                        <td>
                            <form method='post' action='mettre_a_jour_panier.php'>
                                <input type='hidden' name='product_id' value='$id_produit'>
                                <input type='number' name='quantite' value='$quantite' min='1'>
                                <input type='submit' value='Mettre à jour'>
                            </form>
                        </td>
                        <td>$prix_unitaire DH</td>
                        <td>$total_produit DH</td>
                        <td>
                        <!-- Bouton de suppression avec un appel JavaScript -->
                        <button class='supprimer-btn' onclick='supprimerProduit($id_produit)'>Supprimer</button>
                    </td>
                    </tr>";

                $total_prix += $total_produit;
            }

            echo "</table>";

            echo "<br><p class='total'>Total : $total_prix DH</p>";

            // Bouton pour confirmer l'achat
            echo "<a href='acheter.php' id='confirmerAchat'>Confirmer l'achat</a>";

        } else {
            echo "Le panier est vide.";
        }
        

        $conn->close();
    }

    // JavaScript pour la confirmation de suppression
echo "<script>
function supprimerProduit(idProduit) {
    if (confirm('Voulez-vous vraiment supprimer ce produit du panier ?')) {
        window.location.href = 'supprimer_du_panier.php?product_id=' + idProduit;
    }
}
</script>";

include('footer.php');
?>
</body>
  </html>
