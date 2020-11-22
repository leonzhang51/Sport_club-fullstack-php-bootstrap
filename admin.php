<?php
/**
 * @file        admin.php.
 * @author      Leon Zhang .
 * @version     1.0.
 * @date        30 janvier 2019.
 * @brief       Page d'@b administration du site.
 * @details     Cette page comporte 3 modules de gestion,
 *              le premier pour les inscriptions en attente, 
 *              le second pour la gestion des animateur  et
 *              le dernier pour la gestion des activités.
 */

    require_once("inc/connectDB.php"); 
    require_once("inc/sessionUtilisateur2.php");
    require_once("inc/fonctionsFichiers.php");

?>



<!DOCTYPE html>
<html lang="fr">

<head>
    <?php require_once("head_gestion.php");?> <!-- head -->
    <title>Administrateur</title>
</head>

<body>


    <?php require_once("header_gestion.php");?> <!-- header -->
  

    <section class="container">
        <h1 class="text-center">Tableau de bord de l'administrateur</h1>
        <article class="card border-dark my-5 text-center text-uppercase" style="max-width: 25rem;"><!-- carte pour les inscriptions en attente -->
            <div class="card-header">Inscriptions En Attente</div>
            <div class="card-body text-dark ">
                <h5 class="card-title text-lowercase">
                    <?php
                                $nombre;
                                $sql_tr= "SELECT COUNT(id_inscription) as nom from inscriptions
                                WHERE inscriptions.statut_inscription='pending'";
                                $nombre=afficher_nombre_utilisateur($conn,$sql_tr);
                                echo $nombre; /** nombre de demandes en attente.*/
                            ?>
                    demandes sont en attente d'approbation.</h5>
                <p class="card-text">
                    <button type="button" class="btn btn-danger mt-4" data-toggle="modal" data-target="#waitingList">Détails</button>
                </p>
            </div> <!-- end of body card container -->
        </article>

        <article class="row">
            
            <div class="card border-dark p-0 my-3 col-sm-6" style="max-width: 18rem;"> <!-- carte de gestion des animateurs-->
                <div class="card-header text-center text-uppercase ">Gestion des Animateurs</div>
                <div class="card-body text-dark">
                    <h5 class="card-title"></h5>
                    <p class="card-text text-center">
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#animateur">Aller</button>
                    </p>
                </div>
            </div> <!-- end card gestion des animateurs -->
            
            
            <div class="card border-dark p-0 my-3 col-sm-6" style="max-width: 18rem;"><!-- carte pour gérer l'activites-->
                <div class="card-header text-center text-uppercase">Gestion des Activités</div>
                <div class="card-body text-dark">
                    <h5 class="card-title"></h5>
                    <p class="card-text text-center">
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#activitie">Aller</button>
                    </p>
                </div>
            </div> <!-- end card gestion des activités -->
            
        </article>


        
        <article class="modal fade" id="waitingList" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true"><!-- Module d'affichage des demandes en attente de validation -->
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header rounded-0">
                        <h5 class="modal-title" id="exampleModalLongTitle">Inscriptions en attente</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span class="croix" aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <?php
                            $sql_tr= "SELECT inscriptions.id_inscription as id,utilisateurs.nom_utilisateur as nom,activites.nom_activite as nom_de_activitie,
                            activites.categorie_activite as categorie, inscriptions.statut_inscription as statut from activites
                            left JOIN gestions ON gestions.idgestions=activites.gestions_idgestions
                            left JOIN inscriptions ON activites.id_activite=inscriptions.activites_id_activite
                            left JOIN utilisateurs ON inscriptions.utilisateurs_id_utilisateur=utilisateurs.id_utilisateur
                            where inscriptions.statut_inscription='pending' ;";
                            operation_utisateur_pending($conn,$sql_tr,1); /** affiche les demandes en attente de validation.*/
                        ?>
                    </div> <!-- end of modal-body -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger text-uppercase" data-dismiss="modal">Fermer</button>
                    </div>

                </div>
            </div> <!-- end of modal-dialog -->
        </article>

       
       
       
        <div class="modal fade" id="animateur" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true"><!-- Module CRUD de l'animateur -->
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header rounded-0">
                        <h5 class="modal-title" id="exampleModalLongTitle">Gestion des animateurs</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span class="croix" aria-hidden="true">&times;</span>
                        </button>
                    </div> <!-- end of modal header -->
                    <div class="modal-body">
                        <?php
                            $sql_tr= "SELECT idgestions as id,nom,prenom,courriel,mot_de_passe,type from gestions
                            WHERE type='2' ;";
                            afficher_animateur($conn,$sql_tr,1); /** Affiche la liste des animateurs.*/
                        ?>
                    </div>
                    <div class="modal-footer">
                        <a href='ajouter_animateur.php' class="btn rounded-2 bg-primary text-white">Ajouter un animateur</a>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Quitter</button>
                    </div>
                </div><!-- end of modal content -->
            </div> <!-- end of modal-dialog -->
        </div>
        
        
        
        <div class="modal fade" id="activitie" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true"><!-- Module de gestion des activités CRUD -->
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content ">
                    <div class="modal-header rounded-0">
                        <h5 class="modal-title" id="exampleModalLongTitle">Gestion des activités</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span class="croix" aria-hidden="true">&times;</span>
                        </button>
                    </div> <!-- end of modal header -->

                    <div class="modal-body">

                        <?php
                                $sql_tr= "SELECT id_activite as id, nom_activite, categorie_activite, nombre_place_activite,
                                gestions_idgestions as gestion_id from activites;";
                                afficher_activities($conn,$sql_tr,1); /** Affiche la liste des activités.*/
                        ?>
                    </div>
                    <div class="modal-footer">
                        <a href='ajouter_activitie.php' class="btn bg-primary text-white">Ajouter une activité</a>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Quitter</button>
                    </div>
                </div> <!-- end of modal content -->
            </div> <!-- end of modal-dialog -->
        </div>
    </section>
    
    
    <?php require_once("footer_gestion.php");?> <!-- footer -->



</body>
</html>