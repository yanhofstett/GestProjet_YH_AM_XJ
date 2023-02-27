    <!---
    Auteur : Alexandre Montandon
    Date : 29.11.2022    
    Description : Projet module 151 // Page de connection
    --->
<?php
    // inclue la page 'database'
    require_once("../model/modelDB.php");

    // inclue la page 'config'
    include_once("../controller/config.php");

	// Crée la session
	session_start();

	#region Code pour la création des varibles pour le retour en arrière
    // Si le GET à été entré
    if(isset($_GET['backInfo']))
    {
        // Si le GET est égal à BCTAR
        if($_GET['backInfo']=='BCTAR')
        {
            // Désactive la variable pour retourner en arrière sur la page d'index
            unset($_SESSION["backToIndex"]);

            // Crée la variable de session pour retourner en arrière sur la page de toutes les recettes
            $_SESSION["backToAllRecipes"] = 1;
        }
        // Sinon si le GET est égal à BCTI
        else if($_GET['backInfo']=='BCTI')
        {
            // Désactiver la variable pour retourner en arrière sur la page de toutes les recettes
            unset($_SESSION["backToAllRecipes"]);

            // Crée la variable de session pour retourner en arrière sur la page d'index
            $_SESSION["backToIndex"] = 1;
        }
    }
    #endregion

	#region tout les messages quand on a effectué quelque chose sur le site
    #region messages dans la page de toutes les recettes après avoir crée un compte
	// Si le GET à été entré
    if(isset($_GET['msgCreateUser']))
    {
        // Si le GET est égal à CUC
        if($_GET['msgCreateUser']=='CUC')
        {
            // Afficher le message que la modification a réussi depuis le config.php
            echo CREATE_USER_CORRECT;
            ?>
            <!-- Script Javascript -->
            <script>
                //Crée un timeout qui va s'écouler avant de faire myFunction
                setTimeout(myFunction, 4000);

                // Création d'une fonction
                function myFunction()
                {    
                    // Redirige vers la page de login
                    location.href="login.php";
                }
            // Fin du script
            </script>

            <!-- Ouvre le php -->
            <?php   
        }
    }
    // Si le GET à été entré
    else if(isset($_GET['msgConnexion']))
    {
        // Si le GET est égal à CUC
        if($_GET['msgConnexion']=='LEM')
        {
            // Afficher le message que la modification a réussi depuis le config.php
            echo LOGIN_EMAIL_MISSING;
            ?>
            <!-- Script Javascript -->
            <script>
                //Crée un timeout qui va s'écouler avant de faire myFunction
                setTimeout(myFunction, 4000);

                // Création d'une fonction
                function myFunction()
                {    
                    // Redirige vers la page de login
                    location.href="login.php";
                }
            // Fin du script
            </script>

            <!-- Ouvre le php -->
            <?php   
        }
        // Si le GET est égal à CUC
        else if($_GET['msgConnexion']=='LPM')
        {
            // Afficher le message que la modification a réussi depuis le config.php
            echo LOGIN_PASSWORD_MISSING;
            ?>
            <!-- Script Javascript -->
            <script>
                //Crée un timeout qui va s'écouler avant de faire myFunction
                setTimeout(myFunction, 4000);

                // Création d'une fonction
                function myFunction()
                {    
                    // Redirige vers la page de login
                    location.href="login.php";
                }
            // Fin du script
            </script>

            <!-- Ouvre le php -->
            <?php   
        }
    }
	#endregion

    
	#endregion

?>
<!doctype html>
<html lang="fr">
  <head>
  	<title style="font-style: italic;">Page de connexion foire aux recettes</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="../../../resources/css/style-login.css">
	<link rel="stylesheet" href="../../../resources/css/style.css">
	<link rel="icon" type="image/x-icon" href="../../../resources/images/favicon.png">
	</head>
	<header>
	</header>
	<body class="img js-fullheight" style="background-image: url(../../../resources/images/???);">
		<section class="ftco-section">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-md-6 col-lg-4">
						<div class="login-wrap p-0">
							<h3 class="mb-4 text-center">Connectez-vous!</h3>
							<form action="../controller/verifLogin.php" method="post" class="login-form">
								<div class="form-group">
									<input type="text" class="form-control" placeholder="Email" name="email" required>
								</div>
								<div class="form-group">
									<input id="password-field" type="password" name="password" class="form-control" placeholder="Mot de passe" required>
									<span toggle="#password-field" class="fa fa-fw field-icon toggle-password"></span>
								</div>
								<div class="form-group">
									<button type="submit" name="btnLogin" class="form-control btn btn-primary submit px-3">se Connecter</button>
									<a class="loginRegisterAnswer" href="register.php">Pas de compte ?</a>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</section>
	</body>
	<script src="../../js/jquery.min.js"></script>
	<script src="../../js/popper.js"></script>
	<script src="../../js/bootstrap.min.js"></script>
	<script src="../../js/main.js"></script>
</html>

