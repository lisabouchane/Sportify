<?php
// Démarrage de la session
session_start();

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

// Fonctions utilitaires
function registerUser($name, $email, $password, $role) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->execute([$name, $email, password_hash($password, PASSWORD_BCRYPT), $role]);
}

function loginUser($email, $password) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_role'] = $user['role'];
        return true;
    }
    return false;
}

function logoutUser() {
    session_destroy();
}

function getCurrentUser() {
    if (isset($_SESSION['user_id'])) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        return $stmt->fetch();
    }
    return null;
}

function getCoaches() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM coaches JOIN users ON coaches.user_id = users.id");
    return $stmt->fetchAll();
}

function addCoach($userId, $specialty, $bio) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO coaches (user_id, specialty, bio) VALUES (?, ?, ?)");
    $stmt->execute([$userId, $specialty, $bio]);
}

function scheduleAppointment($clientId, $coachId, $time) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO appointments (client_id, coach_id, appointment_time) VALUES (?, ?, ?)");
    $stmt->execute([$clientId, $coachId, $time]);
}

function cancelAppointment($appointmentId) {
    global $pdo;
    $stmt = $pdo->prepare("UPDATE appointments SET status = 'cancelled' WHERE id = ?");
    $stmt->execute([$appointmentId]);
}

function getAppointmentsByUser($userId) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM appointments WHERE client_id = ? OR coach_id = ?");
    $stmt->execute([$userId, $userId]);
    return $stmt->fetchAll();
}

// Gestion des actions via URL
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

// Page d'accueil
if ($action == 'index') {
    $user = getCurrentUser();
    if ($user) {
        header("Location: ?action=dashboard");
        exit();
    }
    echo "<h1>Bienvenue sur votre compte Sportify</h1>";
    echo '<a href="?action=login">Se connecter</a> | <a href="?action=register">S\'inscrire</a>';
}

// Formulaire de connexion
if ($action == 'login') {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (loginUser($_POST['email'], $_POST['password'])) {
            header("Location: ?action=dashboard");
            exit();
        } else {
            echo "<p>Email ou mot de passe incorrect</p>";
        }
    }
    echo '<h1>Connexion</h1>';
    echo '<form method="post">';
    echo '<input type="email" name="email" placeholder="Email" required>';
    echo '<input type="password" name="password" placeholder="Mot de passe" required>';
    echo '<button type="submit">Se connecter</button>';
    echo '</form>';
}

// Formulaire d'inscription
if ($action == 'register') {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        registerUser($_POST['name'], $_POST['email'], $_POST['password'], $_POST['role']);
        header("Location: ?action=login");
        exit();
    }
    echo '<h1>Inscription</h1>';
    echo '<form method="post">';
    echo '<input type="text" name="name" placeholder="Nom" required>';
    echo '<input type="email" name="email" placeholder="Email" required>';
    echo '<input type="password" name="password" placeholder="Mot de passe" required>';
    echo '<select name="role" required>';
    echo '<option value="client">Client</option>';
    echo '<option value="coach">Coach</option>';
    echo '<option value="admin">Administrateur</option>';
    echo '</select>';
    echo '<button type="submit">S\'inscrire</button>';
    echo '</form>';
}

// Déconnexion
if ($action == 'logout') {
    logoutUser();
    header("Location: ?action=index");
    exit();
}

// Tableau de bord
if ($action == 'dashboard') {
    $user = getCurrentUser();
    if (!$user) {
        header("Location: ?action=login");
        exit();
    }
    echo '<h1>Bienvenue, ' . htmlspecialchars($user['name']) . '!</h1>';
    echo '<a href="?action=logout">Se déconnecter</a>';
    if ($user['role'] == 'admin') {
        echo '<h2>Administration</h2>';
        echo '<a href="?action=add_coach">Ajouter un coach</a>';
    } elseif ($user['role'] == 'coach') {
        echo '<h2>Coach</h2>';
        echo '<p>Vos rendez-vous :</p>';
        $appointments = getAppointmentsByUser($user['id']);
        foreach ($appointments as $appointment) {
            echo '<p>RDV avec le client ID ' . $appointment['client_id'] . ' le ' . $appointment['appointment_time'] . '</p>';
        }
    } else {
        echo '<h2>Client</h2>';
        echo '<p>Prendre un rendez-vous :</p>';
        echo '<form method="post" action="?action=schedule">';
        echo '<select name="coach_id" required>';
        $coaches = getCoaches();
        foreach ($coaches as $coach) {
            echo '<option value="' . $coach['id'] . '">' . $coach['name'] . ' (' . $coach['specialty'] . ')</option>';
        }
        echo '</select>';
        echo '<input type="datetime-local" name="appointment_time" required>';
        echo '<button type="submit">Prendre RDV</button>';
        echo '</form>';
        echo '<h3>Vos rendez-vous :</h3>';
        $appointments = getAppointmentsByUser($user['id']);
        foreach ($appointments as $appointment) {
            echo '<p>RDV avec le coach ID ' . $appointment['coach_id'] . ' le ' . $appointment['appointment_time'] . '</p>';
            if ($appointment['status'] == 'scheduled') {
                echo '<form method="post" action="?action=cancel"><input type="hidden" name="appointment_id" value="' . $appointment['id'] . '"><button type="submit">Annuler</button></form>';
            }
        }
    }
}

// Ajouter un coach (Admin seulement)
if ($action == 'add_coach') {
    $user = getCurrentUser();
    if (!$user || $user['role'] != 'admin') {
        header("Location: ?action=login");
        exit();
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        addCoach($_POST['user_id'], $_POST['specialty'], $_POST['bio']);
        header("Location: ?action=dashboard");
        exit();
    }
    echo '<h1>Ajouter un coach</h1>';
    echo '<form method="post">';
    echo '<input type="number" name="user_id" placeholder="ID de l\'utilisateur" required>';
    echo '<input type="text" name="specialty" placeholder="Spécialité" required>';
    echo '<textarea name="bio" placeholder="Biographie"></textarea>';
    echo '<button type="submit">Ajouter</button>';
    echo '</form>';
}

// Prendre un rendez-vous (Client seulement)
if ($action == 'schedule') {
    $user = getCurrentUser();
    if (!$user || $user['role'] != 'client') {
        header("Location: ?action=login");
        exit();
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        scheduleAppointment($user['id'], $_POST['coach_id'], $_POST['appointment_time']);
        header("Location: ?action=dashboard");
        exit();
    }
}

// Annuler un rendez-vous
if ($action == 'cancel') {
    $user = getCurrentUser();
    if (!$user || $user['role'] == 'admin') {
        header("Location: ?action=login");
        exit();
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        cancelAppointment($_POST['appointment_id']);
        header("Location: ?action=dashboard");
        exit();
    }
}
?>
