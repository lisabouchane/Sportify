<?php

session_start();

//supprimer toutes les variables de session.
$_SESSION = array();

// si vous voulez détruire complètement la session, supprimez également le cookie de session.
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

//détruire la session.
session_destroy();

//rediriger vers la page de connexion.
header('Location: login.php');
exit;

?>
