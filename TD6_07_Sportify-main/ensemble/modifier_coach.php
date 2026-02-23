<?php
require_once 'php/db.php'; // Inclure le fichier de connexion à la base de données

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $coach_id = $_POST['coach_id'];
    $utilisateur_id = $_POST['utilisateur_id'];
    $specialite = $_POST['specialite'];
    $disponibilite = $_POST['disponibilite'];
    $bio = $_POST['bio'];

    $photo_path = null;
    $xml_file_path = null;

    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $photo = $_FILES['photo'];
        $photo_path = 'uploads/' . basename($photo['name']);
        if (!is_dir('uploads')) {
            mkdir('uploads', 0777, true);
        }
        if (move_uploaded_file($photo['tmp_name'], $photo_path)) {
            $photo_uploaded = true;
        } else {
            echo "Erreur lors du téléchargement de la photo.";
            exit;
        }
    }

    if (isset($_FILES['xml_file']) && $_FILES['xml_file']['error'] == 0) {
        $xml_file = $_FILES['xml_file'];
        $xml_file_path = 'XML/' . basename($xml_file['name']);
        if (!is_dir('XML')) {
            mkdir('XML', 0777, true);
        }
        if (move_uploaded_file($xml_file['tmp_name'], $xml_file_path)) {
            $xml_uploaded = true;
        } else {
            echo "Erreur lors du téléchargement du fichier XML.";
            exit;
        }
    }

    $sql = "UPDATE coachs SET utilisateur_id = ?, specialite = ?, disponibilite = ?, bio = ?";
    if ($photo_path) {
        $sql .= ", photo = ?";
    }
    if ($xml_file_path) {
        $sql .= ", xml_file = ?";
    }
    $sql .= " WHERE coach_id = ?";

    $stmt = $pdo->prepare($sql);
    $params = [$utilisateur_id, $specialite, $disponibilite, $bio];
    if ($photo_path) {
        $params[] = $photo_path;
    }
    if ($xml_file_path) {
        $params[] = $xml_file_path;
    }
    $params[] = $coach_id;

    if ($stmt->execute($params)) {
        echo "Coach modifié avec succès.";
    } else {
        echo "Erreur lors de la modification du coach.";
    }
} else {
    echo "Méthode non autorisée.";
}
?>
