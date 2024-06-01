<?php
include("config.php");

$message = '';
$recherche = '';
$resultat = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['recherche'])) {
        $recherche = $_POST['recherche'];
        $paramRecherche = '%' . $recherche . '%';

        // Listes de prénoms pour redirection
        $activitéSportive = ['lisa', 'axel', 'melinda', 'vida', 'alex'];
        $sportsCompetition = ['melissa', 'zinedine', 'laure', 'bruno', 'david', 'maxime'];

        // Vérification pour redirection
        $rechercheLower = strtolower($recherche); // Convertir la recherche en minuscule pour la comparaison
        if (in_array($rechercheLower, $activitéSportive)) {
            header("Location: activité_sportive.html");
            exit;
        } elseif (in_array($rechercheLower, $sportsCompetition)) {
            header("Location: sports_competition.html");
            exit;
        }

        $sql = "SELECT * FROM coach WHERE nom_coach LIKE :recherche OR prenom_coach LIKE :recherche OR specialite_coach LIKE :recherche";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['recherche' => $paramRecherche]);
        $resultat = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($resultat)) {
            $message = "Aucun résultat trouvé";
        }
    } else {
        $message = 'Veuillez entrer un terme de recherche.';
    }
}

// Gestion des suggestions AJAX
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['query'])) {
    $query = $_GET['query'];
    $paramRecherche = '%' . $query . '%';

    $sql = "SELECT prenom_coach FROM coach WHERE prenom_coach LIKE :query LIMIT 10";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['query' => $paramRecherche]);
    $resultat = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($resultat);
    exit; // Terminer le script pour éviter de renvoyer le HTML en plus des données JSON
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Recherche des Coachs</title>
    <style>
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function() {
    $('#recherche').on('input', function() {
        var query = $(this).val();
        if (query.length > 0) {
            $.ajax({
                url: '',
                method: 'GET',
                data: {query: query},
                success: function(data) {
                    var suggestions = JSON.parse(data);
                    $('#suggestions').empty().show();
                    suggestions.forEach(function(suggestion) {
                        $('#suggestions').append('<li>' + suggestion.prenom_coach + '</li>');
                    });
                }
            });
        } else {
            $('#suggestions').hide();
        }
    });

    $(document).on('click', '#suggestions li', function() {
        $('#recherche').val($(this).text());
        $('#suggestions').hide();
    });
});
</script>

</body>
</html>
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