<?php
session_start();

// verifications
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}


include('config.php');

//récupérer les informations de l'utilisateur
$user_id = $_SESSION['user_id'];
$sql = "SELECT nom_client, prenom_client FROM clients WHERE id_client = :id_client";
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
    <title>Confirmation de Paiement</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .confirmation-container {
            max-width: 400px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px 30px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            text-align: center;
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
    </style>
</head>
<body>

<div class="confirmation-container">
    <h2>Merci pour votre paiement, <?php echo htmlspecialchars($user['prenom_client']); ?> <?php echo htmlspecialchars($user['nom_client']); ?>!</h2>
    <p>Votre paiement a été traité avec succès.</p>
    <p>Vous pouvez maintenant accéder à votre tableau de bord ou retourner à l'accueil.</p>
    <a href="dashboard_client.php">Retour au tableau de bord</a><br>
    <a href="index.html">Retour à l'accueil</a>
</div>

</body>
</html>
