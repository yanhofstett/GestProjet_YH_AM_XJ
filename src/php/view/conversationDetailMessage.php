<?php
/**
 * Auteur : Yann Hofstetter
 * Date : 16.12.2022
 * Description : permet d'afficher une conversation entre un athlete et un coach qui on match ensemble
 */

    //regarde si c'est un athlete (car l'ordre d'appelle de méthode change en fonction des 2 utilisateur et le nom de l'id change également)
    if (isset($_SESSION["isAthlete"]))
    {
        //récupere dans un tableau toutes les informations sur l'athlete
        $userConv = Database::getInstance() -> getOneAthlete($_SESSION["email"]);
        //récupere dans un tableau toutes les informations sur l'utilisateur qui a posé la question
        $conv = Database::getInstance() -> getMatchMessage($userConv["idAthlete"],$_GET['idAutherUser']);
        
        //crée 2 variable de session pour stoquer l'id de l'athlete et l'id du coach
        $_SESSION["tempIdAthlete"] = $userConv["idAthlete"];
        $_SESSION["tempIdCoach"] = $_GET['idAutherUser'];

        //affiche tout les message consernant les 2 matches
        foreach($conv as $message)
        {
            //regarde si c'est l'utilisateur qui consulte cette page qui a envoyer le message
            if ($message["fkMessageSendBy"] == $userConv["idAthlete"]."Athlete")
            {
                ?>
                    <!--affiche le message a droite de la page-->
                    <p style="text-align: right; margin-right: 400px;"><?=$message["mesMessage"]?>
                        <a href="src/php/controller/deletMessage.php?id=<?=$message["idMessage"]?>" onclick="return deleteChek()"><img src="resources/images/supprimer_logo.png" alt="supprimer icone"  width="20" height="20"></a>
                    </p>
                    <?php
            }
            else
            {
                ?>
                    <!--affiche le message a gauche de la page-->
                    <p style="text-align: left; margin-left: 300px;"><?=$message["mesMessage"]?></p>
                <?php
            }
        }
    }
    //sinon regarde si c'est un coach
    else if (isset($_SESSION["isCoach"]))
    {
        //récupere dans un tableau toutes les informations sur l'athlete
        $userConv = Database::getInstance() -> getOneCoach($_SESSION["email"]);
        //récupere dans un tableau toutes les informations sur l'utilisateur qui a posé la question
        $conv = Database::getInstance() -> getMatchMessage($_GET['idAutherUser'],$userConv["idCoach"]);

        //crée 2 variable de session pour stoquer l'id de l'athlete et l'id du coach
        $_SESSION["tempIdAthlete"] = $_GET['idAutherUser'];
        $_SESSION["tempIdCoach"] = $userConv["idCoach"];

        //affiche tout les message consernant les 2 matches
        foreach($conv as $message)
        {
            //regarde si c'est l'utilisateur qui consulte cette page qui a envoyer le message
            if ($message["fkMessageSendBy"] == $userConv["idCoach"]."Coach")
            {
                ?>
                    <!--affiche le message a droite de la page-->
                    <p style="text-align: right; margin-right: 400px;"><?=$message["mesMessage"]?>
                        <a href="src/php/controller/deletMessage.php?id=<?=$message["idMessage"]?>" onclick="return deleteChek()"><img src="resources/images/supprimer_logo.png" alt="supprimer icone"  width="20" height="20"></a>
                    </p>                             
                <?php
            }
            else
            {
                ?>
                    <!--affiche le message a gauche de la page-->
                    <p style="text-align: left; margin-left: 300px;"><?=$message["mesMessage"]?></p>
                <?php
            }
        }
    }
    ?>

    <!--Permet d'envoyer une message-->
    <div class ="container">
        <form method="post" action="src/php/controller/verifSend.php">
            
            <div class="form-floating">
                <?php
                    //regarde si c'est un athlete qui a envoyer le messgae
                    if (isset($_SESSION["isAthlete"]))
                    {
                ?>

                <!--met dans 2 label invisible different l'id de l'athlete et l'id du coach-->
                <input type ="hidden" name ="idAthlete" value="<?= $userConv["idAthlete"]?>">
                <input type ="hidden" name ="idCoach" value="<?= $_GET['idAutherUser']?>">
                
                <!--ajoute un label invisible qui permet de savoir qui envoye le message-->
                <input type ="hidden" name ="idUser" value="<?= $userConv["idAthlete"]."Athlete"?>">

                <?php
                    }
                    //sinon regarde si c'est un coach
                    else if (isset($_SESSION["isCoach"]))
                    {
                ?>
                
                <!--met dans 2 label invisible different l'id de l'athlete et l'id du coach-->
                <input type ="hidden" name ="idAthlete" value="<?= $_GET['idAutherUser']?>">
                <input type ="hidden" name ="idCoach" value="<?= $userConv["idCoach"]?>">
                
                <!--ajoute un label invisible qui permet de savoir qui envoye le message-->
                <input type ="hidden" name ="idUser" value="<?= $userConv["idCoach"]."Coach"?>">

                <?php
                    }
                ?>

                <!--met un textBox pour le message-->
                <textarea class="form-control" id="MessageFromUser" name="MessageFromUser" placeholder="Mon message" required></textarea>
                <label for="floatingInput">Message</label>
            </div>

            <input type="submit" name="btnSend" value="Envoyer">
        </form>
    </div>


<script>
    //crée une fonction pour verifier si il veux vraiment suprimmer un produit
    function deleteChek() 
    {
        //affiche le text dans un popup en récupérant la valeur donnée
        let text = "Voulez-vous vraiment suprimmer ce produit ?";
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