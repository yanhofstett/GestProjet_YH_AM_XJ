<?php
    /*
    Auteur : Alexandre Montandon
    Date : 07.01.2023    
    Description : Projet module 151 // Page pour checker le formulaire de contact
    */
    
    // Crée la session
    session_start();

    // Utiliser un fichier de phpMailer
    use PHPMailer\PHPMailer\PHPMailer;

    // Utiliser un fichier de phpMailer
    use PHPMailer\PHPMailer\Exception;

    // Si le bouton submit a été cliquer
    if(isset($_POST['submit'])) 
    {
        // Si la case pour le nom n'est pas vide
        if(!empty($_POST["name"]) && preg_match("/^[éèüäöøà'êâça-zA-Z]{3,50}+$/", trim($_POST["name"])))
        {
            // Si la case pour le prénom n'est pas vide
            if(!empty($_POST["surname"]) && preg_match("/^[éèüäöøà'êâça-zA-Z]{3,50}+$/", trim($_POST["surname"])))
            {
                // Si la case pour la localité n'est pas vide
                if(!empty($_POST["local"]) && preg_match("/^[A-Za-zäöüÄÖÜß\s]{2,35},?\s?\d{4,5}+$/", trim($_POST["local"])))
                {
                    // Si la case pour le téléphone n'est pas vide et respecte les regexs suivants
                    if(!empty($_POST["tel"]) && !preg_match("/^(\+?)(\d{2,4})(\s?)(\-?)((\(0\))?)(\s?)(\d{2})(\s?)(\-?)(\d{3})(\s?)(\-?)(\d{2})(\s?)(\-?)(\d{2})/", trim($_POST["tel"])) || !preg_match("/^\d{3}\s\d{3}\s\d{2}\s\d{2}$/", trim($_POST["tel"])))
                    {
                        // Si la case pour l'email n'est pas vide et respecte les regexs suivants
                        if(!empty($_POST["email"]) && preg_match("/^[\w\.]+@[\w]+.+[\w]{2,4}+$/", trim($_POST["email"])) || !filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL))
                        {
                            // Si la case pour le message n'est pas vide
                            if(!empty($_POST["message"]) && preg_match("/^.{15,450}$/", trim($_POST["message"])))
                            {
                                // inclue la page 'exception'
                                require_once('../../../src/PHPMailer-master/src/Exception.php');

                                // inclue la page 'phpmailer'
                                require_once('../../../src/PHPMailer-master/src/PHPMailer.php');

                                // inclue la page 'smtp'
                                require_once('../../../src/PHPMailer-master/src/SMTP.php');
                        
                                // Crée un nouveau objet phpmailer
                                $mail = new PHPMailer();

                                // Si il est en smtp
                                $mail->IsSMTP();

                                // Adresse IP ou DNS du serveur SMTP
                                $mail->Host = 'smtp.gmail.com';       
                                
                                // Port TCP du serveur SMTP
                                $mail->Port = 465;          

                                // Utiliser l'identification                
                                $mail->SMTPAuth = true;     
                                
                                // Mettre le charset en utf-8
                                $mail->CharSet = 'UTF-8';
                        
                                // Si le mail est authentifier en smtp
                                if($mail->SMTPAuth)
                                {
                                    //Protocole de sécurisation des échanges avec le SMTP
                                    $mail->SMTPSecure =  'ssl';               

                                    //Adresse email à utiliser
                                    $mail->Username   =  'sitecontactenvoie@gmail.com';   

                                    //Mot de passe de l'adresse email à utiliser
                                    $mail->Password   =  'vhevsfjfmjdzrjbc';         
                            
                                    // Connecter au smtp
                                    $mail->smtpConnect();
                                }

                                //L'email à afficher pour l'envoi
                                $mail->setFrom($_POST["surname"] , $_POST["name"]);                

                                //L'alias de l'email de l'emetteur
                                $mail->FromName   = trim($_POST["name"] . " " . $_POST["surname"], $_POST["tel"]);          
                        
                                // Mettre à l'adresse suivante
                                $mail->AddAddress('sitecontactenvoie@gmail.com');
                        
                                //Le sujet du mail
                                $mail->Subject    =  $_POST["email"] . " 𝘷𝘰𝘶𝘴 𝘦𝘯𝘷𝘰𝘪𝘦 𝘶𝘯𝘦 𝘳𝘦𝘮𝘢𝘳𝘲𝘶𝘦𝘴 𝘰𝘶 𝘶𝘯𝘦 𝘲𝘶𝘦𝘴𝘵𝘪𝘰𝘯𝘴 !";       

                                // Limite de caractère
                                $mail->WordWrap   = 120; 	

                                //Nombre de caracteres pour le retour a la ligne automatique
                                $mail->Body = "𝘓𝘦 𝘮𝘦𝘴𝘴𝘢𝘨𝘦 𝘥𝘦 𝘭'𝘶𝘵𝘪𝘭𝘪𝘴𝘢𝘵𝘦𝘶𝘳 : " . $_POST["message"] . "\n\n" . "Infos : " . "\n" . "-----------------" . "\n" . "Nom: " . $_POST["name"] . "\n" . "Prénom: " . $_POST["surname"] . "\n" . "Tel : " . $_POST["tel"] . "\n" . "Localité: " . $_POST["local"] . "\n" . "Adresse IP: " . $_SERVER["REMOTE_ADDR"]; 	       //Message + infos
                                
                                //Préciser qu'il faut utiliser le texte brut
                                $mail->IsHTML(false);
                        
                                // Si le message c'est envoyé
                                if ($mail->send()) 
                                {
                                    // Redirige à la page de toutes les recettes avec un paramètre GET
                                    header('location:../../../index.php?page=contact&sendMsg=EMSC');
                                } 
                                // Sinon
                                else
                                {
                                    // Redirige à la page de toutes les recettes avec un paramètre GET
                                    header('location:../../../index.php?page=contact&sendMsg=EMSE');
                                }
                            }
                            // Sinon
                            else
                            {
                                // Redirigé sur la page de contact
                                header("location:../../../index.php?page=contact&sendMsg=EMSEMR");
                            }
                        }
                        // Sinon
                        else
                        {
                            // Redirigé sur la page de contact
                            header("location:../../../index.php?page=contact&sendMsg=EMSEMM");
                        }
                    }
                    // Sinon
                    else
                    {
                        // Redirigé sur la page de contact
                        header("location:../../../index.php?page=contact&sendMsg=EMSEMP");
                    }
                }
                // Sinon
                else
                {
                    // Redirigé sur la page de contact
                    header("location:../../../index.php?page=contact&sendMsg=EMSEML");
                }
            }
            // Sinon
            else
            {
                // Redirigé sur la page de contact
                header("location:../../../index.php?page=contact&sendMsg=EMSEMS");
            }
        }
        // Sinon
        else
        {
            // Redirigé sur la page de contact
            header("location:../../../index.php?page=contact&sendMsg=EMSEMN");
        }
    }
    // Sinon
    else
    {
        // Redirigé sur la page de contact
        header("location:../../../index.php?page=contact&sendMsg=EMSE");
    }
?>