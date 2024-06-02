<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sportify";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("La connexion a échoué: " . $conn->connect_error);
}

// Requête SQL pour récupérer les disponibilités du coach "alexiane"
$sql = "SELECT * FROM coachs WHERE prenom_coach = 'vida'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Récupérer les données du coach "alexiane"
    $row = $result->fetch_assoc();
    $coach_id = $row["id_coach"];
    $nom_coach = $row["nom_coach"];
    $prenom_coach = $row["prenom_coach"];
    $specialite_coach = $row["specialite_coach"];
    $disponibilites = explode(", ", $row["disponibilite_coach"]);
} else {
    echo "Aucun coach trouvé";
    exit;
}

$conn->close();

// Créer un tableau des disponibilités par jour et heure
$planning = [];
foreach ($disponibilites as $disponibilite) {
    preg_match('/([a-z]+)([0-9]+)/i', $disponibilite, $matches);
    $jour = strtolower($matches[1]);
    $heure = intval($matches[2]);
    $planning[$jour][$heure] = true;
}

// Définir les jours de la semaine et les heures
$jours = ["lundi", "mardi", "mercredi", "jeudi", "vendredi", "samedi", "dimanche"];
$heures = range(9, 20);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Planning de <?= $prenom_coach ?> <?= $nom_coach ?></title>
    <style>
        table {
            width: 70%;
            border-collapse: collapse;
            margin: 10px auto -70px auto; /* Ajustement pour le centrage */
            margin-top: 150px;
        }
        th, td {
            border: 1px solid #ddd;
            text-align: center;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
        .disponible {
            background-color: white;
        }
        .indisponible {
            background-color: #ccc;
        }
        .selected {
            background-color: #6FBBFF;
            color: white;
        }
        .text {
            font-weight: bold;
            color: black;
            text-align: center;
            margin: 10px auto -70px auto; /* Ajustement pour le centrage */
            font-size: 40px; /* Ajustez cette valeur selon vos besoins */
        }
        .text2 {
            font-weight: bold;
            color: black;
            text-align: center;
            margin: 10px auto -70px auto; /* Ajustement pour le centrage */
            font-size: 20px; /* Ajustez cette valeur selon vos besoins */
            margin-top: 70px;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            document.querySelectorAll('.disponible').forEach(cell => {
                cell.addEventListener('click', () => {
                    cell.classList.toggle('selected');

                    // Récupérer la date actuelle
                    let today = new Date();
                    let year = today.getFullYear();
                    let month = String(today.getMonth() + 1).padStart(2, '0');
                    let day = String(today.getDate()).padStart(2, '0');

                    // Construire la date et l'heure du créneau cliqué
                    let dateHeure = `${year}-${month}-${day} ${cell.getAttribute('data-heure')}:00:00`;
                    let coachId = <?= $coach_id ?>;
                    let action = cell.classList.contains('selected') ? 'enregistrer' : 'supprimer';

                    // Envoi de la requête AJAX
                    let xhr = new XMLHttpRequest();
                    xhr.open("POST", "enregistrer_rendezvous.php", true);
                    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState == 4 && xhr.status == 200) {
                            console.log(xhr.responseText);
                        }
                    };
                    xhr.send("coach_id=" + coachId + "&date_heure=" + dateHeure + "&action=" + action);
                });
            });
        });
    </script>
</head>
<body>
    <p class="text">Planning de <?= $prenom_coach ?> <?= $nom_coach ?></p><br>

    <p class="text2">Spécialité: <?= $specialite_coach ?></p>
    

    <table>
        <thead>
            <tr>
                <th>Heures</th>
                <?php foreach ($jours as $jour): ?>
                    <th><?= ucfirst($jour) ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($heures as $heure): ?>
                <tr>
                    <td><?= $heure ?>:00 - <?= $heure + 2 ?>:00</td>
                    <?php foreach ($jours as $jour): ?>
                        <td class="<?= isset($planning[$jour][$heure]) ? 'disponible' : 'indisponible' ?>" data-heure="<?= $heure ?>"></td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
