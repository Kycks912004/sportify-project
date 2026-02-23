<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rendezvous_id = $_POST['id'];
    
    // Update the rendezvous status
    $stmt = $conn->prepare("UPDATE rendezvous SET statut = 'annulé' WHERE rendezvous_id = ?");
    $stmt->bind_param("i", $rendezvous_id);
    
    if ($stmt->execute()) {
        // Retrieve the creaneaux_id corresponding to the rendezvous
        $stmt = $conn->prepare("SELECT id FROM creaneaux_horaires WHERE coach_id = (SELECT coach_id FROM rendezvous WHERE rendezvous_id = ?)");
        $stmt->bind_param("i", $rendezvous_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $creaneaux_id = $row['id'];

        // Set the creaneaux_horaires status to 'disponible'
        $stmt = $conn->prepare("UPDATE creaneaux_horaires SET statut = 'disponible' WHERE id = ?");
        $stmt->bind_param("i", $creaneaux_id);
        $stmt->execute();

        echo "Le rendez-vous a été annulé et le créneau est maintenant disponible.";
    } else {
        echo "Erreur lors de l'annulation du rendez-vous: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
