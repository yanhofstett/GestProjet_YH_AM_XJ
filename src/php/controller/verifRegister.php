<?php
    /**
     * Auteur : Alexandre Montandon
     * Date : 07.01.2023
     * Description : Projet module 151 // permet de verifier si la création de l'utilisateur est accepter pour créer l'utilisateur dans la db
     */

    // inclue la page 'database'
    require_once("../model/modelDB.php");

    // inclue la page 'config'
    include_once("../controller/config.php");

    // Crée la session
    session_start();
    
    // Récupere dans un tableau toutes les informations sur les athletes créer dans la db
    $allUsers = Database::getInstance() -> getAllUsers();

    #region Création des variables pour savoir si c'est l'athlète qui viens ou le coach
    // Regarde que le bouton "Suite"
    if (isset($_POST["btnRegisterAthlete"]) || isset($_POST["btnRegisterCoach"]))
    {
        $registerAthlete = 0;
        $registerCoach = 0;
        
        // Si l'utilisateur a choisi de se connecter en tant qu'athlète
        if(isset($_POST["btnRegisterAthlete"]))
        {
            // Crée une variable pour après dire que nous retournons sur la page de registration de l'athlète
            $registerAthlete = 1;
        }
        // Sinon 
        else if (isset($_POST["btnRegisterCoach"]))
        {
            // Crée une variable pour après dire que nous retournons sur la page de registration du coach
            $registerCoach = 1;
        }
        #endregion

        #region Regex
        #region vérife pour l'Email
        // Crée une variable qui va dire si oui ou non la valeur entré pour l'email de l'utilisateur et correcte
        $useEmailTrue = false;

        // Regarde si l'email à bien été entré et si c'est bien un adresse mail(verifie que cela ressemble a une adresse mail qui peut exister)
        if (preg_match("/^[\w\.]+@[\w]+.+[\w]{2,4}+$/", trim($_POST["email"])) && empty(trim($_POST["email"])) || !filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL))
        {
            if($registerAthlete == 1)
            {
                // Redirige à la page de login avec un paramètre GET
                header("Location:../view/registerAthlete.php?msgCreateUser=REAO");
                exit;
            }
            else if($registerCoach == 1)
            {
                // Redirige à la page de login avec un paramètre GET
                header("Location:../view/registerCoach.php?msgCreateUser=REAO");
                exit;
            }
        }
        else
        {
            // Change la valeur de useEmailTrue en true car c'est vrai
            $useEmailTrue = true;

            // Parcours tout les utilisateurs déjà crées dans la db
            foreach($allUsers as $emailUsers)
            {
                // Vérifie que l'email n'est pas encore utilisé dans la db
                if ($emailUsers["athEmail"] == trim($_POST["email"]))
                {
                    // Change la valeur de useEmailTrue en false car elle est déjà utilisée
                    $useEmailTrue = false;

                    if($registerAthlete == 1)
                    {
                        // Redirige à la page de login avec un paramètre GET
                        header("Location:../view/registerAthlete.php?msgCreateUser=REAE");
                        exit;
                    }
                    else if($registerCoach == 1)
                    {
                        // Redirige à la page de login avec un paramètre GET
                        header("Location:../view/registerCoach.php?msgCreateUser=REAE");
                        exit;
                    }
                }
            }
        }
        #endregion

        #region vérife pour le mot de passe
        // Crée une variable qui va dire si oui ou non la valeur entré pour le mot de passe de l'utilisateur et correcte
        $usePasswordTrue = false;

        // Si le mot de passe à bien été entré (ne compte pas les éspace avant ni après) et que c'est le meme sur les 2 champs de mot de passe
        if (preg_match("/^(?=.*[a-z])(?=.*[+¦@#*°ç§%¬&|¢()ø=?^~$!{},.-])(?=.*[A-Z])(?=.*\d)[^\s]{12,32}$/", trim($_POST["password"])) && empty(trim($_POST["password"])) || trim($_POST["password"]) != trim($_POST["passwordVerif"]))
        {
            if($registerAthlete == 1)
            {
                // Redirige à la page de login avec un paramètre GET
                header("Location:../view/registerAthlete.php?msgCreateUser=RPDM");
                exit;
            }
            else if($registerCoach == 1)
            {
                // Redirige à la page de login avec un paramètre GET
                header("Location:../view/registerCoach.php?msgCreateUser=RPDM");
                exit;
            }
        }
        else
        {
            // Change la valeur de usePasswordTrue en true car c'est vrai
            $usePasswordTrue = true;
        }
        #endregion

        #region vérife pour le reste
        // Crée une variable qui va dire si oui ou non la valeur est entré pour le nom de l'utilisateur et correcte
        $useName = false;

        // Regarde si le nom est conforme
        if (!preg_match("/^[éèüäöøà'êâça-zA-Z]{0,50}+$/", trim($_POST["name"])) || empty(trim($_POST["name"])))
        {
            if($registerAthlete == 1)
            {
                // Redirige à la page de login avec un paramètre GET
                header("Location:../view/registerAthlete.php?msgCreateUser=RNAOT");
                exit;
            }
            else if($registerCoach == 1)
            {
                // Redirige à la page de login avec un paramètre GET
                header("Location:../view/registerCoach.php?msgCreateUser=RNAOT");
                exit;
            }
        }
        else
        {
            // Vu que le test c'est bien passer dit que la variable est vrai
            $useName = true;

            // Crée une variable qui va dire si oui ou non la valeur est entré pour le prénom de l'utilisateur et correcte
            $useSurname = false;
        
            // Regarde si le prénom est conforme
            if (!preg_match("/^[éèüäöøà'êâça-zA-Z]{0,50}+$/", trim($_POST["surname"])) || empty(trim($_POST["surname"])))
            {
                if($registerAthlete == 1)
                {
                    // Redirige à la page de login avec un paramètre GET
                    header("Location:../view/registerAthlete.php?msgCreateUser=RSAOT");
                    exit;
                }
                else if($registerCoach == 1)
                {
                    // Redirige à la page de login avec un paramètre GET
                    header("Location:../view/registerCoach.php?msgCreateUser=RSAOT");
                    exit;
                }
            }
            else
            {        
                // Vu que le test c'est bien passer dit que la variable est vrai
                $useSurname = true;

                // Crée une variable qui va dire si oui ou non la valeur est entré pour le téléphone de l'utilisateur et correcte
                $usePhone = false;

                // Regarde si le téléphone est conforme
                if(!preg_match("/^(\+?)(\d{2,4})(\s?)(\-?)((\(0\))?)(\s?)(\d{2})(\s?)(\-?)(\d{3})(\s?)(\-?)(\d{2})(\s?)(\-?)(\d{2})/", trim($_POST["phone"])) && !preg_match("/^\d{3}\s\d{3}\s\d{2}\s\d{2}$/", trim($_POST["phone"])) || empty(trim($_POST["phone"])))
                {
                    if($registerAthlete == 1)
                    {
                        // Redirige à la page de login avec un paramètre GET
                        header("Location:../view/registerAthlete.php?msgCreateUser=RPAOT");
                        exit;
                    }
                    else if($registerCoach == 1)
                    {
                        // Redirige à la page de login avec un paramètre GET
                        header("Location:../view/registerCoach.php?msgCreateUser=RPAOT");
                        exit;
                    }
                }
                else
                {      
                    // Vu que le test c'est bien passer dit que la variable est vrai
                    $usePhone = true;

                    if($registerAthlete == 1)
                    {
                        // Crée une variable qui va dire si oui ou non la valeur est entré pour la ville de l'utilisateur et correcte
                        $useTown = false;

                        // Regarde si la ville est conforme
                        if (!preg_match("/^[éèüäöøà'êâça-zA-Z]{0,100}+$/", trim($_POST["town"])) || empty(trim($_POST["town"])))
                        {
                            if($registerAthlete == 1)
                            {
                                
                                // Redirige à la page de login avec un paramètre GET
                                header("Location:../view/registerAthlete.php?msgCreateUser=RTAOT");
                                exit;
                            }
                            else if($registerCoach == 1)
                            {
                                // Redirige à la page de login avec un paramètre GET
                                header("Location:../view/registerCoach.php?msgCreateUser=RATOT");
                                exit;
                            }
                        }
                        else
                        {
                            // Vu que le test c'est bien passer dit que la variable est vrai
                            $useTown = true;

                            // Crée une variable qui va dire si oui ou non la valeur est entré pour le code postal de l'utilisateur et correcte
                            $useNPA = false;

                            // Regarde si le code postal est conforme
                            if (!preg_match("/^[0-9]{0,6}+$/", trim($_POST["NPA"])) || empty(trim($_POST["NPA"])))
                            {
                                if($registerAthlete == 1)
                                {
                                    // Redirige à la page de login avec un paramètre GET
                                    header("Location:../view/registerAthlete.php?msgCreateUser=RPNOT");
                                    exit;
                                }
                                else if($registerCoach == 1)
                                {
                                    // Redirige à la page de login avec un paramètre GET
                                    header("Location:../view/registerCoach.php?msgCreateUser=RPNOT");
                                    exit;
                                }
                            }
                            else
                            {
                                // Vu que le test c'est bien passer dit que la variable est vrai
                                $useNPA = true;
                            }
                        }
                    }
                    else if($registerCoach == 1)
                    {
                        // Crée une variable qui va dire si oui ou non la valeur est entré pour l'experience de l'utilisateur et correcte
                        $useExperience = false;

                        if (!preg_match("/^[éèà'êâça-zA-Z\s]{0,1000}+$/", trim($_POST["experience"])) || empty(trim($_POST["experience"])))
                        {
                            if($registerAthlete == 1)
                            {
                                // Redirige à la page de login avec un paramètre GET
                                header("Location:../view/registerAthlete.php?msgCreateUser=REAOT");
                                exit;
                            }
                            else if($registerCoach == 1)
                            {
                                // Redirige à la page de login avec un paramètre GET
                                header("Location:../view/registerCoach.php?msgCreateUser=REAOT");
                                exit;
                            }
                        }
                        else
                        {
                            $useExperience = true;
                        }
                    }
                }
            }   
        }

        // Change la valeur de usePasswordTrue en true car c'est vrai
        $usePasswordTuseNamerue = true;
        #endregion
        
        #endregion

        // Regarde si toutes les valeurs on bien été entré
        if ($useEmailTrue == true && $usePasswordTrue == true && $useName == true && $useSurname == true && $usePhone == true)
        {
            #region Pour athlète
            if(isset($_POST["btnRegisterAthlete"]))
            {
                echo "A";
                if($useTown == true && $useNPA == true)
                {
                    // Ajoute le nouvelle utilisateur dans la DB
                    Database::getInstance()->registerAthlete(trim($_POST['name']), trim($_POST['surname']), trim($_POST['email']), password_hash(trim($_POST["password"]), PASSWORD_DEFAULT), trim($_POST['phone']), trim($_POST['town']), trim($_POST['NPA']));

                    // Stoque les informations utiles à la connection dans des variables une session pour pouvoir l'utiliser pour se connecter tout de suite en créant un compte 
                    $_SESSION["email"] = trim($_POST["email"]);

                    // Stoque le bouton pour dire a la page de connection que le bouton a bien été appuyé
                    $_SESSION["btnRegisterAthlete"] = 1;

                    // Redirige à la page de login avec un paramètre GET
                    header("Location:../view/login.php?msgCreateUser=CUC");
        
                    // Quitte la page
                    exit;
                }
                else
                {
                    if($registerAthlete == 1)
                    {
                        // Redirige à la page de login avec un paramètre GET
                        header("Location:../view/registerAthlete.php?msgCreateUser=CUF");
                        exit;
                    }
                    else if($registerCoach == 1)
                    {
                        // Redirige à la page de login avec un paramètre GET
                        header("Location:../view/registerCoach.php?msgCreateUser=CUF");
                        exit;
                    }
                }
                
            }
            #endregion
            #region pour coach
            // Sinon si le bouton de la page de registration du coach est entré
            else if(isset($_POST["btnRegisterCoach"]))
            {
                if($useExperience == true)
                {
                    var_dump($_FILES["downloadFile"]);

                    // Mettre la source de l'envoie
                    $sourceCover=$_FILES["downloadFile"]["tmp_name"];

                    // La destination de chemin
                    $destinationCover="../../../userContent/images/" . date("YmdHis") . $_FILES["downloadFile"]["name"];

                    // Si une image à été selectionnée
                    if(isset($_FILES["downloadFile"]))
                    {

                        // Envoie l'image et si l'envoie c'est bien passé
                        if(move_uploaded_file($sourceCover,$destinationCover))
                        {
                            // Ajoute le nouvelle utilisateur dans la DB
                            Database::getInstance()->registerCoach(trim($_POST['name']), trim($_POST['surname']), trim($_POST['email']), password_hash(trim($_POST["password"]), PASSWORD_DEFAULT), trim($_POST['phone']), trim($_POST['experience']), date("YmdHis") . $_FILES["downloadFile"]["name"]);
                        }
                    }
                    // Sinon
                    else
                    {
                        // Ajoute le nouvelle utilisateur dans la DB
                        Database::getInstance()->registerCoach(trim($_POST['name']), trim($_POST['surname']), trim($_POST['email']), password_hash(trim($_POST["password"]), PASSWORD_DEFAULT), trim($_POST['phone']), trim($_POST['experience']), 'no_picture.png');
                    }
                    // Stoque les informations utiles à la connection dans des variables une session pour pouvoir l'utiliser pour se connecter tout de suite en créant un compte 
                    $_SESSION["email"] = trim($_POST["email"]);

                    // Stoque le bouton pour dire a la page de connection que le bouton a bien été appuyé
                    $_SESSION["btnRegisterCoach"] = 1;

                    // Redirige à la page de login avec un paramètre GET
                    header("Location:../view/login.php?msgCreateUser=CUC");
                    exit;
                }
                else
                {
                    if($registerAthlete == 1)
                    {
                        // Redirige à la page de login avec un paramètre GET
                        header("Location:../view/registerAthlete.php?msgCreateUser=CUF");
                        exit;
                    }
                    else if($registerCoach == 1)
                    {
                        // Redirige à la page de login avec un paramètre GET
                        header("Location:../view/registerCoach.php?msgCreateUser=CUF");
                        exit;
                    }
                }
            }
            #endregion
        }
    }
    // Sinon
    else
    {
        if($registerAthlete == 1)
        {
            // Redirige à la page de login avec un paramètre GET
            header("Location:../view/registerAthlete.php?msgCreateUser=CUF");
            exit;
        }
        else if($registerCoach == 1)
        {
            // Redirige à la page de login avec un paramètre GET
            header("Location:../view/registerCoach.php?msgCreateUser=CUF");
            exit;
        }
    }
?>