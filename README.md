Pour base de données (connexion Client/Admin/Coach) : 
( ma base de donnée s'appelle Sportify)

** ce que vous devez mettre dans votre sql : **

rr

CREATE TABLE IF NOT EXISTS `clients` (
  `id_client` int(11) NOT NULL AUTO_INCREMENT,
  `nom_client` varchar(255) DEFAULT NULL,
  `prenom_client` varchar(255) DEFAULT NULL,
  `adresse_client` text,
  `ville_client` varchar(255) DEFAULT NULL,
  `code_postal_client` varchar(20) DEFAULT NULL,
  `pays_client` varchar(100) DEFAULT NULL,
  `telephone_client` varchar(20) DEFAULT NULL,
  `courriel_client` varchar(255) DEFAULT NULL,
  `mdp_client` varchar(255) DEFAULT NULL,
  `carte_etudiante_client` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_client`),
  UNIQUE KEY `courriel` (`courriel_client`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;




CREATE TABLE IF NOT EXISTS `coachs` (
  `id_coach` int(11) NOT NULL AUTO_INCREMENT,
  `nom_coach` varchar(255) DEFAULT NULL,
  `prenom_coach` varchar(255) DEFAULT NULL,
  `photo_coach` varchar(255) DEFAULT NULL,
  `specialite_coach` varchar(255) DEFAULT NULL,
  `cv_coach` text,
  `disponibilite_coach` text,
  `courriel_coach` varchar(255) DEFAULT NULL,
  `mdp_coach` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_coach`),
  UNIQUE KEY `courriel` (`courriel_coach`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;




CREATE TABLE IF NOT EXISTS `administrateurs` (
  `id_admin` int(11) NOT NULL AUTO_INCREMENT,
  `nom_admin` varchar(255) DEFAULT NULL,
  `prenom_admin` varchar(255) DEFAULT NULL,
  `courriel_admin` varchar(255) DEFAULT NULL,
  `mdp_admin` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_admin`),
  UNIQUE KEY `courriel` (`courriel_admin`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;



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




ALTER TABLE `paiement`
  ADD CONSTRAINT `paiement_ibfk_1` FOREIGN KEY (`id_client`) REFERENCES `clients` (`id_client`) ON DELETE CASCADE;



CREATE TABLE IF NOT EXISTS `rendez_vous` (
  `id_r` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) DEFAULT NULL,
  `coach_id` int(11) DEFAULT NULL,
  `date_heure` datetime DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_r`),
  KEY `client_id` (`client_id`),
  KEY `coach_id` (`coach_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;



ALTER TABLE `rendez_vous`
  ADD CONSTRAINT `rendez_vous_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id_client`),
  ADD CONSTRAINT `rendez_vous_ibfk_2` FOREIGN KEY (`coach_id`) REFERENCES `coachs` (`id_coach`);



