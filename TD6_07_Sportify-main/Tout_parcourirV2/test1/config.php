<?php
// config.php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Sportify";

// Crée une connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifie la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
