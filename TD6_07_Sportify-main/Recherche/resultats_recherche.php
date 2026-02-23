<?php
include 'php/db.php'; // Assurez-vous que le chemin est correct

$query = isset($_GET['query']) ? $_GET['query'] : '';

$searchResults = [];

// Rechercher des coachs par nom ou spécialité
$sql = "SELECT u.nom AS coach_nom, u.email, u.numero_telephone, u.adresse, c.specialite, c.disponibilite, c.bio, c.photo
        FROM Utilisateurs u
        JOIN Coachs c ON u.utilisateur_id = c.utilisateur_id
        WHERE u.nom LIKE ? OR c.specialite LIKE ?";
$stmt = $conn->prepare($sql);
$searchTerm = "%" . $query . "%";
$stmt->bind_param("ss", $searchTerm, $searchTerm);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $searchResults[] = $row;
}

// Rechercher des installations sportives par nom
$sql = "SELECT nom, description, regles, disponibilite
        FROM InstallationsSportives
        WHERE nom LIKE ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $searchTerm);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $searchResults[] = $row;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats de recherche - Sportify</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <nav>
        <ul>
            <li><a href="index.php">Accueil</a></li>
            <li><a href="user_account.php">Votre compte</a></li>
            <li><a href="recherche.php">Recherche</a></li>
        </ul>
    </nav>
    <h1>Résultats de recherche pour "<?php echo htmlspecialchars($query); ?>"</h1>
    <?php if (empty($searchResults)): ?>
        <p>Aucun résultat trouvé.</p>
    <?php else: ?>
        <div class="search-results">
            <ul>
                <?php foreach ($searchResults as $result): ?>
                    <li>
                        <?php if (isset($result['coach_nom'])): ?>
                            <h2>Coach: <?php echo htmlspecialchars($result['coach_nom']); ?></h2>
                            <p>Email: <?php echo htmlspecialchars($result['email']); ?></p>
                            <p>Téléphone: <?php echo htmlspecialchars($result['numero_telephone']); ?></p>
                            <p>Adresse: <?php echo htmlspecialchars($result['adresse']); ?></p>
                            <p>Spécialité: <?php echo htmlspecialchars($result['specialite']); ?></p>
                            <p>Disponibilité: <?php echo htmlspecialchars($result['disponibilite']); ?></p>
                            <p>Bio: <?php echo htmlspecialchars($result['bio']); ?></p>
                            <img src="<?php echo htmlspecialchars($result['photo']); ?>" alt="Photo de <?php echo htmlspecialchars($result['coach_nom']); ?>" class="search-results img">
                        <?php else: ?>
                            <h2>Installation sportive: <?php echo htmlspecialchars($result['nom']); ?></h2>
                            <p>Description: <?php echo htmlspecialchars($result['description']); ?></p>
                            <p>Règles: <?php echo htmlspecialchars($result['regles']); ?></p>
                            <p>Disponibilité: <?php echo htmlspecialchars($result['disponibilite']); ?></p>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
</body>
</html>
