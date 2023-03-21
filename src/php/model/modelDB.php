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
     * TODO: à compléter
     */
    private function querySimpleExecute($query)
    {
        // Utilisation de query pour effectuer une requête
        return $this->connector->query($query);
    }

    /**
     * TODO: à compléter
     */
    private function queryPrepareExecute($query, $binds)
    {
        try
        {
            // Utilisation de prepare, bindValue et execute
            $req = $this->connector->prepare($query);

            foreach($binds as $tableKey=>$recipe)
            {
                //associe les valeurs dans un tableau associatife
                $req->bindValue(":$tableKey", $recipe['value'], $recipe['type']);
            }
            
            $req->execute();
            return $req;
        }
        catch (PDOException $e)
        {
            die('Erreur : ' . $e->getMessage());
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
     * 
     */
    public function getOneAthlete($email)
    {
        //récupére l'id de l'utilisateur, le login, l'email, le mot de passe, si oui ou non il est admin
        $query = "SELECT idAthlete, athName, athSurname, athEmail, athPassword, athPhone, athStreet, athTown, athNPA FROM t_athlete WHERE athEmail = :athEmail";
        //avoir la requête sql pour un utilisateur (utilisation de l'emial de l'utilisateur)
        $binds['athEmail']=['value'=>$email,'type'=>PDO::PARAM_STR];

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

    public function checkIsAthleteOrCoach($email)
    {
        //appelle la méthode pour récupérer les info sur l'athlete
        $status = $this->getOneAthlete($email);
        //met la variable de session a 1 pour dire que c'est un athlete
        $_SESSION["status"] = 1;

        //regarde si la variable status est vide (donc que aucun athlete corresspond avec se mail)
        if (empty($status))
        {
            //appelle la méthode pour récupérer les info sur le coach
            $status = $this->getOneCoach($email);
            //met la variable de session a 2 pour dire que c'est un coach
            $_SESSION["status"] = 2;
        }

        return $status;
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

        $binds["idAthlete"]=["value"=>$idAthlete, "type"=>PDO::PARAM_STR];
        $binds["idCoach"]=["value"=>$idCoach, "type"=>PDO::PARAM_INT];

        $this->queryPrepareExecute($query, $binds);
    }
}


?>