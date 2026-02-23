<?php
session_start();
include 'php/db.php';  // Vérifiez que ce fichier contient la connexion à la base de données

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'Administrateur') {
    header("Location: login.html");
    exit();
}

$sql = "SELECT * FROM coachs";
$result = $conn->query($sql);
$coaches = [];
while ($row = $result->fetch_assoc()) {
    $coaches[] = $row;
}

echo json_encode(['coaches' => $coaches]);

$conn->close();
?>
