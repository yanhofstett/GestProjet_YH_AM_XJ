<?php
    /**
     * Auteur : Alexandre Montandon
     * Date : 07.01.2023
     * Description : Projet module 151 // permet de verifier si la création de l'utilisateur est accepter pour créer l'utilisateur dans la db
     */

    // inclue la page 'database'
    require_once("database.php");

    // inclue la page 'config'
    include_once("config.php");
    
    // Crée la session
    session_start();
    
    // Récupere dans un tableau toutes les informations sur les utilisateurs créer dans la db
    $allUser = Database::getInstance() -> getAllUsers();

    // Regarde que le bouton "Suite"
    if (isset($_POST["btnRegister"]))
    {
        #region vérife pour le Peudo
        // Crée une variable qui va dire si oui ou non la valeur entré pour le pseudo de l'utilisateur et correcte
        $usePseudoTrue = false;

        // Regarde si le pseudo à bien été entré
        if (empty(trim($_POST["pseudo"])))
        {
            // Redirige à la page de register avec un paramètre GET
            header('Location:register.php?msgCreateUser=RPAO');
        }
        else
        {
            // Change la valeur de usePseudoTrue en true car c'est vrai
            $usePseudoTrue = true;

            // Parcours tout les utilisateurs déjà créer dans la db
            foreach($allUser as $emailUser)
            {
                // Vérifie que le pseudo n'est pas encore utiliser dans la db
                if ($emailUser["usePseudo"] == trim($_POST["pseudo"]))
                {
                    // Change la valeur de usePseudoTrue en false car elle est déjà utilisé
                    $usePseudoTrue = false;

                    // Redirige à la page de register avec un paramètre GET
                    header('Location:register.php?msgCreateUser=RPAO');
                }
            }
        }
        #endregion

        #region vérife pour l'Email
        // Crée une variable qui va dire si oui ou non la valeur entré pour l'email de l'utilisateur et correcte
        $useEmailTrue = false;

        // Regarde si l'email à bien été entré et si c'est bien un adresse mail(verifie que cela ressemble a une adresse mail qui peut exister)
        if (preg_match("/^[\w\.]+@[\w]+.+[\w]{2,4}+$/", trim($_POST["email"])) && empty(trim($_POST["email"])) || !filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL))
        {
            // Redirige à la page de register avec un paramètre GET
            header('Location:register.php?msgCreateUser=REAO');
        }
        else
        {
            // Change la valeur de useEmailTrue en true car c'est vrai
            $useEmailTrue = true;

            // Parcours tout les utilisateurs déjà crées dans la db
            foreach($allUser as $emailUser)
            {
                // Vérifie que l'email n'est pas encore utilisé dans la db
                if ($emailUser["useLogin"] == trim($_POST["email"]))
                {
                    // Change la valeur de useEmailTrue en false car elle est déjà utilisée
                    $useEmailTrue = false;

                    // Redirige à la page de register avec un paramètre GET
                    header('Location:register.php?msgCreateUser=REAO');
                }
            }
        }
        #endregion

        #region vérife pour le mot de passe
        // Crée une variable qui va dire si oui ou non la valeur entré pour le mot de passe de l'utilisateur et correcte
        $usePasswordTrue = false;

        // Regarde si le mot de passe à bien été entré (ne compte pas les éspace avant ni après) et que c'est le meme sur les 2 champs de mot de passe
        if (preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+.{3,}$/", trim($_POST["password"])) && empty(trim($_POST["password"])) || trim($_POST["password"]) != trim($_POST["passwordVerif"]))
        {
            // Redirige à la page de register avec un paramètre GET
            header('Location:register.php?msgCreateUser=RPDM');
        }
        else
        {
            // Change la valeur de usePasswordTrue en true car c'est vrai
            $usePasswordTrue = true;
        }
        #endregion

        // Regarde si toutes les valeurs on bien été entré
        if ($usePseudoTrue == true && $useEmailTrue == true && $usePasswordTrue == true)
        {
            // Ajoute le nouvelle utilisateur dans la DB
            Database::getInstance()->register(trim($_POST["pseudo"]),trim($_POST["email"]), password_hash(trim($_POST["password"]), PASSWORD_DEFAULT));
            
            // Stoque les informations utiles à la connection dans des variables une session pour pouvoir l'utiliser pour se connecter tout de suite en créant un compte 
            $_SESSION["email"] = trim($_POST["email"]);

            // Stoque les informations utiles à la connection dans des variables une session pour pouvoir l'utiliser pour se connecter tout de suite en créant un compte 
            $_SESSION["pseudo"] = trim($_POST["pseudo"]);

            // Stoque les informations utiles à la connection dans des variables une session pour pouvoir l'utiliser pour se connecter tout de suite en créant un compte 
            $_SESSION["password"] = trim($_POST["password"]);

            // Stoque le bouton pour dire a la page de connection que le bouton a bien été appuyé
            $_SESSION["btnRegister"] = 1;

            // Redirige à la page de login avec un paramètre GET
            header("Location:login.php?msgCreateUser=CUC");
            exit;
        }
    }
    else
    {
        // Redirige à la page de login avec un paramètre GET
        header("Location:register.php?msgCreateUser=CUF");
        exit;
    }
?>