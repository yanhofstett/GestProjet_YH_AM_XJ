<?php
/**
 * Auteur : Yann Hofstetter
 * Date : 16.12.2022
 * Description : page qui permet au personne admin d'avoir toutes les questions des utilisateurs et d'y répondre
 */

    //regarde si c'est un Athlete qui est connecter ou si c'est un Coach
    if (isset($_SESSION["isAthlete"]))
    {
        //récupere dans un tableau toutes les informations sur l'utilisateur qui a posé la question
        $userConv = Database::getInstance() -> getOneAthlete($_SESSION["email"]);
        //récupere tout les matchs de cette utilisateur
        $match = Database::getInstance() -> getMatchAthlete($userConv["idAthlete"]);

        //crée un tableau qui va stoquer toutes les vlaeur des Coaches avec qui il a matché
        $InfoMatch = array();

        //récupère toutes les information des coachs avec qui il a match
        foreach($match as $value)
        {
            $coachesInfo = Database::getInstance() -> getOneCoach($value["coaEmail"]);
            array_unshift($InfoMatch, $coachesInfo);
        }

        //affiche le nom + prénom de tout les matches
        foreach($InfoMatch as $value)
        {
            ?>
            
            <!-- affiche le nom + prénom des matches-->
            <a href="./index.php?page=convDetail&idAutherUser=<?php echo $value["idCoach"]?>"><?= $value["coaName"]." ".$value["coaSurname"]?><a>                        
            
            <!--fait 2 retour a la ligne-->
            <br><br>

            <?php
        }
    }
    else
    {
        //récupere dans un tableau toutes les informations sur l'utilisateur qui a posé la question
        $userConv = Database::getInstance() -> getOneCoach($_SESSION["email"]);
        //récupere tout les matchs de cette utilisateur
        $match = Database::getInstance() -> getMatchCoache($userConv["idCoach"]);

        //crée un tableau qui va stoquer toutes les vlaeur des Coaches avec qui il a matché
        $InfoMatch = array();

        //récupère toutes les information des coachs avec qui il a match
        foreach($match as $value)
        {
            $coachesInfo = Database::getInstance() -> getOneAthlete($value["athEmail"]);
            array_unshift($InfoMatch, $coachesInfo);
        }

        //affiche le nom + prénom de tout les matches
        foreach($InfoMatch as $value)
        {
            ?>
            
            <!-- affiche le nom + prénom des matches-->
            <a href="./index.php?page=convDetail&idAutherUser=<?php echo $value["idAthlete"]?>"><?= $value["athName"]." ".$value["athSurname"]?><a>                        
            
            <!--fait 2 retour a la ligne-->
            <br><br>

            <?php
        }
    }

?>
