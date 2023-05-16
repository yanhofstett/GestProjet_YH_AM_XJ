    <!---
    Auteur : Alexandre Montandon
    Date : 29.11.2022    
    Description : Projet module 151 // Page de contact
    --->
<script>
    if(performance.navigation.type === 1) 
    {
        var url = window.location.href.split('&sendMsg')[0];
        window.history.replaceState({}, document.title, url)
    }
</script>
<?php
    // inclue la page 'database'
    require_once("src/php/model/modelDB.php");

    // inclue la page 'config'
    include_once("src/php/controller/config.php");

    #region tout les messages quand on a effectué quelque chose sur le site
    #region messages dans la page de contact après avoir envoyé le message
    // Si le GET à été entré
    if(isset($_GET['sendMsg']))
    {
        // Si le GET est égal à EMSC
        if($_GET['sendMsg']=='EMSC')
        {
            // Afficher le message que le produit à bien été ajouté depuis le config.php
            echo EMAIL_MESSAGE_SEND_CORRECT;   
        }
        // Sinon si le GET est égal à EMSE
        else if($_GET['sendMsg']=='EMSE')
        {
            // Afficher l'erreur d'ajout de produit depuis le config.php
            echo EMAIL_MESSAGE_SEND_ERROR;    
        }
        // Sinon si le GET est égal à EMSEMN
        else if($_GET['sendMsg']=='EMSEMN')
        {
            // Afficher l'erreur d'ajout de produit depuis le config.php
            echo EMAIL_MESSAGE_SEND_ERROR_MISSING_NAME;   
        }        
        // Sinon si le GET est égal à EMSEMS
        else if($_GET['sendMsg']=='EMSEMS')
        {
            // Afficher l'erreur d'ajout de produit depuis le config.php
            echo EMAIL_MESSAGE_SEND_ERROR_MISSING_SURNAME;  
        }        
        // Sinon si le GET est égal à EMSEML
        else if($_GET['sendMsg']=='EMSEML')
        {
            // Afficher l'erreur d'ajout de produit depuis le config.php
            echo EMAIL_MESSAGE_SEND_ERROR_MISSING_LOCAL; 
        }       
        // Sinon si le GET est égal à EMSEMP
        else if($_GET['sendMsg']=='EMSEMP')
        {
            // Afficher l'erreur d'ajout de produit depuis le config.php
            echo EMAIL_MESSAGE_SEND_ERROR_MISSING_PHONE;   
        }        
        // Sinon si le GET est égal à EMSEMM
        else if($_GET['sendMsg']=='EMSEMM')
        {
            // Afficher l'erreur d'ajout de produit depuis le config.php
            echo EMAIL_MESSAGE_SEND_ERROR_MISSING_MAIL;   
        }        
        // Sinon si le GET est égal à EMSEMR
        else if($_GET['sendMsg']=='EMSEMR')
        {
            // Afficher l'erreur d'ajout de produit depuis le config.php
            echo EMAIL_MESSAGE_SEND_ERROR_MISSING_REM; 
        }
    }
    #endregion
    #endregion
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>Page de contact</title>
        <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="../../../resources/css/style.css">
        <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="../../../resources/css/style-login.css">
        <link rel="icon" type="image/x-icon" href="../../../resources/images/favicon.png">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <link rel="icon" type="image/x-icon" href="../../resources/images/favicon.png">
    </head>
    <body>
        <h3 class="h3lastRecipes" style="margin-left: 15%;">Contacter le créateur du site</h3>
        <section class="sectionPageContact"  style=" margin-left: 18%;">
            <form action="src/php/controller/verifContact.php" method="post" id="contact" class="allForm">
                <div class="divNom" style=" margin: 2% 0% 1% 0%; ">
                    <label class="labelNom" style="margin-right: 8%;">Nom  :</label>
                    <input class="inputNom" type="text" name="name" style=" width: 50%; " placeholder="ex. Nicolas[𝘾𝙝𝙖𝙢𝙥𝙨 𝙤𝙗𝙡𝙞𝙜𝙖𝙩𝙤𝙞𝙧𝙚]" required>
                </div>
                <div class="divPrenom" style=" margin-bottom: 1%; ">
                    <label class="labelPrenom" style="margin-right: 6.7%;">Prénom  : </label>
                    <input class="inputPrenom" type="text" name="surname" style=" width: 50%; " placeholder="ex. Dujanet[𝘾𝙝𝙖𝙢𝙥𝙨 𝙤𝙗𝙡𝙞𝙜𝙖𝙩𝙤𝙞𝙧𝙚]" required>
                </div>
                <div class="divLocalite" style=" margin-bottom: 1%; ">
                    <label class="labelLocalite" style="margin-right: 6.8%;">Localité  : </label>
                    <input class="inputLocalite" type="text" name="local" style=" width: 50%; " list="dataList" id="autocompletionForm" autocomplete="off" onkeyup="fetchData()" placeholder="ex. Montreux, 1820[𝘾𝙝𝙖𝙢𝙥𝙨 𝙉𝙊𝙉-𝙤𝙗𝙡𝙞𝙜𝙖𝙩𝙤𝙞𝙧𝙚]"></span>
                    <datalist id="dataList"></datalist>
                    <script type="text/javascript" src="../js/autoComplete.js"></script>
                </div>
                <div class="divTel" style=" margin-bottom: 1%; ">
                    <label class="labelTel" style="margin-right: 2.5%;">Téléphone (strict)  : </label>
                    <input class="inputTel" type="tel" id="tel" name="tel" style=" width: 50%; " placeholder="𝘦𝘹. +41 79 000 00 00[𝘾𝙝𝙖𝙢𝙥𝙨 𝙉𝙊𝙉-𝙤𝙗𝙡𝙞𝙜𝙖𝙩𝙤𝙞𝙧𝙚]">
                </div>
                <div class="divMail" style=" margin-bottom: 3%; ">
                    <label class="labelMail" style="margin-right: 8.3%;">Mail  : </label>
                    <input class="inputMail" type="email" id="email" name="email" style=" width: 50%; " value="
                    <?php 
                        // Si la variable que si on est connecté est entré
                        if(isset($_SESSION["isConnected"]))
                        {
                            // Écris l'email du compte
                            echo $_SESSION["email"];
                        }
                            ?>" placeholder="ex. exemple@gmail.comㅤㅤㅤㅤㅤㅤ[𝘾𝙝𝙖𝙢𝙥𝙨 𝙤𝙗𝙡𝙞𝙜𝙖𝙩𝙤𝙞𝙧𝙚]" required>
                </div>
                <div class="divAnswer" style=" margin-bottom: 1%; ">
                    <label class="labelAnswer">Questions, remarques  : </label>
                    <script type="text/javascript">
                        /*
                        *Fonction : Pour le nombre de caractère*
                        *Paramètre : cara, nbrcara*/
                        function nbrCara(cara,nbrcara)
                        {
                            /*Variable : Limite de caractère*/
                            var limit = 450;

                            /*Variable : Le text entré*/
                            var myText = document.getElementById(myText);

                            /*Variable : la longueur actuelle*/
                            var nombre = document.getElementById(cara).value.length

                            // Défénir la limite
                            document.getElementById(nbrcara).innerHTML = nombre + "/" + limit;

                            myText.Text(myText.Text().substring(0,450))

                            // Si la longueur actuelle est plus grande que 420
                            if(nombre > 420)
                            {
                                // Change la couleur du nombre
                                document.getElementById("nbrcara").style.color = "orange";

                                // Fais la transition
                                document.getElementById("nbrcara").style.transition = "color 2s ease";
                            }

                            // Si la longueur actuelle est plus petite que 420
                            if(nombre < 420)
                            {
                                // Change la couleur du nombre
                                document.getElementById("nbrcara").style.color = "#09df98";

                                // Fais la transition
                                document.getElementById("nbrcara").style.transition = "color 2s ease";
                            }

                            // Si la longueur actuelle est plus grande que 420
                            if(nombre > 440)
                            {
                                // Change la couleur du nombre
                                document.getElementById("nbrcara").style.color = "red";

                                // Fais la transition
                                document.getElementById("nbrcara").style.transition = "color 2s ease";
                            }

                            // Si la longueur actuelle est égal à 420
                            if(nombre == 450)
                            {
                                // Change la couleur du nombre
                                document.getElementById("nbrcara").style.color = "rgb(138, 42, 255)";

                                // Fais la transition
                                document.getElementById("nbrcara").style.transition = "color 2s ease";
                            }

                            // Si la longueur actuelle est plus petite que 10
                            if(nombre < 10)
                            {
                                // Change la couleur du nombre
                                document.getElementById("nbrcara").style.color = "rgb(255, 255, 0)";

                                // Fais la transition
                                document.getElementById("nbrcara").style.transition = "color 2s ease";
                            }
                        }
                    </script>
                    <textarea type="hidden" name="message" class="textArea" id="myText" rows="5" style=" width: 50%; " minlength="10" maxlength="450" placeholder="Écrivez quelque chose ici...[𝘾𝙝𝙖𝙢𝙥𝙨 𝙤𝙗𝙡𝙞𝙜𝙖𝙩𝙤𝙞𝙧𝙚]" 
                        onkeyup="nbrCara('myText','nbrcara');"onkeydown="nbrCara('myText','nbrcara');" onmouseout="nbrCara('myText','nbrcara');" 
                        required="Veuillez entrer votre message à faire parvenir au créateur du site ici"></textarea>
                    <p class="limitCara" id="nbrcara">0/450</p>
                <div class="divSend">
                    <input class="buttonContact" type="submit" name="submit" value="Envoyer">
                </div>
            </form>
        </section>
        </body>
    <script>
    /*
    *Fonction : pour revenir en arrière*
    **/
    function goBack() 
    {
        // Revenir en arrière dans l'historique
        window.history.back();
    }
    </script>
</html>