<?php
    if (isset($_SESSION["isAthlete"]))
    {
        echo "Bienvenu Athlete";
        //appele la méthode pour trouver le coach a afficher
        coachDisplay();
    }
    else if (isset($_SESSION["isCoach"]))
    {
        echo "Bienvenu Coach";
    }

    function coachDisplay()
    {
        do
        {
            //appelle la méthode pour 
            $coachToDisplay = Database::getInstance() -> getLastRecipe();
        }
        while();
    }
?>