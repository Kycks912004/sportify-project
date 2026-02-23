<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tout Parcourir - Sportify</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="wrapper">
        <header class="header">
            <h1><span class="highlight">Sportify:</span> Consultation Sportive</h1>
            <img src="path/to/logo.png" alt="Sportify Logo">
        </header>
        <nav class="navigation">
            <button onclick="location.href='index.html'">Accueil</button>
            <button onclick="location.href='activites-sportives.php'">Activités Sportives</button>
            <button onclick="location.href='sports-de-competition.php'">Les Sports de Compétition</button>
            <button onclick="location.href='recherche.html'">Recherche</button>
            <button onclick="location.href='rendez-vous.html'">Rendez-vous</button>
            <button onclick="location.href='votre-compte.html'">Votre Compte</button>
        </nav>
        <section class="section">
            <h2>Tout Parcourir</h2>
            <p>Il s’agit de toutes les catégories des services disponibles chez Sportify.</p>
            <ul>
                <li onclick="loadCoachInfo(6)">Musculation</li>
                <li onclick="loadCoachInfo(7)">Fitness</li>
                <li onclick="loadCoachInfo(8)">Cardio-Training</li>
                <li onclick="loadCoachInfo(12)">Biking</li>
                <li onclick="loadCoachInfo(13)">Cours Collectifs</li>
                <li onclick="loadCoachInfo(14)">Basketball</li>
                <li onclick="loadCoachInfo(15)">Football</li>
                <li onclick="loadCoachInfo(16)">Rugby</li>
                <li onclick="loadCoachInfo(17)">Tennis</li>
                <li onclick="loadCoachInfo(18)">Natation</li>
                <li onclick="loadCoachInfo(19)">Plongeon</li>
            </ul>
            <div id="coach-info"></div>
        </section>
        <footer class="footer">
            <!-- Footer Content -->
        </footer>
    </div>
    <script src="script.js"></script>
</body>
</html>
