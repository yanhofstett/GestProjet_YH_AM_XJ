<?php
    if (isset($_SESSION["isAthlete"]))
    {
        //variable qui regarde quelle coach est le prochain a se faire afficher
        $idCoachToDisplay=0;

        echo "Bienvenu Athlete";

        //appele la méthode pour trouver le coach a afficher
        coachDisplay($idCoachToDisplay);
    }
    else if (isset($_SESSION["isCoach"]))
    {
        echo "Bienvenu Coach";
    }

    function coachDisplay($idCoachToDisplay)
    {
        //récupère toutes les info sur l'utilisateur
        $informationOfMe = Database::getInstance() -> getOneAthlete($_SESSION["email"]);

        do
        {
            //ajoute 1 a l'id du coach a afficher
            $idCoachToDisplay++;

            //le prochain coach qui va etre afficher
            $coachToDisplay = Database::getInstance() -> findNextCoach($idCoachToDisplay);

            //regarde que le coach a été trouvé
            if (!empty($coachToDisplay))
            {
                //regarde si le coach est déjà match (null si il y a pas de match corresspondant a cela)
                $coachAlreadyMatch = Database::getInstance() -> getOneCoachAlreadyMatch($informationOfMe["idAthlete"],$coachToDisplay[0]["idCoach"]);
            }
        }
        //recommence tant que la variable "coachToDisplay" est vide et que "coachAlreadyMatch" n'est pas null
        while(empty($coachToDisplay) || !empty($coachAlreadyMatch));

        echo "\n\n\n".$idCoachToDisplay."\n\n\n";
        var_dump($coachToDisplay);
        var_dump($coachAlreadyMatch);
    }
?>