<nav class="navbar navbar-expand-lg navbar-light ">
    <button class="navbar-toggler custom-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-between" id="navbarTogglerDemo01">
        <a class="navbar-brand" href="index.php"><img src="images/logoSVG3.svg" alt="logo de NDG Le Club"></a>
        <ul class="navbar-nav  mt-2 mt-lg-0 justify-content-end">
            <li class="nav-item ">
<!--                <a class="nav-link text-white btn btn-transparent text-uppercase" href="index.php">accueil</a>-->
                <a class="nav-link text-white " href="index.php"><button type="button" class="btn <?php if(CATEGORIE == 'accueil') {echo ' active';} ?> rounded-0 ">Accueil</button></a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="#"><button type="button" class="btn ">Installations</button></a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="#"><button type="button" class="btn ">Équipe</button></a>
            </li>
            <li class="nav-item ">
                <?php if (!isset($_SESSION['identifiant_utilisateur'])) : ?>
                <a class="nav-link text-white" href="#"><button type="submit" name="envoi" date-focus="true" data-backdrop="static" data-keyboard="false" class="btn " data-toggle="modal" data-target="#exampleModalCenter">Se connecter</button></a>
                <?php else : ?>
                <a class="nav-link text-white" href="deconnexion.php"><button type="submit" name="envoi" class="btn ">Se Déconnecter</button><span><i class="fas fa-user-circle"></i></span></a>
                
                <?php endif; ?>
            </li>
        </ul> <!-- end ul part -->
    </div>
</nav> <!-- end nav container -->