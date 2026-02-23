<?php
session_start();
include 'php/db.php';  // Vérifiez que ce fichier contient la connexion à la base de données

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Préparer et exécuter la requête pour récupérer l'utilisateur par email
    $stmt = $conn->prepare("SELECT * FROM Utilisateurs WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Vérifier le mot de passe en utilisant password_verify
        if (password_verify($password, $user['mot_de_passe'])) {
            // Mot de passe correct, démarrer la session utilisateur
            $_SESSION['user_id'] = $user['utilisateur_id'];
            $_SESSION['user_name'] = $user['nom'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_type'] = $user['type_utilisateur'];
            header("Location: compte.html");
        } else {
            // Mot de passe incorrect
            echo "Email ou mot de passe incorrect.";
        }
    } else {
        // Email non trouvé
        echo "Email ou mot de passe incorrect.";
    }

    $stmt->close();
}

$conn->close();
?>
