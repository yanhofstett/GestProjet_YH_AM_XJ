<!--
    Auteur : Yann Hofstetter
    Date : 07.12.2022
    Description : page qui permet de pouvoir afficher la barre de navigation sans devoir la mettre sur chaque page
-->

<!DOCTYPE html>
<html lang="fr">

    <!--la barre de navigation (importer depuis BootStrap)-->
    <header class="p-3 mb-3 border-bottom">
        <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
            <a class="d-flex align-items-center mb-2 mb-lg-0 text-dark text-decoration-none" href="./index.php">
                <img src="resources/images/Logo-AXY.png" width="72" height="32" alt="logo du site">
            </a>

            <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
            
            <li><a href="./index.php" class="nav-link px-2 link-secondary">Accueil</a></li>
           
            <li><a href="./index.php?page=conv" class="nav-link px-2 link-secondary">Conversation</a></li>
            
            <li><a href="#" class="nav-link px-2 link-secondary">#</a></li>
            
            </ul>
            
            <div class="dropdown text-end">
            <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="resources/images/login_logo.png" alt="login_logo" width="32" height="32" class="rounded-circle">
            </a>
            <ul class="dropdown-menu text-small">
                <!--ajoute les options de la liste déroulante-->
                <li><a class="dropdown-item" href="./index.php?page=profile">Profil</a></li>
                
                <!--met un trait pour séparer les option-->
                <li><hr class="dropdown-divider"></li>
                
                <!--affiche le bouton pour se déconnecté du site-->
                <li><a class="dropdown-item" href="src/php/view/login.php">Déconnexion</a></li>
            </ul>
            </div>
        </div>
        </div>
    </header>
</html>