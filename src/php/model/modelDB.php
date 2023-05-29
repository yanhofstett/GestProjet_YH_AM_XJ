<?php
    /*
    //Auteur : Alexandre Montandon, Xavier Jaquet, Yann Hofstetter
    //Date : 06.02.2023
    //Description :
    */


class Database 
{   

    // Variable de classe
    private $connector;

    // Variable pour l'instance
    private static $instance = null;


    /**
     * Fonction pour la connexion et la construction en se connectant avec PDO avec la base de donnée
     **/
    private function __construct()
    {
        // Essayer
        try 
        {
            // Crée une nouvelle connexion PDO
            $this->connector = new PDO(PAVE, USER/*"mysql:host=localhost;dbname=db_sport;charset=utf8","db_PGest042"*/, $this->getPassword());
        }
        // Si a échoué crée l'execptionm pdo
        catch (PDOException $e)
        {
            // Afficher l'erreur
            die('Erreur : ' . $e->getMessage());
        }
    }

    /**
     * Fonction pour l'instance
     **/
    public static function getInstance()
    {
        // Si instance est "vide"
        if(is_null(self::$instance))   
        {
            // Crée l'instance
            self::$instance = new Database();
        }
        // Retourne obligatoirement l'instance
        return self::$instance;
    }

    /**
    * Fonction pour avoir le mot de passe du compte pour la base de donnée depuis le fichier JSON
    **/  
    private function getPassword()
    {
        // Lire le fichier JSON avec file_get_contents
        $readJSONFile = file_get_contents(__DIR__.'/../../json/secret.json');

        // Décoder le fichier JSON
        $array = json_decode($readJSONFile, TRUE);

        // Retourner en tableau le mot de passe
        return $array["password"];
    }

    /**
    * Fonction pour l'execution simplifier d'une requête sans where
    *Paramètre : $query*/
    private function querySimpleExecute($query)
    {
        // Utilisation de query pour effectuer une requête
        return $this->connector->query($query);
    }

    /**
     * Fonction pour l'execution et le "bindage" préparer d'une requête avec where et pour éviter les injections
     *Paramètres : $queryString, $binds*/
    private function queryPrepareExecute($queryString, $binds)
    {
        // Essayer
        try
        {
            // Mettre le paramètre qui sera préparer dans la variable
            $pdoStatment = $this->connector->prepare($queryString);

            // Crée une boucle foreach pour retourner les elements du tableau associatif
            foreach($binds as $key=>$element)
            {
                // Placer les valeurs dans bindValue
                $pdoStatment->bindValue(":$key",$element["value"], $element["type"]);
            }
            // Executer la variable et le bindValue
            $pdoStatment->execute();

            // Demande le retour de la variable qui a éxecuté
            return $pdoStatment;
        }
        // Si a échoué crée l'exeption dans la variable "$e"
        catch(PDOException $e)
        {
            // Ecrire l'erreur
            die("Erreur :" . $e->getMessage());
        }
    }

    /**
     * TODO: à compléter
     */
    private function formatData($req)
    {
        // Traitement, transformer le résultat en tableau associatif
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
    * Permet de récupérer touts les informations sur les utilisateurs déjà créer dans la db
    **/
    public function getAllUsers()
    {
        // Requête SQL*
        $query = "SELECT `idAthlete`, `athName`, `athSurname`, `athEmail`, `athPassword`, `athPhone`, `athTown`, `athNPA`, `athIsAdministrator` FROM `t_athlete`UNION SELECT `idCoach`, `coaName`, `coaSurname`, `coaEmail`, `coaPassword`, `coaPhone`, `coaExperience`, `coaImage`, `coaIsAdministrator` FROM `t_coach`";


        //utiliser ca cette fois car pas de WHERE donc faut pas utiliser queryPrepareExecute
        $temp = $this->querySimpleExecute($query);

        //appeler la méthode pour avoir le résultat sous forme de tableau associatif 
        $tabTemp = $this->formatData($temp);

        // Retourner le tableau
        return $tabTemp;
    }

    /**
     * 
     */
    public function getOneAthlete($email)
    {
        //récupére l'id de l'utilisateur, le login, l'email, le mot de passe, si oui ou non il est admin
        $query = "SELECT idAthlete, athName, athSurname, athEmail, athPassword, athPhone, athTown, athNPA FROM t_athlete WHERE athEmail = :athEmail";

        //avoir la requête sql pour un utilisateur (utilisation de l'emial de l'utilisateur)
        $binds['athEmail']=['value'=>$email,'type'=>PDO::PARAM_STR];

        // appeler la méthode pour executer la requête
        $prepareTemp = $this->queryPrepareExecute($query,$binds);
        
        //appeler la méthode pour avoir le résultat sous forme de tableau associatif
        $prepareTabTemp = $this->formatData($prepareTemp);

        //retourn le tableau associatife du login
        return $prepareTabTemp;
    }

    /**
     * 
     */
    public function getOneCoach($email)
    {
        //récupére l'id de l'utilisateur, le login, l'email, le mot de passe, si oui ou non il est admin
        $query = "SELECT idCoach, coaName, coaSurname, coaEmail, coaPassword, coaPhone, coaExperience, coaImage FROM t_coach WHERE coaEmail = :coaEmail";
        //avoir la requête sql pour un utilisateur (utilisation de l'emial de l'utilisateur)
        $binds['coaEmail']=['value'=>$email,'type'=>PDO::PARAM_STR];

        // appeler la méthode pour executer la requête
        $prepareTemp = $this->queryPrepareExecute($query,$binds);
        //appeler la méthode pour avoir le résultat sous forme de tableau associatif
        $prepareTabTemp = $this->formatData($prepareTemp);

        //retourn le tableau associatife du login
        return $prepareTabTemp[0];
    }

    /**
     * 
     */
    public function getMatchAthlete($idAthlete)
    {
        //récupére l'id de l'athlete et l'id du coach qui on matche ensemble
        $query = "SELECT fkAthlete, fkCoach, athEmail, coaEmail FROM t_select JOIN `t_coach` ON `idCoach`=`fkCoach` JOIN `t_athlete` ON `idAthlete`=`fkAthlete` WHERE fkAthlete = :fkAthlete && validateCoach = 1";

        $binds['fkAthlete']=['value'=>$idAthlete,'type'=>PDO::PARAM_STR];

        // appeler la méthode pour executer la requête
        $prepareTemp = $this->queryPrepareExecute($query,$binds);
        //appeler la méthode pour avoir le résultat sous forme de tableau associatif
        $prepareTabTemp = $this->formatData($prepareTemp);

        //retourn le tableau associatife du login
        return $prepareTabTemp;
    }

    /**
     * 
     */
    public function getMatchCoache($idCoach)
    {
        //récupére l'id de l'athlete et l'id du coach qui on matche ensemble
        $query = "SELECT fkAthlete, fkCoach, athEmail, coaEmail FROM t_select JOIN `t_coach` ON `idCoach`=`fkCoach` JOIN `t_athlete` ON idAthlete=fkAthlete WHERE fkCoach = :fkCoach && validateCoach = 1";

        $binds['fkCoach']=['value'=>$idCoach,'type'=>PDO::PARAM_STR];

        // appeler la méthode pour executer la requête
        $prepareTemp = $this->queryPrepareExecute($query,$binds);
        //appeler la méthode pour avoir le résultat sous forme de tableau associatif
        $prepareTabTemp = $this->formatData($prepareTemp);

        //retourn le tableau associatife du login
        return $prepareTabTemp;
    }

    /**
     * 
     */
    public function getMatchMessage($idAthlete,$idCoach)
    {
        //récupére l'id de l'athlete et l'id du coach qui on matche ensemble
        $query = "SELECT idMessage,mesMessage,fkCoach,fkAthlete,fkMessageSendBy FROM t_message WHERE fkCoach = :fkCoach && fkAthlete = :fkAthlete";

        $binds['fkCoach']=['value'=>$idCoach,'type'=>PDO::PARAM_STR];
        $binds['fkAthlete']=['value'=>$idAthlete,'type'=>PDO::PARAM_STR];

        // appeler la méthode pour executer la requête
        $prepareTemp = $this->queryPrepareExecute($query,$binds);
        //appeler la méthode pour avoir le résultat sous forme de tableau associatif
        $prepareTabTemp = $this->formatData($prepareTemp);

        //retourn le tableau associatife du login
        return $prepareTabTemp;
    }
    
    /**
     * 
     */
    public function createMessage($message,$idAthlete,$idCoach,$idSendBy)
    {
        $query="INSERT INTO t_message(mesMessage, fkAthlete, fkCoach, fkMessageSendBy) VALUES (:mesMessage, :fkAthlete, :fkCoach, :fkMessageSendBy)";

        $binds["mesMessage"]=["value"=>$message, "type"=>PDO::PARAM_STR];
        $binds["fkAthlete"]=["value"=>$idAthlete, "type"=>PDO::PARAM_INT];
        $binds["fkCoach"]=["value"=>$idCoach, "type"=>PDO::PARAM_INT];
        $binds["fkMessageSendBy"]=["value"=>$idSendBy, "type"=>PDO::PARAM_INT];

        $this->queryPrepareExecute($query, $binds);
    }

    /**
     * 
     */
    public function getOneMessage($id)
    {
        $query = "SELECT idMessage,mesMessage,fkCoach,fkAthlete,fkMessageSendBy FROM t_message WHERE idMessage = :idMessage";

        $binds['idMessage']=['value'=>$id,'type'=>PDO::PARAM_INT];

        $prepareTemp = $this->queryPrepareExecute($query,$binds);

        $prepareTabTemp = $this->formatData($prepareTemp);

        return $prepareTabTemp;
    }

    /**
     * 
     */
    public function deletQuestion($idMessageToDelet)
    {
        $query = "DELETE FROM t_message WHERE idMessage = :idMessage";

        $binds["idMessage"]=["value"=>$idMessageToDelet, "type"=>PDO::PARAM_INT];

        $this->queryPrepareExecute($query, $binds);
    }
    
    /**
     * 
     */
    public function findNextCoach($idCoachToDisplay)
    {
        $query = "SELECT idCoach,coaName,coaSurname,coaEmail,coaPassword,coaPhone,coaExperience,coaImage FROM t_coach WHERE idCoach = :idNextCoach";
        
        $binds["idNextCoach"]=["value"=>$idCoachToDisplay, "type"=>PDO::PARAM_INT];
        
        $prepareTemp = $this->queryPrepareExecute($query,$binds);

        $prepareTabTemp = $this->formatData($prepareTemp);

        return $prepareTabTemp;
    }
    
    /**
     * 
     */
    public function findNextAthlete($idMe, $idAthleteToDisplay)
    {
        $query = "SELECT `idAthlete`,`athName`,`athSurname`,`athEmail`,`athPassword`,`athPhone`,`athTown`,`athNPA` 
        FROM `t_athlete` JOIN t_select ON `fkAthlete`=`idAthlete` 
        WHERE fkCoach = :idMe && `validateCoach` = 0 && `fkAthlete` = :idAthleteToDisplay ORDER BY fkAthlete ASC LIMIT 1";
        
        $binds["idMe"]=["value"=>$idMe, "type"=>PDO::PARAM_INT];
        $binds["idAthleteToDisplay"]=["value"=>$idAthleteToDisplay, "type"=>PDO::PARAM_INT];
        
        $prepareTemp = $this->queryPrepareExecute($query,$binds);

        $prepareTabTemp = $this->formatData($prepareTemp);

        return $prepareTabTemp;
    }

    /**
     * 
     */
    public function getOneCoachAlreadyMatch($idAthlete,$idCoach)
    {
        $query = "SELECT fkAthlete, fkCoach, athEmail, coaEmail FROM t_select JOIN t_coach ON idCoach=fkCoach JOIN t_athlete ON idAthlete=fkAthlete WHERE fkAthlete = :idAthlete && fkCoach = :idCoach";

        $binds["idAthlete"]=["value"=>$idAthlete, "type"=>PDO::PARAM_INT];
        $binds["idCoach"]=["value"=>$idCoach, "type"=>PDO::PARAM_INT];
        
        $prepareTemp = $this->queryPrepareExecute($query,$binds);

        $prepareTabTemp = $this->formatData($prepareTemp);

        return $prepareTabTemp;
    }

    /**
     * 
     */
    public function selectCoachByAthlete($idAthlete,$idCoach)
    {
        $query="INSERT INTO t_select (fkAthlete, fkCoach) VALUES (:idAthlete, :idCoach)";

        $binds["idAthlete"]=["value"=>$idAthlete, "type"=>PDO::PARAM_INT];
        $binds["idCoach"]=["value"=>$idCoach, "type"=>PDO::PARAM_INT];

        $this->queryPrepareExecute($query, $binds);
    }
    
    /**
     * 
     */
    public function getMaxCoachInDB()
    {
        $query = "SELECT `idCoach` FROM `t_coach` ORDER BY `idCoach` DESC LIMIT 1";
        $prepareTemp = $this->querySimpleExecute($query);
        $prepareTabTemp = $this->formatData($prepareTemp);

        return $prepareTabTemp[0];
    } 

    /**
     * 
     */
    public function getFirstAthleteMatchMeInDB($idCoach)
    {
        $query = "SELECT `fkAthlete` FROM `t_select` WHERE `fkCoach` = :fkCoach ORDER BY fkAthlete ASC LIMIT 1";

        $binds["fkCoach"]=["value"=>$idCoach, "type"=>PDO::PARAM_INT];
        
        $prepareTemp = $this->queryPrepareExecute($query,$binds);

        $prepareTabTemp = $this->formatData($prepareTemp);

        return $prepareTabTemp;
    } 

    /**
     * 
     */
    public function getNumberAthleteMatcheMehInDB($idCoach,$paramValid)
    {
        $query = "SELECT COUNT(fkAthlete) FROM t_select WHERE fkCoach = :fkCoach && validateCoach = :matchOrNot";
            
        $binds["fkCoach"]=["value"=>$idCoach, "type"=>PDO::PARAM_INT];
        $binds["matchOrNot"]=["value"=>$paramValid, "type"=>PDO::PARAM_INT];
        
        $prepareTemp = $this->queryPrepareExecute($query,$binds);

        $prepareTabTemp = $this->formatData($prepareTemp);

        return $prepareTabTemp[0];
    }
     
     /**
     * 
     */
    public function getNumberMatcheMehInDB($idCoach)
    {
        $query = "SELECT `fkAthlete` FROM `t_select` ORDER BY `fkAthlete` DESC LIMIT 1";
        
        $prepareTemp = $this->querySimpleExecute($query);

        $prepareTabTemp = $this->formatData($prepareTemp);

        return $prepareTabTemp;
    }

    /**
     * 
     */
    public function getNumberMatchByAthlete($idAthlete)
    {
        $query = "SELECT COUNT(fkCoach) FROM `t_select` WHERE fkAthlete = :idAthlete";
        
        $binds["idAthlete"]=["value"=>$idAthlete, "type"=>PDO::PARAM_INT];
        
        $prepareTemp = $this->queryPrepareExecute($query,$binds);

        $prepareTabTemp = $this->formatData($prepareTemp);

        return $prepareTabTemp[0];
    }

    /**
     * 
     */
    public function valideMatch($idAthlete, $idCoach)
    {
        $query = "UPDATE t_select SET `validateCoach` = 1 WHERE `fkAthlete` = :fkAthlete && `fkCoach` = :fkCoach";
        
        $binds["fkAthlete"]=["value"=>$idAthlete, "type"=>PDO::PARAM_INT];
        $binds["fkCoach"]=["value"=>$idCoach, "type"=>PDO::PARAM_INT];
        
        $prepareTemp = $this->queryPrepareExecute($query,$binds);

        $prepareTabTemp = $this->formatData($prepareTemp);

        return $prepareTabTemp;
    }
    
    /**
     * permet de modifier les information de l'utilisateur
     */
    public function modifyAthlete($id,$name,$surname,$email,$phone,$town,$npa,$password)
    {
        $query="UPDATE `t_athlete` SET athName = :athName, athSurname = :athSurname , athEmail = :athEmail , athPassword = :athPassword , athPhone = :athPhone , athTown = :athTown , athNPA = :athNPA WHERE idAthlete = :idAthlete";

        $binds["idAthlete"]=["value"=>$id, "type"=>PDO::PARAM_INT];
        $binds["athName"]=["value"=>$name, "type"=>PDO::PARAM_STR];
        $binds["athSurname"]=["value"=>$surname, "type"=>PDO::PARAM_STR];
        $binds["athEmail"]=["value"=>$email, "type"=>PDO::PARAM_STR];
        $binds["athPhone"]=["value"=>$phone, "type"=>PDO::PARAM_STR];
        $binds["athTown"]=["value"=>$town, "type"=>PDO::PARAM_STR];
        $binds["athNPA"]=["value"=>$npa, "type"=>PDO::PARAM_STR];
        $binds["athPassword"]=["value"=>$password, "type"=>PDO::PARAM_STR];
        
        $this->queryPrepareExecute($query, $binds);
    }

    /**
     * permet de modifier les information de l'utilisateur
     */
    public function modifyCoach($id,$name,$surname,$email,$phone,$experience,$image,$password)
    {
        $query="UPDATE `t_coach` SET coaName = :coaName, coaSurname = :coaSurname , coaEmail = :coaEmail , coaPhone = :coaPhone , coaExperience = :coaExperience , coaImage = :coaImage , coaPassword = :coaPassword WHERE idCoach = :idCoach";

        $binds["idCoach"]=["value"=>$id, "type"=>PDO::PARAM_INT];
        $binds["coaName"]=["value"=>$name, "type"=>PDO::PARAM_STR];
        $binds["coaSurname"]=["value"=>$surname, "type"=>PDO::PARAM_STR];
        $binds["coaEmail"]=["value"=>$email, "type"=>PDO::PARAM_STR];
        $binds["coaPhone"]=["value"=>$phone, "type"=>PDO::PARAM_STR];
        $binds["coaExperience"]=["value"=>$experience, "type"=>PDO::PARAM_STR];
        $binds["coaImage"]=["value"=>$image, "type"=>PDO::PARAM_STR];
        $binds["coaPassword"]=["value"=>$password, "type"=>PDO::PARAM_STR];
        
        $this->queryPrepareExecute($query, $binds);
    }

    /**
     * 
     */
    public function getActivityCoach($idCoach)
    {
        $query = "SELECT actActivite FROM `t_do` JOIN t_activity ON idActivity=fkActivity WHERE `fkCoach` = :fkCoach";
        
        $binds["fkCoach"]=["value"=>$idCoach, "type"=>PDO::PARAM_INT];
        
        $prepareTemp = $this->queryPrepareExecute($query,$binds);

        $prepareTabTemp = $this->formatData($prepareTemp);

        return $prepareTabTemp;
    }

    /**
    * Fonction pour se connecter au site en tant qu'coach
    *Paramètre : $email*/
    public function connexionCoach($email)
    {
        // Requête SQL
        $query = "SELECT coaName, coaSurname, coaEmail, coaPassword, coaPhone, coaExperience, coaImage, coaIsAdministrator FROM t_coach WHERE coaEmail=:email";

        // Mettre dans un bind la valeur de l'email
        $binds['email']=['value'=>$email,'type'=>PDO::PARAM_STR];

        // Executer avec une requête préparer la requête et avec le bind
        $prepareTemp = $this->queryPrepareExecute($query, $binds);

        // Retourner en tableau associatif
        $prepareTabTemp = $this->formatData($prepareTemp);

        // Retourner le tableau
        return $prepareTabTemp;
    }

    /**
    * Fonction pour se connecter au site en tant qu'athlete
    *Paramètre : $email*/
    public function connexionAthlete($email)
    {
        // Requête SQL
        $query = "SELECT athName, athSurname, athEmail, athPassword, athPhone, athTown, athNPA, athIsAdministrator FROM t_athlete WHERE athEmail=:email";

        // Mettre dans un bind la valeur de l'email
        $binds['email']=['value'=>$email,'type'=>PDO::PARAM_STR];

        // Executer avec une requête préparer la requête et avec le bind
        $prepareTemp = $this->queryPrepareExecute($query, $binds);

        // Retourner en tableau associatif
        $prepareTabTemp = $this->formatData($prepareTemp);

        // Retourner le tableau
        return $prepareTabTemp;
    }

 /**
    * Fonction pour crée un compte de Athlete sur le site
    *Paramètre : $name, $surname, $email, $password, $phone, $town, $npa*/
    public function registerAthlete($name, $surname, $email, $password, $phone, $town, $npa)
    {
        // Requête SQL
        $query = "INSERT INTO `t_athlete`(`athName`, `athSurname`, `athEmail`, `athPassword`, `athPhone`, `athTown`, `athNPA`) VALUES (:athName, :athSurname, :athEmail, :athPassword, :athPhone, :athTown, :athNPA)";

        // Mettre dans un bind la valeur du nom
        $binds['athName']=['value'=>$name,'type'=>PDO::PARAM_STR];     

        // Mettre dans un bind la valeur du prénom
        $binds['athSurname']=['value'=>$surname,'type'=>PDO::PARAM_STR];

        // Mettre dans un bind la valeur de la l'email
        $binds['athEmail']=['value'=>$email,'type'=>PDO::PARAM_STR];

        // Mettre dans un bind la valeur du mot de passe
        $binds['athPassword']=['value'=>$password,'type'=>PDO::PARAM_STR];
    
        // Mettre dans un bind la valeur du téléphone
        $binds['athPhone']=['value'=>$phone,'type'=>PDO::PARAM_STR];

        // Mettre dans un bind la valeur de la ville
        $binds['athTown']=['value'=>$town,'type'=>PDO::PARAM_STR];

        // Mettre dans un bind la valeur du code postal
        $binds['athNPA']=['value'=>$npa,'type'=>PDO::PARAM_STR];

        // Executer avec une requête préparer la requête et avec le bind
        $this->queryPrepareExecute($query, $binds);
    }   
    
    /**
    * Fonction pour crée un compte de coach sur le site
    *Paramètre : $name, $surname, $email, $password, $phone, $experience, $image*/
    public function registerCoach($name, $surname, $email, $password, $phone, $experience, $image)
    {
        // Requête SQL
        $query = "INSERT INTO `t_coach`(`coaName`, `coaSurname`, `coaEmail`, `coaPassword`, `coaPhone`, `coaExperience`, `coaImage`) VALUES (:coaName, :coaSurname, :coaEmail, :coaPassword, :coaPhone, :coaExperience, :coaImage)";

        // Mettre dans un bind la valeur du nom
        $binds['coaName']=['value'=>$name,'type'=>PDO::PARAM_STR];     

        // Mettre dans un bind la valeur du prénom
        $binds['coaSurname']=['value'=>$surname,'type'=>PDO::PARAM_STR];

        // Mettre dans un bind la valeur de la l'email
        $binds['coaEmail']=['value'=>$email,'type'=>PDO::PARAM_STR];

        // Mettre dans un bind la valeur du mot de passe
        $binds['coaPassword']=['value'=>$password,'type'=>PDO::PARAM_STR];
    
        // Mettre dans un bind la valeur du téléphone
        $binds['coaPhone']=['value'=>$phone,'type'=>PDO::PARAM_STR];

        // Mettre dans un bind la valeur de la ville
        $binds['coaExperience']=['value'=>$experience,'type'=>PDO::PARAM_STR];

        // Mettre dans un bind la valeur du code postal
        $binds['coaImage']=['value'=>$image,'type'=>PDO::PARAM_STR];

        // Executer avec une requête préparer la requête et avec le bind
        $this->queryPrepareExecute($query, $binds);
    }
    
    /**
     * 
     */
    public function stopMatch($idAthlete,$idCoach)
    {
        $query="DELETE FROM `t_select` WHERE `fkAthlete`= :idAthlete && `fkCoach` = :idCoach";

        $binds["idAthlete"]=["value"=>$idAthlete, "type"=>PDO::PARAM_INT];
        $binds["idCoach"]=["value"=>$idCoach, "type"=>PDO::PARAM_INT];
        
        $this->queryPrepareExecute($query, $binds);
    }
}
?>