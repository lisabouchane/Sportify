<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

include('config.php');

if (isset($_GET['id_coach'])) {
    $id_coach = $_GET['id_coach'];
    
    $stmt = $pdo->prepare("DELETE FROM coachs WHERE id_coach = :id_coach");
    $stmt->execute(['id_coach' => $id_coach]);
    
    header('Location: dashboard_admin.php');
    exit;
}
?>
