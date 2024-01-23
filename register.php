<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['fname'], $_POST['lname'], $_POST['phonenumber'], $_POST['logemail'], $_POST['logpass'])) {

        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $phonenumber = $_POST['phonenumber'];
        $logemail = $_POST['logemail'];
        $logpass = $_POST['logpass'];

        if (empty($fname) || empty($lname) || empty($phonenumber) || empty($logemail) || empty($logpass)) {
            header("Location: inscription.html?error=fill_all_fields");
    exit();
        }

        $servername = "127.0.0.1";
        $username = "root";
        $password = "";
        $dbname = "ecommerce_web_site";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $fname = $conn->real_escape_string($fname);
        $lname = $conn->real_escape_string($lname);
        $phonenumber = $conn->real_escape_string($phonenumber);
        $logemail = $conn->real_escape_string($logemail);
        $logpass = $conn->real_escape_string($logpass);

        $sql = "INSERT INTO users (fname, lname, phonenumber, logemail, logpass) VALUES ('$fname', '$lname', '$phonenumber', '$logemail', '$logpass')";

        if ($conn->query($sql) === TRUE) {
            header("Location: inscription.html?success=registration_success");
    exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();

    } else {
        echo "<script>alert('Certains champs du formulaire sont manquants.');</script>";
    }
}
?>
