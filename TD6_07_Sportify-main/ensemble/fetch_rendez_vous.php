<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'Utilisateur non connecté']);
    exit;
}

$user_id = $_SESSION['user_id'];

$query = "
    SELECT 
        r.rendezvous_id AS id, 
        CONCAT(c.coach_id, ' ', u.nom) AS coach_name, 
        DATE(r.date_rendezvous) AS date, 
        TIME(r.date_rendezvous) AS time, 
        IFNULL(r.adresse, 'Non spécifiée') AS address, 
        IFNULL(r.document, 'Aucun') AS document, 
        IFNULL(r.digicode, 'Non spécifié') AS digicode
    FROM 
        rendezvous r
    JOIN 
        coachs c ON r.coach_id = c.coach_id
    JOIN 
        utilisateurs u ON c.utilisateur_id = u.utilisateur_id
    WHERE 
        r.utilisateur_id = ? 
    AND 
        r.statut = 'confirmé'
";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$rendez_vous = array();
while ($row = $result->fetch_assoc()) {
    $rendez_vous[] = $row;
}

echo json_encode($rendez_vous);

$stmt->close();
$conn->close();
?>
