<?php
/**
 * Auteur : Yann Hofstetter
 * Date : 18.11.2022
 * Description : toutes les requettes pour intéragire avec la db
 */


 class Database {


    // Variable de classe
    private $connector;

    /**
     * TODO: à compléter
     */
    private function __construct()
    {
        //se connecte via PDO
        try
        {
            $this->connector = new PDO(DB_CONFIG , DB_USER, $this->getPassword(),array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));;
        }
        catch (PDOException $e)
        {
            die('Erreur : ' . $e->getMessage());
        }
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
     * TODO: à compléter
     */
    private function unsetData($req)
    {
        // Vider le jeu d'enregistrements
        $req->closeCursor();
    }

    /**
     * TODO: à compléter
     */
    public function getAllRecipes()
    {
        //séléctionne le nom,les information sur la préparation, l'id de la recette, l'id de la catégorie, le nom de la catégorie (trié grace a l'id des catégorie pour avoir les produits dans l'ordre qu'on mange)
        $query = 'SELECT recName,recPicture,recCookingInfo,idRecipes,idCategory,catName FROM t_recipes JOIN t_category ON fkCategory=idCategory ORDER BY `t_category`.`idCategory` ASC';
        //utiliser ca cette fois car pas de WHERE donc faut pas utiliser queryPrepareExecute
        $temp = $this->querySimpleExecute($query);
        $tabTemp = $this->formatData($temp);

        return $tabTemp;
        // TODO: récupère la liste de tous les enseignants de la BD
        // TODO: avoir la requête sql
        // TODO: appeler la méthode pour executer la requête
        // TODO: appeler la méthode pour avoir le résultat sous forme de tableau
        // TODO: retour tous les enseignants
    }

    /**
     * TODO: à compléter
     */
    public function getOneRecipes($id)
    {
        $query = "SELECT recName, recPicture, recIngredients, recCookingInfo,recUstensils,catName FROM t_recipes JOIN t_category ON fkCategory=idCategory WHERE idRecipes = :prepareId";
        $binds['prepareId']=['value'=>$id,'type'=>PDO::PARAM_INT];
        $prepareTemp = $this->queryPrepareExecute($query,$binds);
        $prepareTabTemp = $this->formatData($prepareTemp);

        //[0] car 1 seul élément
        return $prepareTabTemp[0];

        // TODO: récupére la liste des informations pour 1 enseignant
        // TODO: avoir la requête sql pour 1 enseignant (utilisation de l'id)
        // TODO: appeler la méthode pour executer la requête
        // TODO: appeler la méthode pour avoir le résultat sous forme de tableau
        // TODO: retour l'enseignant
    }
    
    private function getPassword()
    {
        // lire le fichier JSON 
        $json = file_get_contents(__DIR__.'/../Json/Secret.json');
        
        //Decode le fichier JSON
        $json_data = json_decode($json,true);

        //retourn le mot de passe
        return $json_data["password"];
    }

    private static $instance = null;

    public static function getInstance()
    {
        //regarde si la base de donnée n'est pas créer
        if (is_null(self::$instance))
        {
            //crée une nouvelle base de données
            self::$instance = new Database();
        }
        //retourne la base de données
        return self::$instance;
    }

    public function insertRecipes($name,$picture,$ingredients,$cookingInfo,$utensils,$category)
    {
        $query="INSERT INTO t_recipes(recName, recPicture, recIngredients, recCookingInfo, recUstensils, fkCategory) VALUES (:recName, :recPicture, :recIngredients, :recCookingInfo , :recUstensils, :fkCategory )";

        $binds["recName"]=["value"=>$name, "type"=>PDO::PARAM_STR];
        $binds["recPicture"]=["value"=>$picture, "type"=>PDO::PARAM_STR];
        $binds["recIngredients"]=["value"=>$ingredients, "type"=>PDO::PARAM_STR];
        $binds["recCookingInfo"]=["value"=>$cookingInfo, "type"=>PDO::PARAM_STR];
        $binds["recUstensils"]=["value"=>$utensils, "type"=>PDO::PARAM_STR];
        $binds["fkCategory"]=["value"=>$category, "type"=>PDO::PARAM_INT];

        $this->queryPrepareExecute($query, $binds);
    }

    public function deletRecipes($idRecipes,$pictureName)
    {
        $query = "DELETE FROM t_recipes WHERE idRecipes = :idRecipes";

        $binds["idRecipes"]=["value"=>$idRecipes, "type"=>PDO::PARAM_INT];

        //regarde que la suppression c'est bien passé
        if($this->queryPrepareExecute($query, $binds))
        {
            $this->deletOldImage($pictureName);
        }
    }

    /**
     * permet de supprimer l'ancienne image de la recette (utile quand on modifie l'image pour l'enlever du fichier qui stoque les images ou quand on supprime le produit pour enlever l'image)
     */
    public function deletOldImage($pictureName)
    {
        //regarde que l'image du produit n'est pas l'image de quand il n'y a pas d'image chargée et que ce n'est pas une des images des recettes ajoutées par défaut (pour que si on supprime une de ces recettes et qu'on remette la db la photo reviennent)
        if ($pictureName != "no_picture.png" && $pictureName != "20221223125514Soupe de potiron paysanne.webp" && $pictureName != "20221223125514Bûche tiramisu-chocolat.webp" && $pictureName != "20221223125915Terrine de foies de volaille.webp")
        {
            //supprime l'image du répértoire des images
            unlink("../../userContent/images/picture_recipes/".$pictureName);
        }
    }

    /**
     * permet de modifier une recette
     */
    public function modifyRecipes($id,$name,$picture,$ingredients,$cookingInfo,$ustensils,$category)
    {
        $query="UPDATE t_recipes SET recName = :recName, recPicture = :recPicture, recIngredients = :recIngredients, recCookingInfo = :recCookingInfo, recUstensils = :recUstensils, fkCategory =:fkCategory WHERE idRecipes = :id";

        $binds["id"]=["value"=>$id, "type"=>PDO::PARAM_INT];
        $binds["recName"]=["value"=>$name, "type"=>PDO::PARAM_STR];
        $binds["recPicture"]=["value"=>$picture, "type"=>PDO::PARAM_STR];
        $binds["recIngredients"]=["value"=>$ingredients, "type"=>PDO::PARAM_STR];
        $binds["recCookingInfo"]=["value"=>$cookingInfo, "type"=>PDO::PARAM_STR];
        $binds["recUstensils"]=["value"=>$ustensils, "type"=>PDO::PARAM_STR];
        $binds["fkCategory"]=["value"=>$category, "type"=>PDO::PARAM_INT];

        $this->queryPrepareExecute($query, $binds);
    }

    /**
     * permet de récupérer toutes les catégorie de recette
     */
    public function getAllCategory()
    {
        $query = 'SELECT idCategory,catName FROM t_category';
        //utiliser ca cette fois car pas de WHERE donc faut pas utiliser queryPrepareExecute
        $temp = $this->querySimpleExecute($query);
        $tabTemp = $this->formatData($temp);

        return $tabTemp;
    }

    /**
     * permet de récupérer la derniere recette ajouté
     */
    public function getLastRecipe()
    {
        //selectionne uniquement la dernierre recette (la dernierre est trouvé grace a son id on prend l'id le plus grand)
        $query = "SELECT idRecipes, recPicture, recName FROM t_recipes ORDER BY `idRecipes` DESC LIMIT 1";
        $prepareTemp = $this->querySimpleExecute($query);
        $prepareTabTemp = $this->formatData($prepareTemp);

        return $prepareTabTemp;
    } 

    /**
     * permet de récupérer les informations sur un utilisateur déjà créer dans la db
     */
    public function getOneUser($email)
    {
        //récupére l'id de l'utilisateur, le login, l'email, le mot de passe, si oui ou non il est admin
        $query = "SELECT idUser, usePseudo, useEmail, usePassword, useAdministrator FROM t_user WHERE useEmail = :useEmail";
        //avoir la requête sql pour un utilisateur (utilisation de l'emial de l'utilisateur)
        $binds['useEmail']=['value'=>$email,'type'=>PDO::PARAM_STR];

        // appeler la méthode pour executer la requête
        $prepareTemp = $this->queryPrepareExecute($query,$binds);
        //appeler la méthode pour avoir le résultat sous forme de tableau associatif
        $prepareTabTemp = $this->formatData($prepareTemp);

        //retourn le tableau associatife du login
        return $prepareTabTemp;
    }

    /**
     * permet de récupérer touts les informations sur les utilisateurs déjà créer dans la db
     */
    public function getAllUsers()
    {
        $query = 'SELECT idUser, usePseudo, useEmail, usePassword, useAdministrator FROM t_user';
        
        //utiliser ca cette fois car pas de WHERE donc faut pas utiliser queryPrepareExecute
        $temp = $this->querySimpleExecute($query);
        //appeler la méthode pour avoir le résultat sous forme de tableau associatif
        $tabTemp = $this->formatData($temp);

        return $tabTemp;
    }

    /**
     * permet de créer un nouvelle utilisateur
     */
    public function createLogin($pseudo,$email,$password)
    {
        $query="INSERT INTO t_user(usePseudo, useEmail, usePassword) VALUES (:useLogin, :useEmail, :usePassword)";

        $binds["useLogin"]=["value"=>$pseudo, "type"=>PDO::PARAM_STR];
        $binds["useEmail"]=["value"=>$email, "type"=>PDO::PARAM_STR];
        $binds["usePassword"]=["value"=>$password, "type"=>PDO::PARAM_STR];

        $this->queryPrepareExecute($query, $binds);
    }

    /**
     * permet de créer une nouvelle question créer par un utilisateur
     */
    public function createQuestion($name,$description,$idUser)
    {
        $query="INSERT INTO t_question(queName, queDescription, fkUser) VALUES (:queName, :queDescription, :fkUser)";

        $binds["queName"]=["value"=>$name, "type"=>PDO::PARAM_STR];
        $binds["queDescription"]=["value"=>$description, "type"=>PDO::PARAM_STR];
        $binds["fkUser"]=["value"=>$idUser, "type"=>PDO::PARAM_INT];

        $this->queryPrepareExecute($query, $binds);
    }

    /**
     * permet de récupérer toutes les questions des utilisateurs
     */
    public function getAllQuestions()
    {
        $query = 'SELECT idQuestion, queName, usePseudo FROM t_question JOIN t_user ON fkUser=idUser WHERE `queAlreadyAnswered` = 0 ORDER BY `idQuestion` ASC';

        //utiliser ca cette fois car pas de WHERE donc faut pas utiliser queryPrepareExecute
        $temp = $this->querySimpleExecute($query);
        //appeler la méthode pour avoir le résultat sous forme de tableau associatif
        $tabTemp = $this->formatData($temp);

        return $tabTemp;
    }

    /**
     * permet de récupérer une seul question posé par un utilisateur
     */
    public function getOneQuestions($id)
    {
        $query = "SELECT idQuestion, queName, queDescription, queAnswer, usePseudo, useEmail FROM t_question JOIN t_user ON fkUser=idUser WHERE idQuestion = :prepareId";
        $binds['prepareId']=['value'=>$id,'type'=>PDO::PARAM_INT];
        $prepareTemp = $this->queryPrepareExecute($query,$binds);
        $prepareTabTemp = $this->formatData($prepareTemp);

        //[0] car 1 seul élément
        return $prepareTabTemp[0];
    }

    /**
     * permet de modifier la réponse au question des utilisateurs
     */
    public function answerQuestion($id,$answer)
    {
        $query="UPDATE t_question SET queAnswer = :queAnswer WHERE idQuestion = :prepareId"; 

        $binds["prepareId"]=["value"=>$id, "type"=>PDO::PARAM_INT];
        $binds["queAnswer"]=["value"=>$answer, "type"=>PDO::PARAM_STR];
        
        $this->queryPrepareExecute($query, $binds);

        //appelle la méthode pour modifier la valeur de si oui ou non la question a été répondu
        $this->questionAreAnswered($id);
    }

    /**
     * permet de modifie la valeur de si oui ou non la question a été répondu
     */
    public function questionAreAnswered($id)
    {
        $query="UPDATE t_question SET queAlreadyAnswered = '1' WHERE idQuestion = :prepareId";

        $binds["prepareId"]=["value"=>$id, "type"=>PDO::PARAM_INT];
        
        $this->queryPrepareExecute($query, $binds);
    }

    /**
     * permet de modifier la réponse au question des utilisateurs
     */
    public function answerOfMyQuestion($idUser)
    {
        $query = "SELECT idQuestion, queName FROM t_question WHERE fkUser = :userId ORDER BY queAlreadyAnswered DESC";
        
        $binds['userId']=['value'=>$idUser,'type'=>PDO::PARAM_INT];

        $prepareTemp = $this->queryPrepareExecute($query,$binds);
        $prepareTabTemp = $this->formatData($prepareTemp);

        //[0] car 1 seul élément
        return $prepareTabTemp;
    }

    /**
     * permet de supprimer une question posé par nous (si on est connecter) ou par un administarateur
     */
    public function deletQuestion($idQuestionToDelet)
    {
        $query = "DELETE FROM t_question WHERE idQuestion = :idOfQuestion";
        
        $binds["idOfQuestion"]=["value"=>$idQuestionToDelet, "type"=>PDO::PARAM_INT];

        $this->queryPrepareExecute($query, $binds);
    }

    /**
     * permet de modifier les information de l'utilisateur
     */
    public function modifyUser($id,$pseudo,$email,$password)
    {
        $query="UPDATE t_user SET usePseudo = :usePseudo, useEmail = :useEmail, usePassword = :usePassword WHERE idUser = :id";

        $binds["id"]=["value"=>$id, "type"=>PDO::PARAM_INT];
        $binds["usePseudo"]=["value"=>$pseudo, "type"=>PDO::PARAM_STR];
        $binds["useEmail"]=["value"=>$email, "type"=>PDO::PARAM_STR];
        $binds["usePassword"]=["value"=>$password, "type"=>PDO::PARAM_STR];
        
        $this->queryPrepareExecute($query, $binds);
    }

}
?>