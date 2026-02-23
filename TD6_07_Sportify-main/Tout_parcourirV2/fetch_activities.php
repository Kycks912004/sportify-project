<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sportify";

// Créer une connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$type = $_GET['type'];
$activities = [];

if ($type == 'sportives') {
    $sql = "SELECT activite_id, nom, responsable_id FROM activitessportives WHERE nom IN ('Musculation', 'Fitness', 'Biking', 'Cardio-Training', 'Cours Collectifs')";
} else {
    $sql = "SELECT activite_id, nom, responsable_id FROM activitessportives WHERE nom IN ('Basketball', 'Football', 'Rugby', 'Tennis', 'Natation', 'Plongeon')";
}

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $activities[] = $row;
    }
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($activities);
?>
