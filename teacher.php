<?php
/**
/**
 * @file        teacher.php.
 * @author      Leon Zhang .
 * @version     1.0.
 * @date        30 janvier 2019.
 * @brief       Page d'@b animateur du site.
 * @details     Cette page comporte deux modules de gestion,
 *              le premier pour les inscriptions en attente, 
 *              le second pour la gestion des différentes 
 *              activités dont l'animateur a la charge.
 */



require_once("inc/connectDB.php");
require_once("inc/fonctionsFichiers.php");
require_once("inc/sessionUtilisateur3.php");
$id_teacher = $_SESSION['id_utilisateur'];
$prenom_teacher = $_SESSION['prenom'];
$nom_teacher= $_SESSION['nom'];
?>



<!DOCTYPE html>
<html lang="fr">

<head>
    <?php require_once("head_gestion.php");?> <!-- head -->
    <title>Animateur</title>
</head>



<body>
    <?php require_once("header_gestion.php");?> <!-- header -->


    <section class="container my-4">
        <h1 class="text-center ">Tableau de bord de l'animateur</h1>
        <h2 class="text-center ">&ndash; <?php echo $prenom_teacher?> <?php echo $nom_teacher?> &ndash;</h2>
        <article class="row">
         
            <div class="card border-dark text-center my-5 "><!-- carte pour les inscriptions en attente -->
                <div class="card-header">Validation des demandes</div>
                <div class="card-body text-dark">
                    <h5 class="card-title">
                        <?php
                            
                            $nombre;
                            $sql_tr= "SELECT COUNT(utilisateurs.nom_utilisateur) as nom from gestions
                            left JOIN activites ON gestions.idgestions=activites.gestions_idgestions
                            left JOIN inscriptions ON activites.id_activite=inscriptions.activites_id_activite
                            left JOIN utilisateurs ON inscriptions.utilisateurs_id_utilisateur=utilisateurs.id_utilisateur
                            where inscriptions.statut_inscription='pending' AND gestions.idgestions='$id_teacher'"; 
                            $nombre=afficher_nombre_utilisateur($conn,$sql_tr);
                            echo $nombre; /** nombre de demandes en attente.*/
                    
                        ?>
                        demande(s) en attente d'approbation.</h5>
                    <p class="card-text">
                        <button type="button" class="btn btn-danger mt-3" data-toggle="modal" data-target="#attente">Voir détails</button>

                    </p>
                </div>
            </div><!-- end of body card container -->
        </article>



    </section>
    <h2 class="text-center">Membres inscrits à mes cours</h2>
    <article class="row">

        <?php
                afficher_card($id_teacher, $conn); /** Affichage du panneau de gestion des membres inscrits.*/
        ?>
    </article>






    <article class="modal fade" id="attente" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true"> <!-- Module d'affichage des demandes d'inscriptions en attente-->
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header rounded-0">
                    <h5 class="modal-title" id="exampleModalLongTitle">En attente de validation</h5>
                    <button type="button" class="close" aria-label="Close" data-dismiss="modal">
                        <span class="croix" aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <?php
                            $sql_tr= "SELECT inscriptions.id_inscription as id,utilisateurs.nom_utilisateur as nom,activites.nom_activite as nom_de_activitie,
                            activites.categorie_activite as categorie, inscriptions.statut_inscription as statut from gestions
                            INNER JOIN activites ON gestions.idgestions=activites.gestions_idgestions
                            INNER JOIN inscriptions ON activites.id_activite=inscriptions.activites_id_activite
                            INNER JOIN utilisateurs ON inscriptions.utilisateurs_id_utilisateur=utilisateurs.id_utilisateur
                            where inscriptions.statut_inscription='pending' AND gestions.idgestions='$id_teacher'";
                            operation_utisateur_pending($conn,$sql_tr,0); /** Affichage des demandes en attente le module.*/
                        ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger text-uppercase" data-dismiss="modal">Quitter</button>
                </div>
            </div>
        </div>
    </article>


    <article class="modal fade" id="ajouter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true"><!-- Module d'affichage des membres inscrits-->
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header rounded-0">
                    <h5 class="modal-title" id="exampleModalLongTitle">Membres inscrits</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span class="croix" aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <?php
                            $sql_tr= "SELECT inscriptions.id_inscription as id,utilisateurs.nom_utilisateur as nom,activites.nom_activite as nom_de_activitie,
                            activites.categorie_activite as categorie, inscriptions.statut_inscription as statut from gestions
                            left JOIN activites ON gestions.idgestions=activites.gestions_idgestions
                            left JOIN inscriptions ON activites.id_activite=inscriptions.activites_id_activite
                            left JOIN utilisateurs ON inscriptions.utilisateurs_id_utilisateur=utilisateurs.id_utilisateur
                            where inscriptions.statut_inscription='pay' AND gestions.idgestions='$id_teacher'";
                            afficher_utisateur_activitie_actuel($conn,$sql_tr,0); /** Affichage des membres inscrits dans le module.*/
                        ?>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger text-uppercase" data-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </article>
    
    
 <?php require_once("footer_gestion.php");?> <!-- footer -->
   

</body>

</html>
