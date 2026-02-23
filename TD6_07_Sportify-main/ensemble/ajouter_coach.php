<?php
require_once 'php/db.php'; // Inclure le fichier de connexion à la base de données

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $utilisateur_id = $_POST['utilisateur_id'];
    $specialite = $_POST['specialite'];
    $disponibilite = $_POST['disponibilite'];
    $bio = $_POST['bio'];

    $photo = $_FILES['photo'];
    $xml_file = $_FILES['xml_file'];

    $photo_path = 'uploads/' . basename($photo['name']);
    if (!is_dir('uploads')) {
        mkdir('uploads', 0777, true);
    }

    if (move_uploaded_file($photo['tmp_name'], $photo_path)) {
        $photo_uploaded = true;
    } else {
        $photo_uploaded = false;
        $photo_error = "Erreur lors du téléchargement de la photo.";
    }

    $xml_file_path = null;
    if (!empty($xml_file['name'])) {
        $xml_file_path = 'XML/' . basename($xml_file['name']);
        if (!is_dir('XML')) {
            mkdir('XML', 0777, true);
        }

        if (move_uploaded_file($xml_file['tmp_name'], $xml_file_path)) {
            $xml_uploaded = true;
        } else {
            $xml_uploaded = false;
            $xml_error = "Erreur lors du téléchargement du fichier XML.";
        }
    }

    // Vérifiez que la connexion à la base de données est initialisée
    if (!isset($pdo)) {
        die("La connexion à la base de données n'est pas initialisée.");
    }

    $sql = "INSERT INTO coachs (utilisateur_id, specialite, disponibilite, bio, photo, xml_file) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute([$utilisateur_id, $specialite, $disponibilite, $bio, $photo_path, $xml_file_path])) {
        echo "Coach ajouté avec succès.";
    } else {
        echo "Erreur lors de l'ajout du coach.";
    }
} else {
    echo "Méthode non autorisée.";
}
?>
