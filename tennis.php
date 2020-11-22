<?php

/**
 * @file        tennis.php.
 * @author      Leon Zhang .
 * @version     1.0.
 * @date        30 janvier 2019.
 * @brief       Page @b Tennis du site.
 * @details     Cette page comporte un module d'@b authentification
 *              permettant au membre, moniteur ou à l'administrateur
 *              de se connecter si celui-ci possède un compte. Le module
 *              comporte aussi un lien renvoyant vers une page d'@b inscription pour
 *              le visiteur non inscrit.
 */



require_once("inc/connectDB.php"); /** Connexion à la base de données.*/
require_once("inc/sessionUtilisateur.php"); /** Start session.*/
require_once("inc/fonctionsFichiers.php"); /** Fichiers contenant les fonctions.*/
define ("CATEGORIE", "tennis");

$listeActivites = listeActivites($conn, CATEGORIE);

$identifiant="";
$mot_de_passe="";
$erreur=true;
$fonction=""; /** Permet de sélectionner via le select la requête MySql adéquate.*/


if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['fonction']))
{
 
    
    $identifiant = trim($_POST['username']); /** Retirer les espaces vides avant et après le mot saisi.*/
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
            if (AuthentificationUtilisateur($conn, $identifiant, $mot_de_passe) === 1)
            {
                $_SESSION['categorie'] = "musculation";
                $infoMembre = lireUtilisateur($conn, $identifiant);
                $_SESSION['nom'] = $infoMembre[0]['nom_utilisateur'];
                $_SESSION['prenom'] = $infoMembre[0]['prenom_utilisateur'];
                $_SESSION['id_utilisateur'] = $infoMembre[0]['id_utilisateur'];
                $_SESSION['identifiant_utilisateur'] = $identifiant;
                $_SESSION['categorie'] = CATEGORIE;
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
    <title>Tennis</title>
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
                        <input type="email" name="username" id="username" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="john2@exemple.com" required>
                        <small id="emailHelp" class="form-text text-muted">Nous garantissons la confidentialité de votre courriel.</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Mot de passe</label>
                        <input type="text" name="password" id="password" class="form-control" id="exampleInputPassword1" placeholder="8 lettres max. suivi d'un chiffre max." required>
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
    

<div class="container-activites biopic img-fluid">
    <img class="tennis img-fluid" src="./images/tennis_teacher.jpg" class="tennis img-fluid">
    <div class="text-bio">
        <h3 class="nom">Raphael</h3>
        <div class="trait"></div>
        <h4>Expert (souriant) en tennis</h4>
        <p>Contrary to popular belief, 
            lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years. Richard McClitock, Contrary to popular belief.</p>
    </div> <!-- end div text-bio -->
</div>
    
    
    
    

<div class="container-activites img-fluid">
    <img class="background img-fluid" src="images/tennis_background.jpg">
    <div class="text-activites">
        <h3>à toi de saisir la balle</h3>
<!--        <div class="trait-activite"></div>-->
        <div class="activite-nom">

            <?php foreach ($listeActivites as $nom): ?> <!-- boucle d'affichage des activités sportives -->
            
            <p class="activite">
                <?php echo $nom['nom_activite'] ?> <br>
                <span class="horaire">Mardi-Samedi | 10 h - 13 h</span>
            </p>
            
            <?php endforeach; ?> <!-- Fin de la boucle d'affichage des activités sportives -->

        </div> <!-- end div activite-nom -->
        
        <?php if (!isset($_SESSION['identifiant_utilisateur'])) : ?>
        
        <button type="submit" class="btn bg-danger text-white text-uppercase" data-toggle="modal" data-target="#exampleModalCenter">S'inscrire</button>
        
        <?php else : $_SESSION['categorie'] = CATEGORIE ?>
        
        <a class="nav-link text-white" href="membre.php">
            <button type="submit" class="btn bg-danger text-white text-uppercase">S'inscrire</button>
        </a>
        
        <?php endif; ?>
        
    </div> <!-- end div text-activite -->
</div> <!-- end container activites -->


    <footer>
               <?php require_once("footer.php");?> <!-- footer -->
    </footer>





    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="js/tennis.js"></script>

</body>

</html>
