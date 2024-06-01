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
$status = $_POST['status'];
$client_id = 9; // Client ID fixe

// Insérer les données dans la table rendez_vous
$sql = "INSERT INTO rendez_vous (client_id, coach_id, date_heure, status) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iiss", $client_id, $coach_id, $date_heure, $status);

if ($stmt->execute()) {
    echo "Rendez-vous enregistré avec succès";
} else {
    echo "Erreur: " . $sql . "<br>" . $conn->error;
}

$stmt->close();
$conn->close();
?>
