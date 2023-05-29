<body style="text-align: center;">
    <?php
        //inclu la page qui permet de choisire la prochaine personne affiché
        include("src/php/controller/NextChoiceMeeting.php");

        //regarde si la personne connecter est connecter en tant que athlete
        if (isset($_SESSION["isAthlete"]))
        {
            //regarde que la variable n'a pas encore été créé
            if(!isset($_SESSION["idCoachToDisplay"]))
            {
                //variable qui regarde quelle coach est le prochain a se faire afficher
                $_SESSION["idCoachToDisplay"]=1;
            }
            
            echo "Bienvenue Athlete <br>";
            
            //appele la méthode pour trouver le coach a afficher
            $idCoachMatch = NextChoiceMeeting::getInstance() -> coachDisplay($_SESSION["idCoachToDisplay"]);
        
            if (isset($_POST["Information"]))
            {
            ?>
                <div class="card" onclick="flipCard()">
                    <div class="card-inner">
                        <div class="card-front">
                        <img src="./userContent/images/<?=$_POST["Information"][0]["coaImage"]?>" alt="Carte">
                        </div>
                        <div class="card-back">
                        <div class="card-text">
                            <?php
                            // Récupérer toutes les activités du coach
                            $activityOfCoach = Database::getInstance()->getActivityCoach($_POST["Information"][0]["idCoach"]);
                            
                            // affiche toutes les sports que le coach fait (quand on tourne la carte)
                            if (!empty($activityOfCoach)) {
                                echo "<ul>";
                                foreach ($activityOfCoach as $activity)
                                {
                                    echo "<li>".$activity['actActivite']."</li>";
                                }
                                echo "</ul>";
                            } else {
                                echo "Aucune activité trouvée.";
                            }
                            ?>
                        </div>
                        <div class="card-back-image" style="background-image: url('./userContent/images/floutee/<?=$_POST["Information"][0]["coaImage"]?>')"></div>
                        </div>
                    </div>
                </div>

            <?php
                // affiche les infos du coach
                echo $_POST["Information"][0]["coaSurname"] . " " . $_POST["Information"][0]["coaName"];
                echo "<br>";
            }

            //regarde si c'est un match ou non
            if (isset($_GET["acction"]))
            {
                //regarde si c'est un athlete qui a match
                if ($_GET["acction"] == "mach")
                {
                    //récupère toutes les info sur l'Athlete qui a fait le match
                    $me = Database::getInstance() -> getOneAthlete($_SESSION["email"]);
                    
                    //ajoute la séléction du coach
                    Database::getInstance() -> selectCoachByAthlete($me["idAthlete"], $idCoachMatch);

                    //ajoute 1 au coach a afficher
                    $_SESSION["idCoachToDisplay"]+=1;
                }
                //regarde si c'est un athlete qui n'a pas match
                else if ($_GET["acction"] == "notMach")
                {
                    //ajoute 1 au coach a afficher
                    $_SESSION["idCoachToDisplay"]+=1;
                }
                
                //redirige ver la page sans l'acction
                echo "<script language='Javascript'>document.location='./index.php?page=meet'</script>";
            }
            
            //regarde que le "$_POST["noInformationToDisplay"]" n'est pas créer (donc qu'il y a encore des coaches a match)
            if (!isset($_POST["noInformationToDisplay"]))
            {
        ?>
        
        <a href="./index.php?page=meet&acction=mach"><img src="resources/images/match.png" alt="match" width="20" height="20"></a>
        <a href="./index.php?page=meet&acction=notMach"><img src="resources/images/not_match.png" alt="match pas" width="20" height="20"></a>
        
        <?php
            }
            //sinon affiche un message pour prévenir l'athlete
            else
            {
                //affiche un message comme quoi il n'y a pas d'autre coach a afficher
                echo "plus rien a afficher";
            }
        }
        //sinon regarde si la personne connecter est connecter en tant que coach
        else if (isset($_SESSION["isCoach"]))
        {
            //regarde que la variable n'a pas encore été créé
            if(!isset($_SESSION["idAthleteMatcheMeToDisplay"]))
            {
                //variable qui regarde quelle athlete est le prochain a se faire afficher
                $_SESSION["idAthleteMatcheMeToDisplay"]=1;
            }

            echo "Bienvenue Coach <br>";

            //appele la méthode pour trouver l'athlete a afficher
            $idAthleteMatchMe = NextChoiceMeeting::getInstance() -> AthleteMatcheWithMeToDisplay($_SESSION["idAthleteMatcheMeToDisplay"]);
        
            if (isset($_POST["Information"]))
            {
                // affiche les infos du coach
                echo $_POST["Information"][0]["athSurname"] . " " . $_POST["Information"][0]["athName"];
                echo "<br>";
            }
            
            //regarde si c'est un match ou non
            if (isset($_GET["acction"]))
            {
                //regarde si le coach veut matcher avec cette athlete
                if ($_GET["acction"] == "mach")
                {
                    //récupère toutes les info sur le coach qui valide le match
                    $me = Database::getInstance() -> getOneCoach($_SESSION["email"]);
                    
                    //met a jour la colone de si oui ou non le coach a match
                    Database::getInstance() -> valideMatch($idAthleteMatchMe, $me["idCoach"]);

                    //ajoute 1 au coach a afficher
                    $_SESSION["idAthleteMatcheMeToDisplay"]+=1;
                }
                //regarde si c'est un athlete qui n'a pas match
                else if ($_GET["acction"] == "notMach")
                {
                    //met l'id de l'athlete dans la variable de session
                    $_SESSION["idAthleteMatcheMeToDisplay"] = $idAthleteMatchMe;

                    //ajoute 1 a l'athlete a afficher
                    $_SESSION["idAthleteMatcheMeToDisplay"]+=1;
                }
                
                //redirige ver la page sans l'acction
                echo "<script language='Javascript'>document.location='./index.php?page=meet'</script>";
            }
            
            //regarde que le "$_POST["noInformationToDisplay"]" n'est pas créer (donc qu'il y a encore des coaches a match)
            if (!isset($_POST["noInformationToDisplay"]))
            {
        ?>
        
        <a href="./index.php?page=meet&acction=mach"><img src="resources/images/match.png" alt="match" width="20" height="20"></a>
        <a href="./index.php?page=meet&acction=notMach"><img src="resources/images/not_match.png" alt="match pas" width="20" height="20"></a>
        
        <?php
            }
            //sinon affiche un message pour prévenir l'athlete
            else
            {
                //affiche un message comme quoi il n'y a pas d'autre coach a afficher
                echo "plus rien a afficher";
            }

        }
    ?>
</body>


<script>
/**
 * permet de retourner la carte
 */
function flipCard() {
    var card = document.querySelector('.card');
    card.classList.toggle('card-flipped');
  }
</script>