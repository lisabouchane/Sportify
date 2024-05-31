<?php
session_start();

//vérifications
//connexion : client
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

include('config.php');

// informations 
$user_id = $_SESSION['user_id'];
$sql = "SELECT nom_client, prenom_client, adresse_client, courriel_client, carte_etudiante_client FROM clients WHERE id_client = :id_client";
$stmt = $pdo->prepare($sql);
$stmt->execute(['id_client' => $user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "Aucun utilisateur trouvé.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Votre compte Sportify</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .dashboard-container {
            max-width: 800px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px 30px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h2 {
            color: #333;
        }
        p {
            color: #555;
        }
        a, .button-link {
            color: #fff;
            text-decoration: none;
            padding: 10px 20px;
            background-color: #007BFF;
            border-radius: 4px;
            display: inline-block;
            transition: background-color 0.3s;
        }
        a:hover, .button-link:hover {
            background-color: #0056b3;
        }
        .button-link {
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="dashboard-container">
    <h2>Bienvenue sur votre tableau de bord, <?php echo htmlspecialchars($user['prenom_client']); ?> <?php echo htmlspecialchars($user['nom_client']); ?>!</h2>
    <p>Voici vos informations :</p>
    <p><strong>Adresse :</strong> <?php echo nl2br(htmlspecialchars($user['adresse_client'])); ?></p>
    <p><strong>Courriel :</strong> <?php echo htmlspecialchars($user['courriel_client']); ?></p>
    <p><strong>Carte étudiante :</strong> <?php echo htmlspecialchars($user['carte_etudiante_client']); ?></p>

    <h3>Historique des consultations :</h3>
    
    <!-- bouton pour annuler le RDV -->
    <p><button onclick="annulerRDV()">Annuler ce RDV</button></p>

    <h3>Services</h3>
    <p>Formule par mois : Payer 59.99 euros/mois pour avoir des rendez-vous illimités.</p>
    <a href="payement.php"class="button-link">Je fonce !</a>

    <p>Formule découverte : Payer 12.99 euros/mois pour avoir 5 rendez-vous en 2 semaines.</p>
    <a href="payement.php" class="button-link">Je fonce vers la découverte!</a>
    
    <a href="logout.php">Se déconnecter</a>
</div>



</body>
</html>
