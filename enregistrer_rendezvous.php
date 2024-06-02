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

// Récupérer les données envoyées par l'AJAX
$coach_id = $_POST['coach_id'];
$date_heure = $_POST['date_heure'];
$action = $_POST['action'];
$client_id = 9; // Client ID fixe

if ($action == 'enregistrer') {
    // Insérer les données dans la table rendez_vous
    $sql = "INSERT INTO rendez_vous (client_id, coach_id, date_heure, status) VALUES (?, ?, ?, 'enregistré')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iis", $client_id, $coach_id, $date_heure);

    if ($stmt->execute()) {
        echo "Rendez-vous enregistré avec succès";
    } else {
        echo "Erreur: " . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
} elseif ($action == 'supprimer') {
    // Supprimer les données de la table rendez_vous
    $sql = "DELETE FROM rendez_vous WHERE client_id = ? AND coach_id = ? AND date_heure = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iis", $client_id, $coach_id, $date_heure);

    if ($stmt->execute()) {
        echo "Rendez-vous supprimé avec succès";
    } else {
        echo "Erreur: " . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>
