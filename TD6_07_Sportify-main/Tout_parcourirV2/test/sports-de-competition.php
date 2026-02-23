<?php
require_once 'connexion_bdd.php';

$requete = "SELECT a.*, c.nom AS nom_coach, c.photo AS photo_coach, c.disponibilite AS disponibilite_coach, c.cv AS cv_coach
            FROM activitessportives a
            INNER JOIN coachs c ON a.responsable_id = c.coach_id
            WHERE a.type = 'competition'";
$resultat = mysqli_query($connexion, $requete);

if (mysqli_num_rows($resultat) > 0) {
    echo "<h1>Sports de compétition</h1>";
    echo "<ul>";
    while ($ligne = mysqli_fetch_assoc($resultat)) {
        echo "<li>";
        echo "<h2>" . $ligne['nom'] . "</h2>";
        echo "<p>Responsable : " . $ligne['nom_coach'] . "</p>";
        echo "<a href='voir_coach.php?coach_id=" . $ligne['responsable_id'] . "'><img src='" . $ligne['photo_coach'] . "' alt='" . $ligne['nom_coach'] . "'></a>";
        echo "</li>";
    }
    echo "</ul>";
} else {
    echo "<p>Aucun sport de compétition trouvé.</p>";
}

mysqli_close($connexion);
?>
