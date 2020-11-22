<?php
/**
 * @file        ajouter_activitie.php.
 * @author      Leon Zhang.
 * @version     1.0.
 * @date        30 janvier 2019.
 * @brief       Page @b Ajout d'activité du site.
 * @details     Cette page comporte un module avec un formulaire
 *              de saisie des différents champs nécessaires
 *              à l'enregistrement d'une nouvelle activité.
 */

require_once("inc/connectDB.php");
require_once("inc/sessionUtilisateur2.php");
require_once("inc/fonctionsFichiers.php");




    if(isset( $_SESSION["activitie"])){
        
        $retSQL=$_SESSION["activitie"];
    }
    

if (isset($_POST['envoi']))
{
    $nom_activite = trim($_POST['nom_activite']); /** suppression des espaces au début et la fin de la variable.*/
    $categorie_activite = trim($_POST['categorie_activite']); /** suppression des espaces au début et la fin de la variable.*/
    $nombre_place_activite = trim($_POST['nombre_place_activite']); /** suppression des espaces au début et la fin de la variable.*/
    $gestions_idgestions = trim($_POST['gestions_idgestions']); /** suppression des espaces au début et la fin de la variable.*/
    
    ajouter_activitie($conn, $nom_activite , $categorie_activite, $nombre_place_activite,$gestions_idgestions);
    $nom_activite = $categorie_activite = $nombre_place_activite= $gestions_idgestions= ""; /** Réinitialisation des variables.*/
    echo "<meta http-equiv='refresh' content='0'>";//actualiser la page pour obtenir la valeur de session la plus récente
}

?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <?php require_once("head_gestion.php");?> <!-- head -->
    <title>Ajout d'activité</title>
</head>


<body>

<script>
    $(document).ready(function(){       
   $('#myModal').modal('show');
    }); 
</script>  
  
   
    <?php require_once("header_gestion.php");?> <!-- header -->
    
    
    <section class="confirmation text-center mt-4"> 
       <h1 class="text-center">Ajouter une activité</h1>
       <h6 class="text-danger text-center m-5"><?php echo isset($retSQL) ? $retSQL : "&nbsp;" ?></h6> <!-- message retour-->
       <div class="text-center">
        <button type="button" class="btn btn-danger text-center text-uppercase" data-toggle="modal" data-target="#myModal">Ajouter activité</button>
       </div>
       <div class="text-center mt-4">
        <a class="text-center" href="admin.php">Retour à la page d'administration</a>
       </div>
    </section>
    
    <div id="myModal" class="modal fade" role="dialog"> <!-- module d'affichage du formulaire d'ajout d'activité-->
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
            <div class="modal-header rounded-0">
            <h4 class="modal-title">Ajouter une activité</h4>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body text-center">
                

                <p class="text-danger"><?php echo isset($retSQL) ? $retSQL : "&nbsp;" ?></p> <!-- message de retour-->
                
                <!-- formulaire d'ajout d'une activité-->
                <form action="ajouter_activitie.php" method="post">
                    <div class="form-group">
                        <label for="nom_activite">Nom de l'activité</label>
                        <input type="text" class="form-control text-center" name="nom_activite" value="" required>
                    </div>
                                
                    <div class="form-group">
                        <label for="categorie_activite">Catégorie</label>
                        <input type="text" class="form-control text-center" name="categorie_activite" value="" required>
                    </div>
                   <div class="form-group">
                        <label for="nombre_place_activite">Places disponibles</label>
                        <input type="number" class="form-control text-center" name="nombre_place_activite" value="" required >
                    </div>
                    <div class="form-group">
                        <label for="gestions_idgestions">Identifiant de l'animateur</label>
                        <input type="text" class="form-control text-center" name="gestions_idgestions" value="" required>
                    </div>
                                
                    <input class="btn btn-danger mb-5 text-uppercase" type="submit" name="envoi" value="Envoyer"> 
                </form><!-- fin du formulaire pour modification-->
                <div class="text-center m-2">
        
                    <a class="text-center" href="admin.php">Retour retour à la page d'administration</a>
                </div>
                <?php
                    $sql_tr= "SELECT gestions.idgestions as gestion_id,activites.nom_activite as nom_activite,gestions.nom as nom,gestions.prenom as prenom,activites.categorie_activite as categorie_activite from activites
                    INNER JOIN gestions ON activites.gestions_idgestions=gestions.idgestions;";
                    afficher_animateur_aa($conn,$sql_tr); 
                    ?>      
                
            </div>
            <div class="modal-footer">
                 <button type="button" class="btn btn-danger text-uppercase" data-dismiss="modal">Fermer</button> 
            </div>
            </div>

        </div>
    </div>
    
    <?php require_once("footer_gestion.php");?> <!-- footer -->
    
</body>
</html>	