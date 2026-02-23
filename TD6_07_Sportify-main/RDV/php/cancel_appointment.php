<?php
include 'db.php';

$data = json_decode(file_get_contents('php://input'), true);
$rendezvous_id = $data['rendezvous_id'];

$sql = "UPDATE RendezVous SET statut = 'annulé' WHERE rendezvous_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $rendezvous_id);

$response = [];
if ($stmt->execute()) {
    $response['success'] = true;
} else {
    $response['success'] = false;
}

$stmt->close();
$conn->close();

header('Content-Type: application/json');
echo json_encode($response);
?>
