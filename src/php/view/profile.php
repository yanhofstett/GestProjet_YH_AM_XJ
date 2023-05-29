<?php
/**
 * Auteur : Yann Hofstetter
 * Date : 16.12.2022
 * Description : page qui permet au personne admin d'avoir toutes les questions des utilisateurs et d'y répondre
 */

	#region tout les messages quand on a effectué quelque chose sur le site
    #region messages dans la page de toutes les recettes après avoir crée un compte
	// Si le GET à été entré
    if(isset($_GET['msgCreateUser']))
    {
        // Si le GET est égal à CUF
        if($_GET['msgCreateUser']=='CUF')
        {
            // Affiche le message d'erreur et que la modification n'a pas pu aboutir depuis le config.php
            echo CREATE_USER_FAILED;   
        }
		// Sinon si le GET est égal à CUF
		else if($_GET['msgCreateUser']=='RPAO')
		{
			// Affiche le message d'erreur et que la modification n'a pas pu aboutir depuis le config.php
			echo REGISTER_PSEUDO_ALREADY_ORNOT;    
		}
		// Sinon si le GET est égal à REF
		else if($_GET['msgCreateUser']=='REF')
		{
			// Affiche le message d'erreur et que la modification n'a pas pu aboutir depuis le config.php
			echo REGISTER_EMAIL_FAIL;    
		}
		// Sinon si le GET est égal à REAE
		else if($_GET['msgCreateUser']=='REAE')
		{
			// Affiche le message d'erreur et que la modification n'a pas pu aboutir depuis le config.php
			echo REGISTER_EMAIL_ALREADY_EXIST;    
		}
		// Sinon si le GET est égal à CUF
		else if($_GET['msgCreateUser']=='RPDM')
		{
			// Affiche le message d'erreur et que la modification n'a pas pu aboutir depuis le config.php
			echo REGISTER_PASSWORD_DOESNT_MATCH;    
		}		
		// Sinon si le GET est égal à RNAOT
		else if($_GET['msgCreateUser']=='RNAOT')
		{
			// Affiche le message d'erreur et que la modification n'a pas pu aboutir depuis le config.php
			echo REGISTER_NAME_ALREADY_ORNOT;   
		}
		// Sinon si le GET est égal à RSAOT
		else if($_GET['msgCreateUser']=='RSAOT')
		{
			// Affiche le message d'erreur et que la modification n'a pas pu aboutir depuis le config.php
			echo REGISTER_SURNAME_ALREADY_ORNOT;   
		}		
		// Sinon si le GET est égal à RPAOT
		else if($_GET['msgCreateUser']=='RPAOT')
		{
			// Affiche le message d'erreur et que la modification n'a pas pu aboutir depuis le config.php
			echo REGISTER_PHONE_ALREADY_ORNOT;    
		}		
		//  Sinon si l'utilisateur est un athlete
		else if(isset($_SESSION["isAthlete"]))
        {
            // Si le message GET dans l'url est égal à RTAOT
            if($_GET['msgCreateUser']=='RTAOT')
            {
                // Affiche le message d'erreur et que la modification n'a pas pu aboutir depuis le config.php
                echo REGISTER_TOWN_ALREADY_ORNOT;     
            }	
            // Sinon si le GET est égal à RNAOT
            else if($_GET['msgCreateUser']=='RNAOT')
            {
                // Affiche le message d'erreur et que la modification n'a pas pu aboutir depuis le config.php
                echo REGISTER_NPA_ALREADY_ORNOT;   
            }
        }	
        // Sinon si l'utilisateur est un coach
        else if(isset($_SESSION["isCoach"]))
        {
            // Si le GET est égal à REAOT
            if($_GET['msgCreateUser']=='REAOT')
            {
                // Affiche le message d'erreur et que la modification n'a pas pu aboutir depuis le config.php
                echo REGISTER_EX_ALREADY_ORNOT;     
            }
        }	
    }
	#endregion
	#endregion
    ?>
    <!doctype html>
    <html lang="fr">
      <head>
          <title style="font-style: italic;">Page de registration foire aux recettes</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="../../../resources/css/style-login.css">
        <link rel="stylesheet" href="../../../resources/css/style.css">
        <link rel="icon" type="image/x-icon" href="../../../resources/images/favicon.png">
        </head>
        <?php
    //regarde si c'est un Athlete qui est connecter ou si c'est un Coach
    if (isset($_SESSION["isAthlete"]))
    {
        //récupere dans un tableau toutes les informations sur un utilisateur de la db
        $user = Database::getInstance() -> getOneAthlete($_SESSION["email"]);
        
        //crée une variable de session pour le mot de passe
        $_SESSION["password"] = $user["athPassword"];
        ?>
            <body class="text-center">

                <form method="post" action="src/php/controller/verifProfile.php" enctype="multipart/form-data">
                    <input type="hidden" name="idUser" value="<?php echo $user["idAthlete"]?>">
                    
                    <div><label for="name">Nom: </label><br>
                    <input id="name" type="text" required class="addRecipes" name="name" value="<?php echo $user["athName"]?>"></div><br>
                    
                    <div><label for="surname">Prénom: </label><br>
                    <input id="surname" type="text" required class="addRecipes" name="surname" value="<?php echo $user["athSurname"]?>"></div><br>
                    
                    <div><label for="email">Email: </label><br>
                    <input id="email" type="text" required class="addRecipes" name="email" value="<?php echo $user["athEmail"]?>"></div><br>

                    <div><label for="phone">Numéro de téléphonne: </label><br>
                    <input id="phone" type="text" required class="addRecipes" name="phone" value="<?php echo $user["athPhone"]?>"></div><br>
                    
                    <div><label for="street">Rue: </label><br>
                    <input id="street" type="text" required class="addRecipes" name="street" value="<?php echo $user["athStreet"]?>"></div><br>
                    
                    <div><label for="town">Ville: </label><br>
                    <input id="town" type="text" required class="addRecipes" name="town" value="<?php echo $user["athTown"]?>"></div><br>
                    
                    <div><label for="NPA">NPA: </label><br>
                    <input id="NPA" type="text" required class="addRecipes" name="NPA" value="<?php echo $user["athNPA"]?>"></div><br>

                    <br><br>
                    <div>
                        <label for="usePassword">Mot de passe actuel : 
                            <p class = "textInfo" style="margin-bottom: 0rem;" >(si vous n'entré pas le bon mot de passe vous garderer votre ancien mot de passe)</p> 
                        </label>
                        <input id="oldPassword" type="password" style="width: 15%; margin-left:  42.5%;" class="addRecipes form-control" name="oldPassword">
                    </div><br>

                    <div>
                        <label for="usePassword">Nouveau mot de passe :</label>
                        <input id="newPassword" type="password" style="width: 15%; margin-left:  42.5%;" class="addRecipes form-control" name="newPassword">
                    </div><br>
                    
                    <div>
                        <label for="password">Verification mot de passe :
                            <p class = "textInfo" style="margin-bottom: 0rem;">(re-écrivez le nouveau mot de passe)</p> 
                        </label>
                        <br>
                        <input id="verifNewPassword" type="password" style="width: 15%; margin-left:  42.5%;" class="addRecipes form-control" name="verifNewPassword" >
                    </div>
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
        //récupere dans un tableau toutes les informations sur un utilisateur de la db
        $user = Database::getInstance() -> getOneCoach($_SESSION["email"]);
        
        //crée une variable de session pour le mot de passe
        $_SESSION["password"] = $user["coaPassword"];
        
        ?>
            <body class="text-center">

                <form method="post" action="src/php/controller/verifProfile.php" enctype="multipart/form-data">
                    <input type="hidden" name="idUser" value="<?php echo $user["idCoach"]?>">
                    
                    <div><label for="name">Nom: </label><br>
                    <input id="name" type="text" style="width: 15%; margin-left:  42.5%;" required class="addRecipes form-control" name="name" value="<?php echo $user["coaName"]?>"></div><br>
                    
                    <div><label for="surname">Prénom: </label><br>
                    <input id="surname" type="text" style="width: 15%; margin-left:  42.5%;" required class="addRecipes form-control" name="surname" value="<?php echo $user["coaSurname"]?>"></div><br>
                    
                    <div><label for="email">Email: </label><br>
                    <input id="email" type="text" style="width: 15%; margin-left:  42.5%;" required class="addRecipes form-control" name="email" value="<?php echo $user["coaEmail"]?>"></div><br>

                    <div><label for="phone">Numéro de téléphone: </label><br>
                    <input id="phone" type="text" style="width: 15%; margin-left:  42.5%;" required class="addRecipes form-control" name="phone" value="<?php echo $user["coaPhone"]?>"></div><br>
                    
                    <div><label for="experience">Experience: </label><br>
                    <input id="experience" type="text" style="width: 15%; margin-left:  42.5%;" required class="addRecipes form-control" name="experience" value="<?php echo $user["coaExperience"]?>"></div><br>
                    
                    <label for="downloadFile" id="coachSee">Image de vous :</label><br>
					<input type="file" style="width: 15%; margin-left:  42.5%;" class="form-control" name="downloadFile" id="downloadFile" value="choose">

                    <br><br>
                    <div>
                        <label for="usePassword">Mot de passe actuel : 
                            <p class = "textInfo" style="margin-bottom: 0rem;" >(si vous n'entré pas le bon mot de passe vous garderer votre ancien mot de passe)</p> 
                        </label>
                        <input id="oldPassword" type="password" style="width: 15%; margin-left:  42.5%;" class="addRecipes form-control" name="oldPassword">
                    </div><br>

                    <div>
                        <label for="usePassword">Nouveau mot de passe :</label>
                        <input id="newpassword" type="password" style="width: 15%; margin-left:  42.5%;" class="addRecipes form-control" name="newPassword">
                    </div><br>
                    
                    <div>
                        <label for="password">Verification mot de passe :
                            <p class = "textInfo" style="margin-bottom: 0rem;">(re-écrivez le nouveau mot de passe)</p> 
                        </label>
                        <br>
                        <input id="verifNewPassword" type="password" style="width: 15%; margin-left:  42.5%;" class="addRecipes form-control" name="verifNewPassword" >
                    </div>
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

?>
