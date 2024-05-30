<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Inclure le fichier de configuration pour la connexion à la base de données
include('config.php');

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Informations de l'utilisateur
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $adresse_ligne1 = $_POST['adresse_ligne1'];
    $adresse_ligne2 = $_POST['adresse_ligne2'];
    $ville = $_POST['ville'];
    $code_postal = $_POST['code_postal'];
    $pays = $_POST['pays'];
    $telephone = $_POST['telephone'];
    $carte_etudiant = $_POST['carte_etudiant'];

    // Informations de paiement
    $card_type = $_POST['card_type'];
    $card_number = $_POST['card_number'];
    $card_name = $_POST['card_name'];
    $expiry_date = $_POST['expiry_date'];
    $cvv = $_POST['cvv'];

    if (!empty($nom) && !empty($prenom) && !empty($adresse_ligne1) && !empty($ville) && !empty($code_postal) && !empty($pays) && !empty($telephone) && !empty($carte_etudiant) && !empty($card_type) && !empty($card_number) && !empty($card_name) && !empty($expiry_date) && !empty($cvv)) {
        // Simuler la validation de paiement
        // Dans un vrai scénario, vous devez intégrer une API de paiement pour traiter le paiement
        $user_id = $_SESSION['user_id'];
        
        // Mettre à jour les informations de l'utilisateur
        $adresse = "$adresse_ligne1\n$adresse_ligne2";
        $sql = "UPDATE clients SET 
            nom_client = :nom,
            prenom_client = :prenom,
            adresse_client = :adresse,
            ville_client = :ville,
            code_postal_client = :code_postal,
            pays_client = :pays,
            telephone_client = :telephone,
            carte_etudiante_client = :carte_etudiant 
            WHERE id_client = :id_client";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'nom' => $nom,
            'prenom' => $prenom,
            'adresse' => $adresse,
            'ville' => $ville,
            'code_postal' => $code_postal,
            'pays' => $pays,
            'telephone' => $telephone,
            'carte_etudiant' => $carte_etudiant,
            'id_client' => $user_id
        ]);

        // Insérer les informations de paiement dans la table paiement
        $sql = "INSERT INTO paiement (id_client, type_carte, numero_carte, nom_carte, date_expiration, cvv) VALUES (:id_client, :card_type, :card_number, :card_name, :expiry_date, :cvv)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'id_client' => $user_id,
            'card_type' => $card_type,
            'card_number' => $card_number,
            'card_name' => $card_name,
            'expiry_date' => $expiry_date,
            'cvv' => $cvv
        ]);

        header('Location: confirmation_paiement.php');
        exit;
    } else {
        $message = 'Veuillez remplir tous les champs.';
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paiement</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .payment-container {
            max-width: 400px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px 30px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h2 {
            color: #333;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
        }

        input[type="text"],
        input[type="password"],
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        input[type="submit"] {
            background-color: #007BFF;
            color: #fff;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        p {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="payment-container">
    <h2>Paiement</h2>

    <?php if (!empty($message)): ?>
        <p><?= $message ?></p>
    <?php endif; ?>

    <form action="payement.php" method="post">
        <h3>Informations personnelles</h3>
        <div>
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" required>
        </div>
        <div>
            <label for="prenom">Prénom :</label>
            <input type="text" id="prenom" name="prenom" required>
        </div>
        <div>
            <label for="adresse_ligne1">Adresse Ligne 1 :</label>
            <input type="text" id="adresse_ligne1" name="adresse_ligne1" required>
        </div>
        <div>
            <label for="adresse_ligne2">Adresse Ligne 2 :</label>
            <input type="text" id="adresse_ligne2" name="adresse_ligne2">
        </div>
        <div>
            <label for="ville">Ville :</label>
            <input type="text" id="ville" name="ville" required>
        </div>
        <div>
            <label for="code_postal">Code Postal :</label>
            <input type="text" id="code_postal" name="code_postal" required>
        </div>
        <div>
            <label for="pays">Pays :</label>
            <input type="text" id="pays" name="pays" required>
        </div>
        <div>
            <label for="telephone">Numéro de téléphone :</label>
            <input type="text" id="telephone" name="telephone" required>
        </div>
        <div>
            <label for="carte_etudiant">Numéro de carte étudiant :</label>
            <input type="text" id="carte_etudiant" name="carte_etudiant" required>
        </div>

        <h3>Informations de paiement</h3>
        <div>
            <label for="card_type">Type de carte :</label>
            <input type="text" id="card_type" name="card_type" required>
        </div>
        <div>
            <label for="card_number">Numéro de carte :</label>
            <input type="text" id="card_number" name="card_number" required>
        </div>
        <div>
            <label for="card_name">Nom sur la carte :</label>
            <input type="text" id="card_name" name="card_name" required>
        </div>
        <div>
            <label for="expiry_date">Date d'expiration (mois/année) :</label>
            <input type="text" id="expiry_date" name="expiry_date" required>
        </div>
        <div>
            <label for="cvv">CVV :</label>
            <input type="password" id="cvv" name="cvv" required>
        </div>

        <input type="submit" value="Payer">
    </form>
</div>

</body>
</html>
