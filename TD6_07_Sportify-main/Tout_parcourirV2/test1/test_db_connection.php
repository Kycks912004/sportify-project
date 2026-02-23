<?php
header('Content-Type: text/plain');

// Affichage des erreurs PHP pour le débogage
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Inclusion du fichier de configuration
include 'config.php';

// Vérification de la connexion à la base de données
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Requête de test pour récupérer des données de la table des coachs
$sql = "SELECT * FROM coachs LIMIT 5";
$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . $conn->error);
}

// Affichage des résultats
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "Coach ID: " . $row['coach_id'] . "\n";
        echo "Utilisateur ID: " . $row['utilisateur_id'] . "\n";
        echo "Photo: " . $row['photo'] . "\n";
        echo "Disponibilité: " . $row['disponibilite'] . "\n";
        echo "Bio: " . $row['bio'] . "\n";
        echo "CV: " . $row['cv'] . "\n\n";
    }
} else {
    echo "No records found.";
}

$conn->close();
?>
