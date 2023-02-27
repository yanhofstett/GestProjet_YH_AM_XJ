<?php
/**
 * Auteur : Yann Hofstetter
 * Date : 16.12.2022
 * Description : permet de verifier si l'ajout de la question est accepter pour ajouter cette question dans la db
 */

    //ajoute le fichier qui gère les requette SQL
    include 'config.php';
    require "../model/modelDB.php";

    //regarde que le bouton "Suite"
    if (isset($_POST["btnSend"]))
    {
        //regarde si le textBox est bien remplis pour ajouter la questuin a la db
        if (!empty($_POST["MessageFromUser"]))
        {
            //ajoute le message dans la DB
            Database::getInstance() -> createMessage($_POST["MessageFromUser"],$_POST["idAthlete"],$_POST["idCoach"],$_POST["idUser"]);
            
            //redirige ver la page de contacte
            header("Location:".$_SERVER[HTTP_REFERER]);
            exit;
        }
        else
        {
            echo "Merci de mettre un nom et une question";
        }
    }
    else
    {
        //redirige ver la page de contacte
        header("Location:../../../index.php");
        exit;
    }
?>