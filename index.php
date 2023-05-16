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

    //session_destroy();
    $_SESSION["isConnected"]=1;
    $_SESSION["isAthlete"]=1;
    $_SESSION["email"]="hfhu9hff@gmail.com";
    //$_SESSION["adminConnected"]=1;
    //$_SESSION["email"]="hfhu9hgg@gmail.com";
    //$_SESSION["isCoach"]=1;
    //$_SESSION["email"]="uzguzg1@gmail.com";
    //$_SESSION["email"]="bsdjuusdu@gmail.com";

    //regarde si l'utilisateur n'est pas connecter pour le rediriger ver la page de connection (car pour visité le site on doit être connecté)
    if(!isset($_SESSION["isConnected"]))
    {
        //redirige ver la page de connection
        header("Location:src/php/view/login.php");
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

#region tout les messages quand on a effectué quelque chose sur le site
    #region messages dans l'index après avoir modifiés

    // Si le GET à été entré
    if(isset($_GET['msgModify']))
    {
        // Si le GET est égal à MCM
        if($_GET['msgModify']=='MCM')
        {
            // Afficher le message que la modification a réussi depuis le config.php
            echo MODIFY_CORRECT_MESSAGE;
            ?>
            <!-- Script Javascript -->
            <script>
                //Crée un timeout qui va s'écouler avant de faire myFunction
                setTimeout(myFunction, 2600);

                // Création d'une fonction
                function myFunction()
                {    
                    // Redirige vers la page d'index
                    location.href="index.php";
                }
            // Fin du script
            </script>

            <!-- Ouvre le php -->
            <?php   
        }
        // Sinon si le GET est égal à MEM
        else if($_GET['msgModify']=='MEM')
        {
            // Affiche le message d'erreur et que la modification n'a pas pu aboutir depuis le config.php
            echo MODIFY_ERROR_MESSAGE;
            
            ?>
            <!-- Script Javascript -->
            <script>
                //Crée un timeout qui va s'écouler avant de faire myFunction
                setTimeout(myFunction, 2600);

                // Création d'une fonction
                function myFunction()
                {    
                    // Redirige vers la page d'index
                    location.href="index.php";
                }
            // Fin du script
            </script>

            <!-- Ouvre le php -->
            <?php      
        }
    }
    #endregion

    #region messages dans l'index après avoir supprimer un produit

    // Si le GET à été entré
    if(isset($_GET['msgDelete']))
    {        
        // Si le GET est égal à DCM
        if($_GET['msgDelete']=='DCM')
        {
            // Afficher le message que le produit à été supprimer depuis le config.php
            echo DELETE_CORRECT_MESSAGE;
            ?>
            <!-- Script Javascript -->
            <script>
                //Crée un timeout qui va s'écouler avant de faire myFunction
                setTimeout(myFunction, 2600);

                // Création d'une fonction
                function myFunction()
                {    
                    // Redirige vers la page d'index
                    location.href="index.php";
                }
            // Fin du script
            </script>

            <!-- Ouvre le php -->
            <?php     
        }
        // Sinon si le GET est égal à DEM
        else if($_GET['msgDelete']=='DEM')
        {
            // Afficher le message que le produit à été supprimer depuis le config.php
            echo DELETE_ERROR_MESSAGE;
            ?>
            <!-- Script Javascript -->
            <script>
                //Crée un timeout qui va s'écouler avant de faire myFunction
                setTimeout(myFunction, 2600);

                // Création d'une fonction
                function myFunction()
                {    
                    // Redirige vers la page d'index
                    location.href="index.php";
                }
            // Fin du script
            </script>

            <!-- Ouvre le php -->
            <?php     
        }
    }
    #endregion

    #region messages dans l'index après avoir ajouté un produit
    // Si le GET à été entré
    if(isset($_GET['msgAdded']))
    {
        // Si le GET est égal à ACM
        if($_GET['msgAdded']=='ACM')
        {
            // Afficher le message que le produit à bien été ajouté depuis le config.php
            echo ADDED_CORRECT_MESSAGE;
            ?>
            <!-- Script Javascript -->
            <script>
                //Crée un timeout qui va s'écouler avant de faire myFunction
                setTimeout(myFunction, 2600);

                // Création d'une fonction
                function myFunction()
                {    
                    // Redirige vers la page d'index
                    location.href="index.php";
                }
            // Fin du script
            </script>

            <!-- Ouvre le php -->
            <?php     
        }
        // Sinon si le GET est égal à AEM
        else if($_GET['msgAdded']=='AEM')
        {
            // Afficher l'erreur d'ajout de produit depuis le config.php
            echo ADDED_ERROR_MESSAGE;
            ?>
            <!-- Script Javascript -->
            <script>
                //Crée un timeout qui va s'écouler avant de faire myFunction
                setTimeout(myFunction, 2600);

                // Création d'une fonction
                function myFunction()
                {    
                    // Redirige vers la page d'index
                    location.href="index.php";
                }
            // Fin du script
            </script>

            <!-- Ouvre le php -->
            <?php     
        }
    }
    #endregion

    #region messages dans l'index après s'être connecté en tant qu'utilisateur ou Administrateur du site

    // Si le GET à été entré
    if(isset($_GET['msgConnexion']))
    {
        // Si le GET est égal à CCUM
        if($_GET['msgConnexion']=='CCMU')
        {
            // Afficher le message de connexion pour un admin depuis le config.php
            echo CONNEXION_CORRECT_MESSAGE_USER;

            // Crée la variable de session pour dire que c'est un user seulement
            $_SESSION["userConnected"] = 1;
            ?>
            <!-- Script Javascript -->
            <script>
                //Crée un timeout qui va s'écouler avant de faire myFunction
                setTimeout(myFunction, 2600);

                // Création d'une fonction
                function myFunction()
                {    
                    // Redirige vers la page d'index
                    location.href="index.php";
                }
            // Fin du script
            </script>

            <!-- Ouvre le php -->
            <?php     
        }
        // Sinon si le GET est égal à CCMA
        else if($_GET['msgConnexion']=='CCMA')
        {
            // Afficher le message de connexion pour un admin depuis le config.php
            echo CONNEXION_CORRECT_MESSAGE_ADMIN;

            // Crée la variable de session pour dire que c'est un administrateur seulement
            $_SESSION["adminConnected"] = 1;
            ?>
            <!-- Script Javascript -->
            <script>
                //Crée un timeout qui va s'écouler avant de faire myFunction
                setTimeout(myFunction, 2600);

                // Création d'une fonction
                function myFunction()
                {    
                    // Redirige vers la page d'index
                    location.href="index.php";
                }
            // Fin du script
            </script>

            <!-- Ouvre le php -->
            <?php     
        }
        else if($_GET['msgConnexion']=='COM')
        {
            // Afficher le message de connexion pour un admin depuis le config.php
            echo CONNEXION_ONLY_MESSAGE;
            ?>
            <!-- Script Javascript -->
            <script>
                //Crée un timeout qui va s'écouler avant de faire myFunction
                setTimeout(myFunction, 2600);

                // Création d'une fonction
                function myFunction()
                {    
                    // Redirige vers la page d'index
                    location.href="index.php";
                }
            // Fin du script
            </script>

            <!-- Ouvre le php -->
            <?php     
        }
    }
    #endregion

    #region messages dans l'index si nous n'arrivons pas à nous connecté
    // Si le GET à été entré
    if(isset($_GET['msgConnexion']))
    {
        // Si le GET est égal à CEM
        if($_GET['msgConnexion']=='CCEM')
        {
            // Afficher l'erreur que la connexion a échoué depuis le config.php
            echo CONNECTOR_CONNEXION_ERROR_MESSAGE;
            ?>
            <!-- Script Javascript -->
            <script>
                //Crée un timeout qui va s'écouler avant de faire myFunction
                setTimeout(myFunction, 4600);

                // Création d'une fonction
                function myFunction()
                {    
                    // Redirige vers la page d'index
                    location.href="index.php";
                }
            // Fin du script
            </script>

            <!-- Ouvre le php -->
            <?php     
        }
    }
    #endregion

    #region messages dans l'index si nous n'arrivons pas accèdé aux détails puisque nous ne sommes pas conncté
    // Si le GET à été entré
    if(isset($_GET['msgConnected']))
    {
        // Si le GET est égal à CEM
        if($_GET['msgConnected']=='IAI')
        {
            // Afficher l'erreur que la connexion a échoué depuis le config.php
            echo ISNT_ABLE_INFO;
            ?>
            <!-- Script Javascript -->
            <script>
                //Crée un timeout qui va s'écouler avant de faire myFunction
                setTimeout(myFunction, 4600);

                // Création d'une fonction
                function myFunction()
                {    
                    // Redirige vers la page d'index
                    location.href="index.php";
                }
            // Fin du script
            </script>

            <!-- Ouvre le php -->
            <?php     
        }
    }
    #endregion

    #endregion

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
        case "profile":
            $pageChose = "profile";
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