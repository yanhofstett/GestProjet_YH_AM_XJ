<?php
/**
 * Auteur : Yann Hofstetter
 * Date : 30.11.2022
 * Description : permet de supprimmer une recette
 */

    //ajoute le fichier qui gère les requette SQL
    include 'config.php';
    require "../model/modelDB.php";

    //appelle la méthode pour enlever le match
    Database::getInstance() -> stopMatch($_GET["idAthlete"],$_GET["idCoach"]);

    //redirige ver la page du menu principal
    header("Location: ../../../index.php?page=conv");
    exit;
?>