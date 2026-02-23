<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hasher le mot de passe pour la sécurité
    $role = $_POST['role'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $student_card = $_POST['student_card'];

    // Vérifier si l'email existe déjà
    $checkEmail = $conn->prepare("SELECT * FROM Utilisateurs WHERE email = ?");
    $checkEmail->bind_param("s", $email);
    $checkEmail->execute();
    $result = $checkEmail->get_result();

    if ($result->num_rows > 0) {
        echo "Cet email est déjà utilisé.";
    } else {
        // Insérer le nouvel utilisateur dans la base de données
        $stmt = $conn->prepare("INSERT INTO Utilisateurs (nom, email, mot_de_passe, type_utilisateur, adresse, numero_telephone, carte_etudiant) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $name, $email, $password, $role, $address, $phone, $student_card);

        if ($stmt->execute()) {
            echo "Inscription réussie!";
            // Rediriger l'utilisateur vers la page de connexion
            header("Location: login.html");
        } else {
            echo "Erreur: " . $stmt->error;
        }

        $stmt->close();
    }

    $checkEmail->close();
}

$conn->close();
?>
