<?php
include 'db.php';

// Supposons que l'utilisateur connecté a l'ID 1 (à remplacer par le système d'authentification réel)
$user_id = 1;

$sql = "SELECT rv.rendezvous_id, c.nom AS coach_name, rv.date_rendezvous, c.adresse, rv.informations
        FROM RendezVous rv
        JOIN Coachs c ON rv.coach_id = c.coach_id
        JOIN Utilisateurs u ON rv.utilisateur_id = u.utilisateur_id
        WHERE rv.utilisateur_id = ? AND rv.statut = 'confirmé'";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$appointments = [];
while ($row = $result->fetch_assoc()) {
    $appointments[] = $row;
}

$stmt->close();
$conn->close();

header('Content-Type: application/json');
echo json_encode($appointments);
?>
