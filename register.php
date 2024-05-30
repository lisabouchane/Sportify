<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choix du type d'utilisateur</title>
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

        select {
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
    <h2>Choisissez votre type d'utilisateur</h2>

    <form action="register.php" method="post">
        <div>
            <label for="user_type">Type d'utilisateur:</label>
            <select id="user_type" name="user_type" required>
                <option value="client">Client</option>
                <option value="admin">Administrateur</option>
            </select>
        </div>

        <div>
            <input type="submit" value="Continuer">
        </div>
    </form>
</div>

<?php
if (isset($_POST['user_type'])) {
    $user_type = $_POST['user_type'];

    switch ($user_type) {
        case 'client':
            header('Location: register_client.php');
            break;
        case 'admin':
            header('Location: register_admin.php');
            break;
        case 'coach':
            header('Location: register_coach.php');
            break;
        default:
            echo "<p>Type d'utilisateur non valide.</p>";
            exit;
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    echo "<p>Aucun type d'utilisateur sélectionné.</p>";
}
?>

</body>
</html>
