<?php
include("config.php");

$message = '';
$recherche = '';
$resultat = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['recherche'])) {
        $recherche = $_POST['recherche'];
        $paramRecherche = '%' . $recherche . '%';

        // Définition des noms de coachs et leur section correspondante
        $redirections = [
            'lisa' => 'activité_sportive.html#biking',
            'biking' => 'activité_sportive.html#biking',
            'B212' => 'activité_sportive.html#biking',
            'axel' => 'activité_sportive.html#fitness',
             'B202' => 'activité_sportive.html#fitness',
            'fitness' => 'activité_sportive.html#fitness',
            'vida' => 'activité_sportive.html#musculation',
            'musculation' => 'activité_sportive.html#musculation',
            'melinda' => 'activité_sportive.html#cardio-training',
            'cardio training' => 'activité_sportive.html#cardio-training',
            'B213' => 'activité_sportive.html#cardio-training',
            'alex' => 'activité_sportive.html#cours-collectifs',
            'B214' => 'activité_sportive.html#cours-collectifs',
            'cours collectifs' => 'activité_sportive.html#cours-collectifs',
            'melissa' => 'sports_competition.html#Basket',
            'B301' => 'sports_competition.html#Basket',
            'basket' => 'sports_competition.html#Basket',
            'zinedine' => 'sports_competition.html#Football',
            'B302' => 'sports_competition.html#Football',
            'football' => 'sports_competition.html#Football',
            'bruno' => 'sports_competition.html#Rugby',
            'B303' => 'sports_competition.html#Rugby',
            'rugby' => 'sports_competition.html#Rugby',
            'david' => 'sports_competition.html#Tennis',
            'B304' => 'sports_competition.html#Tennis',
            'laure' => 'sports_competition.html#Natation',
            'maxime' => 'sports_competition.html#Plongeon',
            'tennis' => 'sports_competition.html#Tennis',
            'natation' => 'sports_competition.html#Natation',
            'B305' => 'sports_competition.html#Natation',
            'plongeon' => 'sports_competition.html#Plongeon',
            'B306' => 'sports_competition.html#Plongeon',
            'B201' => 'activité_sportive.html#musculation',

        ];

        $rechercheLower = strtolower($recherche); // Convertir la recherche en minuscule

        foreach ($redirections as $key => $url) {
            if ($rechercheLower === $key) {
                header("Location: $url");
                exit;
            }
        }

        // Si aucun coach correspondant n'est trouvé, continuez la recherche dans la base de données
        $sql = "SELECT * FROM coach WHERE nom_coach LIKE :recherche OR prenom_coach LIKE :recherche OR specialite_coach LIKE :recherche";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['recherche' => $paramRecherche]);
        $resultat = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($resultat)) {
            $message = "Aucun résultat trouvé pour '$recherche'.";
        }
    } else {
        $message = 'Veuillez entrer un terme de recherche.';
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Recherche des Coachs</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f4f4f4;
            font-family: Arial, sans-serif;
        }
        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
        }
        input[type="text"] {
            width: 40%;
            padding: 10px;
            margin-bottom: 10px;
            font-size: 16px;
            border: 2px solid orange;
            border-radius: 5px;
        }
        button {
            padding: 10px 20px;
            background-color: orange;
            border: none;
            color: white;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
        }
        button:hover {
            background-color: darkorange;
        }
        #suggestions {
            border: 1px solid #ccc;
            display: none;
            position: absolute;
            background: #fff;
            z-index: 1000;
        }
        #suggestions li {
            padding: 8px;
            cursor: pointer;
        }
        #suggestions li:hover {
            background: #f0f0f0;
        }
    </style>
</head>
<body>

<form method="post" action="">
    <input type="text" name="recherche" id="recherche" placeholder="Nom, Prénom ou Spécialité" autocomplete="off" value="<?php echo htmlspecialchars($recherche); ?>">
    <button type="submit">Rechercher</button>
</form>
<ul id="suggestions"></ul>

<?php
if ($message) {
    echo "<p>$message</p>";
}

if (!empty($resultat)) {
    echo "<ul>";
    foreach ($resultat as $ligne) {
        echo "<li>" . htmlspecialchars($ligne['nom_coach']) . " " . htmlspecialchars($ligne['prenom_coach']) . " - " . htmlspecialchars($ligne['specialite_coach']) . "</li>";
    }
    echo "</ul>";
}
?>

</body>
</html>
