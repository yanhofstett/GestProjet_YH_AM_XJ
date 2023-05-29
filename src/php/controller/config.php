<?PHP
    /*
    //Auteur : Alexandre Montandon, Xavier Jaquet, Yann Hofstetter
    //Date : 06.02.2023
    //Description : Projet gestion || Page de configuration pour le site
    */

// Définir et dire que le text est égal à mysql
define("DB_LANGUAGE","mysql");

// Définir et dire que le text est égal à 127.0.0.1
define("HOST_NAME","127.0.0.1;");

// Définir et dire que le text est égal au nom de la base de données
define("DB_NAME","db_sport;");

// Définir et dire que le text est égal a<u charset utf-8
define("CHARSET","charset=utf8");

// Définir et assembler tout les éléments pour faire la connexion de la base de donnée
define("PAVE",DB_LANGUAGE.":host=".HOST_NAME."dbname=".DB_NAME.CHARSET);

// Définir et dire que le text est égal au nom de l'utilisateur
define("USER","db_PGest042");


// Définir et dire que le text est égal à l'alert suivante ##
define('MODIFY_CORRECT_MESSAGE', '✔️La recette à bien été modifié✔️');

// ##bis
define('MODIFY_ERROR_MESSAGE', "❌La recette n'à pas bien été modifié❌");

// ##bis
define('MODIFY_ERROR_PATTERN_MESSAGE', "❌La recette n'a pas été modifié, vous ne pouvez pas entrez une case vide, vous devez aussi entrez un minimum de text pour pouvoir continuer, et seul les caractère suivant sont accepter = a - z, A - Z, 0 - 9, ç, û, é, à, è, î, ,, ., !, ?, -, espace. Au delà de ces caractère votre recette ne peut pas se modifiée...❌");


// ##bis
define('ISNT_ABLE_INFO', "❌Vous ne pouvez pas accèdez aux détails de la recette veuillez vous connecter❌");


// ##bis
define('DELETE_CORRECT_MESSAGE', "✔️La recette à bien été supprimer✔️");

// ##bis
define('DELETE_ERROR_MESSAGE', "❌La recette n'à pas été supprimer❌");


// ##bis
define('ADDED_CORRECT_MESSAGE', "✔️La recette à bien été ajoutée✔️");

// ##bis
define('ADDED_ERROR_PATTERN_MESSAGE', "❌La recette n'a pas été crée, vous ne pouvez pas entrez une case vide, vous devez aussi entrez un minimum de text pour pouvoir continuer, et seul les caractère suivant sont accepter = a - z, A - Z, 0 - 9, ç, û, é, à, è, î, ,, ., !, ?, -, espace. Au delà de ces caractère votre recette ne peut pas s'ajouter...❌");

// ##bis
define('ADDED_ERROR_MESSAGE', "❌La recette n'à bien été ajoutée, veuillez faire attention a bien avoir entrer tout les champs, puis réessayez...❌");


// ##bis
define('CREATE_USER_CORRECT', "✔️Votre compte à bien été crée, vous pouvez désormais vous connecté✔️");

// ##bis
define('CREATE_USER_FAILED', "❌Votre compte n'a pas été crée, entrez le même mot de passe sur les deux cases de mot de passe et qu'il soit d'au moins 4 caractère, une majuscule et une minuscule. Et un e-mail valide, votre pseudo est peut-être déjà utiliser, seul les caractère suivant sont accepter = a - z, A - Z, 0 - 9, ç, û, é, à, è, î, ,, ., !, ?, -, espace. Au delà de ces caractère votre compte ne peut pas se crée...❌");

// ##bis
define('REGISTER_PSEUDO_ALREADY_ORNOT', "❌Votre compte n'a pas été crée, car le champs pseudo est vide ou votre pseudo est déjà utiliser, seul les caractère suivant sont accepter = a - z, A - Z, 0 - 9, ç, û, é, à, è, î, ,, ., !, ?, -, espace. Au delà de ces caractère votre compte ne peut pas se crée...❌");

// ##bis
define('REGISTER_EMAIL_ALREADY_ORNOT', "❌Votre compte n'a pas été crée, le champs pour l'email ne peut pas être vide et entrez et un e-mail valide et qui n'est pas utiliser, seul les caractère suivant sont accepter = a - z, A - Z, 0 - 9, ç, û, é, à, è, î, ,, ., !, ?, -, espace. Au delà de ces caractère votre compte ne peut pas se crée...❌");

// ##bis
define('REGISTER_PASSWORD_DOESNT_MATCH', "❌Votre compte n'a pas été crée, le champs pe peut pas être vide et ou ne correspond pas à la vérification, seul les caractère suivant sont accepter = a - z, A - Z, 0 - 9, ç, û, é, à, è, î, ,, ., !, ?, -, espace. Au delà de ces caractère votre compte ne peut pas se crée...❌");


// ##bis
define('CONNEXION_CORRECT_MESSAGE_USER', "✔️Vous êtes bien connecté en grade : 'user'✔️");

// ##bis
define('CONNEXION_CORRECT_MESSAGE_ADMIN', "✔️Vous êtes bien connecté en grade : 'administrateur'✔️");

// ##bis
define('LOGIN_PASSWORD_MISSING', "❌Veuillez entrez le champ de mot de passe❌");

// ##bis
define('LOGIN_EMAIL_MISSING', "❌Veuillez entrez le champ de l'email❌");

// ##bis
define('CONNEXION_ONLY_MESSAGE', "❌Seul les 'administrateur' peuvent accèder à cette page❌");

// ##bis
define('CONNECTOR_CONNEXION_ERROR_MESSAGE', "❌La connexion à échoué, veuillez faire attention à bien avoir entrer un email correct et le bon mot de passe, puis réessayez❌");


// ##bis
define('EMAIL_MESSAGE_SEND_CORRECT', "✔️Wow! Parfait, votre message vient d'être envoyer✔️");

// ##bis
define('EMAIL_MESSAGE_SEND_ERROR', "❌Oups! Le système n'adère pas à votre message, réssayez maintenant ou plus tard❌");

// ##bis
define('EMAIL_MESSAGE_SEND_ERROR_MISSING_NAME', "❌Aie! Le message n'a pas été envoyer, le champs du nom ne peut pas être vide❌");

// ##bis
define('EMAIL_MESSAGE_SEND_ERROR_MISSING_SURNAME', "❌Aie! Le message n'a pas été envoyer, le champs du prénom ne peut pas être vide❌");

// ##bis
define('EMAIL_MESSAGE_SEND_ERROR_MISSING_LOCAL', "❌Aie! Le message n'a pas été envoyer, le champs de la localité ne peut pas être vide❌");

// ##bis
define('EMAIL_MESSAGE_SEND_ERROR_MISSING_PHONE', "❌Aie! Le message n'a pas été envoyer, le champs du téléphone ne peut pas être vide ou doit être valide, et seul ce format est valide : +41 79 000 00 00❌");

// ##bis
define('EMAIL_MESSAGE_SEND_ERROR_MISSING_MAIL', "❌Aie! Le message n'a pas été envoyer,  le champs de l'email ne peut pas être vide ou doit être valide, et seul ce format est valide : exemple@gmail.ch / exemple.deux@glo.com❌");

// ##bis
define('EMAIL_MESSAGE_SEND_ERROR_MISSING_REM', "❌Aie! Le message n'a pas été envoyer, soit les cases sont vides et doit contenir minimum 10 caractère et maximum 450❌");

?>