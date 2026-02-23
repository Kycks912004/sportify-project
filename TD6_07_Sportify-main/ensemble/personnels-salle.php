<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Coachs</title>
    <style>
        /* Ajoute ton CSS ici */
        .coach {
            border: 1px solid #ccc;
            margin-bottom: 20px;
            padding: 10px;
        }
        .coach img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin-right: 10px;
            float: left;
        }
        .coach-info {
            float: left;
        }
        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }
    </style>
</head>
<body>
    <h1>Liste des Coachs</h1>
    <?php
    include 'php/db.php';

    $conn = new mysqli($servername, $username, $password, $dbname);


    

    // Récupérer les données des coachs
    $sql = "SELECT coachs.*, utilisateurs.nom AS nom_utilisateur FROM coachs INNER JOIN utilisateurs ON coachs.utilisateur_id = utilisateurs.utilisateur_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Afficher les données
        while($row = $result->fetch_assoc()) {
            echo "<div class='coach'>";
            echo "<img src='" . $row['photo'] . "' alt='Photo du coach'>";
            echo "<div class='coach-info'>";
            echo "<h2>" . $row['nom_utilisateur'] . "</h2>";
            echo "<p><strong>Spécialité:</strong> " . $row['specialite'] . "</p>";
            echo "<p><strong>Disponibilité:</strong> " . $row['disponibilite'] . "</p>";
            echo "<p><strong>Bio:</strong> " . $row['bio'] . "</p>";
            echo "</div>";
            echo "</div>";
            echo "<div class='clearfix'></div>";
        }
    } else {
        echo "Aucun coach trouvé";
    }
    $conn->close();
    ?>
</body>
</html>
