<?php
require 'php/db.php'; // fichier de configuration pour la connexion à la base de données

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $coach_id = $_POST['coach_id'];

    // Vérifier si l'ID du coach est bien défini et n'est pas vide
    if (isset($coach_id) && !empty($coach_id)) {
        $sql = "DELETE FROM coachs WHERE coach_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $coach_id);
        if ($stmt->execute()) {
            echo "Coach supprimé avec succès.";
        } else {
            echo "Erreur lors de la suppression du coach : " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "ID du coach non valide.";
    }
}

$conn->close();
?>
