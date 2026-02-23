<?php
include 'php/db.php';  // Vérifiez que ce fichier contient la connexion à la base de données

$query = isset($_GET['query']) ? $_GET['query'] : '';
$searchResults = [];

if (!empty($query)) {
    // Rechercher des coachs par nom ou spécialité
    $sql = "SELECT u.nom AS coach_nom, u.email, u.numero_telephone, u.adresse, c.specialite, c.disponibilite, c.bio, c.photo
            FROM Utilisateurs u
            JOIN Coachs c ON u.utilisateur_id = c.utilisateur_id
            WHERE u.nom LIKE ? OR c.specialite LIKE ? OR 'coach' = ?";
    $stmt = $conn->prepare($sql);
    $searchTerm = "%" . $query . "%";
    $stmt->bind_param("sss", $searchTerm, $searchTerm, $query);
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
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sportify: Consultation Sportive</title>
    <link rel="stylesheet" href="stylesVTR.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css">
</head>
<body>
    <div class="wrapper">
        <header class="header">
            <h1><span class="highlight">Sportify:</span> Consultation Sportive</h1>
            <img src="logo.png" alt="Sportify Logo">
        </header>
        <nav class="navigation">
            <button onclick="window.location.href='index.html'">Accueil</button>
            <button onclick="window.location.href='tout-parcourir.html'">Tout Parcourir</button>
            <button onclick="window.location.href='recherche.php'">Recherche</button>
            <button>Rendez-vous</button>
            <button onclick="window.location.href='compte.html'">Votre Compte</button>
        </nav>
        <section class="section">
            <form action="recherche.php" method="GET">
                <input type="text" name="query" placeholder="Entrez votre recherche...">
                <button type="submit">Rechercher</button>
            </form>
            <?php if (empty($searchResults)): ?>
                <p>Aucun résultat trouvé.</p>
            <?php else: ?>
                <ul>
                    <?php foreach ($searchResults as $result): ?>
                        <li>
                            <?php if (isset($result['coach_nom'])): ?>
                                <h3>Coach: <?php echo htmlspecialchars($result['coach_nom']); ?></h3>
                                <p>Email: <?php echo htmlspecialchars($result['email']); ?></p>
                                <p>Téléphone: <?php echo htmlspecialchars($result['numero_telephone']); ?></p>
                                <p>Adresse: <?php echo htmlspecialchars($result['adresse']); ?></p>
                                <p>Spécialité: <?php echo htmlspecialchars($result['specialite']); ?></p>
                                <p>Disponibilité: <?php echo htmlspecialchars($result['disponibilite']); ?></p>
                                <p>Bio: <?php echo htmlspecialchars($result['bio']); ?></p>
                                <img src="<?php echo htmlspecialchars($result['photo']); ?>" alt="Photo de <?php echo htmlspecialchars($result['coach_nom']); ?>" width="100">
                            <?php else: ?>
                                <h3>Installation sportive: <?php echo htmlspecialchars($result['nom']); ?></h3>
                                <p>Description: <?php echo htmlspecialchars($result['description']); ?></p>
                                <p>Règles: <?php echo htmlspecialchars($result['regles']); ?></p>
                                <p>Disponibilité: <?php echo htmlspecialchars($result['disponibilite']); ?></p>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </section>
        <footer class="footer">
            <div class="contact-info">
                <h2>Contactez-nous</h2>
                <p>Email: contact@sportify.com</p>
                <p>Téléphone: 01 23 45 67 89</p>
                <p>Adresse: 10 rue Sextius Michel, 75016 Paris </p>
            </div>
            <div class="map">
                <h2>Notre Adresse</h2>
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2624.935874220475!2d2.2885659!3d48.8512252!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e6701b4f58251b%3A0x167f5a60fb94aa76!2sECE%20-%20Ecole%20d'ing%C3%A9nieurs%20-%20Campus%20de%20Paris!5e0!3m2!1sen!2sfr!4v1593582738147!5m2!1sen!2sfr" 
                    width="600" 
                    height="450" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy">
                </iframe>
            </div>
        </footer>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
    <script src="scripts.js"></script>
</body>
</html>
