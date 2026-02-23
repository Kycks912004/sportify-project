<?php
include 'php/db.php';

if (!isset($_GET['specialite'])) {
    echo "Specialité not specified.";
    exit();
}

$specialite = $_GET['specialite'];

$sql = "SELECT c.*, u.nom FROM coachs c
        JOIN utilisateurs u ON c.utilisateur_id = u.utilisateur_id
        WHERE c.specialite = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $specialite);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $coach = $result->fetch_assoc();
} else {
    echo "Coach not found.";
    exit();
}

// Récupérer les créneaux horaires du coach
$creaneaux = [];
$creaneaux_sql = "SELECT * FROM creaneaux_horaires WHERE coach_id = ?";
$creaneaux_stmt = $conn->prepare($creaneaux_sql);
$creaneaux_stmt->bind_param("i", $coach['coach_id']);
$creaneaux_stmt->execute();
$creaneaux_result = $creaneaux_stmt->get_result();
while ($row = $creaneaux_result->fetch_assoc()) {
    $creaneaux[$row['date_rendezvous']] = $row['statut'];
}

// Fonction pour vérifier si un créneau est réservé
function is_reserved($datetime) {
    global $creaneaux;
    return isset($creaneaux[$datetime]) && $creaneaux[$datetime] === 'indisponible';
}

$jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
$times = ['09:00', '10:00', '11:00', '12:00', '14:00', '15:00', '16:00', '17:00'];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil du Coach</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .coach-profile {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }

        .coach-profile img {
            width: 100%;
            max-width: 600px; /* Ajuster la largeur maximale souhaitée */
            height: auto;
            border-radius: 15px; /* Retirer la bordure arrondie pour un rectangle */
            margin-bottom: 20px;
        }

        .coach-profile h1, .coach-profile h2, .coach-profile p {
            text-align: center;
            margin-bottom: 10px;
        }

        .availability-table {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
        }

        .availability-table th, .availability-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        .availability-table th {
            background-color: #f2f2f2;
        }

        .available {
            background-color: #fff;
            cursor: pointer;
        }

        .reserved {
            background-color: #87CEEB;
            cursor: not-allowed;
        }

        .available:hover {
            background-color: #e0e0e0;
        }

        .button-container {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
        }

        .button-container button {
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .button-rdv {
            background-color: #28a745;
            color: white;
        }

        .button-comm {
            background-color: #17a2b8;
            color: white;
        }

        .button-cv {
            background-color: #ffc107;
            color: white;
        }

        .success-message {
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #c3e6cb;
            border-radius: 5px;
        }
    </style>
    <script>
        function reserveSlot(date) {
            if (confirm('Voulez-vous vraiment réserver ce créneau ?')) {
                window.location.href = 'reserve.php?coach_id=<?php echo $coach['coach_id']; ?>&date=' + encodeURIComponent(date);
            }
        }
    </script>
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
            <div class="coach-profile">
                <img src='<?php echo $coach["photo"]; ?>' alt='Photo du Coach'>
                <h1><?php echo $coach['nom']; ?></h1>
                <h2><?php echo $coach['specialite']; ?></h2>
                <p><?php echo $coach['bio']; ?></p>

                <h3>Disponibilité</h3>
                <table class="availability-table">
                    <thead>
                        <tr>
                            <th>Jour</th>
                            <th>09:00</th>
                            <th>10:00</th>
                            <th>11:00</th>
                            <th>12:00</th>
                            <th>14:00</th>
                            <th>15:00</th>
                            <th>16:00</th>
                            <th>17:00</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        foreach ($jours as $jour) {
                            echo "<tr><td>$jour</td>";
                            foreach ($times as $time) {
                                $datetime = date('Y-m-d H:i:s', strtotime("next $jour $time"));
                                $class = is_reserved($datetime) ? 'reserved' : 'available';
                                
                                // Si nous venons de réserver ce créneau, le mettre en bleu également
                                if (isset($_GET['date']) && $_GET['date'] === $datetime) {
                                    $class = 'reserved';
                                }
                                
                                $onclick = is_reserved($datetime) ? '' : "onclick=\"reserveSlot('$datetime')\"";
                                echo "<td class='$class' $onclick>$time</td>";
                            }
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>

                <?php if (isset($_GET['success'])): ?>
                    <div class="success-message">Rendez-vous réservé avec succès. Vous recevrez une confirmation par SMS ou courriel.</div>
                <?php endif; ?>

                <div class="button-container">
                    <button class="button-rdv" onclick="window.location.href='rdv.php?coach_id=<?php echo $coach['coach_id']; ?>'">Prendre un RDV</button>
                    <button class="button-comm" onclick="window.location.href='choose_communication.html?to_user_id=<?php echo $coach['coach_id']; ?>'">Communiquer avec le coach</button>
                    <button class="button-cv" onclick="window.location.href='cv.php?coach_id=<?php echo $coach['coach_id']; ?>'">Voir son CV</button>
                </div>
            </div>
        </section>
        <footer class="footer">
            <!-- Footer Content -->
        </footer>
    </div>
</body>
</html>
