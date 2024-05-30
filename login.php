<?php

include("config.php");

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Clients
    if (isset($_POST['courriel_client']) && isset($_POST['mdp_client'])) {
        $courriel_client = $_POST['courriel_client'];
        $mdp_client = $_POST['mdp_client'];

        $sql = "SELECT * FROM clients WHERE courriel_client = :courriel_client";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['courriel_client' => $courriel_client]);
        $user = $stmt->fetch();

        if ($user) {
            if (password_verify($mdp_client, $user['mdp_client'])) {
                session_start();
                $_SESSION['user_id'] = $user['id_client'];
                header('Location: dashboard_client.php');
                exit;
            } else {
                $message = 'Mauvais identifiants.';
            }
        } else {
            // Redirection vers la page d'inscription si l'utilisateur n'est pas trouvé
            header('Location: register_client.php');
            exit;
        }
    }
    // Admins
    elseif (isset($_POST['courriel_admin']) && isset($_POST['mdp_admin'])) {
        $courriel_admin = $_POST['courriel_admin'];
        $mdp_admin = $_POST['mdp_admin'];

        $sql = "SELECT * FROM administrateurs WHERE courriel_admin = :courriel_admin";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['courriel_admin' => $courriel_admin]);
        $admin = $stmt->fetch();

        if ($admin && password_verify($mdp_admin, $admin['mdp_admin'])) {
            session_start();
            $_SESSION['admin_id'] = $admin['id_admin'];
            header('Location: dashboard_admin.php');
            exit;
        } else {
            $message = 'Mauvais identifiants.';
        }
    }
    // Coachs
    elseif (isset($_POST['courriel_coach']) && isset($_POST['mdp_coach'])) {
        $courriel_coach = $_POST['courriel_coach'];
        $mdp_coach = $_POST['mdp_coach'];

        $sql = "SELECT * FROM coachs WHERE courriel_coach = :courriel_coach";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['courriel_coach' => $courriel_coach]);
        $coach = $stmt->fetch();

        if ($coach && password_verify($mdp_coach, $coach['mdp_coach'])) {
            session_start();
            $_SESSION['coach_id'] = $coach['id_coach'];
            header('Location: dashboard_coach.php');
            exit;
        } else {
            $message = 'Mauvais identifiants.';
        }
    } else {
        $message = 'Veuillez remplir tous les champs.';
    }
}
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
                <label for="courriel_client">Email:</label>
                <input type="text" id="courriel_client" name="courriel_client" required>
            </div>

            <div>
                <label for="mdp_client">Mot de passe:</label>
                <input type="password" id="mdp_client" name="mdp_client" required>
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
                <label for="courriel_admin">Adresse e-mail:</label>
                <input type="text" id="courriel_admin" name="courriel_admin" required>
            </div>

            <div>
                <label for="mdp_admin">Mot de passe:</label>
                <input type="password" id="mdp_admin" name="mdp_admin" required>
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
                <label for="courriel_coach">Adresse e-mail:</label>
                <input type="text" id="courriel_coach" name="courriel_coach" required>
            </div>
            <div>
                <label for="mdp_coach">Mot de passe:</label>
                <input type="password" id="mdp_coach" name="mdp_coach" required>
            </div>
            <div>
                <input type="submit" value="Se connecter">
            </div>
        </form>
    </div>
</body>
</html>
