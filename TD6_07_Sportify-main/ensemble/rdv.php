<?php
include 'php/db.php';

if (!isset($_GET['coach_id'])) {
    echo "Coach not specified.";
    exit();
}

$coach_id = $_GET['coach_id'];

// Récupérer les informations du coach
$sql = "SELECT c.*, u.nom FROM coachs c
        JOIN utilisateurs u ON c.utilisateur_id = u.utilisateur_id
        WHERE c.coach_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $coach_id);
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
$creaneaux_sql = "SELECT * FROM creaneaux_horaires WHERE coach_id = ? AND statut = 'disponible'";
$creaneaux_stmt = $conn->prepare($creaneaux_sql);
$creaneaux_stmt->bind_param("i", $coach_id);
$creaneaux_stmt->execute();
$creaneaux_result = $creaneaux_stmt->get_result();
while ($row = $creaneaux_result->fetch_assoc()) {
    $creaneaux[$row['date_rendezvous']] = $row['statut'];
}

$jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
$times = ['09:00', '10:00', '11:00', '12:00', '14:00', '15:00', '16:00', '17:00'];

function is_reserved($datetime) {
    global $creaneaux;
    return isset($creaneaux[$datetime]) && $creaneaux[$datetime] === 'indisponible';
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réserver un RDV - <?php echo htmlspecialchars($coach['nom']); ?></title>
    <link rel="stylesheet" href="styles.css">
    <style>
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

        .confirmed {
            background-color: #000;
            color: #fff;
            cursor: not-allowed;
        }

        .available:hover {
            background-color: #e0e0e0;
        }
    </style>
    <script>
        function reserveSlot(date, cell) {
            if (confirm('Voulez-vous vraiment réserver ce créneau ?')) {
                fetch('reserve1.php?coach_id=<?php echo $coach['coach_id']; ?>&date=' + encodeURIComponent(date))
                    .then(response => response.text())
                    .then(data => {
                        if (data === 'Réservation confirmée.') {
                            alert(data);
                            cell.className = 'confirmed';
                            cell.onclick = null;
                            cell.innerHTML = 'Indisponible';
                        } else {
                            alert('Erreur lors de la réservation.');
                        }
                    });
            }
        }
    </script>
</head>
<body>
    <div class="wrapper">
        <header class="header">
            <h1>Réserver un RDV avec <?php echo htmlspecialchars($coach['nom']); ?></h1>
        </header>
        <section class="section">
            <h2>Disponibilité</h2>
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
                            $onclick = is_reserved($datetime) ? '' : "onclick=\"reserveSlot('$datetime', this)\"";
                            echo "<td class='$class' $onclick>$time</td>";
                        }
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </section>
        <footer class="footer">
            <!-- Footer Content -->
        </footer>
    </div>
</body>
</html>
