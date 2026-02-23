<?php
include 'php/db.php';

// Récupérer les activités sportives
$sql = "SELECT activitessportives.nom AS activite_nom, coachs.coach_id, coachs.specialite 
        FROM activitessportives 
        JOIN coachs ON activitessportives.responsable_id = coachs.coach_id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Activités Sportives</title>
</head>
<body>
    <h1>Activités Sportives</h1>
    <ul>
        <?php while ($row = $result->fetch_assoc()): ?>
            <li>
                <?php echo $row['activite_nom']; ?> - 
                <a href="coach_profile.php?coach_id=<?php echo $row['coach_id']; ?>">En savoir plus sur le coach</a>
            </li>
        <?php endwhile; ?>
    </ul>
</body>
</html>
