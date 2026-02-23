<?php
include 'config.php';

$user_id = $_GET['user_id'];

$stmt = $conn->prepare("SELECT online FROM utilisateurs WHERE utilisateur_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

echo json_encode(['online' => (bool)$user['online']]);

$stmt->close();
$conn->close();
?>
