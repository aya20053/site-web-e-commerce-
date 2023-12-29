

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
    <title>ZahAya</title>
    <link rel="stylesheet" href="pro.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="shortcut icon" href="logo.png">
<style>
    li a[href="index.php"]{
        border-bottom: solid 2px #003554;
    }
    li a[href="index.php"]:hover{
        border: none;
    }
    .email {
    color:#935d95;
    text-decoration:none;

}

    section.para{
  padding-bottom: 20px;
  margin: 20px 100px;
  box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
  background-image: linear-gradient(rgba(224, 198, 219, 0.6),rgba(213, 193, 213, 0.6)),url('bach.jpg');
  border-radius: 30px;
}

</style>

    
</head>
<body>

    <section class="para">
        <h1 >"Bienvenue dans l'univers de la Mignonnerie !"</h1>
        <p class="paragraph">Bienvenue dans l'univers enchanteur de la Mignonnerie chez<strong> ZahAya !</strong> Nous sommes ravis de vous offrir une sélection soigneusement choisie de tasses et de bouteilles adorables qui ajouteront une touche de bonheur à votre quotidien. Explorez notre boutique en ligne pour découvrir des créations uniques spécialement conçues pour égayer votre routine.

            Que vous cherchiez le cadeau parfait ou que vous souhaitiez agrémenter votre propre collection, nos produits mignons sont là pour égayer chaque instant de votre journée. Plongez dans un monde de douceur, de créativité et de sourires avec nos tasses et bouteilles au design irrésistible.
            
            Rejoignez notre communauté de passionnés de la mignonnerie et découvrez comment nos produits peuvent apporter de la joie à votre vie quotidienne. Merci infiniment de visiter ZahAya, où chaque sourire compte , <span>n'oubliez pas de sourire ! 😊</span></p>
            
        <div class="lien"><a  href="product.html">Decouvrer nos produits</a></div> 
     </section>  
     
     <footer>
        <section class="foot">
          <h4>  A propos de nous</h4>
          <p> "Votre source de mignonnerie préférée : tout ce qui est mignon en un seul endroit."</p>




      <div class="icones">
      <i class="fa fa-envelope-o"></i>
                               <a class="email" href="mailto:ayaaatfaoui38@gmail.com"> <span> ayaaatfaoui38@gmail.com  /</span></a>
                              <a class="email" href="mailto:zahraechokrii@gmail.com"><span> zahraechokrii@gmail.com</span></a>
                                     
       <p>made with <i class="fa fa-superpowers" ></i> by  Chokri Zahra, Aatfaoui Aya .</p>
                              </span> 
                        
      
    </section>
</footer>

</body>
</html>
