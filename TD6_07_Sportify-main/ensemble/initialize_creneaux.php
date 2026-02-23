<?php
include 'php/db.php';

function initialize_creneaux($coach_id) {
    global $conn;
    $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
    $times = ['09:00', '10:00', '11:00', '12:00', '14:00', '15:00', '16:00', '17:00'];
    
    foreach ($jours as $jour) {
        foreach ($times as $time) {
            $datetime = date('Y-m-d H:i:s', strtotime("next $jour $time"));
            $sql = "INSERT INTO creaneaux_horaires (coach_id, date_rendezvous, statut) VALUES (?, ?, 'disponible')";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("is", $coach_id, $datetime);
            $stmt->execute();
        }
    }
}

// Initialiser les créneaux pour tous les coachs
$coachs = $conn->query("SELECT coach_id FROM coachs");
while ($row = $coachs->fetch_assoc()) {
    initialize_creneaux($row['coach_id']);
}
?>
