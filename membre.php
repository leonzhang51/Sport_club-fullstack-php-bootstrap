<?php

/**
 * @file        membre.php.
 * @author      Leon Zhang .
 * @version     1.0.
 * @date        30 janvier 2019.
 * @brief       Page d'@b membre du site.
 * @details     Cette page affiche les différentes sortes de yoga auxquelles
 *              le membre inscrit du club peut s'inscrire. Pur cela, il lui suffit
 *              de sélectionner l'activité souhaitée et d'envoyer sa demande
 *              en cliquant sur le bouton envoyer. Un message de confirmation
 *              s'affiche à l'écran si l'inscription a bien été effectuée. Si
 *              le membre inscrit est déjà inscrit, un message l'en informe,
 *              de même que lorsqu'il se produit une erreur.
 */




require_once("inc/connectDB.php");
require_once("inc/sessionUtilisateur.php");
require_once("inc/fonctionsFichiers.php");


$categorie=$_SESSION['categorie'];
$listeActivites = listeActivites($conn, $categorie);
$identifiantActivite ="";
$id_Utilisateur=$_SESSION['id_utilisateur'];

    if(isset($_POST["idRadio"]))
	{
		$identifiantActivite = $_POST["idRadio"];
        
        if(verifInscription ($conn, $id_Utilisateur, $identifiantActivite)==0)
        {
            
            if(inscriptionActivite($conn,$id_Utilisateur,$identifiantActivite)==1)
            {
                echo "01";
            }
            else
            {
                echo "02";
            }
        }
        else
        {
            echo "03";
        }
    }
?>







<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once("head.php");?> <!-- head -->
    <title>Membre</title>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light ">
        <button class="navbar-toggler custom-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-between" id="navbarTogglerDemo01">
            <a class="navbar-brand" href="#"><img src="images/logoSVG3.svg"></a>
            <ul class="navbar-nav mt-2 mt-lg-0 justify-content-end">
               
                <li class="nav-item ">
                    <a class="nav-link text-white " href="index.php"><button type="button" class="btn  rounded-0 ">Accueil</button></a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link text-white" href="index.php"><button type="button" class="btn ">installations</button></a>
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
            </ul>
        </div>
    </nav>



    <div class="modal fade" id="modalConfirmation" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0 rounded-0">
                <div class="modal-header rounded-0">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Message</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span class="croix" id="croix" aria-hidden="true">&times;</span>
                            
                    </button>
                </div>
                <div id="bodyResponse" class="modal-body">
                   <p id="confirmation"></p>
             

                </div>
                <div class="modal-footer">
                    <button type="button" id="bouton-onglet-response" class="btn text-uppercase text-white" data-dismiss="modal">Fermer</button>
<!--                    <button type="button" class="btn btn-primary">Save changes</button>-->
                </div>
            </div>
        </div>
    </div>



    <div class="container-activites membre img-fluid">
<!--        <img src="images/../images/natation.jpg" class="img-fluid">-->
        <div class="text-membre">
            <div class="message-acueil">
                <h3 class="nom">Bonjour
                    <?php echo $_SESSION['prenom'] ?>
                    <?php echo $_SESSION['nom'] ?>,</h3>
                <p>Pour t’inscrire aux activités suivantes, il te suffit de cocher la case correspondante à l’activité
                    souhaitée et de nous envoyer ta demande en cliquant sur le bouton envoyer. Une
                    fois que notre responsable des inscriptions aura traité ta demande, ce qui ne devrait
                    pas prendre pas plus de 24 heures, tu recevras un courriel de confirmation. À bientôt !</p>
            </div>

            <form class="formulaire-activites" action="membre.php" method="post">
                <div class="col-lg-12">
                    <table class="table table-hover table-borderless ">
                        <thead>
                            <tr>
                                <!--                                <th scope="col">#</th>-->
                                <th scope="col">activité</th>
                                <th scope="col">Places disponibles</th>
                                <th scope="col">Inscription</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($listeActivites as $nom => $value): ?>
                            <tr>
                                <!--                                <th scope="row" class="align-middle">1</th>-->
                                <td class="align-middle">
                                    <?php echo $value['nom_activite'] ?>
                                </td>
                                <td class="align-middle">
                                    <?php echo $value['nombre_place_activite'] ?>
                                </td>
                                <td class="align-middle">
                                    <?php if ($value['nombre_place_activite']!=0) : ?>
                                    <div class="btn-group-toggle" data-toggle="buttons">
                                        <label name="inscription2" class="btn btn-secondary bouton-inscrire active">
                                            <input class="custom-control-input" id="customRadio[<?= $value['id_activite'] ?>]" type="radio" name="inscription" value="<?= $value['id_activite'] ?>"> Je m'inscris
                                        </label>
                                    </div>

                                    <?php else : ?>
                                    Complet
                                    <?php endif; ?>
                                </td>

                            </tr>
                            <?php endforeach; ?>


                        </tbody>
                    </table>
                </div>
                <button type="button" name="bouton" data-toggle="modal" data-target="#myModal" id="envoyer" class="btn btn-danger text-uppercase">envoyer</button>
            </form>
        </div>
    </div>




<footer>
    <?php require_once("footer.php");?> <!-- footer -->
</footer>





    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="js/membre.js"></script>

</body>

</html>
