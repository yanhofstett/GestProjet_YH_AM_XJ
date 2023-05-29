<?php
/*
 * Auteur : Alexandre Montandon, Xavier Jaquet, Yann Hofstetter
 * Date : 23.12.2022
 * Description : permet de verifier si la modification de l'utilisateur est accepter pour modifier l'utilisateur dans la db
 */

    // Démarrer le système de session
    session_start();

    // Inclut la page de configuration pour pouvoir intéragir avec la db
    include_once('config.php');

    // Inclut la page qui fait les requêtes qui intéragissent avec la db
    require_once('../model/modelDB.php');
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>Verification de la modif d'un profil</title>
        <meta charset="utf-8" />
        <link href="../../resources/css/acceuil.css" rel="stylesheet" type="text/css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
    <?php
        var_dump($_SESSION);


        // Regarde que le bouton "sauvegarder" à été appuyer
        if (isset($_POST["btnSave"]))
        {
            // Regarde si c'est un athlete ou un coach
            if (isset($_SESSION["isAthlete"]))
            {
                // Récupere dans un tableau toutes les informations sur un utilisateur de la db
                $user = Database::getInstance() -> getOneAthlete($_SESSION["email"]);

                var_dump($user);

                if(!empty(trim($_POST["oldpassword"])) && !empty(trim($_POST["newPassword"])) && !empty(trim($_POST["verifNewPassword"])) && password_verify(trim($_POST["oldpassword"]), $user["athPassword"]) && trim($_POST["newPassword"]) == trim($_POST["verifNewPassword"]))
                {
                    // Modifie l'utilisateur dans la DB (avec le nouveau mot de passe)
                    Database::getInstance() -> modifyAthlete($_POST["idUser"], trim($_POST["name"]), trim($_POST["surname"]), trim($_POST["email"]), trim($_POST["phone"]), trim($_POST["town"]), trim($_POST["NPA"]), password_hash(trim($_POST["verifNewPassword"]), PASSWORD_DEFAULT));
        
                    // Redirige ver la page de match
                    //23("Location:../../../index.php?page=profile");

                    // Quitte la page
                    exit;
                }
                else
                {
                    // Modifie l'utilisateur dans la DB (avec le nouveau mot de passe)
                    Database::getInstance() -> modifyAthlete($_POST["idUser"], trim($_POST["name"]), trim($_POST["surname"]), trim($_POST["email"]), trim($_POST["phone"]), trim($_POST["town"]), trim($_POST["NPA"]), $user[0]["athPassword"]);
                    
                    // Redirige ver la page de match
                    //23("Location:../../../index.php?page=profile");

                    // Quitte la page
                    exit;
                }
            }
            else if(isset($_SESSION["isCoach"]))
            {
                // Récupere dans un tableau toutes les informations sur un utilisateur de la db
                $user = Database::getInstance() -> getOneCoach($_SESSION["email"]);

                // Mettre la source de l'envoie
                $sourceCover=$_FILES["downloadFile"]["tmp_name"];

                // La destination de chemin
                $destinationCover="../../../userContent/images/" . date("YmdHis") . $_FILES["downloadFile"]["name"];

                if(!empty(trim($_POST["oldPassword"])) && !empty(trim($_POST["newPassword"])) && !empty(trim($_POST["verifNewPassword"])) && password_verify(trim($_POST["oldPassword"]), $user["coaPassword"]) && trim($_POST["newPassword"]) == trim($_POST["verifNewPassword"]))
                {
                    // Si une image à été selectionnée
                    if(isset($_FILES["downloadFile"]) && is_uploaded_file($_FILES["downloadFile"]))
                    {
                        // Envoie l'image et si l'envoie c'est bien passé
                        if(move_uploaded_file($sourceCover,$destinationCover))
                        {
                            // Modifie l'utilisateur dans la DB (avec le nouveau mot de passe)
                            Database::getInstance() -> modifyCoach($_POST["idUser"], trim($_POST["name"]), trim($_POST["surname"]), trim($_POST["email"]), trim($_POST["phone"]), trim($_POST['experience']), date("YmdHis") . $_FILES["downloadFile"]["name"], password_hash(trim($_POST["verifNewPassword"]), PASSWORD_DEFAULT));
                        }
                    }
                    // Sinon
                    else
                    {
                        echo "lé";
                        // Modifie l'utilisateur dans la DB (avec le nouveau mot de passe)
                        // Database::getInstance() -> modifyCoach($_POST["idUser"], trim($_POST["name"]), trim($_POST["surname"]), trim($_POST["email"]), trim($_POST["phone"]), trim($_POST['experience']), $user["coaImage"], password_hash(trim($_POST["verifNewPassword"]), PASSWORD_DEFAULT));
                        Database::getInstance() -> modifyCoach($_POST["idUser"], trim($_POST["name"]), trim($_POST["surname"]), trim($_POST["email"]), trim($_POST["phone"]), trim($_POST['experience']), "2.fk" , password_hash(trim($_POST["verifNewPassword"]), PASSWORD_DEFAULT));
                    }

                    // Redirige ver la page de match
                    //23("Location:../../../index.php?page=profile");

                    // Quitte la page
                    exit;
                }
                else
                {
                    // Si une image à été selectionnée
                    if(isset($_FILES["downloadFile"]))
                    {
                        // Envoie l'image et si l'envoie c'est bien passé
                        if(move_uploaded_file($sourceCover,$destinationCover))
                        {
                            echo "ok";
                            // Modifie l'utilisateur dans la DB (avec le nouveau mot de passe)
                            Database::getInstance() -> modifyCoach($_POST["idUser"], trim($_POST["name"]), trim($_POST["surname"]), trim($_POST["email"]), trim($_POST["phone"]), trim($_POST['experience']), date("YmdHis") . $_FILES["downloadFile"]["name"], $user["coaPassword"]);
                        }
                    }
                    // Sinon
                    else
                    {
                        // Modifie l'utilisateur dans la DB (avec le nouveau mot de passe)
                        Database::getInstance() -> modifyCoach($_POST["idUser"], trim($_POST["name"]), trim($_POST["surname"]), trim($_POST["email"]), trim($_POST["phone"]), trim($_POST['experience']), $user["coaImage"], $user["coaPassword"]);
                    }

                    //redirige ver la page de match
                    //23("Location:../../../index.php?page=profile");

                    // Quitte la page
                    exit;
                }
            }
        }
        else
        {
            //redirige ver la page de match
            //23("Location:../../../index.php");
            exit;
        }
    ?>