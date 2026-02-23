<?php
session_start();
include 'config.php';

$from_user_id = $_SESSION['user_id'];
$to_user_id = $_GET['to_user_id'];

$stmt = $conn->prepare("SELECT * FROM messages WHERE (from_user_id = ? AND to_user_id = ?) OR (from_user_id = ? AND to_user_id = ?) ORDER BY timestamp");
$stmt->bind_param("iiii", $from_user_id, $to_user_id, $to_user_id, $from_user_id);
$stmt->execute();
$result = $stmt->get_result();

$messages = array();
while ($row = $result->fetch_assoc()) {
    $messages[] = $row;
}

echo json_encode($messages);

$stmt->close();
$conn->close();
?>
