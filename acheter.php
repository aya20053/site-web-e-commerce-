<?php
// Démarrez la session
session_start();

// Vérifiez la méthode de la requête (POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifiez si les champs du formulaire sont définis
    if (isset($_POST['validerAchat'])) {
        // Récupérer le panier depuis la session
        $panier = $_SESSION['panier'] ?? [];

        // Vérifier si le panier n'est pas vide
        if (!empty($panier)) {
            // Connecter à la base de données
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "ecommerce_web_site";

            $conn = new mysqli($servername, $username, $password, $dbname);

            // Vérifier la connexion à la base de données
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);

            }
            // Fermer la connexion à la base de données
            $conn->close();

            if (isset($_GET['pdf'])) {
                $pdf_filename = $_GET['pdf'];
                echo "<p><a href='$pdf_filename' download>Télécharger votre facture</a></p>";
            }
            
        } else {
            echo "<script>alert('Votre panier est vide. Ajoutez des produits avant de procéder à l'achat.');location = 'acheter.php';</script>";
        }

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
 <link rel="stylesheet" href="pro.css">
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
 <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
 <link rel="shortcut icon" href="logo.png">
 

 
 <style>
       #afficherFormulaire{
  margin-bottom: 10px;
}
#messageRemerciement{
color: #D3A29D;
font-size:large;
}
.forimg{
    height: 40px;
   
}
.carte{
    width: 50px;
    height: 35px;
    margin:5px 20px;
}
.exd{
    margin-left:10px;
    margin-bottom:20px;
    font-size:13px;
    text-align:left;
    color:rgb(170, 170, 170);
}
.titrep{
    text-align:left;
    color:#e9c2c5;
    
}
 </style>
</head>
<body >
 
<div class="card">
  <h4 class="title">Formulaire d'Achat</h4>
  <div>
      <form action="acheterform.php" method="post"><br>
      <p class="titrep">Information personnel :</p>
          <div class="field">
          <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAACXBIWXMAAAsTAAALEwEAmpwYAAAA+ElEQVR4nO2UwWrCQBCG8wC9eTAK9iI99E0aetE3SVPfqQ9RIZnZmYQgvkSMZXa9294iG1ovVmLiBjz4w8Cy+zMfO/+ynndXGxngVwEqNXLVpQRpY5QKzgKsoWtzfYRwcRZwbXP9W10A3wJpqOPcNwAjQXqze84AAmn4zzgjdzeIc/8EsMyGvQJ2RGN3I0KKTrzAC7chI0U24DrkhN818o9LQNX3M636AQDtNdCHIM++kuxZx/GDLbsWlc7tWe3pAhDgVQkw8Rq0VepRkNbtb0A0bWr+J5NkT60B5Wc+uBRgvbcRsvT9XRulgmsgglxoTF8uHe1dntUBbeSmUTmIojoAAAAASUVORK5CYII=">
              <input autocomplete="off" id="nom" placeholder="Nom" class="input-field" name="nom" type="text" required>
          </div>
          <div class="field">
          <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAACXBIWXMAAAsTAAALEwEAmpwYAAAA+ElEQVR4nO2UwWrCQBCG8wC9eTAK9iI99E0aetE3SVPfqQ9RIZnZmYQgvkSMZXa9294iG1ovVmLiBjz4w8Cy+zMfO/+ynndXGxngVwEqNXLVpQRpY5QKzgKsoWtzfYRwcRZwbXP9W10A3wJpqOPcNwAjQXqze84AAmn4zzgjdzeIc/8EsMyGvQJ2RGN3I0KKTrzAC7chI0U24DrkhN818o9LQNX3M636AQDtNdCHIM++kuxZx/GDLbsWlc7tWe3pAhDgVQkw8Rq0VepRkNbtb0A0bWr+J5NkT60B5Wc+uBRgvbcRsvT9XRulgmsgglxoTF8uHe1dntUBbeSmUTmIojoAAAAASUVORK5CYII=">
              <input autocomplete="off" id="prenom" placeholder="Prénom" class="input-field" name="prenom" type="text" required>
          </div>
          <div class="field">
          <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAACXBIWXMAAAsTAAALEwEAmpwYAAABZ0lEQVR4nN2VsS9EQRDGF4WEREGpoNdrKfgbKFQ6f4JKpaMSQicUuFJxyUXCzezMuksuChEFBS7Ozl5EoSNYeULy7nkvOW4vEV+y3cv+3nw734xS/0ZS1JMCtOqANuLHghkNAwB+dMg+eQRoKwjAAd+kARxSOQhAgIqpFSC/3B6UB0JUsJxeAXuLPN0ywAJNZQEc0nrLgKox/QL0/O1yoKc6mjEVQg54P9FBr4I0o0JJtJlo/HteVCHlve8QJI4BzmqVSk9QSJTcyJoYZFuFlkNaarRKzwcFXOTz3YJ00hg4WogsjH/nve+sa5791by6N2ZQkKuJlt2xhULvx+W5XJcgb8asrAtyQZBXrNbjTUGs1iMCXEtArqNQCvJeVjAF6bLpSu6YhxzSeXbK0yYw135mV6nUF+0GAXprCyC+lBzSadsAX53zORgPsyuiKxVC9uh42CHNOeTd6GEF+CHaHwK8FgTwJ/QONoc2ENjZ+/cAAAAASUVORK5CYII=">

              <input autocomplete="off" id="telephone" placeholder="Numéro de téléphone" class="input-field" name="telephone" type="tel" required>
          </div>
          <div class="field">
          <svg class="input-icon" viewBox="0 0 500 500" xmlns="http://www.w3.org/2000/svg">
            <path d="M207.8 20.73c-93.45 18.32-168.7 93.66-187 187.1c-27.64 140.9 68.65 266.2 199.1 285.1c19.01 2.888 36.17-12.26 36.17-31.49l.0001-.6631c0-15.74-11.44-28.88-26.84-31.24c-84.35-12.98-149.2-86.13-149.2-174.2c0-102.9 88.61-185.5 193.4-175.4c91.54 8.869 158.6 91.25 158.6 183.2l0 16.16c0 22.09-17.94 40.05-40 40.05s-40.01-17.96-40.01-40.05v-120.1c0-8.847-7.161-16.02-16.01-16.02l-31.98 .0036c-7.299 0-13.2 4.992-15.12 11.68c-24.85-12.15-54.24-16.38-86.06-5.106c-38.75 13.73-68.12 48.91-73.72 89.64c-9.483 69.01 43.81 128 110.9 128c26.44 0 50.43-9.544 69.59-24.88c24 31.3 65.23 48.69 109.4 37.49C465.2 369.3 496 324.1 495.1 277.2V256.3C495.1 107.1 361.2-9.332 207.8 20.73zM239.1 304.3c-26.47 0-48-21.56-48-48.05s21.53-48.05 48-48.05s48 21.56 48 48.05S266.5 304.3 239.1 304.3z"></path></svg>
              <input autocomplete="off" id="email" placeholder="Adresse e-mail" class="input-field" name="email" type="email" required>
          </div>
        
         
          <div class="field">
          <svg class="input-icon" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 18">
    <path d="M17 16h-1V2a1 1 0 1 0 0-2H2a1 1 0 0 0 0 2v14H1a1 1 0 0 0 0 2h16a1 1 0 0 0 0-2ZM5 4a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V4Zm0 5V8a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1Zm6 7H7v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3Zm2-7a1 1 0 0 1-1 1h-1a1 1 0 0 1-1-1V8a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v1Zm0-4a1 1 0 0 1-1 1h-1a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v1Z"/>
  </svg>
              <input autocomplete="off" id="ville" placeholder="Ville" class="input-field" name="ville" type="text" required>
          </div>
          <div class="field">
          <svg class="input-icon" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 18">
    <path d="M17 16h-1V2a1 1 0 1 0 0-2H2a1 1 0 0 0 0 2v14H1a1 1 0 0 0 0 2h16a1 1 0 0 0 0-2ZM5 4a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V4Zm0 5V8a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1Zm6 7H7v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3Zm2-7a1 1 0 0 1-1 1h-1a1 1 0 0 1-1-1V8a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v1Zm0-4a1 1 0 0 1-1 1h-1a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v1Z"/>
  </svg>
        <input autocomplete="off" id="code_postal" placeholder="Code postal" class="input-field" name="code_postal" type="text" required>
    </div>
    <div class="field">
    <svg class="input-icon" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
    <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/>
  </svg>
              <input autocomplete="off" id="adresse" placeholder="Adresse" class="input-field" name="adresse" type="text" required>
          </div>
          <br>
        <p class="titrep">Information sur la carte :</p><br>
        <div class="forimg"><img src="visa.png" alt=""  width="40px" class="carte" >
        <img src="paypal.jpg" alt="" width="30px" class="carte" ></div>

       
        
           <!-- Informations de paiement -->
    <div class="field">
        
        
    <svg class="input-icon" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 16">
    <path d="M18 0H2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2ZM6.5 3a2.5 2.5 0 1 1 0 5 2.5 2.5 0 0 1 0-5ZM3.014 13.021l.157-.625A3.427 3.427 0 0 1 6.5 9.571a3.426 3.426 0 0 1 3.322 2.805l.159.622-6.967.023ZM16 12h-3a1 1 0 0 1 0-2h3a1 1 0 0 1 0 2Zm0-3h-3a1 1 0 1 1 0-2h3a1 1 0 1 1 0 2Zm0-3h-3a1 1 0 1 1 0-2h3a1 1 0 1 1 0 2Z"/>
  </svg>
        <input autocomplete="off" id="nom_carte" placeholder="Nom de la carte" class="input-field" name="nom_carte" type="text" required>
    </div>
    
    <div class="field">
    <svg class="input-icon" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 16">
    <path d="M18 0H2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2ZM6.5 3a2.5 2.5 0 1 1 0 5 2.5 2.5 0 0 1 0-5ZM3.014 13.021l.157-.625A3.427 3.427 0 0 1 6.5 9.571a3.426 3.426 0 0 1 3.322 2.805l.159.622-6.967.023ZM16 12h-3a1 1 0 0 1 0-2h3a1 1 0 0 1 0 2Zm0-3h-3a1 1 0 1 1 0-2h3a1 1 0 1 1 0 2Zm0-3h-3a1 1 0 1 1 0-2h3a1 1 0 1 1 0 2Z"/>
  </svg>
        <input autocomplete="off" id="numero_carte" placeholder="Numéro de carte" class="input-field" name="numero_carte" type="text" required>
    </div>

    <div class="field">
    <svg class="input-icon" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 16">
    <path d="M18 0H2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2ZM6.5 3a2.5 2.5 0 1 1 0 5 2.5 2.5 0 0 1 0-5ZM3.014 13.021l.157-.625A3.427 3.427 0 0 1 6.5 9.571a3.426 3.426 0 0 1 3.322 2.805l.159.622-6.967.023ZM16 12h-3a1 1 0 0 1 0-2h3a1 1 0 0 1 0 2Zm0-3h-3a1 1 0 1 1 0-2h3a1 1 0 1 1 0 2Zm0-3h-3a1 1 0 1 1 0-2h3a1 1 0 1 1 0 2Z"/>
  </svg>
        <input autocomplete="off" id="expiration_carte" placeholder="Expiration de la carte" class="input-field" name="expiration_carte" type="date" required>
    </div>
    <div class="exd">Expiration de la carte</div>
    

          <button class="btn" type="submit" name="validerAchat" >Valider l'Achat</button><br><br>      
          <p id="messageRemerciement"></p>
          <p>Si Vous n'avez pas encore connectez <a href="connexion.html" class="btn-link">Connectez-vous!</a> </p><br>
          <p>Vous n'avez pas encore de compte ? <a href="inscription.html" class="btn-link">Inscrivez-vous!</a> </p>
      </form>
  </div>
</div>

<?php include('footer.php'); ?>
</body>
</html>
