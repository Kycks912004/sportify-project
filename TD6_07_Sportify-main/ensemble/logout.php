<?php
session_start();
include 'php/db.php';  // Vérifiez que ce fichier contient la connexion à la base de données

$user_id = $_SESSION['user_id'];

// Mettre à jour l'état hors ligne
$update_status = $conn->prepare("UPDATE utilisateurs SET online = 0 WHERE utilisateur_id = ?");
$update_status->bind_param("i", $user_id);
$update_status->execute();

session_destroy();
header("Location: login.html");
?>
