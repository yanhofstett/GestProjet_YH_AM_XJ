<?php
/**
 * Auteur : Yann Hofstetter
 * Date : 16.12.2022
 * Description : page qui permet au personne admin d'avoir toutes les questions des utilisateurs et d'y répondre
 */

    //regarde si c'est un Athlete qui est connecter ou si c'est un Coach
    if (isset($_SESSION["isAthlete"]))
    {
        //récupere dans un tableau toutes les informations sur un utilisateur de la db
        $user = Database::getInstance() -> getOneAthlete($_SESSION["email"]);
        
        //crée une variable de session pour le mot de passe
        $_SESSION["password"] = $user["athPassword"];
        ?>
            <body class="text-center">

                <form method="post" action="src/php/controller/verifProfile.php">
                    <input type="hidden" name="idUser" value="<?php echo $user["idAthlete"]?>">
                    
                    <div><label for="email">Nom: </label><br>
                    <input id="name" type="text" required class="addRecipes" name="name" value="<?php echo $user["athName"]?>"></div><br>
                    
                    <div><label for="email">Prénom: </label><br>
                    <input id="surname" type="text" required class="addRecipes" name="surname" value="<?php echo $user["athSurname"]?>"></div><br>
                    
                    <div><label for="email">Email: </label><br>
                    <input id="email" type="text" required class="addRecipes" name="email" value="<?php echo $user["athEmail"]?>"></div><br>

                    <div><label for="email">Numéro de téléphonne: </label><br>
                    <input id="phone" type="text" required class="addRecipes" name="phone" value="<?php echo $user["athPhone"]?>"></div><br>
                    
                    <div><label for="email">Rue: </label><br>
                    <input id="street" type="text" required class="addRecipes" name="street" value="<?php echo $user["athStreet"]?>"></div><br>
                    
                    <div><label for="email">Ville: </label><br>
                    <input id="town" type="text" required class="addRecipes" name="town" value="<?php echo $user["athTown"]?>"></div><br>
                    
                    <div><label for="email">NPA: </label><br>
                    <input id="NPA" type="text" required class="addRecipes" name="NPA" value="<?php echo $user["athNPA"]?>"></div><br>
                    

                    <div><label for="usePassword">Mot de passe : 
                    <br>
                    <p class = "textInfo">(si vous n'entré pas de mot de passe vous garderer votre ancien mot de passe)</p> </label><br>
                    <input id="password" type="password" class="addRecipes" name="password"></div>
                    
                    <div><label for="password">Verification mot de passe :
                    <br>
                    <p class = "textInfo">(si vous n'entré pas de mot de passe vous garderer votre ancien mot de passe)</p> </label><br>
                    <input id="verifPassword" type="password" class="addRecipes" name="verifPassword" ></div><br>
                    
                    <br><br>
                    <input type="submit" name="btnSave" value="Sauvegarder">
                </form>
                <!--crée le bouton pour annuler (revenir a la page de match)-->
                <form method="post" action="./index.php">
                    <input type="submit" name="btnCancel" value="Annuler">
                </form>
            </body>

        <?php
    }
    else
    {
        
    }

?>
