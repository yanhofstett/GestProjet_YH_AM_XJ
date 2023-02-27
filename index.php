<!--
Auteur : Alexandre Montandon, Xavier Jaquet, Yann Hofstetter
Date : 06.02.2023
Description : page qui permet de rediriger ver les différentes page de notre site web
-->

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8" />
        <!--liens avec le css de bootstrap-->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="../../resources/css/style.css" rel="stylesheet" type="text/css">
    </head>
    
    <?php

    //commence le système de session
    session_start();

    //ajoute le fichier qui gère les requette SQL
    include 'src/php/controller/config.php';
    require "src/php/model/modelDB.php";

    session_destroy();
    $_SESSION["isConnected"]=1;
    $_SESSION["isAthlete"]=1;
    $_SESSION["email"]="hfhu9hff";
    //$_SESSION["email"]="hfhu9hgg";
    //$_SESSION["isCoach"]=1;
    //$_SESSION["email"]="uzguzg1";

    //regarde si l'utilisateur n'est pas connecter pour le rediriger ver la page de connection (car pour visité le site on doit être connecté)
    if(!isset($_SESSION["isConnected"]))
    {
        //redirige ver la page de connection
        header("Location:src/php/view/connection.php");
        exit;
    }

    //si il n'y a pas de GET dans l'URL (donc qu'il arrive pour la premiere fois sur le site)
    if (!isset($_GET['page'])) 
    {
        //regarde si il est athlète ou un coach
        if (isset($_SESSION["isAthlete"]) || isset($_SESSION["isCoach"]))
        {
            $_GET['page'] = 'meet';
        }
        else
        {
            $_GET['page'] = "";
        }
    }

    //affiche la barre de navigation
    include("src/php/view/navBar.php");

    //regarde sur quelle page il veut aller
    switch($_GET["page"])
    {
        case "meet":
            $pageChose = "meeting";
            break;
        case "conv":
            $pageChose = "conversation";
            break;
        case "convDetail":
            $pageChose = "conversationDetailMessage";
            break;
        default:
            $pageChose = "error";
            break;
    }

    //redirige ver la page demandé
    include("src/php/view/".$pageChose.".php");

    //affiche le footer
    include("src/html/footer.html");

    ?>
</html>