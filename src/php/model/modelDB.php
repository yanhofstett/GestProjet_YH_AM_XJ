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
            $this->connector = new PDO(PAVE, USER, $this->getPassword());
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
        $readJSONFile = file_get_contents(__DIR__.'/../controller/json/secret.json');

        // Décoder le fichier JSON
        $array = json_decode($readJSONFile, TRUE);

        // Retourner en tableau le mot de passe
        return $array["password"];
    }

}


?>