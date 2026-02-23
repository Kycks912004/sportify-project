<?php
// Configuration commune
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "Sportify";
$charset = 'utf8mb4';

// Configuration MySQLi
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion MySQLi
if ($conn->connect_error) {
    die("Échec de la connexion MySQLi : " . $conn->connect_error);
}

// Configuration PDO
$dsn = "mysql:host=$servername;dbname=$dbname;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    die("Échec de la connexion PDO : " . $e->getMessage());
}
?>
