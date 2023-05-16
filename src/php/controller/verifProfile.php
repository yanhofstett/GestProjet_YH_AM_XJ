<?php
/**
 * Auteur : Yann Hofstetter
 * Date : 23.12.2022
 * Description : permet de verifier si la modification de l'utilisateur est accepter pour modifier l'utilisateur dans la db
 */

    // Démarrer le système de session
    session_start();

    include "Config.php";
    require "../model/modelDB.php";
    
    /*
    //récupere dans un tableau toutes les informations sur les utilisateurs créer dans la db
    $allUser = Database::getInstance() -> getAllUsers();
    $user = Database::getInstance() -> getOneAthlete($_SESSION["email"]);
    */
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>Verification de l'ajout d'un produits</title>
        <meta charset="utf-8" />
        <link href="../../resources/css/acceuil.css" rel="stylesheet" type="text/css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
    </head>

    <body>
        <?php
       
            //regarde que le bouton "Suite"
            if (isset($_POST["btnSave"]))
            {

                /*

                //crée une variable qui va dire si oui ou non la valeur entré pour le nom de l'utilisateur et correcte
                $useNameTrue = false;
                //crée une variable qui va dire si oui ou non la valeur entré pour le prénom de l'utilisateur et correcte
                $useSurnameTrue = false;
                //crée une variable qui va dire si oui ou non la valeur entré pour l'email de l'utilisateur et correcte
                $useEmailTrue = false;
                //crée une variable qui va dire si oui ou non la valeur entré pour le numéro de téléphonne de l'utilisateur et correcte
                $useNumTelTrue = false;
                //crée une variable qui va dire si oui ou non la valeur entré pour la rue de l'utilisateur et correcte
                $useStreetTrue = false;
                //crée une variable qui va dire si oui ou non la valeur entré pour la ville de l'utilisateur et correcte
                $useTownTrue = false;
                //crée une variable qui va dire si oui ou non la valeur entré pour le NPA de l'utilisateur et correcte
                $useNPATrue = false;
                //crée une variable qui va dire si oui ou non la valeur entré pour le mot de passe de l'utilisateur et correcte
                $usePasswordTrue = false;

                //regarde si le pseudo à bien été entré
                if (empty(trim($_POST["pseudo"])))
                {
                    //affiche un message d'erreur
                    echo "Merci de mettre un pseudo <br>";
                }
                else
                {
                    //change la valeur de usePseudoTrue en true car c'est vrai
                    $usePseudoTrue = true;

                    //parcour tout les utilisateurs déjà créer dans la db
                    foreach($allUser as $userPseudo)
                    {
                        //vérifie que l'email n'est pas encore utiliser dans la db
                        if ($userPseudo["usePseudo"] == trim($_POST["pseudo"]))
                        {
                            //regarde que le pseudo entré n'est pas le meme pseudo car c'est un pseudo qui a été modifié (il n'a pas garder son pseudo d'avant)
                            if (trim($_POST["pseudo"]) != $user[0]["usePseudo"])
                            {
                                //change la valeur de usePseudoTrue en false car elle est déjà utilisé
                                $usePseudoTrue = false;

                                //affiche un message d'erreur qui dit que le pseudo est déjà utilisé
                                echo "Le pseudo est déja utilisé <br>";
                            }
                        }
                    }
                }

                //regarde si l'email à bien été entré et si c'est bien un adresse mail(verifie que cela ressemble a une adresse mail qui peut exister)
                if (empty(trim($_POST["email"])) || !filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL))
                {
                    //affiche un message d'erreur
                    echo "Merci de mettre un email qui existe <br>";
                }
                else
                {
                    //change la valeur de useEmailTrue en true car c'est vrai
                    $useEmailTrue = true;

                    //parcour tout les utilisateurs déjà créer dans la db
                    foreach($allUser as $emailUser)
                    {
                        //vérifie que l'email n'est pas encore utiliser dans la db
                        if ($emailUser["useEmail"] == trim($_POST["email"]))
                        {
                            //regarde que l'email entré n'est pas le meme email car c'est un email qui a été modifié (il n'a pas garder son email d'avant)
                            if (trim($_POST["email"]) != $user[0]["useEmail"])
                            {
                                //change la valeur de useEmailTrue en false car elle est déjà utilisé
                                $useEmailTrue = false;

                                //affiche un message d'erreur qui dit que l'email est déjà utilisé
                                echo "L'email est déja utilisé <br>";
                            }
                        }
                    }
                }

                //regarde si le mot de passe à bien été entré (ne compte pas les éspace avant ni après) et que c'est le meme sur les 2 champs de mot de passe
                if (trim($_POST["usePassword"]) != trim($_POST["password"]))
                {
                    //affiche un message d'erreur
                    echo "Merci de mettre le même mot de passe dans le champs de vérification <br>";
                }
                else
                {
                    //change la valeur de usePasswordTrue en true car c'est vrai
                    $usePasswordTrue = true;
                }

                */

                //regarde si toutes les valeurs on bien été entré
                if (true/*$usePseudoTrue == true && $useEmailTrue == true && $usePasswordTrue == true*/)
                {
                    //stoque l'email dans des variable de session pour pouvoir l'utiliser pour se connecter tout de suite en modifiant le compte 
                    $_SESSION["email"] = trim($_POST["email"]);

                    //regarde si l'utilisateur a modifier le mot de passe ou non
                    if (!empty(trim($_POST["password"])))
                    {
                        //modifie l'utilisateur dans la DB (avec le nouveau mot de passe)
                        Database::getInstance() -> modifyUser($_POST["idUser"],trim($_POST["name"]),trim($_POST["surname"]),trim($_POST["email"]),trim($_POST["phone"]),trim($_POST["street"]),trim($_POST["town"]),trim($_POST["NPA"]), password_hash(trim($_POST["password"]), PASSWORD_DEFAULT));
                        
                        //stoque le mot de passe dans des variable de session pour pouvoir l'utiliser pour se connecter tout de suite en modifiant le compte 
                        $_SESSION["password"] = trim($_POST["password"]);
                    }
                    else
                    {
                        //modifie l'utilisateur dans la DB (avec son ancien mot de passe)
                        Database::getInstance() -> modifyUser($_POST["idUser"],trim($_POST["name"]),trim($_POST["surname"]),trim($_POST["email"]),trim($_POST["phone"]),trim($_POST["street"]),trim($_POST["town"]),trim($_POST["NPA"]), password_hash($_SESSION["password"], PASSWORD_DEFAULT));
                    }
                    var_dump($_POST);
                    //redirige ver la page de match
                    header("Location:../../../index.php?page=profile");
                    exit;
                }
            }
            else
            {
                //redirige ver la page de match
                header("Location:../../../index.php");
                exit;
            }
        ?>

        <hr>
        <p id = "copyright">Copyright: Yann Hofstetter - 2022 </p>
    </body>
</html>