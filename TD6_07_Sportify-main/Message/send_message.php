<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $from_user_id = $_SESSION['user_id'];
    $to_user_id = $_POST['to_user_id'];
    $message = $_POST['message'];

    $stmt = $conn->prepare("INSERT INTO messages (from_user_id, to_user_id, message) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $from_user_id, $to_user_id, $message);

    if ($stmt->execute()) {
        echo "Message envoyé!";
    } else {
        echo "Erreur: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
