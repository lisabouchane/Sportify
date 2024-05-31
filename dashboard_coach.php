<?php
session_start();

//verifications
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

include('config.php');

//information
$user_id = $_SESSION['user_id'];
$sql = "SELECT nom_coach, prenom_coach, courriel_coach FROM coachs WHERE id_coach = :id_coach";
$stmt = $pdo->prepare($sql);
$stmt->execute(['id_coach' => $user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "Aucun coach trouvé.";
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
        a {
            color: #007BFF;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        .chatroom-link {
        display: inline-block;
        padding: 10px 20px;
        font-size: 16px;
        color: #fff;
        background-color: #007BFF;
        text-align: center;
        text-decoration: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s;
        }

        .chatroom-link:hover {
            background-color: #0056b3;
        }

    </style>
</head>
<body>

<div class="dashboard-container">
    <h2>Bienvenue sur votre tableau de bord, <?php echo htmlspecialchars($user['prenom_coach']); ?> <?php echo htmlspecialchars($user['nom_coach']); ?>!</h2>
    <p>Voici vos informations :</p>
    <p><strong>Courriel :</strong> <?php echo htmlspecialchars($user['courriel_coach']); ?></p>

     <!-- Affichage des consultations courantes ou à venir -->
    <h3>Consultations à venir :</h3>


     <!-- Lien vers la chatroom -->
    <a href="chatroom.php" class="chatroom-link">Accéder à la chatroom</a>

    

    <p><a href="logout.php">Se déconnecter</a></p>
</div>

</body>
</html>
