<?php
session_start();


//site internet : https://www.xarala.co/blog/guide-complet-systeme-dauthentification-avec-php-et-mysql/

// Configuration de la base de données
$host = 'localhost';
$db = 'sportify';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database $db :" . $e->getMessage());
}

?>
