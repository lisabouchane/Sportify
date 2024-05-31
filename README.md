Pour base de données (connexion Client/Admin/Coach) : 
( ma base de donnée s'appelle Sportify)

** ce que vous devez mettre dans votre sql : **

*****************************************************

clients : CREATE TABLE clients (
    id_client INT(11) NOT NULL AUTO_INCREMENT,
    nom_client VARCHAR(255) COLLATE latin1_swedish_ci NULL,
    prenom_client VARCHAR(255) COLLATE latin1_swedish_ci NULL,
    adresse_client TEXT COLLATE latin1_swedish_ci NULL,
    ville_client VARCHAR(255) COLLATE latin1_swedish_ci NULL,
    code_postal_client VARCHAR(20) COLLATE latin1_swedish_ci NULL,
    pays_client VARCHAR(100) COLLATE latin1_swedish_ci NULL,
    telephone_client VARCHAR(20) COLLATE latin1_swedish_ci NULL,
    courriel_client VARCHAR(255) COLLATE latin1_swedish_ci NULL,
    mdp_client VARCHAR(255) COLLATE latin1_swedish_ci NULL,
    carte_etudiante_client VARCHAR(255) COLLATE latin1_swedish_ci NULL,
    PRIMARY KEY (id_client)
);

*****************************************************

coachs : CREATE TABLE coachs (
    id_coach INT(11) NOT NULL AUTO_INCREMENT,
    nom_coach VARCHAR(255) COLLATE latin1_swedish_ci NULL,
    prenom_coach VARCHAR(255) COLLATE latin1_swedish_ci NULL,
    photos_coach VARCHAR(255) COLLATE latin1_swedish_ci NULL,
    specialite_coach VARCHAR(255) COLLATE latin1_swedish_ci NULL,
    cv_coach TEXT COLLATE latin1_swedish_ci NULL,
    disponibilite_coach TEXT COLLATE latin1_swedish_ci NULL,
    courriel_coach VARCHAR(255) COLLATE latin1_swedish_ci NULL,
    mdp_coach VARCHAR(255) COLLATE latin1_swedish_ci NULL,
    PRIMARY KEY (id_coach)
);


*****************************************************

admin : CREATE TABLE administrateurs (
    id_admin INT(11) NOT NULL AUTO_INCREMENT,
    nom_admin VARCHAR(255) COLLATE latin1_swedish_ci NULL,
    prenom_admin VARCHAR(255) COLLATE latin1_swedish_ci NULL,
    courriel_admin VARCHAR(255) COLLATE latin1_swedish_ci NULL,
    mdp_admin VARCHAR(255) COLLATE latin1_swedish_ci NULL,
    PRIMARY KEY (id_admin)
);

*****************************************************

-- Structure de la table `paiement`
--

CREATE TABLE IF NOT EXISTS `paiement` (
  `id_paiement` int(11) NOT NULL AUTO_INCREMENT,
  `id_client` int(11) NOT NULL,
  `type_carte` varchar(50) NOT NULL,
  `numero_carte` varchar(20) NOT NULL,
  `nom_carte` varchar(255) NOT NULL,
  `date_expiration` text NOT NULL,
  `cvv` int(4) NOT NULL,
  PRIMARY KEY (`id_paiement`),
  UNIQUE KEY `id_client` (`id_client`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

*****************************************************

rendez_vous : CREATE TABLE rendez_vous (
    id INT(11) NOT NULL AUTO_INCREMENT,
    client_id INT(11) NULL,
    coach_id INT(11) NULL,
    date_heure DATETIME NULL,
    status VARCHAR(50) COLLATE latin1_swedish_ci NULL,
    PRIMARY KEY (id),
    INDEX (client_id),
    INDEX (coach_id),
    INDEX (date_heure),
    INDEX (status)
);

*****************************************************

