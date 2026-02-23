<?php
include 'php/db.php';

if (!isset($_GET['coach_id'])) {
    echo "Coach ID not specified.";
    exit();
}

$coach_id = $_GET['coach_id'];

// Récupérer les informations du coach, y compris son nom et prénom
$sql = "SELECT coachs.*, utilisateurs.nom, utilisateurs.prenom 
        FROM coachs 
        INNER JOIN utilisateurs ON coachs.utilisateur_id = utilisateurs.utilisateur_id 
        WHERE coach_id = ?";
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

$xml_file = $coach['xml_file'];

// Charger le contenu du fichier XML
$xml_content = file_get_contents($xml_file);
$xml = simplexml_load_string($xml_content);

if ($xml === false) {
    echo "Failed to load XML file.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CV de <?php echo htmlspecialchars($coach['nom'] . ' ' . $coach['prenom']); ?></title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .profile-picture {
            display: block;
            margin: 0 auto 20px;
            max-width: 150px;
            border-radius: 50%;
        }
        section {
            margin-bottom: 20px;
        }
        section h2 {
            background: #007bff;
            color: white;
            padding: 10px;
            border-radius: 5px;
            text-transform: uppercase;
            font-size: 1.2em;
        }
        section p, section ul {
            padding: 10px;
            background: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        ul {
            list-style: none;
            padding-left: 0;
        }
        ul li {
            margin-bottom: 10px;
        }
        .back-button {
            display: block;
            width: 150px;
            margin: 20px auto;
            padding: 10px;
            text-align: center;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s ease;
        }
        .back-button:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>CV de <?php echo htmlspecialchars($coach['nom'] . ' ' . $coach['prenom']); ?></h1>
        <img src="<?php echo htmlspecialchars($xml->ProfilePicture); ?>" alt="Profile Picture" class="profile-picture">
        <?php foreach ($xml->Page as $page): ?>
            <section>
                <h2>Page <?php echo htmlspecialchars($page['number']); ?></h2>
                <p><?php echo nl2br(htmlspecialchars($page)); ?></p>
            </section>
        <?php endforeach; ?>
        <a href="javascript:history.back()" class="back-button">Retour</a>
    </div>
</body>
</html>
