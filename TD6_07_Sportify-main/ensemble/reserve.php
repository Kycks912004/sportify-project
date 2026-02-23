<?php
include 'php/db.php';

if (!isset($_GET['coach_id']) || !isset($_GET['date'])) {
    echo "Missing parameters.";
    exit();
}

$coach_id = $_GET['coach_id'];
$date = $_GET['date']; // Format: 'Y-m-d H:i:s'

// Vérifier si le créneau est déjà réservé
$sql = "SELECT * FROM creaneaux_horaires WHERE coach_id = ? AND date_rendezvous = ? AND statut = 'indisponible'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $coach_id, $date);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "Ce créneau est déjà réservé.";
    exit();
}

// Remplacez $utilisateur_id par l'ID de l'utilisateur connecté
$utilisateur_id = 1; // Exemple: ID de l'utilisateur connecté

// Insérer le rendez-vous dans la base de données
$sql = "INSERT INTO rendezvous (utilisateur_id, coach_id, date_rendezvous, statut) VALUES (?, ?, ?, 'confirmé')";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iis", $utilisateur_id, $coach_id, $date);
$stmt->execute();

// Mettre à jour le créneau horaire comme indisponible
$sql = "UPDATE creaneaux_horaires SET statut = 'indisponible' WHERE coach_id = ? AND date_rendezvous = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $coach_id, $date);
$stmt->execute();

// Rediriger vers la page du profil du coach avec un message de succès
$specialite_sql = "SELECT specialite FROM coachs WHERE coach_id = ?";
$specialite_stmt = $conn->prepare($specialite_sql);
$specialite_stmt->bind_param("i", $coach_id);
$specialite_stmt->execute();
$specialite_result = $specialite_stmt->get_result();
$specialite_row = $specialite_result->fetch_assoc();
$specialite = $specialite_row['specialite'];

header("Location: coach_profile.php?specialite=" . urlencode($specialite) . "&success=1&date=$date");
exit();
?>
