<?php
session_start();
include 'php/db.php';  // Vérifiez que ce fichier contient la connexion à la base de données

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hasher le mot de passe pour la sécurité
    $role = $_POST['role'];
    $address = $_POST['address'];
    $address_line2 = $_POST['address_line2'];
    $ville = $_POST['ville'];
    $code_postal = $_POST['code_postal'];
    $pays = $_POST['pays'];
    $phone = $_POST['phone'];
    $student_card = $_POST['student_card'];

    // Vérifier si l'email existe déjà
    $checkEmail = $conn->prepare("SELECT * FROM utilisateurs WHERE email = ?");
    $checkEmail->bind_param("s", $email);
    $checkEmail->execute();
    $result = $checkEmail->get_result();

    if ($result->num_rows > 0) {
        echo "Cet email est déjà utilisé.";
    } else {
        // Insérer le nouvel utilisateur dans la base de données
        $stmt = $conn->prepare("INSERT INTO utilisateurs (nom, prenom, email, mot_de_passe, type_utilisateur, adresse, adresse_ligne_2, ville, code_postal, pays, numero_telephone, carte_etudiant) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssssssss", $name, $prenom, $email, $password, $role, $address, $address_line2, $ville, $code_postal, $pays, $phone, $student_card);

        if ($stmt->execute()) {
            $user_id = $conn->insert_id;

            // Si le rôle est client, insérer les informations de paiement
            if ($role === 'client') {
                $type_carte = $_POST['type_carte'];
                $numero_carte = $_POST['numero_carte'];
                $nom_carte = $_POST['nom_carte'];
                $date_expiration = $_POST['date_expiration'];
                $code_securite = $_POST['code_securite'];

                $stmt_payment = $conn->prepare("INSERT INTO paiements (utilisateur_id, type_carte, numero_carte, nom_carte, date_expiration, code_securite) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt_payment->bind_param("isssss", $user_id, $type_carte, $numero_carte, $nom_carte, $date_expiration, $code_securite);

                if ($stmt_payment->execute()) {
                    echo "Inscription réussie!";
                    // Rediriger vers la page de connexion ou une autre page appropriée
                    header("Location: login.html");
                    exit();
                } else {
                    echo "Erreur lors de l'enregistrement des informations de paiement: " . $stmt_payment->error;
                }
            } else {
                echo "Inscription réussie!";
                // Rediriger vers la page de connexion ou une autre page appropriée
                header("Location: login.html");
                exit();
            }
        } else {
            echo "Erreur lors de l'enregistrement: " . $stmt->error;
        }
    }
}
?>
