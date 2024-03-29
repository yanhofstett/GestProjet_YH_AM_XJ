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


-- ajoute les athletes ( les mot de passe sont 123 )
INSERT INTO `t_athlete` (`idAthlete`, `athName`, `athSurname`, `athEmail`, `athPassword`, `athPhone`, `athStreet`, `athTown`, `athNPA`, `athIsAdministrator`, `athIsAthlete`) VALUES ('1', 'toto', 'athlete', 'hfhu9hff@gmail.com', '$2y$10$CbKGPjyDRgQjYs38fg7MBOkluoP12ZyY1wiCuI2IDeex/W8ZD6lXe', '0787776641', '15 rue du truc', 'chose', '1087', '1', '1');
INSERT INTO `t_athlete` (`idAthlete`, `athName`, `athSurname`, `athEmail`, `athPassword`, `athPhone`, `athStreet`, `athTown`, `athNPA`, `athIsAdministrator`, `athIsAthlete`) VALUES ('2', 'tutu', 'athlete', 'hfhu9hgg@gmail.com', '$2y$10$CbKGPjyDRgQjYs38fg7MBOkluoP12ZyY1wiCuI2IDeex/W8ZD6lXe', '0787776642', '14', '4', '18', '0', '1');

-- ajoute les coachs ( les mot de passe sont 123 )
INSERT INTO `t_coach` (`idCoach`, `coaName`, `coaSurname`, `coaEmail`, `coaPassword`, `coaPhone`, `coaExperience`, `coaImage`, `coaIsAdministrator`, `coaIsCoach`) VALUES ('1', 'tata', 'coach', 'uzguzg1@gmail.com', '$2y$10$CbKGPjyDRgQjYs38fg7MBOkluoP12ZyY1wiCuI2IDeex/W8ZD6lXe', '0787776643', 'rien', 'r', '1', '1');
INSERT INTO `t_coach` (`idCoach`, `coaName`, `coaSurname`, `coaEmail`, `coaPassword`, `coaPhone`, `coaExperience`, `coaImage`, `coaIsAdministrator`, `coaIsCoach`) VALUES ('2', 'titi', 'coach', 'bsdjuusdu@gmail.com', '$2y$10$CbKGPjyDRgQjYs38fg7MBOkluoP12ZyY1wiCuI2IDeex/W8ZD6lXe', '0787776644', 'tout', 'r', '0', '1');