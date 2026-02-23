<?php
session_start();
include 'php/db.php';  // Vérifiez que ce fichier contient la connexion à la base de données

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM Utilisateurs WHERE utilisateur_id='$user_id'";
$result = $conn->query($sql);
$user = $result->fetch_assoc();

$sql = "SELECT * FROM RendezVous WHERE utilisateur_id='$user_id'";
$appointments_result = $conn->query($sql);
$appointments = [];
while ($row = $appointments_result->fetch_assoc()) {
    $appointments[] = $row;
}

$user_info = [
    'name' => $user['nom'],
    'email' => $user['email'],
    'userType' => $user['type_utilisateur'],
    'appointments' => $appointments
];

echo json_encode($user_info);

$conn->close();
?>
