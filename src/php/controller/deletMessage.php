<?php
/**
 * Auteur : Yann Hofstetter
 * Date : 30.11.2022
 * Description : permet de supprimmer une recette
 */

    // Démarrer le système de session
    session_start();

    include "Config.php";
    require "../model/modelDB.php";

    $recipes = Database::getInstance() -> getOneMessage($_GET['id']);
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>Suppression de produits</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
    </head>

    <body>
        <?php
            //supprime la recette de la DB
            Database::getInstance() -> deletQuestion($_GET['id']);

            //redirige ver la page du menu principal
            header("Location:".$_SERVER[HTTP_REFERER]);
            exit;
        ?>

        <br><br>
        <hr>
        <p id = "copyright">Copyright: Yann Hofstetter - 2022 </p>
    </body>
</html>