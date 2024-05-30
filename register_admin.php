<?php
include("config.php");

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['nom_admin']) && isset($_POST['prenom_admin']) && isset($_POST['courriel_admin']) && isset($_POST['mdp_admin'])) {
        $nom_admin = $_POST['nom_admin'];
        $prenom_admin = $_POST['prenom_admin'];
        $courriel_admin = $_POST['courriel_admin'];
        $mdp_admin = password_hash($_POST['mdp_admin'], PASSWORD_DEFAULT);

        $sql = "INSERT INTO administrateurs (nom_admin, prenom_admin, courriel_admin, mdp_admin) VALUES (:nom_admin, :prenom_admin, :courriel_admin, :mdp_admin)";
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([
            'nom_admin' => $nom_admin,
            'prenom_admin' => $prenom_admin,
            'courriel_admin' => $courriel_admin,
            'mdp_admin' => $mdp_admin
        ]);

        if ($result) {
            $message = 'Inscription réussie!';
            header('Location: login.php');
            exit;
        } else {
            $message = 'Erreur lors de l\'inscription.';
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
    <title>Inscription Administrateur</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .login-container {
            max-width: 400px;
            margin: 100px auto;
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
    <h2>Inscription Administrateur</h2>

    <?php if (!empty($message)): ?>
        <p style="color:red"><?= $message ?></p>
    <?php endif; ?>

    <form action="register_admin.php" method="post">
        <div>
            <label for="nom_admin">Nom:</label>
            <input type="text" id="nom_admin" name="nom_admin" required>
        </div>
        <div>
            <label for="prenom_admin">Prénom:</label>
            <input type="text" id="prenom_admin" name="prenom_admin" required>
        </div>
        <div>
            <label for="courriel_admin">Adresse e-mail:</label>
            <input type="text" id="courriel_admin" name="courriel_admin" required>
        </div>
        <div>
            <label for="mdp_admin">Mot de passe:</label>
            <input type="password" id="mdp_admin" name="mdp_admin" required>
        </div>
        <div>
            <input type="submit" value="S'inscrire">
        </div>
    </form>
</div>

</body>
</html>
