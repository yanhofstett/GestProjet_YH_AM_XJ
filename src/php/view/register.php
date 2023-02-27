<?php
    // inclue la page 'database'
    require_once("../model/modelDB.php");

    // inclue la page 'config'
    include_once("../controller/config.php");

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
            
            ?>
            <!-- Script Javascript -->
            <script>
                //Crée un timeout qui va s'écouler avant de faire myFunction
                setTimeout(myFunction, 10000);

                // Création d'une fonction
                function myFunction()
                {    
                    // Redirige vers la page de register
                    location.href="register.php";
                }
            // Fin du script
            </script>

            <!-- Ouvre le php -->
            <?php      
        }
		// Sinon si le GET est égal à CUF
		else if($_GET['msgCreateUser']=='RPAO')
		{
			// Affiche le message d'erreur et que la modification n'a pas pu aboutir depuis le config.php
			echo REGISTER_PSEUDO_ALREADY_ORNOT;
			
			?>
			<!-- Script Javascript -->
			<script>
				//Crée un timeout qui va s'écouler avant de faire myFunction
				setTimeout(myFunction, 10000);

				// Création d'une fonction
				function myFunction()
				{    
					// Redirige vers la page de register
					location.href="register.php";
				}
			// Fin du script
			</script>

			<!-- Ouvre le php -->
			<?php      
		}
		// Sinon si le GET est égal à CUF
		else if($_GET['msgCreateUser']=='REAO')
		{
			// Affiche le message d'erreur et que la modification n'a pas pu aboutir depuis le config.php
			echo REGISTER_EMAIL_ALREADY_ORNOT;
			?>
			<!-- Script Javascript -->
			<script>
				//Crée un timeout qui va s'écouler avant de faire myFunction
				setTimeout(myFunction, 10000);

				// Création d'une fonction
				function myFunction()
				{    
					// Redirige vers la page de register
					location.href="register.php";
				}
			// Fin du script
			</script>

			<!-- Ouvre le php -->
			<?php      
		}
		// Sinon si le GET est égal à CUF
		else if($_GET['msgCreateUser']=='RPDM')
		{
			// Affiche le message d'erreur et que la modification n'a pas pu aboutir depuis le config.php
			echo REGISTER_PASSWORD_DOESNT_MATCH;
			?>
			<!-- Script Javascript -->
			<script>
				//Crée un timeout qui va s'écouler avant de faire myFunction
				setTimeout(myFunction, 10000);

				// Création d'une fonction
				function myFunction()
				{    
					// Redirige vers la page de register
					location.href="register.php";
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
  	<title style="font-style: italic;">Page de registration foire aux recettes</title>
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
	<body class="img js-fullheight" style="background-image: url(../../../resources/images/????); height: 969px;">
		<section class="ftco-section">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-md-6 col-lg-4">
						<div class="login-wrap p-0">
							<h3 class="mb-4 text-center">Enregistrez-vous!</h3>
							<form action="checkRegister.php" method="post" class="signin-form">
								<div class="form-group">
									<input type="text" class="form-control" placeholder="Entrez un nouveau pseudo" name="pseudo" required>
								</div>
								<div class="form-group">
									<input type="email" class="form-control" placeholder="Entrez votre e-mail" name="email" required>
								</div>
								<div class="form-group">
									<input id="password-field" type="password" name="password" class="form-control" placeholder="Entrez votre mot de passe" required>
									<span toggle="#password-field" class="fa fa-fw field-icon toggle-password"></span>
								</div>
								<div class="form-group">
									<input id="password-field" type="password" name="passwordVerif" class="form-control" placeholder="Repetez le mot de passe" required>
									<span toggle="#password-field" class="fa fa-fw field-icon toggle-password"></span>
								</div>
								<div class="form-group">
									<button type="submit" name="btnRegister" class="form-control btn btn-primary submit px-3">s'enregistrer</button>
									<a class="loginRegisterAnswer" href="login.php">Déjà un compte ?</a>
								</div>
								<div class="form-group d-md-flex">
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</section>
	</body>
	<script src="../js/jquery.min.js"></script>
	<script src="../js/popper.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<script src="../js/main.js"></script>
</html>

