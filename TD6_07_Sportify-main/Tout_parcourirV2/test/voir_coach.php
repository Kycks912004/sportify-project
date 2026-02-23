<?php
require_once 'connexion_bdd.php';

$coach_id = $_GET['coach_id'];

$requete = "SELECT * FROM coachs WHERE coach_id = $coach_id";
$resultat = mysqli_query($connexion, $requete);

if (mysqli_num_rows($resultat) > 0) {
    $ligne = mysqli_fetch_assoc($resultat);
    echo "<h1>" . $ligne['nom'] . "</h1>";
    echo "<img src='" . $ligne['photo'] . "' alt='" . $ligne['nom'] . "'>";
    echo "<h2>Disponibilité</h2>";
    echo "<p>" . $ligne['disponibilite'] . "</p>";
    echo "<h2>CV</h2>";
    echo "<p>" . $ligne['cv'] . "</p>";
} else {
    echo "<p>Aucun coach trouvé avec cet ID.</p>";
}

mysqli_close($connexion);
?>
