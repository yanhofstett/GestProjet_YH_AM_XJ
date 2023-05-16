<?php   

class NextChoiceMeeting 
{   
    
    // Variable pour l'instance
    private static $instance = null;

    /**
     * Fonction pour l'instance
     **/
    public static function getInstance()
    {
        // Si instance est "vide"
        if(is_null(self::$instance))   
        {
            // Crée l'instance
            self::$instance = new NextChoiceMeeting();
        }
        // Retourne obligatoirement l'instance
        return self::$instance;
    }

    function coachDisplay($idCoachToDisplay)
    {
        //récupère toutes les info sur l'utilisateur
        $informationOfMe = Database::getInstance() -> getOneAthlete($_SESSION["email"]);

        //récupère le nombre max de coaches possible d'afficher
        $maxInDB = Database::getInstance() -> getMaxCoachInDB();
        //récupère le nombre de match que l'Athlete a déjà fait (en sachant qu'il ne peut pas matche 2 fois le meme coach)
        $numberOfMatch = Database::getInstance() -> getNumberMatchByAthlete($informationOfMe["idAthlete"]);
        
        do
        {
            //regarde si le coach a afficher est supérieur au nombre de coach total (rentre si c'est suppérieur)
            if ($idCoachToDisplay > $maxInDB["idCoach"] || $_SESSION["idCoachToDisplay"] > $maxInDB["idCoach"])
            {
                //remet les variable consérné a 1 (l'id du premier coach théorique)
                $idCoachToDisplay = 1;
                $_SESSION["idCoachToDisplay"] = 1;
            }
            //regarde si l'utilisateur a le meme nombre de match que le nombre total de coach a match (donc qu'il les a tous match et qu'il n'y a donc plus de coach a afficher)
            if ($numberOfMatch["COUNT(fkCoach)"] >= $maxInDB["idCoach"])
            {
                //sort de la boucle do while
                break;
            }
            
            //le prochain coach qui va etre afficher
            $coachToDisplay = Database::getInstance() -> findNextCoach($idCoachToDisplay);

            //regarde que le coach a été trouvé
            if (!empty($coachToDisplay))
            {
                //regarde si le coach est déjà match (null si il y a pas de match corresspondant a cela)
                $coachAlreadyMatch = Database::getInstance() -> getOneCoachAlreadyMatch($informationOfMe["idAthlete"],$coachToDisplay[0]["idCoach"]);
            }
            
            if (empty($coachToDisplay) || !empty($coachAlreadyMatch))
            {
                $idCoachToDisplay+=1;
                $_SESSION["idCoachToDisplay"] += 1;
            }
        }
        //recommence tant que la variable "coachToDisplay" est vide et que "coachAlreadyMatch" n'est pas null
        while(empty($coachToDisplay) || !empty($coachAlreadyMatch));
        
        if (isset($coachToDisplay) || isset($coachAlreadyMatch))
        {
            //met les info du coach dans un $Post
            $_POST["Information"] = $coachToDisplay;
        }
        else
        {
            $_POST["noInformationToDisplay"] = 1;
        }

        return $idCoachToDisplay;
    }





    function AthleteMatcheWithMeToDisplay($idAthleteToDisplay)
    {
        //récupère toutes les info sur l'utilisateur
        $informationOfMe = Database::getInstance() -> getOneCoach($_SESSION["email"]);

        //récupère le nombre max d'athlete possible d'afficher
        $numberAthleteMatchMe = Database::getInstance() -> getNumberAthleteMatcheMehInDB($informationOfMe["idCoach"],0);
        //récupère le nombre d'athlete que le coach a déjà match
        $numberAthleteMatchByMe = Database::getInstance() -> getNumberMatcheMehInDB($informationOfMe["idCoach"]);

        do
        {

            //regarde si l'athlete a afficher est supérieur au nombre d'athlete total (rentre si c'est suppérieur)
            if ($idAthleteToDisplay > $numberAthleteMatchByMe["COUNT(fkAthlete)"] || $_SESSION["idAthleteMatcheMeToDisplay"] > $numberAthleteMatchByMe["COUNT(fkAthlete)"])
            {
                //remet les variable consérné a 1 (l'id du premier athlete a afficher théoriquement)
                $idAthleteToDisplay = 1;
                $_SESSION["idAthleteMatcheMeToDisplay"] = 1;
            }

            //regarde si le nombre que l'utilisateur peut encore match est a 0
            if ($numberAthleteMatchMe["COUNT(fkAthlete)"] == 0)
            {
                //sort de la boucle do while
                break;
            }
            
            //le prochain athlete qui va etre afficher
            $athleteToDisplay = Database::getInstance() -> findNextAthlete($informationOfMe["idCoach"], $idAthleteToDisplay);
            
            if (!empty($athleteToDisplay))
            {
                //met les info du coach dans un $Post
                $_POST["Information"] = $athleteToDisplay;
            }

            if (empty($athleteToDisplay))
            {
                $idAthleteToDisplay+=1;
            }
        }
        //recommence tant que la variable "coachToDisplay" est vide et que "coachAlreadyMatch" n'est pas null
        while(empty($athleteToDisplay));

        if (isset($athleteToDisplay))
        {
            //met les info du coach dans un $Post
            $_POST["Information"] = $athleteToDisplay;
        }
        else
        {
            $_POST["noInformationToDisplay"] = 1;
        }

        return $idAthleteToDisplay;
    }
}

?>