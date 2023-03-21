<?php
    //inclu la page qui permet de choisire la prochaine personne affiché
    include("src/php/controller/NextChoiceMeeting.php");

    if (isset($_SESSION["isAthlete"]))
    {
        //regarde que la variable n'a pas encore été créé
        if(!isset($idCoachToDisplay))
        {
            //variable qui regarde quelle coach est le prochain a se faire afficher
            $idCoachToDisplay=0;
        }

        echo "Bienvenu Athlete";

        //appele la méthode pour trouver le coach a afficher
        $idCoachMatch = NextChoiceMeeting::getInstance() -> coachDisplay($idCoachToDisplay);
    }
    else if (isset($_SESSION["isCoach"]))
    {
        echo "Bienvenu Coach";
    }
    
    //regarde si c'est un match ou non et si l'utilisateur qui fait le match est un Athlete ou un Coach
    if (isset($_GET["acction"]))
    {
        //regarde si c'est un athlete qui a match
        if ($_GET["acction"] == "machByAthlete")
        {
            //récupère toutes les info sur l'Athlete qui a fait le match
            $me = Database::getInstance() -> getOneAthlete($_SESSION["email"]);
            
            //ajoute la séléction du coach
            Database::getInstance() -> selectCoachByAthlete($me["idAthlete"], $idCoachMatch);

            //ajoute 1 au coach a afficher
            $idCoachToDisplay++;
        }
        //regarde si c'est un athlete qui n'a pas match
        else if ($_GET["acction"] == "notMachByAthlete")
        {
            //ajoute 1 au coach a afficher
            $idCoachToDisplay++;
        }

        //redirige ver la page sans l'acction
        header("Location:../../");
        exit;
    }

?>

<a href="./index.php?page=meet&acction=machByAthlete"><img src="resources/images/match.png" alt="match"  width="20" height="20"></a>
<a href="./index.php?page=meet&acction=notMachByAthlete"><img src="resources/images/not_match.png" alt="match pas"  width="20" height="20"></a>