<?php

/**
 * @file index.php.
 * @author      Leon Zhang .
 * @version     1.0.
 * @date        30 janvier 2019.
 * @brief       Page d'@b accueil du site.
 * @details     Cette page comporte un module d'@b authentification
 *              permettant au membre, moniteur ou à l'administrateur
 *              de se connecter si celui-ci possède un compte. Le module
 *              comporte renvoyant vers une page d'@b inscription si l'utilisateur
 *              non inscrit souhaite s'inscrire.
 */


require_once("inc/connectDB.php"); /** Connexion à la base de données.*/
require_once("inc/sessionUtilisateur.php"); /** Start session.*/
require_once("inc/fonctionsFichiers.php"); /** Fichiers contenant les fonctions.*/
define("CATEGORIE", "accueil");

$identifiant="";
$mot_de_passe="";
$erreur=true;
$fonction=""; /** Permet de sélectionner via le select la requête MySql adéquate.*/


if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['fonction']))
{
    $identifiant = trim($_POST['username']);  /** Retirer les espaces vides avant et après le mot saisi.*/
    $mot_de_passe = trim($_POST['password']); /** Retirer les espaces vides avant et après le mot saisi.*/
    $fonction= $_POST['fonction'];

    
    if (!preg_match('/[^@]+@[^\.]+\..+$/', $identifiant))
    {
        $erreur = false;
        echo "No"; /** À la valeur NO correspond un message d'erreur.*/
    }
    
    if (!preg_match('/^[A-Za-z]{1,8}\d$/', $mot_de_passe))
    {
        $erreur = false;
        echo "No"; /** À la valeur NO correspond un message d'erreur.*/
    }
    
    if($erreur==true)
    {
        if($fonction==1) /** 1 correspond au membre.*/
        {
                  
            if (AuthentificationUtilisateur($conn, $identifiant, $mot_de_passe)==1)
            {   
                $infoMembre = lireUtilisateur($conn, $identifiant);
                $_SESSION['nom'] = $infoMembre[0]['nom_utilisateur'];
                $_SESSION['prenom'] = $infoMembre[0]['prenom_utilisateur'];
                $_SESSION['id_utilisateur'] = $infoMembre[0]['id_utilisateur'];
                $_SESSION['identifiant_utilisateur'] = $identifiant;
                echo "01"; /** 01 correspond au membre.*/
            }
            else
            {
                echo "No"; /** À la valeur NO correspond un message d'erreur.*/
            }
        }
    
        if($fonction==2) /** 2 correspond à l'animateur.*/
        {
            if(AuthentificationGestionnaire($conn, $identifiant, $mot_de_passe, $fonction) === 1)
            {
                $infoAnimateur = lireGestionnaire($conn, $identifiant);
                $_SESSION['nom'] = $infoAnimateur[0]['nom'];
                $_SESSION['prenom'] = $infoAnimateur[0]['prenom'];
                $_SESSION['id_utilisateur'] = $infoAnimateur[0]['idgestions'];
                $_SESSION['identifiant_teacher'] = $identifiant;
                $identifiant="";
                $mot_de_passe="";
                echo "02"; /** 02 correspond au moniteur.*/
            }
            else
            {
                echo "No"; /** À la valeur NO correspond un message d'erreur.*/    
            }
        }
        
        if($fonction==3) /** 3 correspond à l'animateur.*/
        {
            if(AuthentificationGestionnaire($conn, $identifiant, $mot_de_passe, $fonction) === 1)
            {
                $_SESSION['identifiant_admin'] = $identifiant;
                $identifiant="";
                $mot_de_passe="";
                echo "03"; /** 03 correspond à l'administrateur.*/
            }
            else
            {
                echo "No"; /** À la valeur NO correspond un message d'erreur.*/   
            }
        }
    }
}
?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <?php require_once("head.php");?> <!-- head -->
    <title>NDG-Accueil</title>
</head>


<body>

<header>
    <?php require_once("header.php");?> <!-- header -->
</header> 
    
    
    

<div class="modal fade " id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 rounded-0">
            <div class="modal-header rounded-0">
                <h5 class="modal-title" id="exampleModalCenterTitle">Se connecter</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span class="croix" id="croix" aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- error message field -->
                <div id="message-erreur" class="message-erreur">
                    <p id="erreurbis2"></p>
                </div> <!-- end error message field -->

                <form class="formulaireindex">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Courriel</label>
                        <input type="email" name="username" id="username" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="john2@exemple.com" required autofocus>
                        <small id="emailHelp" class="form-text text-muted">Nous garantissons la confidentialité de votre courriel.</small>
                    </div>
                    <div class="form-group">
                        <label class="tootip" for="exampleInputPassword1">Mot de passe<i id="tootip" class="fas fa-question-circle mx-2"></i></label>
                        <span class="content-tooltip">8 lettres minuscules max. suvi d'un chiffre max.</span>
                        <input type="text" name="password" id="password" class="form-control" id="exampleInputPassword1" placeholder="Exemple : john2" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputSelect1">Identifiez-vous</label>
                        <select name="fonction" id="fonction" class="custom-select" id="exampleInputSelect1">
                            <option value="1">Membre du club</option>
                            <option value="2">Moniteur de sport</option>
                            <option value="3">Administrateur du site</option>
                        </select>
                    </div>
                    <div class="centrer-bouton">
                        <button type="button" name="envoi" id="envoyer" class="btn btn-sm  text-white">Envoyer</button>
                    </div>
                </form> <!-- end form -->
                
            </div> <!-- end modal body -->
            <div class="modal-footer text-white">
                <a class="text-white" id="bouton-onglet" href="inscription.php"><i class="fas fa-user-alt mr-2"></i>S'inscrire</a>
            </div> <!-- end footer modal -->
        </div> <!-- end modal content -->
    </div> <!-- end modal wrapper -->
</div> <!-- end modal main container -->




<div class="container-fluid">
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol> <!-- end carousel indicators -->
        <div class="carousel-inner ">
            <div class="carousel-item active">
                <img class="d-block w-100 h-100" src="images/action-athlete-blue-863988R.jpg" alt="First slide">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100 h-100" src="images/balance-beach-exercise-317157RRRRR.jpg" alt="Second slide">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100 h-100" src="images/action-athlete-barbell-841130R.jpg" alt="Third slide">
            </div>
        </div> <!-- end carousel inner -->
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span> <!-- left control carousel -->
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span> <!-- right control carousel -->
            <span class="sr-only">Next</span>
        </a>
    </div> <!-- end carousel container -->


    <section>
        <h1 class="text-center" id="activites">Activités sportives</h1>
        <p class="text-center">Le Club NDG compte les meilleurs professionnels pour vous offrir des activités sportives de qualité. En nous rejoignant, vous bénéficierez d'installations modernes et de l'encadrement d'un personnel tout entier dévoué à ce que chez nous, vous vous sentiez chez vous.</p>
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100 text-center">
                    <div class="card-header">Yoga</div>
                    <img class="card-img-top rounded-0" src="./images/card_yoga.jpg" alt="image yoga">
                    <div class="card-body">
                        <p class="card-text">Offrez-vous des plages relaxation avec notre animateur de yoga.</p>
                        <a class="nav-link" href="yoga.php"><button type="button" class="btn text-white bouton-card">Plus d'infos</button></a>
                    </div>
                </div> <!-- end card wrapper  -->
            </div> <!-- end card container number 1  -->

            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100 text-center">
                    <div class="card-header">Musculation</div>
                    <img class="card-img-top rounded-0" src="./images/card_musculation%20copie.jpg" alt="image Musculation">
                    <div class="card-body">
                        <p class="card-text">Venez profiter de nos équipements de musculation de qualité.</p>
                        <a class="nav-link " href="musculation.php"><button type="button" class="btn text-white bouton-card"> Plus d'infos</button></a>
                    </div>
                </div> <!-- end card wrapper  -->
            </div> <!-- end card container number 2  -->

            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100 text-center">
                    <div class="card-header">Natation</div>
                    <img class="card-img-top rounded-0" src="./images/card_natation.jpg" alt="image natation">
                    <div class="card-body ">
                        <p class="card-text">Envie de faire des longueurs ? Nos bassins n'attendent que vous !</p>
                        <a class="nav-link " href="natation.php"><button type="button" class="btn text-white bouton-card"> Plus d'infos</button></a>
                    </div>
                </div> <!-- end card wrapper  -->
            </div> <!-- end card container number 3  -->

            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100 text-center">
                    <div class="card-header">Tennis</div>
                    <img class="card-img-top rounded-0" src="./images/card_tennis.jpg" alt="Card image tennis">
                    <div class="card-body">
                        <p class="card-text">Vous adorerez nos courts et les conseils de notre professeur.</p>
                        <a class="nav-link " href="tennis.php"><button type="button" class="btn text-white bouton-card"> Plus d'infos</button></a>
                    </div>
                </div> <!-- end card wrapper  -->
            </div> <!-- end card container number 4  -->

            <div class="col-lg-4 col-md-6 mb-4">
                <div class=" card h-100 text-center">
                    <div class="card-header">Basketball</div>
                    <img class="card-img-top rounded-0" src="./images/card_basket.jpg" alt="image Basketball">
                    <div class="card-body">
                        <p class="card-text">Nos équipes de soccer attendent que de nouvelles recrues arrivent.</p>
                        <a class="nav-link " href="basketball.php"><button type="button" class="btn text-white bouton-card"> Plus d'infos</button></a>
                    </div>
                </div> <!-- end card wrapper  -->
            </div> <!-- end card container number 5  -->

            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100 text-center ">
                    <div class="card-header ">fitness</div>
                    <img class="card-img-top rounded-0" src="./images/card_fitness.jpg" alt="image fitness">
                    <div class="card-body">
                        <p class="card-text">Désir de se remettre en forme, nos cours de fitness sont faits pour vous.</p>
                        <a class="nav-link " href="fitness.php"><button type="button" class="btn text-white bouton-card"> Plus d'infos</button></a>
                    </div>
                </div> <!-- end card wrapper  -->
            </div> <!-- end card container number 6  -->
        </div> <!-- end card row wrapper  -->
    </section> <!-- end card section activity  -->


    <aside>
        <div class="card img-fluid aside">
            <img class="card-img-top" src="./images/a-young-woman-in-head-to-knee-forward-bend-yoga-pose.jpg" alt="yoga image" style="width:100%">
            <div class="card-img-overlay col-sm-12 col-md-12 col-lg-12 mx-auto">
                <h2 class="card-title text-center">Inscrivez-vous à notre infolettre</h2>
                <p class="text-center">Soyez tout de suite informé des dernières nouvelles du club.</p>
                <div class="input-group ">
                    <input type="text" class="form-control" placeholder="Votre courriel" aria-label="Recipient's username" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <span class="input-group-text text-white" id="basic-addon2">S'abonner</span>
                    </div>
                </div> <!-- end of input container  -->
            </div> <!-- end of overlay container  -->
        </div> <!-- end of aside container  -->
    </aside>
</div> <!-- end of main wrapper  -->


<footer>
    <?php require_once("footer.php");?> <!-- footer -->
</footer>



    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="js/index.js"></script>

</body>

</html>
