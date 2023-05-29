<?php
/**
 * Auteur : Yann Hofstetter
 * Date : 16.12.2022
 * Description : page qui permet au athlete d'avoir les infos sur les coach (email/num/...)
 */
?>
<body style="text-align: center;">

<form method="post" action="./index.php?page=conv" style="text-align: left;">
    <input type="submit" name="return" value="retour">
</form>

    <?php
    
    //regarde si c'est un Athlete qui est connecter ou si c'est un Coach
    if (isset($_SESSION["isAthlete"]))
    {
        //récupère toutes les infos sur le coaches en question
        $infoOfCoach = Database::getInstance() -> getOneCoach($_GET["email"]);
        //récupère toutes les infos sur moi
        $indoOfMe = Database::getInstance() -> getOneAthlete($_SESSION["email"]);

        ?>

        <div class="card" onclick="flipCard()">
            <div class="card-inner">
                <div class="card-front">
                <img src="./userContent/images/<?=$infoOfCoach["coaImage"]?>" alt="Carte">
                </div>
                <div class="card-back">
                <div class="card-text">
                    <?php
                    // Récupérer toutes les activités du coach
                    $activityOfCoach = Database::getInstance()->getActivityCoach($infoOfCoach["idCoach"]);
                    
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
                <div class="card-back-image" style="background-image: url('./userContent/images/floutee/<?=$infoOfCoach["coaImage"]?>')"></div>
                </div>
            </div>
        </div>

        <?php
        //affiche les infos sur les coaches
        echo "Nom : " . $infoOfCoach["coaSurname"] . "<br>";
        echo "Prénom : " . $infoOfCoach["coaName"] . "<br>";
        echo "Email : " . $infoOfCoach["coaEmail"] . "<br>";
        echo "Numéro de téléphone : " . $infoOfCoach["coaPhone"] . "<br>";

        $idAthlete = $indoOfMe["idAthlete"];
        $idCoach = $infoOfCoach["idCoach"];
    }
    else
    {
        //récupère toutes les infos sur le coaches en question
        $infoOfAthlete = Database::getInstance() -> getOneAthlete($_GET["email"]);
        //récupère toutes les infos sur moi
        $indoOfMe = Database::getInstance() -> getOneCoach($_SESSION["email"]);

        //affiche les infos sur les coaches
        echo "Nom : " . $infoOfAthlete["athSurname"] . "<br>";
        echo "Prénom : " . $infoOfAthlete["athName"] . "<br>";
        echo "Email : " . $infoOfAthlete["athEmail"] . "<br>";
        echo "Numéro de téléphone : " . $infoOfAthlete["athPhone"] . "<br>";
        
        $idAthlete = $infoOfAthlete["idAthlete"];
        $idCoach = $indoOfMe["idCoach"];
    }
    ?>
    
    <br><br><br>
    <!--ajoute un bouton pour enlever le match-->
    <p>supprimer le match : <a class = "imageOption" href="./src/php/controller/stopMatch.php?idAthlete=<?=$idAthlete?>&idCoach=<?=$idCoach?>" onclick="return deleteChek()"><img src="resources/images/not_match.png" alt="plus match"  width="20" height="20"></a></p>

</body>


<script>
/**
 * permet de retourner la carte
 */
function flipCard() 
{
    var card = document.querySelector('.card');
    card.classList.toggle('card-flipped');
}

//crée une fonction pour verifier si il veux vraiment suprimmer le match
function deleteChek() 
{
    //affiche le text dans un popup en récupérant la valeur donnée
    let text = "Voulez-vous vraiment me plus match avec cette personne ?";
    if (confirm(text))
    {
        //return true car l'utilisateur veux vraiment suprimmer le produit
        return true;
    }
    else
    {
        //return false car l'utilisateur ne veux pas vraiment suprimmer le produit
        return false;
    }
}
</script>