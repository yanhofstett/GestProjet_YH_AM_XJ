<?php
    if (isset($_SESSION["isAthlete"]))
    {
        //variable qui regarde quelle coach est le prochain a se faire afficher
        $idCoachToDisplay=0;

        echo "<br>Bienvenu.e " . $_SESSION["Surname"] . " vous êtes un athlète";

        //appele la méthode pour trouver le coach a afficher
        coachDisplay($idCoachToDisplay);
    }
    else if (isset($_SESSION["isCoach"]))
    {
        echo "<br>Bienvenu.e " . $_SESSION["Surname"] . " vous êtes un Coach";


    }

//récupère toutes les info sur l'utilisateur
$informationOfMe = Database::getInstance() -> getOneCoach($_SESSION["email"]);
 

var_dump($informationOfMe["coaImage"]);

// Montrer le détail : L'image du coach
echo "<p>Photo de profil : <img class='catName' height='auto' style='max-height: 40px;' width='auto' src='userContent/images/" . $informationOfMe["coaImage"] . "'><br><br></img></p>";
?>