<?PHP
    /*
    // Auteur : Alexandre Montandon, Xavier Jaquet, Yann Hofstetter
    // Date : 29.11.2022    
    // Description : Projet module 151 // Page pour chequez la connexion
    */

    // Commence la session
    session_start();

    // inclue la page 'config'
    include_once("config.php");

    // inclue la page 'database'
    require_once("database.php");

    // Regarde que le bouton "btnLogin" a bien été créer
    if (isset($_POST["btnLogin"]) || isset($_POST["btnLogout"]))
    {
        // Si la variable de session n'est pas entrer et crée n'entre pas dans les crochets suivants
        if (!isset($_SESSION["isConnected"]))
        {
            if(!empty($_POST["password"]))
            {
                if(!empty($_POST["email"]))
                {
                    // Va dans la page database.php pour aller éxecuté la requête avec son ou ses paramètres entrés
                    $user = Database::getInstance()->connexion($_POST['email']);
                    
                    // Si la valeur de la variable qui contient la base de donnée est vide n'entre pas dans les crochets suivants
                    if (!empty($user))
                    {
                        // Si le password et le hash sont les deux les mêmes et bien entre
                        if (password_verify($_POST["password"], $user[0]["usePassword"]))
                        {
                            // Si le verificateur pour savoir si l'utilisateur qui veut se connecter est un admin ou un user est a 0 entre dans les crochets suivants
                            if($user[0]["useAdministrator"] == 0)
                            {
                                // Crée une variable de session is connected
                                $_SESSION["isConnected"] = 1;
                                
                                // Crée la variable qui va dire qu'il est admin
                                $_SESSION["userConnected"] = 1;
                                            
                                // Crée la variable qui va garder le pseudo
                                $_SESSION["pseudo"] = $user[0]["usePseudo"];

                                // Crée la variable qui va garder le mail
                                $_SESSION["mail"] = $user[0]["useLogin"];

                                // Si le GET à été entré
                                if(isset($_SESSION["backToAllRecipes"]))
                                {
                                    // Redirige à la page de toutes les recettes avec un paramètre GET
                                    header('location:allRecipes.php?msgConnexion=CCMU');
                                }
                                // Sinon si le GET à été entré
                                else if(isset($_SESSION["backToIndex"]))
                                {
                                    // Redirige à la page d'index avec un paramètre GET
                                    header('location:../../index.php?msgConnexion=CCMU');
                                }

                                // Quitter la page
                                exit;
                            }
                            // Sinon si le verificateur pour savoir si l'utilisateur qui veut se connecter est un admin ou un user est a 1 entre dans les crochets suivants
                            else if($user[0]["useAdministrator"] == 1)
                            {
                                // Crée une variable de session is connected
                                $_SESSION["isConnected"] = 1;

                                // Crée la variable qui va dire qu'il est admin
                                $_SESSION["adminConnected"] = 1;

                                // Crée la variable qui va garder le pseudo
                                $_SESSION["pseudo"] = $user[0]["usePseudo"];

                                // Crée la variable qui va garder le mail
                                $_SESSION["mail"] = $user[0]["useLogin"];

                                // Si le GET à été entré
                                if(isset($_SESSION["backToAllRecipes"]))
                                {
                                    // Redirige à la page de toutes les recettes avec un paramètre GET
                                    header('location:allRecipes.php?msgConnexion=CCMA');
                                }
                                // Sinon si le GET à été entré
                                else if(isset($_SESSION["backToIndex"]))
                                {
                                    // Redirige à la page d'index avec un paramètre GET
                                    header('location:../../index.php?msgConnexion=CCMA');
                                }

                                // Quitter la page
                                exit;
                            }
                        }
                        // Sinon
                        else
                        {
                            // Si le GET à été entré
                            if(isset($_SESSION["backToAllRecipes"]))
                            {
                                // Redirige à la page index avec un paramètre GET
                                header('location:allRecipes.php?msgConnexion=CCEM');
                            }
                            // Sinon si le GET à été entré
                            else if(isset($_SESSION["backToIndex"]))
                            {
                                // Redirige à la page de toutes les recettes avec un paramètre GET
                                header('location:../../index.php?msgConnexion=CCEM');
                            }

                            // Quitter la page
                            exit;
                        }
                    }
                    // Sinon
                    else
                    {
                        // Si le GET à été entré
                        if(isset($_SESSION["backToAllRecipes"]))
                        {
                            // Redirige à la page de toutes les recettes avec un paramètre GET
                            header('location:allRecipes.php?msgConnexion=CCEM');
                        }
                        // Sinon si le GET à été entré
                        else if(isset($_SESSION["backToIndex"]))
                        {
                            // Redirige à la page d'index avec un paramètre GET
                            header('location:../../index.php?msgConnexion=CCEM');
                        }

                        // Quitter la page
                        exit;
                    }
                }
                else
                {
                    // Redirige à la page de toutes les recettes avec un paramètre GET
                    header('location:login.php?msgConnexion=LEM');

                    // Quitter la page
                    exit;
                }
            }
            else
            {
                // Redirige à la page de toutes les recettes avec un paramètre GET
                header('location:login.php?msgConnexion=LPM');

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
            header('location:../../index.php');

            // Quitter la page
            exit;
        }
    }
    // Sinon
    else
    {
        // Redirige à la page d'index
        header('location:../../index.php');

        // Quitter la page
        exit;
    }
?>