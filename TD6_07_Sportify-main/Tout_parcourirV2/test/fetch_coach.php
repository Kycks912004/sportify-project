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

$coachId = $_GET['id'];
$coach = [];

$sql = "SELECT c.coach_id, u.nom, c.photo, c.disponibilite, c.bio AS cv
        FROM coachs c
        JOIN utilisateurs u ON c.utilisateur_id = u.utilisateur_id
        WHERE c.coach_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $coachId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $coach = $result->fetch_assoc();
}

$stmt->close();
$conn->close();

header('Content-Type: application/json');
echo json_encode($coach);
?>
