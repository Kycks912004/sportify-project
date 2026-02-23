<?php
session_start();
include 'config.php';

$user_id = $_SESSION['user_id'];

// Mettre à jour l'état hors ligne
$update_status = $conn->prepare("UPDATE utilisateurs SET online = 0 WHERE utilisateur_id = ?");
$update_status->bind_param("i", $user_id);
$update_status->execute();

session_destroy();
header("Location: login.html");
?>
