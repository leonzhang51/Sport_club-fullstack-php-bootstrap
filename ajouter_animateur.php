<?php
/**
 * @file        ajouter_animateur.php.
 * @author      Leon Zhang .
 * @version     1.0.
 * @date        30 janvier 2019.
 * @brief       Page @b Ajout d'animateur du site.
 * @details     Cette page comporte un module avec un formulaire
 *              de saisie des différents champs nécessaires
 *              à l'enregistrement d'une nouvelle activité.
 */

require_once("inc/connectDB.php"); /** Connexion à la base de données.*/
require_once("inc/sessionUtilisateur2.php"); /** Start session.*/
require_once("inc/fonctionsFichiers.php"); /** Fichier contenant les fonctions.*/


if(isset( $_SESSION["animateur"])){
    $retSQL=$_SESSION["animateur"];
}





if (isset($_POST['envoi'])) {

    $nom = trim($_POST['nom']); /** suppression des espaces au début et la fin de la variable.*/
    $prenom = trim($_POST['prenom']); /** suppression des espaces au début et la fin de la variable.*/
    $courriel = trim($_POST['courriel']); /** suppression des espaces au début et la fin de la variable.*/
    $password = trim($_POST['password']);/** suppression des espaces au début et la fin de la variable.*/
    $type = trim($_POST['type']); /** suppression des espaces au début et la fin de la variable.*/



    ajouter_animateur($conn, $nom, $prenom, $courriel, $password, $type);
       
    $nom = $prenom = $courriel = $password = $type = ""; /** Réinitialisation des variables. */
    echo "<meta http-equiv='refresh' content='0'>";//actualiser la page pour obtenir la valeur de session la plus récente

}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <?php require_once("head_gestion.php");?> <!-- head -->
    <title>Ajout d'animateur</title>
</head>


<body>
<!-- le menu-->
   <script>
    $(document).ready(function(){       
   $('#myModal').modal('show');
    }); 
</script>
   
   
    <?php require_once("header_gestion.php");?> <!-- header -->


    

       <section class="confirmation text-center mt-4">
        <h1 class="text-center">Ajouter un animateur</h1>
       <h6 class="text-danger text-center m-5"><?php echo isset($retSQL) ? $retSQL : "&nbsp;" ?></h6> <!-- état de l'écriture dB -->
       <div class="text-center">
            <button type="button" class="btn btn-danger text-center text-uppercase" data-toggle="modal" data-target="#myModal">Ajouter animateur</button>
        
       </div>
       <div class="text-center m-2">
        
            <a class="text-center" href="admin.php">Retour à la page d'administration</a>
       </div>
        <div id="myModal" class="modal fade" role="dialog"><!-- module d'affichage du formulaire d'ajout d'activité-->
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
            <div class="modal-header rounded-0">
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body text-center">
                <h1 class="text-center">Ajouter un animateur</h1>

                <p class="text-danger"><?php echo isset($retSQL) ? $retSQL : "&nbsp;" ?></p> <!-- message de retour  -->
                
            <!-- formulaire d'ajout d'un animateur-->
            <form action="ajouter_animateur.php" method="post">
                                <div class="form-group">
                                    <label for="nom">Nom</label>
                                    <input type="text" class="form-control text-center" name="nom" value="" required>
                                </div>

                                <div class="form-group">
                                    <label for="prenom">Prénom</label>
                                    <input type="text" class="form-control text-center" name="prenom" value="" required>
                                </div>
                                <div class="form-group">
                                    <label for="courriel">Courriel</label>
                                    <input type="email" class="form-control text-center" name="courriel" value="" required >
                                </div>
                                <div class="form-group">
                                    <label for="password">Mot_de_passe</label>
                                    <input type="password" pattern="[A-Za-z0-9]{8,}" title="veuillez entrer 8 caractères ou plus"> class="form-control text-center" name="password" value="" required>
                                </div>
                                <div class="form-group">
                                    <label for="type"></label>
                                    <input type="hide" class="form-control text-center" name="type" value="2" required >
                                </div>


                <input class="btn btn-danger mb-4 text-uppercase" type="submit" name="envoi" value="Envoyer">
            </form><!-- fin du formulaire pour modification-->
            <a class="text-center m-2" href="admin.php">Retour à la page d'administration</a>
            </div>
            <div class="modal-footer">
                 <button type="button" class="btn btn-danger text-uppercase" data-dismiss="modal">Fermer</button> 
            </div>
            </div>

        </div>
    </div>
       
    </section>
      <?php require_once("footer_gestion.php");?> <!-- footer -->

</body>
</html>	