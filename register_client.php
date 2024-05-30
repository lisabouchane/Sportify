<?php
include("config.php");

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['email']) && isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['password']) && isset($_POST['adresse']) && isset($_POST['carte_etudiante'])) {
        $email = $_POST['email'];
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $adresse = $_POST['adresse'];
        $carte_etudiante = $_POST['carte_etudiante'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $sql = "INSERT INTO clients (courriel_client, nom_client, prenom_client, adresse_client, mdp_client, carte_etudiante_client) VALUES (:email, :nom, :prenom, :adresse, :password, :carte_etudiante)";
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([
            'email' => $email,
            'nom' => $nom,
            'prenom' => $prenom,
            'adresse' => $adresse,
            'password' => $password,
            'carte_etudiante' => $carte_etudiante
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
    <title>Inscription Client</title>
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
        input[type="password"],
        input[type="email"] {
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
    <h2>Inscription Client</h2>

    <?php if (!empty($message)): ?>
        <p style="color:red"><?= $message ?></p>
    <?php endif; ?>

    <form action="register_client.php" method="post">
        <div>
            <label for="email">Adresse e-mail:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div>
            <label for="nom">Nom:</label>
            <input type="text" id="nom" name="nom" required>
        </div>
        <div>
            <label for="prenom">Prénom:</label>
            <input type="text" id="prenom" name="prenom" required>
        </div>
        <div>
            <label for="adresse">Adresse:</label>
            <input type="text" id="adresse" name="adresse" required>
        </div>
        <div>
            <label for="carte_etudiante">Carte Étudiante:</label>
            <input type="text" id="carte_etudiante" name="carte_etudiante" required>
        </div>
        <div>
            <label for="password">Mot de passe:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div>
            <input type="submit" value="S'inscrire">
        </div>
    </form>
</div>

</body>
</html>
