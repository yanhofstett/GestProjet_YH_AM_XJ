<?php
/**
 * Auteur : Yann Hofstetter
 * Date : 16.12.2022
 * Description : permet d'afficher une conversation entre un athlete et un coach qui on match ensemble
 */
?>
    <!--crée un bouton pour revenir en arriere-->
    <form method="post" action="./index.php?page=conv">
        <input type="submit" name="return" value="retour">
    </form>
    
    <br><br>
<?php
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
                <script type="text/javascript">
                        /*
                        *Fonction : Pour le nombre de caractère*
                        *Paramètre : cara, nbrcara*/
                        function nbrCara(cara,nbrcara)
                        {
                            /*Variable : Limite de caractère*/
                            var limit = 1000;

                            /*Variable : Le text entré*/
                            var myText = document.getElementById(myText);

                            /*Variable : la longueur actuelle*/
                            var nombre = document.getElementById(cara).value.length

                            // Défénir la limite
                            document.getElementById(nbrcara).innerHTML = nombre + "/" + limit;

                            // Si la longueur actuelle est plus grande que la moitier de la limite
                            if(nombre > limit/2)
                            {
                                // Change la couleur du nombre
                                document.getElementById("nbrcara").style.color = "orange";

                                // Fais la transition
                                document.getElementById("nbrcara").style.transition = "color 2s ease";
                            }
                            // Si la longueur actuelle est plus petite que la moitier de la limite
                            else if(nombre < limit/2)
                            {
                                // Change la couleur du nombre
                                document.getElementById("nbrcara").style.color = "#09df98";

                                // Fais la transition
                                document.getElementById("nbrcara").style.transition = "color 2s ease";
                            }
                            // Si la longueur actuelle est plus grande que 40 au dessus de la moitier de la limite limite
                            else if(nombre > limit/2 +40)
                            {
                                // Change la couleur du nombre
                                document.getElementById("nbrcara").style.color = "red";

                                // Fais la transition
                                document.getElementById("nbrcara").style.transition = "color 2s ease";
                            }
                            // Si la longueur actuelle est égal à la limite
                            else if(nombre == limit)
                            {
                                // Change la couleur du nombre
                                document.getElementById("nbrcara").style.color = "rgb(138, 42, 255)";

                                // Fais la transition
                                document.getElementById("nbrcara").style.transition = "color 2s ease";
                            }
                            // Si la longueur actuelle est plus petite que 10
                            else if(nombre < 10)
                            {
                                // Change la couleur du nombre
                                document.getElementById("nbrcara").style.color = "rgb(255, 255, 0)";

                                // Fais la transition
                                document.getElementById("nbrcara").style.transition = "color 2s ease";
                            }
                        }
                    </script>
                    <textarea type="hidden" name="MessageFromUser" class="textArea" id="myText" rows="5" style=" width: 50%; " maxlength="1000" placeholder="message"
                        onkeyup="nbrCara('myText','nbrcara');"onkeydown="nbrCara('myText','nbrcara');" onmouseout="nbrCara('myText','nbrcara');"
                        required></textarea>
                        <p>Caractères restants : <span id="counter"></span></p>
                    <p class="limitCara" id="nbrcara">0/1000</p>
                    
                    <input type="submit" name="btnSend" value="Envoyer">
            </div>
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