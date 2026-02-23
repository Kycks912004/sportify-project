<?php
$servername = "localhost";
$username = "root"; // Assurez-vous que ce nom d'utilisateur est correct
$password = ""; // Assurez-vous que ce mot de passe est correct
$dbname = "Sportify";

// Créer une connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}
?>