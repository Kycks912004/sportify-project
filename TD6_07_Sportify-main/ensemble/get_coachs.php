<?php
require 'php/db.php'; // fichier de configuration pour la connexion à la base de données

$sql = "SELECT c.coach_id, u.nom, c.specialite, c.disponibilite, c.bio, c.photo
        FROM coachs c
        JOIN utilisateurs u ON c.utilisateur_id = u.utilisateur_id";
$result = $conn->query($sql);

$coachs = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $coachs[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode(['coachs' => $coachs], JSON_PRETTY_PRINT);

$conn->close();
?>
