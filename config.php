<?php
$servername = "localhost";
$username = "enter your username here";
$password = "enter your password here";
$dbname = "config";

// Création de la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_errno) {
    die("La connexion a échoué: " . $conn->connect_error);
}
?>
