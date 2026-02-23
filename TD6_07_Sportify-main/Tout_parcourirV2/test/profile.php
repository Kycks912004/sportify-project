<?php
require_once 'connexion_bdd.php';

$id = $_GET['id'];

$sql = "SELECT nom, email, numero_telephone FROM utilisateurs WHERE utilisateur_id = $id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo "<h1>" . $row["nom"] . "</h1>";
    echo "<p><strong>Email :</strong> " . $row["email"] . "</p>";
    echo "<p><strong>Téléphone :</strong> " . $row["numero_telephone"] . "</p>";
    echo "<a href='mailto:" . $row["email"] . "'>Envoyer un email</a>";
} else {
    echo "Aucun coach trouvé avec cet ID.";
}

$conn->close();
?>
