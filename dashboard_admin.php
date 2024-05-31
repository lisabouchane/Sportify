<?php
session_start();

//vérifications
//connexion : admin
if (!isset($_SESSION['admin_id'])) {
    header('Location: login_admin.php');
    exit;
}

//inclure config
include('config.php');

// récupérations informations
$admin_id = $_SESSION['admin_id'];
$sql = "SELECT nom_admin, prenom_admin, courriel_admin FROM administrateurs WHERE id_admin = :id_admin";
$stmt = $pdo->prepare($sql);
$stmt->execute(['id_admin' => $admin_id]);
$admin = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$admin) {
    echo "Aucun administrateur trouvé.";
    exit;
}

//liste coachs
$stmt_coachs = $pdo->query("SELECT * FROM coachs");
$coachs = $stmt_coachs->fetchAll(PDO::FETCH_ASSOC);
?>


<!--HTML-->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compte administrateur</title>
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
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

<div class="dashboard-container">
    <h2>Bienvenue sur le tableau de bord, <?php echo htmlspecialchars($admin['prenom_admin']); ?> <?php echo htmlspecialchars($admin['nom_admin']); ?>!</h2>
    <p>Voici vos informations :</p>
    <p><strong>Courriel :</strong> <?php echo htmlspecialchars($admin['courriel_admin']); ?></p>

    <h3>Rajouter un Coach</h3>
    <!-- rediriger vers register_coach.php -->
    <a href="register_coach.php">Ajouter un nouveau coach</a>

    <h3>Gérer les Coachs</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Spécialité</th>
                
                <th>Disponibilité</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($coachs as $coach): ?>
                <tr>
                    <td><?= htmlspecialchars($coach['id_coach']) ?></td>
                    <td><?= htmlspecialchars($coach['nom_coach']) ?></td>
                    <td><?= htmlspecialchars($coach['prenom_coach']) ?></td>
                    <td><?= htmlspecialchars($coach['specialite_coach']) ?></td>
                    
                    <td><?= htmlspecialchars($coach['disponibilite_coach']) ?></td>
                    <td>
                        <a href="delete_coach.php?id_coach=<?= $coach['id_coach'] ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce coach ?');">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <a href="logout.php">Se déconnecter</a>
</div>

</body>
</html>
