<?php
    if (isset($_SESSION["isAthlete"]))
    {
        echo "Bienvenu Athlete";
    }
    else if (isset($_SESSION["isCoach"]))
    {
        echo "Bienvenu Coach";
    }
?>