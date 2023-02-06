<?php
/**
 * Auteur : Yann Hofstetter
 * Date : 05.10.2022
 * Description : toutes les requettes pour intéragire avec la db
 */

    // Démarrer le système de session
    session_start();

    include "Config.php";
    require "Database.php";
    
    if (isset($_POST["btnSingIn"]))
    {
        $_SESSION["email"] = trim($_POST["email"]);
        $_SESSION["password"] = trim($_POST["password"]);
    }

    //récupere dans un tableau toutes les informations sur un utilisateur de la db
    $user = Database::getInstance() -> getOneUser($_SESSION["email"]);
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>Verification de l'ajout d'un produits</title>
        <meta charset="utf-8" />
        <link href="../../resources/css/Style.css" rel="stylesheet" type="text/css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
    </head>

    <body>
        <?php
            //regarde que le bouton "btnLogin" a bien été créer
            if (isset($_POST["btnSingIn"]) || isset($_SESSION["btnCreate"]))
            {
                if (!empty($user))
                {
                    if (password_verify($_SESSION["password"], $user[0]["usePassword"]))
                    {
                        //crée une variable de session pour dire qu'il est connecté
                        $_SESSION["isConnected"] = 1;
                        
                        //regarde si l'utilisateur est admin ou non
                        if ($user[0]["useAdministrator"] == 1)
                        {
                            //crée une variable de session pour dire qu'il est administrateur
                            $_SESSION["isAdministrator"] = 1;
                        }

                        //redirige ver la page du menu principal
                        header("Location:../../");
                        exit;
                    }
                    else
                    {
                        echo "Mot de passe incorecte";
                    }
                }
                else
                {
                    echo "Login incorecte";
                }
            }
            else
            {
                //redirige ver la page du menu principal
                header("Location:../../");
                exit;
            }
        ?>

        <hr>
        <p id = "copyright">Copyright: Yann Hofstetter - 2022 </p>
    </body>
</html>