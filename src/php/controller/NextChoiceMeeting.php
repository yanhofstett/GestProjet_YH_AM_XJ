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

        do
        {
            //ajoute 1 a l'id du coach a afficher
            $idCoachToDisplay+=1;
            
            //le prochain coach qui va etre afficher
            $coachToDisplay = Database::getInstance() -> findNextCoach($idCoachToDisplay);

            //regarde que le coach a été trouvé
            if (!empty($coachToDisplay))
            {
                //regarde si le coach est déjà match (null si il y a pas de match corresspondant a cela)
                $coachAlreadyMatch = Database::getInstance() -> getOneCoachAlreadyMatch($informationOfMe["idAthlete"],$coachToDisplay[0]["idCoach"]);
            }
            var_dump($coachToDisplay);
            echo "<br><br><br>";
            var_dump($coachAlreadyMatch);

            if ($idCoachToDisplay >= 3)
            {
                exit;
            }
        }
        //recommence tant que la variable "coachToDisplay" est vide et que "coachAlreadyMatch" n'est pas null
        while(empty($coachToDisplay) || !empty($coachAlreadyMatch));
    }
}

?>