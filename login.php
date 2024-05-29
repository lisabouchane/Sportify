<?php

include("config.php");

$message = '';


//Clients 
if (isset($_POST['courriel_client']) && isset($_POST['mdp_client'])) {
    $courriel_client = $_POST['courriel_client'];
    $mdp_client = $_POST['mdp_client'];

    $sql = "SELECT * FROM clients WHERE courriel_client = :courriel_client";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['courriel_client' => $courriel_client]);
    $user = $stmt->fetch();

    if ($user && password_verify($mdp_client, $user['mdp_client'])) {
        session_start();
        $_SESSION['user_id'] = $user['id_client'];
        header('Location: dashboard_client.php');
        exit;
    } else {
        $message = 'Mauvais identifiants';
    }
}

//Admin

//Coach

?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .login-container {
            width: 250px;
            display: inline-block;
            vertical-align: top;
            margin: 20px;
            background-color: #fff;
            padding: 20px 30px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h2 {
            margin-top: 0;
            color: #333;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        input[type="submit"] {
            background-color: #007BFF;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        p {
            color: red;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h2>Client</h2>

        <?php if (!empty($message)): ?>
            <p style="color:red"><?= $message ?></p>
        <?php endif; ?>

        <form action="login.php" method="post">
            <div>
                <label for="nom_client">Nom:</label>
                <input type="text" id="nom_client" name="nom_client">
            </div>

            <div>
                <label for="prenom_client">Prénom:</label>
                <input type="text" id="prenom_client" name="prenom_client">
            </div>

            <div>
                <label for="courriel_client">Email:</label>
                <input type="text" id="courriel_client" name="courriel_client">
            </div>

            <div>
                <label for="mdp_client">Mot de passe:</label>
                <input type="text" id="mdp_client" name="mdp_client">
            </div>

            <div>
                <input type="submit" value="Se connecter">
            </div>
        </form>
    </div>
    <div class="login-container">
        <h2>Admin</h2>

        <?php if (!empty($message)): ?>
            <p style="color:red"><?= $message ?></p>
        <?php endif; ?>

        <form action="login.php" method="post">
            <div>
                <label for="admin-username">Nom d'utilisateur:</label>
                <input type="text" id="admin-username" name="username">
            </div>

            <div>
                <label for="admin-password">Mot de passe:</label>
                <input type="password" id="admin-password" name="password">
            </div>

            <div>
                <input type="submit" value="Se connecter">
            </div>
        </form>
    </div>
    <div class="login-container">
        <h2>Coach</h2>

        <?php if (!empty($message)): ?>
            <p style="color:red"><?= $message ?></p>
        <?php endif; ?>

        <form action="login.php" method="post">
            <div>
                <label for="coach-username">Nom d'utilisateur:</label>
                <input type="text" id="coach-username" name="username">
            </div>

            <div>
                <label for="coach-password">Mot de passe:</label>
                <input type="password" id="coach-password" name="password">
            </div>

            <div>
                <input type="submit" value="Se connecter">
            </div>
        </form>
    </div>
</body>
</html>
