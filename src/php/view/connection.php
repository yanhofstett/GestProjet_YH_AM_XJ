<!--
Auteur : Alexandre Montandon, Xavier Jaquet, Yann Hofstetter
Date : 06.02.2023
Description : page qui permet de se connecter au site
-->

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8" />
        <!--liens avec le css de bootstrap-->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="../../resources/css/Style.css" rel="stylesheet" type="text/css">
        <title>Login</title>
    </head>
    
    <?php
        //affiche une information pour l'utilisateur
        echo "Vous devez être connecter pour pouvoir accéder à ce site";

        //regarde si l'utilisateur n'est pas connecter (donc qu'il doit se connecter) pour afficher les option de connexion
        if (!isset($_SESSION["isConnected"]))
        {
    ?>
    <!--page de login tirer de bootstrap-->
    <body class="text-center">
        <main class="form-signin w-100 m-auto">
            <form method="post" id="login" action="../controller/verifLogin.php">
                <a href="../../../index.php"><img src="../../resources/images/site_logo.png" width="72" height="72" alt="le logo du site"></a>

                <h1 class="h3 mb-3 fw-normal">Se connecter</h1>

                <div class="form-floating">
                <input type="email" class="form-control" id="floatingInput" name="email" placeholder="name@example.com">
                <label for="floatingInput">Adresse mail</label>
                </div>
                <div class="form-floating">
                <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Password">
                <label for="floatingPassword">Mot de passe</label>
                </div>

                <br>
                <button class="w-100 btn btn-lg btn-primary" type="submit" name="btnSingIn">Se connecter</button>
            </form>
            
            <!--crée le bouton pour retourner a la page d'accueil (revenir a la page précédente)-->
            <form method="post" action="#" id="login" style="margin-top: 2px">
                <button class="w-100 btn btn-lg btn-primary" type="submit" name="btnSingIn">crée une compte</button>
            </form>
        </main>
    </body>
    <?php
        }
        //sinon c'est qu'il est connecter donc qu'il veut se déconnecter
        else
        {
            //détruit la variable de session de si il est connecté
            unset($_SESSION["isConnected"]);
            //détruit la variable de session de son email
            unset($_SESSION["email"]);
            //détruit la variable de session de son mont de passe
            unset($_SESSION["password"]);
            //détruit la variable de session de si il est admin
            unset($_SESSION["isAdministrator"]);
            
            //redirige ver la page précédente
            header("Location:../../../");
            exit;
        }
    ?>

</html>