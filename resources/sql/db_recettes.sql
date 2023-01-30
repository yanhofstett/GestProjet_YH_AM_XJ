-- creation de la db
DROP DATABASE IF EXISTS db_recipes;
DROP USER IF EXISTS 'db_recipes_pw42mwi'@'localhost';
CREATE DATABASE if not EXISTS db_recipes CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE db_recipes;

-- creation des tables + contraintes
CREATE TABLE IF NOT EXISTS t_category (
  idCategory int(11) NOT NULL AUTO_INCREMENT,
  catName varchar(20) NOT NULL,
  PRIMARY KEY (idCategory)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS t_recipes (
  idRecipes int(11) NOT NULL AUTO_INCREMENT,
  recName varchar(50) NOT NULL,
  recPicture VARCHAR(100) NOT NULL,
  recIngredients VARCHAR(2000) NOT NULL,
  recCookingInfo VARCHAR(3000) NOT NULL,
  recUstensils VARCHAR(2000) NOT NULL,
  fkCategory int(11) NOT NULL,
  PRIMARY KEY (idRecipes),
  FOREIGN KEY (fkCategory) REFERENCES t_category(idCategory)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS t_user (
  idUser int(11) NOT NULL AUTO_INCREMENT,
  usePseudo varchar(20) NOT NULL,
  useEmail VARCHAR(254) NOT NULL,
  usePassword varchar(62) NOT NULL,
  useAdministrator tinyint(1) NOT NULL,
  PRIMARY KEY (idUser)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS t_question (
  idQuestion int(11) NOT NULL AUTO_INCREMENT,
  queDescription varchar(5000) NOT NULL,
  fkUser int(11) NOT NULL,
  PRIMARY KEY (idQuestion),
  FOREIGN KEY (fkUser) REFERENCES t_user(idUser)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- creation de l'utilisateur
CREATE USER IF NOT EXISTS 'db_recipes_pw42mwi'@'localhost' IDENTIFIED BY 'grp2B2022_pwd';
GRANT SELECT,INSERT,UPDATE,DELETE ON db_recipes.* TO 'db_recipes_pw42mwi'@'localhost';

-- insertion des catégorie de recettes
INSERT INTO `t_category` (`catName`) VALUES ('apperitif');
INSERT INTO `t_category` (`catName`) VALUES ('entree');
INSERT INTO `t_category` (`catName`) VALUES ('soupe');
INSERT INTO `t_category` (`catName`) VALUES ('plat');
INSERT INTO `t_category` (`catName`) VALUES ('fromage');
INSERT INTO `t_category` (`catName`) VALUES ('dessert');
-- insertion des recettes
INSERT INTO `t_recipes` (`idRecipes`, `recName`, `recPicture`, `recIngredients`, `recCookingInfo`, `recUstensils`, `fkCategory`) VALUES (NULL, 'Soupe de potiron paysanne', '20221223125514Soupe de potiron paysanne.webp', '2 cubes de bouilon de volaille dégraissé / 6 pommes de terre / 200g de lardons / 4 c.à.s de crème fraîche / 1/4potirons / il est gros ou 1/2si le potiron est petit', "Faites bouillir une marmite d'eau à laquelle pour y ajouter les deux cubes de bouillon de volaille. Puis peler le potiron et couper le en morceau. Faites de même pour les pommes de terre. Ensuite laisser cuire pendant 3/4 d'heure. Mixer la soupe, ajouter la crème, mixer à nouveau. Après faites bouillir les lardons dans une casserole d'eau pour les dégraisser. Ensuite ajouter les à la soupe, et laisser mijoter quelques minutes. Pour finir régalez-vous !", '1 louche / 1mixeur plongeant / 1 blender / 1 marmites', '2');
INSERT INTO `t_recipes` (`idRecipes`, `recName`, `recPicture`, `recIngredients`, `recCookingInfo`, `recUstensils`, `fkCategory`) VALUES (NULL, 'Bûche tiramisu-chocolat', '20221223125514Bûche tiramisu-chocolat.webp', '150g de chocolat noir / 1 c.à.s de de poudre brute non sucrée – 100% cacao / 15 boudoirs / 25cl de café fort froid / 250g de mascarpone/ 2 feuilles de gélatine / 3 c.à.s de sucre / 3 c.à.s de crème liquide / 2 oeufs', 'Faites fondre le chocolat 2 minutes au micro-ondes à 500W et étalez-le sur une surface rectangulaire très fine dont la taille est 3 fois équivalente à la base de votre moule à bûche. Laissez prendre 2h au frigo. Puis dans un bol d\'eau froide, réhydratez les feuilles de gélatine. Séparez les blancs des jaunes, et montez les blancs en neige. Ensuite battez les jaunes, le sucre et le mascarpone. Faites chauffer la crème liquide. Quand la crème est chaude, ajoutez les feuilles de gélatine préalablement essorées, et mélangez jusqu\'à homogénéisation. Ajoutez la crème liquide au mélange de mascarpone. Après coulez 1/3 de la crème mascarpone dans le moule à bûche. Ajoutez par-dessus la moitié des boudoirs imbibés de café, versez le deuxième 1/3 de l\'appareil mascarpone puis un rectangle du chocolat croquant. Ajoutez à nouveau les boudoirs imbibés de café, le reste de l’appareil mascarpone et terminez par un tiers du chocolat croquant. Faites prendre au froid 6h minimum. Pour finir Démoulez la bûche et saupoudrez-la de cacao en poudre. Décorez de brisures de chocolat.', '1 balance de cuisine / 1 micro-ondes / 1 bol / 1 moule à bûche', '6');
INSERT INTO `t_recipes` (`idRecipes`, `recName`, `recPicture`, `recIngredients`, `recCookingInfo`, `recUstensils`, `fkCategory`) VALUES (NULL, 'Terrine de foies de volaille', '20221223125915Terrine de foies de volaille.webp', '20cl de crème fraîche épaisse / 25g de beurre / 5cl de porto / 1 c.à.s de persil plat ciselé / poivre / sel / 300g de fois de volaille / 2 jaunes d\'oeuf / 1 échalote / 1 pincée de mélange 4 épices', 'Retirez les fines membranes blanches et les petits nerfs des foies de volaille. Passez-les sous l\'eau et épongez les. Coupez-les en petits morceaux. Puis epluchez l\'échalote et hachez-la. Dans une poêle, faites revenir l\'échalote avec le beurre. Ajoutez les foies de volailles, salez et poivrez, faites réduire à feu moyen. Après mettez cette préparation dans la cuve d\'un mixeur et faites tourner jusqu\'à obtention d\'une purée presque lisse. Ensuite ajoutez les jaunes d\'oeufs, la crème fraîche, le porto, le persil ciselé et la pincée de quatre-épices. mélangz bien, vérifiez l\'assaisonnement et réservez. Puis allumez le four à thermostat 6 (180°C). Après beurrez une terrine en porcelaine, remplissez-la avec la préparation et couvrez-la. Glissez la terrine au bain-marie dans le four et faites cuire 25 min. Pour finir faites refroidir la terrine avant de la servir accompagnée de pain de campagne grillé, d\'une salade de mâche et éventuellement d\'une petite sauce crémeuse au porto.', '1 presse-ail / 1 pôele / 1 mixeur / 1 four', '1');

-- insertion des utilisateur (toto est admin et tutu ne l'est pas) leur mot de passe au 2 est 123
INSERT INTO `t_user` (`idUser`, `usePseudo`, `useEmail`, `usePassword`, `useAdministrator`) VALUES (NULL, 'toto', 'toto@gmail.com', '$2y$10$MZTgqprrWInNQE38lu6h0euR1vd9Cd5AR/lKq9nsmwCVTNouDGkEa', '1'), (NULL, 'tutu', 'tutu@gmail.com', '$2y$10$qTCURbItkVf5qh73pS41Iev4/DdmCHBkbW3MgPIxK5GOkgkaRwSGK', '0');
-- insert un utilisateur tout PUBLIC
INSERT INTO `t_user` (`idUser`, `usePseudo`, `useEmail`, `usePassword`, `useAdministrator`) VALUES (NULL, 'allUser', 'allUser@gmail.com', '', '0');

-- modifie la table des utilisateur pour ajouter une valeur par defaut
ALTER TABLE `t_user` CHANGE `useAdministrator` `useAdministrator` TINYINT(1) NOT NULL DEFAULT '0';

-- modifie la table des question pour ajouter une colonne pour un titre a la question
ALTER TABLE `t_question` ADD `queName` VARCHAR(30) NOT NULL AFTER `idQuestion`;
-- modifie la table des question pour ajouter une colonne pour les réponses
ALTER TABLE `t_question` ADD `queAnswer` VARCHAR(5000) NOT NULL DEFAULT 'Aucune réponse pour le moment' AFTER `queDescription`;
-- modifie la table des question pour ajouter une colonne pour dire si oui ou non la question a été répondu
ALTER TABLE `t_question` ADD `queAlreadyAnswered` TINYINT NOT NULL DEFAULT '0' AFTER `queAnswer`; 
-- modifie la table des questions pour que quand je supprime un utilisateur toutes ses question se supprime aussi
ALTER TABLE `t_question` DROP FOREIGN KEY `t_question_ibfk_1`; ALTER TABLE `t_question` ADD CONSTRAINT `t_question_ibfk_1` FOREIGN KEY (`fkUser`) REFERENCES `t_user`(`idUser`) ON DELETE CASCADE ON UPDATE CASCADE;
-- modifie la table des recettes pour que quand je supprime une catégorie toutes ses recettes se supprime aussi
ALTER TABLE `t_recipes` DROP FOREIGN KEY `t_recipes_ibfk_1`; ALTER TABLE `t_recipes` ADD CONSTRAINT `t_recipes_ibfk_1` FOREIGN KEY (`fkCategory`) REFERENCES `t_category`(`idCategory`) ON DELETE CASCADE ON UPDATE CASCADE;
-- modifie la table des recettes pour avoir une colonne pour le liens ver les images
--  ALTER TABLE `t_recipes` ADD `recPicture` VARCHAR(300) NOT NULL AFTER `recName`;