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
                    location.href="registerAthlete.php";
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
					location.href="registerAthlete.php";
				}
			// Fin du script
			</script>

			<!-- Ouvre le php -->
			<?php      
		}
		// Sinon si le GET est égal à REF
		else if($_GET['msgCreateUser']=='REF')
		{
			// Affiche le message d'erreur et que la modification n'a pas pu aboutir depuis le config.php
			echo REGISTER_EMAIL_FAIL;
			?>
			<!-- Script Javascript -->
			<script>
				//Crée un timeout qui va s'écouler avant de faire myFunction
				setTimeout(myFunction, 10000);

				// Création d'une fonction
				function myFunction()
				{    
					// Redirige vers la page de register
					location.href="registerAthlete.php";
				}
			// Fin du script
			</script>

			<!-- Ouvre le php -->
			<?php      
		}
		// Sinon si le GET est égal à REAE
		else if($_GET['msgCreateUser']=='REAE')
		{
			// Affiche le message d'erreur et que la modification n'a pas pu aboutir depuis le config.php
			echo REGISTER_EMAIL_ALREADY_EXIST;
			?>
			<!-- Script Javascript -->
			<script>
				//Crée un timeout qui va s'écouler avant de faire myFunction
				setTimeout(myFunction, 10000);

				// Création d'une fonction
				function myFunction()
				{    
					// Redirige vers la page de register
					location.href="registerAthlete.php";
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
					location.href="registerAthlete.php";
				}
			// Fin du script
			</script>

			<!-- Ouvre le php -->
			<?php      
		}		
		// Sinon si le GET est égal à RNAOT
		else if($_GET['msgCreateUser']=='RNAOT')
		{
			// Affiche le message d'erreur et que la modification n'a pas pu aboutir depuis le config.php
			echo REGISTER_NAME_ALREADY_ORNOT;
			?>
			<!-- Script Javascript -->
			<script>
				//Crée un timeout qui va s'écouler avant de faire myFunction
				setTimeout(myFunction, 10500);

				// Création d'une fonction
				function myFunction()
				{    
					// Redirige vers la page de register
					location.href="registerAthlete.php";
				}
			// Fin du script
			</script>

			<!-- Ouvre le php -->
			<?php      
		}
		// Sinon si le GET est égal à RSAOT
		else if($_GET['msgCreateUser']=='RSAOT')
		{
			// Affiche le message d'erreur et que la modification n'a pas pu aboutir depuis le config.php
			echo REGISTER_SURNAME_ALREADY_ORNOT;
			?>
			<!-- Script Javascript -->
			<script>
				//Crée un timeout qui va s'écouler avant de faire myFunction
				setTimeout(myFunction, 10500);

				// Création d'une fonction
				function myFunction()
				{    
					// Redirige vers la page de register
					location.href="registerAthlete.php";
				}
			// Fin du script
			</script>

			<!-- Ouvre le php -->
			<?php      
		}		
		// Sinon si le GET est égal à RPAOT
		else if($_GET['msgCreateUser']=='RPAOT')
		{
			// Affiche le message d'erreur et que la modification n'a pas pu aboutir depuis le config.php
			echo REGISTER_PHONE_ALREADY_ORNOT;
			?>
			<!-- Script Javascript -->
			<script>
				//Crée un timeout qui va s'écouler avant de faire myFunction
				setTimeout(myFunction, 10500);

				// Création d'une fonction
				function myFunction()
				{    
					// Redirige vers la page de register
					location.href="registerAthlete.php";
				}
			// Fin du script
			</script>

			<!-- Ouvre le php -->
			<?php      
		}		
		// Sinon si le GET est égal à RTAOT
		else if($_GET['msgCreateUser']=='RTAOT')
		{
			// Affiche le message d'erreur et que la modification n'a pas pu aboutir depuis le config.php
			echo REGISTER_TOWN_ALREADY_ORNOT;
			?>
			<!-- Script Javascript -->
			<script>
				//Crée un timeout qui va s'écouler avant de faire myFunction
				setTimeout(myFunction, 10500);

				// Création d'une fonction
				function myFunction()
				{    
					// Redirige vers la page de register
					location.href="registerAthlete.php";
				}
			// Fin du script
			</script>

			<!-- Ouvre le php -->
			<?php      
		}		
		// Sinon si le GET est égal à RNAOT
		else if($_GET['msgCreateUser']=='RNAOT')
		{
			// Affiche le message d'erreur et que la modification n'a pas pu aboutir depuis le config.php
			echo REGISTER_NPA_ALREADY_ORNOT;
			?>
			<!-- Script Javascript -->
			<script>
				//Crée un timeout qui va s'écouler avant de faire myFunction
				setTimeout(myFunction, 10500);

				// Création d'une fonction
				function myFunction()
				{    
					// Redirige vers la page de register
					location.href="registerAthlete.php";
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
		<div class="divTitle">
			<h1>
				GUG
			</h1>
		</div>
	</header>
	<body class="img js-fullheight" style="background-image: url(../../../resources/images/????); height: 969px;">
		<section class="ftco-section">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-md-6 col-lg-4">
						<div class="login-wrap p-0">
							<h3 class="mb-4 text-center" style="margin-right: 4%;">Enregistrez-vous!</h3>
							<form action="../controller/verifRegister.php" method="post" class="signin-form" enctype="multipart/form-data">
								<div class="isWhat">
									<a class="selectIntero athleteIntero activeAthleteRegister" href="registerAthlete.php">Athlète?</a>   
									<a class="selectIntero coachIntero" href="registerCoach.php">Coach?</a>				
								</div>
								<div class="form-group" style="padding-top: 5%;">
									<input type="text" class="form-control" placeholder="Entrez votre nom" name="name" required>
								</div>
								<div class="form-group">
									<input type="text" class="form-control" placeholder="Entrez votre prénom" name="surname" required>
								</div>
								<div class="form-group">
									<input type="email" class="form-control" placeholder="Entrez votre e-mail" name="email" required>
								</div>
								<div class="form-group">
									<input type="text" class="form-control" placeholder="Entrez votre téléphone" name="phone" required>
								</div>
								<div class="form-group" id="athleteSee">
									<input type="text" class="form-control" placeholder="Entrez votre ville" name="town" required>
								</div>
								<div class="form-group" id="athleteSee">
									<input type="text" class="form-control" placeholder="Entrez votre code postal" name="NPA" required>
								</div>
								<br>
								<div class="form-group">
									<input id="password-field" type="password" name="password" class="form-control" placeholder="Entrez votre mot de passe" required>
									<span toggle="#password-field" class="fa fa-fw field-icon toggle-password"></span>
								</div>
								<div class="form-group">
									<input id="password-field" type="password" name="passwordVerif" class="form-control" placeholder="Repetez le mot de passe" required>
									<span toggle="#password-field" class="fa fa-fw field-icon toggle-password"></span>
								</div>
								<div class="form-group">
									<button type="submit" name="btnRegisterAthlete" class="form-control btn btn-primary submit px-3">s'enregistrer</button>
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

