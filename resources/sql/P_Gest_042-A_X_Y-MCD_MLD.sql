-- Database Section

create database if not exists db_sport;
use db_sport;


create table if not exists t_activity (
     idActivity INT(11) not null AUTO_INCREMENT,
     actActivite varchar(60) not null,
     PRIMARY KEY (idActivity)
)  ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table if not exists t_athlete (
     idAthlete INT(11) not null AUTO_INCREMENT,
     athName varchar(50) not null,
     athSurname varchar(50) not null,
     athEmail varchar(254) not null,
     athPassword varchar(150) not null,
     athPhone varchar(10) not null,
     athStreet varchar(100) not null,
     athTown varchar(100) not null,
     athNPA int(6) not null,
     athIsAdministrator tinyint(1) not null DEFAULT 0,
     athIsAthlete tinyint(1) not null DEFAULT 1,
     PRIMARY KEY (idAthlete)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table if not exists t_coach (
     idCoach INT(11) not null AUTO_INCREMENT,
     coaName varchar(50) not null,
     coaSurname varchar(50) not null,
     coaEmail varchar(254) not null,
     coaPassword varchar(150) not null,
     coaPhone varchar(20) not null,
     coaExperience varchar(1000) not null,
     coaImage varchar(100) not null,     
     coaIsAdministrator tinyint(1) not null DEFAULT 0,
     coaIsCoach tinyint(1) not null DEFAULT 1,
     PRIMARY KEY (idCoach)
     )  ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table if not exists t_message (
     idMessage INT(11) not null AUTO_INCREMENT,
     mesMessage varchar(1000) not null,
     fkCoach INT(11) not null,
     fkAthlete INT(11) not null,
     PRIMARY KEY (idMessage),
     FOREIGN KEY (fkCoach) REFERENCES t_coach(idCoach),
     FOREIGN KEY (fkAthlete) REFERENCES t_athlete(idAthlete)
     )  ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table if not exists t_salle (
     idSalle INT(11) not null AUTO_INCREMENT,
     salStreet varchar(100) not null,
     salTown varchar(100) not null,
     salNPA int(6) not null,
     salTarif varchar(1000) not null,
     PRIMARY KEY (idSalle)
    )  ENGINE=InnoDB DEFAULT CHARSET=utf8;
    
create table if not exists t_have (
     fkCoach INT(11) not null,
     fkSalle INT(11) not null,
     FOREIGN KEY (fkCoach) REFERENCES t_coach(idCoach),
     FOREIGN KEY (fkSalle) REFERENCES t_salle(idSalle)
     )  ENGINE=InnoDB DEFAULT CHARSET=utf8;
    
create table if not exists t_do (
     fkActivity INT(11) not null,
     fkCoach INT(11) not null,
     FOREIGN KEY (fkActivity) REFERENCES t_activity(idActivity),
     FOREIGN KEY (fkCoach) REFERENCES t_coach(idCoach)
    )  ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table if not exists t_select (
     fkAthlete INT(11) not null,
     fkCoach INT(11) not null,
     validateCoach tinyINT(1) not null,
     FOREIGN KEY(fkAthlete) REFERENCES t_athlete(idAthlete),
     FOREIGN KEY(fkCoach) REFERENCES t_coach(idCoach)
     )  ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- creation de l'utilisateur
CREATE USER IF NOT EXISTS 'db_PGest042'@'localhost' IDENTIFIED BY 'AXY';
GRANT SELECT,INSERT,UPDATE,DELETE ON db_sport.* TO 'db_PGest042'@'localhost';

-- modification de la table des séléction pour mettre une valeur par défaut (a 0) a la collone si oui ou non le coache l'a valider (car par défaut c'est non)
ALTER TABLE `t_select` CHANGE `validateCoach` `validateCoach` TINYINT(1) NOT NULL DEFAULT '0';

-- modification de la table des message pour mettre une collone pour savoir qui a envoyer le message
ALTER TABLE `t_message` ADD `fkMessageSendBy` VARCHAR(11) NOT NULL AFTER `fkAthlete`;

-- modification de ka table des coach pour qu'il y ai une image par défaut
ALTER TABLE `t_coach` CHANGE `coaImage` `coaImage` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'no_picture.png';

-- ajoute les athletes ( les mot de passe sont 123 )
INSERT INTO `t_athlete` (`idAthlete`, `athName`, `athSurname`, `athEmail`, `athPassword`, `athPhone`, `athStreet`, `athTown`, `athNPA`, `athIsAdministrator`, `athIsAthlete`) VALUES ('1', 'toto', 'athlete', 'hfhu9hff@gmail.com', '$2y$10$CbKGPjyDRgQjYs38fg7MBOkluoP12ZyY1wiCuI2IDeex/W8ZD6lXe', '0787776641', '15 rue du truc', 'chose', '1087', '1', '1');
INSERT INTO `t_athlete` (`idAthlete`, `athName`, `athSurname`, `athEmail`, `athPassword`, `athPhone`, `athStreet`, `athTown`, `athNPA`, `athIsAdministrator`, `athIsAthlete`) VALUES ('2', 'tutu', 'athlete', 'hfhu9hgg@gmail.com', '$2y$10$CbKGPjyDRgQjYs38fg7MBOkluoP12ZyY1wiCuI2IDeex/W8ZD6lXe', '0787776642', '14', '4', '18', '0', '1');

INSERT INTO `t_athlete` (`idAthlete`, `athName`, `athSurname`, `athEmail`, `athPassword`, `athPhone`, `athStreet`, `athTown`, `athNPA`, `athIsAdministrator`, `athIsAthlete`) VALUES (NULL, 'Dupont', 'Jean', 'jean.dupont@example.com', '$2y$10$CbKGPjyDRgQjYs38fg7MBOkluoP12ZyY1wiCuI2IDeex/W8ZD6lXe', '0123456789', 'Rue des Sports 1', 'Ville Athlète 1', '12345', '0', '1'), (NULL, 'Martin', 'Marie', 'marie.martin@example.com', '$2y$10$CbKGPjyDRgQjYs38fg7MBOkluoP12ZyY1wiCuI2IDeex/W8ZD6lXe', '0234567890', 'Avenue des Champions 2', 'Ville Athlète 2', '23456', '0', '1'), (NULL, 'Durand', 'Pierre', 'pierre.durand@example.com', '$2y$10$CbKGPjyDRgQjYs38fg7MBOkluoP12ZyY1wiCuI2IDeex/W8ZD6lXe', '0345678901', 'Allée du Stade 3', 'Ville Athlète 3', '34567', '0', '1'), (NULL, 'John', 'Doe', 'john.doe@example.com', '$2y$10$CbKGPjyDRgQjYs38fg7MBOkluoP12ZyY1wiCuI2IDeex/W8ZD6lXe', '1234567890', 'Rue des Athlètes 1', 'Ville des Athlètes 1', '12345', '0', '1'), (NULL, 'Jane', 'Smith', 'jane.smith@example.com', '$2y$10$CbKGPjyDRgQjYs38fg7MBOkluoP12ZyY1wiCuI2IDeex/W8ZD6lXe', '2345678901', 'Rue des Athlètes 2', 'Ville des Athlètes 2', '23456', '0', '1'), (NULL, 'Tremblay', 'Marie', 'marietremblay@example.com', '$2y$10$CbKGPjyDRgQjYs38fg7MBOkluoP12ZyY1wiCuI2IDeex/W8ZD6lXe', '9876543210', 'Avenue de l\'Entraînement 5', 'Fitville', '54321', '0', '1'), (NULL, 'Garcia', 'Luis', 'luisgarcia@example.com', '$2y$10$CbKGPjyDRgQjYs38fg7MBOkluoP12ZyY1wiCuI2IDeex/W8ZD6lXe', '5555555555', 'Rue du Stade 8', 'Sportstown', '67890', '0', '1'), (NULL, 'Müller', 'Anna', 'annamuller@example.com', '$2y$10$CbKGPjyDRgQjYs38fg7MBOkluoP12ZyY1wiCuI2IDeex/W8ZD6lXe', '9999999999', 'Avenue de la Forme 10', 'Fitcity', '13579', '0', '1'), (NULL, 'Wang', 'Li', 'liwang@example.com', '$2y$10$CbKGPjyDRgQjYs38fg7MBOkluoP12ZyY1wiCuI2IDeex/W8ZD6lXe', '7777777777', 'Rue de l\'Endurance 12', 'Fitville', '54321', '0', '1'), (NULL, 'Gonzalez', 'Miguel', 'miguelgonzalez@example.com', '$2y$10$CbKGPjyDRgQjYs38fg7MBOkluoP12ZyY1wiCuI2IDeex/W8ZD6lXe', '3333333333', 'Rue des Champions 15', 'Fitcity', '13579', '0', '1');

-- ajoute les coachs ( les mot de passe sont 123 )
INSERT INTO `t_coach` (`idCoach`, `coaName`, `coaSurname`, `coaEmail`, `coaPassword`, `coaPhone`, `coaExperience`, `coaImage`, `coaIsAdministrator`, `coaIsCoach`) VALUES ('1', 'Xavier', 'Jaquet', 'xavou@gmail.com', '$2y$10$CbKGPjyDRgQjYs38fg7MBOkluoP12ZyY1wiCuI2IDeex/W8ZD6lXe', '0787776643', 'rien', '1.jpg', '1', '1');
INSERT INTO `t_coach` (`idCoach`, `coaName`, `coaSurname`, `coaEmail`, `coaPassword`, `coaPhone`, `coaExperience`, `coaImage`, `coaIsAdministrator`, `coaIsCoach`) VALUES ('2', 'titi', 'coach', 'bsdjuusdu@gmail.com', '$2y$10$CbKGPjyDRgQjYs38fg7MBOkluoP12ZyY1wiCuI2IDeex/W8ZD6lXe', '0787776644', 'tout', 'no_picture.png', '0', '1');

INSERT INTO `t_coach` (`idCoach`, `coaName`, `coaSurname`, `coaEmail`, `coaPassword`, `coaPhone`, `coaExperience`, `coaImage`, `coaIsAdministrator`, `coaIsCoach`) VALUES (NULL, 'Anderson', 'David', 'davidanderson@example.com', '$2y$10$CbKGPjyDRgQjYs38fg7MBOkluoP12ZyY1wiCuI2IDeex/W8ZD6lXe', '1234567', 'Spécialisé dans la préparation physique', 'no_picture.png', '0', '1'), (NULL, 'Roberts', 'Jessica', 'jessicaroberts@example.com', '$2y$10$CbKGPjyDRgQjYs38fg7MBOkluoP12ZyY1wiCuI2IDeex/W8ZD6lXe', '9876543', 'Spécialisée dans la musculation et la force athlétique', 'no_picture.png', '0', '1'), (NULL, 'Martinez', 'Alejandro', 'alejandromartinez@example.com', '$2y$10$CbKGPjyDRgQjYs38fg7MBOkluoP12ZyY1wiCuI2IDeex/W8ZD6lXe', '5555555', 'Plus de 15 ans d\'expérience en tant que coach sportif', 'no_picture.png', '0', '1'), (NULL, 'Wilson', 'Emma', 'emmawilson@example.com', '$2y$10$CbKGPjyDRgQjYs38fg7MBOkluoP12ZyY1wiCuI2IDeex/W8ZD6lXe', '1111111', 'Spécialisée dans la préparation physique pour les sports de combat', 'no_picture.png', '0', '1'), (NULL, 'García', 'Carlos', 'carlosgarcia@example.com', '$2y$10$CbKGPjyDRgQjYs38fg7MBOkluoP12ZyY1wiCuI2IDeex/W8ZD6lXe', '2222222', 'Spécialisé dans la préparation physique pour les sports collectifs', 'no_picture.png', '0', '1'), (NULL, 'Lea', 'Min-jun', 'minjunlea@example.com', '$2y$10$CbKGPjyDRgQjYs38fg7MBOkluoP12ZyY1wiCuI2IDeex/W8ZD6lXe', '6666666', 'Ancien athlète olympique, spécialisé dans le saut en hauteur', 'no_picture.png', '0', '1'), (NULL, 'Brown', 'Olivia', 'oliviabrown@example.com', '$2y$10$CbKGPjyDRgQjYs38fg7MBOkluoP12ZyY1wiCuI2IDeex/W8ZD6lXe', '7777777', 'Spécialisée dans la préparation physique pour les sports de raquette', 'no_picture.png', '0', '1'), (NULL, 'Müller', 'Hans', 'hansmuller@example.com', '$2y$10$CbKGPjyDRgQjYs38fg7MBOkluoP12ZyY1wiCuI2IDeex/W8ZD6lXe', '8888888', 'Spécialisé dans la préparation physique pour les sports d\'endurance', 'no_picture.png', '0', '1'), (NULL, 'Taylor', 'Sophie', 'sophietaylor@example.com', '$2y$10$CbKGPjyDRgQjYs38fg7MBOkluoP12ZyY1wiCuI2IDeex/W8ZD6lXe', '3333333', 'Spécialisée dans la préparation physique pour les sports aquatiques', 'no_picture.png', '0', '1'), (NULL, 'Rodriguez', 'Manuel', 'manuelrodriguez@example.com', '$2y$10$CbKGPjyDRgQjYs38fg7MBOkluoP12ZyY1wiCuI2IDeex/W8ZD6lXe', '9999999', 'Spécialisé dans la préparation physique pour les sports de combat', 'no_picture.png', '0', '1');

-- ajoute les activité
INSERT INTO t_activity (actActivite) VALUES ('Football'), ('Basketball'), ('Tennis'), ('Natation'), ('Athlétisme'), ('Gymnastique'), ('Cyclisme'), ('Escalade'), ('Yoga'), ('Boxe'), ('Badminton');

-- ajoute des sports que fait des sportifes
INSERT INTO `t_do` (`fkActivity`, `fkCoach`) VALUES ('11', '1'), ('8', '1'), ('10', '1'), ('4', '1'), ('9', '1');
INSERT INTO `t_do` (`fkActivity`, `fkCoach`) VALUES ('1', '7'), ('5', '3'), ('11', '3'), ('5', '2'), ('8', '2'), ('10', '2'), ('5', '12');

-- ajoute des matches
INSERT INTO `t_select` (`fkAthlete`, `fkCoach`, `validateCoach`) VALUES ('1', '4', '1'), ('1', '8', '0'), ('1', '3', '1'), ('1', '2', '1');
INSERT INTO `t_select` (`fkAthlete`, `fkCoach`, `validateCoach`) VALUES ('6', '1', '1'), ('2', '1', '1'), ('10', '1', '1'), ('12', '1', '1'), ('8', '1', '1');
