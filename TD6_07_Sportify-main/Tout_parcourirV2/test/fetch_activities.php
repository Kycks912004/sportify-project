<?php
require_once 'connexion_bdd.php';

$type = $_GET['type'];

if ($type == 'sportives') {
    $activities = ['Musculation', 'Fitness', 'Biking', 'Cardio-Training', 'Cours Collectifs'];
} else if ($type == 'competition') {
    $activities = ['Basketball', 'Football', 'Rugby', 'Tennis', 'Natation', 'Plongeon'];
} else {
    echo "Type d'activité invalide.";
    exit();
}

$activityData = [];

foreach ($activities as $activity) {
    $stmt = $conn->prepare("SELECT a.*, c.nom AS coach_nom, c.photo AS coach_photo, c.disponibilite AS coach_disponibilite, c.cv AS coach_cv FROM activites a JOIN coachs c ON a.responsable_id = c.coach_id WHERE a.nom = ?");
    $stmt->bind_param("s", $activity);
    $stmt->execute();

    $result = $stmt->get_result();
    $activityData[] = $result->fetch_assoc();
}

echo json_encode($activityData);

$stmt->close();
$conn->close();
?>
