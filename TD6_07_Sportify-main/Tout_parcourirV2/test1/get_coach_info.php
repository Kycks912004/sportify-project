<?php
header('Content-Type: application/json');

// Affichage des erreurs PHP pour le débogage
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Inclusion du fichier de configuration
include 'config.php'; 

// Vérification de la présence de l'ID de l'activité
$activite_id = isset($_GET['activite_id']) ? intval($_GET['activite_id']) : 0;
if ($activite_id == 0) {
    echo json_encode(['error' => 'No activite_id provided']);
    exit;
}

// Récupération des informations du coach
$sql = "SELECT u.nom, c.photo, c.disponibilite, c.bio, u.adresse AS bureau, c.cv 
        FROM coachs c 
        JOIN activitessportives a ON c.coach_id = a.responsable_id 
        JOIN utilisateurs u ON c.utilisateur_id = u.utilisateur_id
        WHERE a.activite_id = $activite_id";

$result = $conn->query($sql);

if (!$result) {
    echo json_encode(['error' => 'Database query failed: ' . $conn->error]);
    exit;
}

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode($row);
} else {
    echo json_encode(['error' => 'No coach found for this activity']);
}

$conn->close();
?>
