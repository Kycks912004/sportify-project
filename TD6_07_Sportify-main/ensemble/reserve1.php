<?php
include 'php/db.php';

if (!isset($_GET['coach_id']) || !isset($_GET['date'])) {
    echo "Invalid request.";
    exit();
}

$coach_id = $_GET['coach_id'];
$date = $_GET['date'];


$update_sql = "UPDATE creaneaux_horaires SET statut = 'indisponible' WHERE coach_id = ? AND date_rendezvous = ?";
$update_stmt = $conn->prepare($update_sql);
$update_stmt->bind_param("is", $coach_id, $date);

if ($update_stmt->execute()) {
    echo "Réservation confirmée.";
} else {
    echo "Erreur lors de la réservation.";
}
?>
