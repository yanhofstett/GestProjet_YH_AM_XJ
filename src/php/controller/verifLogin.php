<?PHP
    /*
    // Auteur : Alexandre Montandon, Xavier Jaquet, Yann Hofstetter
    // Date : 29.11.2022    
    // Description : Projet module 151 // Page pour chequez la connexion
    */

    // Commence la session
    session_start();

    // inclue la page 'database'
    require_once("../model/modelDB.php");

    // inclue la page 'config'
    include_once("../controller/config.php");

    // Detruire la variable de session pour s'assurer que la variable soir réinitialisé
    if(isset($_SESSION["status"]))
    {
        unset($_SESSION["status"]);
    }
    
    //appelle la méthode pour récupérer les info sur l'athlete
    $status = Database::getInstance()->getOneAthlete($_POST["email"]);

    //met la variable de session a 1 pour dire que c'est un athlete
    $_SESSION["status"] = 1;

    //regarde si la variable status est vide (donc que aucun athlete corresspond avec se mail)
    if (empty($status))
    {
        //met la variable de session a 2 pour dire que c'est un coach
        $_SESSION["status"] = 2;
    }
    var_dump($status);
    var_dump($_SESSION);


    // Regarde que le bouton "btnLogin" a bien été créer
    if(isset($_POST["btnLogin"]) || !isset($_POST["btnLogout"]))
    {
        // Si la variable de session n'est pas entrer et crée n'entre pas dans les crochets suivants
        if(!isset($_SESSION["isConnected"]) || !isset($_SESSION["userAthleteConnected"]) || !isset($_SESSION["userCoachConnected"]))
        {
            if(!empty($_POST["password"]))
            {
                if(!empty($_POST["email"]))
                {
                    var_dump($_SESSION["status"]);
                    echo ".";
                    if($_SESSION["status"] == 1)
                    {
                        // Va dans la page database.php pour aller éxecuté la requête avec son ou ses paramètres entrés
                        $connectAthlete = Database::getInstance()->connexionAthlete($_POST['email']);
                        
                        // Si la valeur de la variable qui contient la base de donnée est vide n'entre pas dans les crochets suivants
                        if (!empty($connectAthlete))
                        {
                            // Si le password et le hash sont les deux les mêmes et bien entre
                            if (password_verify($_POST["password"], $connectAthlete[0]["athPassword"]))
                            {
                                // Si le verificateur pour savoir si l'utilisateur qui veut se connecter est un admin ou un user est a 0 entre dans les crochets suivants
                                if($connectAthlete[0]["athIsAdministrator"] == 0)
                                {
                                    // Crée une variable de session is connected
                                    $_SESSION["isConnected"] = 1;
                                    
                                    // Crée la variable qui va dire qu'il est athlète
                                    $_SESSION["isAthlete"] = 1;
                                                
                                    // Crée la variable qui va garder le pseudo
                                    $_SESSION["surname"] = $connectAthlete[0]["athSurname"];
    
                                    // Crée la variable qui va garder le mail
                                    $_SESSION["email"] = $connectAthlete[0]["athEmail"];
    
                                    // Redirige à la page d'index avec un paramètre GET
                                    header('location:../../../index.php?msgConnexion=CCMU');
                                    
                                    // Quitter la page
                                    exit;
                                }
                                // Sinon si le verificateur pour savoir si l'utilisateur qui veut se connecter est un admin ou un user est a 1 entre dans les crochets suivants
                                else if($connectAthlete[0]["athIsAdministrator"] == 1)
                                {
                                    // Crée une variable de session is connected
                                    $_SESSION["isConnected"] = 1;

                                    // Crée la variable qui va dire qu'il est athlète
                                    $_SESSION["isAthlete"] = 1;

                                    // Crée la variable qui va dire qu'il est admin
                                    $_SESSION["adminConnected"] = 1;
    
                                    // Crée la variable qui va garder le pseudo
                                    $_SESSION["surname"] = $connectAthlete[0]["athSurname"];
    
                                    // Crée la variable qui va garder le mail
                                    $_SESSION["email"] = $connectAthlete[0]["athEmail"];
    
                                    // Redirige à la page d'index avec un paramètre GET
                                    header('location:../../../index.php?msgConnexion=CCMA');
                                    
                                    // Quitter la page
                                    exit;
                                }
                            }
                            // Sinon
                            else
                            {
                                // Redirige à la page de toutes les recettes avec un paramètre GET
                                header('location:../view/login.php?msgConnexion=CCEM');
                                
                                // Quitter la page
                                exit;
                            }
                        }
                        // Sinon
                        else
                        {
                            // Redirige à la page d'index avec un paramètre GET
                            header('location:../view/login.php?msgConnexion=CCEM');
    
                            // Quitter la page
                            exit;
                        }
                    }
                    else if ($_SESSION["status"] == 2)
                    {
                        // Va dans la page database.php pour aller éxecuté la requête avec son ou ses paramètres entrés
                        $connectCoach = Database::getInstance()->connexionCoach($_POST['email']);

                        //appelle la méthode pour récupérer les info sur le coach
                        $oneCoach = Database::getInstance()->getOneCoach($_POST["email"]);
                        var_dump($connectCoach);
                        // Si la valeur de la variable qui contient la base de donnée est vide n'entre pas dans les crochets suivants
                        if (!empty($connectCoach))
                        {
                            
                            // Si le password et le hash sont les deux les mêmes et bien entre
                            if (password_verify($_POST["password"], $connectCoach[0]["coaPassword"]))
                            {
                               
                                // Si le verificateur pour savoir si l'utilisateur qui veut se connecter est un admin ou un user est a 0 entre dans les crochets suivants
                                if($connectCoach[0]["coaIsAdministrator"] == 0)
                                {
                                    echo "T";
                                    // Crée une variable de session is connected
                                    $_SESSION["isConnected"] = 1;
                                    
                                    // Crée la variable qui va dire qu'il est un coach
                                    $_SESSION["isCoach"] = 1;
                                                
                                    // Crée la variable qui va garder le nom
                                    $_SESSION["Surname"] = $connectCoach[0]["coaSurname"];

                                    // Crée la variable qui va garder le mail
                                    $_SESSION["email"] = $connectCoach[0]["coaEmail"];

                                    // Redirige à la page d'index avec un paramètre GET
                                    header('location:../../../index.php?msgConnexion=CCMU');
                                    
                                    // Quitter la page
                                    exit;
                                }
                                // Sinon si le verificateur pour savoir si l'utilisateur qui veut se connecter est un admin ou un user est a 1 entre dans les crochets suivants
                                else if($connectCoach[0]["coaIsAdministrator"] == 1)
                                {
                                    // Crée une variable de session is connected
                                    $_SESSION["isConnected"] = 1;

                                    // Crée la variable qui va dire qu'il est un coach
                                    $_SESSION["isCoach"] = 1;

                                    // Crée la variable qui va dire qu'il est admin
                                    $_SESSION["adminConnected"] = 1;

                                    // Crée la variable qui va garder le pseudo
                                    $_SESSION["Surname"] = $connectCoach[0]["coaSurname"];

                                    // Crée la variable qui va garder le mail
                                    $_SESSION["email"] = $connectCoach[0]["coaEmail"];

                                    // Redirige à la page d'index avec un paramètre GET
                                    header('location:../../../index.php?msgConnexion=CCMA');
                                    
                                    // Quitter la page
                                    exit;
                                }
                            }
                            // Sinon
                            else
                            {
                                // Redirige à la page de toutes les recettes avec un paramètre GET
                                header('location:../view/login.php?msgConnexion=CCEM');
                                
                                // Quitter la page
                                exit;
                            }
                        }
                        // Sinon
                        else
                        {
                            // Redirige à la page d'index avec un paramètre GET
                            header('location:../view/login.php?msgConnexion=CCEM');
    
                            // Quitter la page
                            exit;
                        }
                    }
                }
                else
                {
                    // Redirige à la page de connexion avec un paramètre GET
                    header('location:../view/login.php?msgConnexion=LEM');

                    // Quitter la page
                    exit;
                }
            }
            else
            {
                // Redirige à la page de connexion avec un paramètre GET
                header('location:../view/login.php?msgConnexion=LPM');

                // Quitter la page
                exit;
            } 
        }
        // Sinon
        else
        {
            // Détruit la connexion
            session_destroy();
            
            // Redirige à la page d'index
            header('location:../view/login.php');

            // Quitter la page
            exit;
        }
    }
    // Sinon
    else
    {
        // Redirige à la page d'index
        header('location:../../../index.php');

        // Quitter la page
        exit;
    }
?>