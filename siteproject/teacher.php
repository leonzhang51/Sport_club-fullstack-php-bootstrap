<?php
/**
 * teacher.php
 *
 * portail du système pour l'animateur
 *
 * @category   Gestion
 * @author     Leon Zhang 
 * @version    1.0
 * @link       "inc/connectDB.php","inc/fonctions.php"
 * @see        afficher_nombre_utilisateur(), operation_utisateur_pending(),
 *              afficher_utisateur_activitie_actuel(),afficher_card()
 * @global type $varname Non.
 * @return type non
 * date: Janvier 20 2019
 */

 //bibliothèque de fonctions de chargement et paramètres de connexion pour la base de données
require_once("inc/connectDB.php");
require_once("inc/fonctions.php");

?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Page de l’animateur</title>
    <meta charset="utf-8">
    <meta name="animateur portail" content="gestion portail pour centre de sport">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Modifier un article</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    



    <style>
        img{
            width: auto;
            height:15em;
        }
        
        .card {
            margin: 0 auto; /* Added */
            float: none; /* Added */
            margin-bottom: 10px; /* Added */
            height:auto;
        }
        .modal-lg {
                max-width: 80% !important;
        }
    
    </style>
</head>

<body>
<!-- le menu-->
        <header>
            <nav class="navbar navbar-expand-sm bg-secondary  justify-content-between">
                <a class="navbar-brand" href="#"><img src="img/logo.png" style="width: 40%;height:40%;"></a>
                <ul class="navbar-nav ">
                    <li class="nav-item active">
                        <a class="nav-link text-white" href="#">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#">Bonjour ...!</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#">Sign out</a>
                    </li>

                </ul>
            </nav>
        </header>
    
    <section class="container">
        <h1 class="text-center">Animateur</h1>
         
         <article class="row">
         <!-- carte Validation En Attente pour activitie-->
            <div class="card border-danger my-3 " >
                    <div class="card-header">Validation En Attente</div>
                    <div class="card-body text-dark">
                        <h5 class="card-title">Il y a 
                        <?php
                            
                            
                            $nombre;
                            $sql_tr= "SELECT COUNT(utilisateurs.nom_utilisateur) as nom from gestions
                            left JOIN activites ON gestions.idgestions=activites.gestions_idgestions
                            left JOIN inscriptions ON activites.id_activite=inscriptions.activites_id_activite
                            left JOIN utilisateurs ON inscriptions.utilisateurs_id_utilisateur=utilisateurs.id_utilisateur
                            where inscriptions.statut_inscription='pending' AND gestions.idgestions='2';";//change 2 to user sign id(gestion id)
                            $nombre=afficher_nombre_utilisateur($conn,$sql_tr);
                            echo $nombre;
                    
                        ?>
                        demandes en attente d'approbation.</h5>
                        <p class="card-text">
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#attente"> En savoir plus</button>

                        </p>
                    </div>
                </article>
                
            </section>
         </div>
            
         <h2 class="text-center">Activitie actuel</h2>
         <!--activité gérée par l'animateur actuel -->
         <article class="row">
            
            <?php
                afficher_card(1,$conn); //1 is the activity id which animateur managed, it need be changed by signed id
            ?>
        </article>
        

        
        
        

    <!-- Modal cliet en attente operation-->
        <article class="modal fade" id="attente" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Validation</h5>
                        <button type="button" class="close"  aria-label="Close" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    
                    <div class="modal-body">
                        <?php
                            $sql_tr= "SELECT inscriptions.id_inscription as id,utilisateurs.nom_utilisateur as nom,activites.nom_activite as nom_de_activitie,
                            activites.categorie_activite as categorie, inscriptions.statut_inscription as statut from gestions
                            INNER JOIN activites ON gestions.idgestions=activites.gestions_idgestions
                            INNER JOIN inscriptions ON activites.id_activite=inscriptions.activites_id_activite
                            INNER JOIN utilisateurs ON inscriptions.utilisateurs_id_utilisateur=utilisateurs.id_utilisateur
                            where inscriptions.statut_inscription='pending' AND gestions.idgestions='2';";//change 2 to user sign id(gestion id)
                            operation_utisateur_pending($conn,$sql_tr,0); 
                        ?>                      
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" data-dismiss="modal">Quitter</button>

                    </div>
                </div>
            </div>
        </article>
        
         
        <!-- Modal client actuel-->
        <article class="modal fade" id="ajouter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Client de Actuel</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    
                    <div class="modal-body">
                    <?php
                            $sql_tr= "SELECT inscriptions.id_inscription as id,utilisateurs.nom_utilisateur as nom,activites.nom_activite as nom_de_activitie,
                            activites.categorie_activite as categorie, inscriptions.statut_inscription as statut from gestions
                            left JOIN activites ON gestions.idgestions=activites.gestions_idgestions
                            left JOIN inscriptions ON activites.id_activite=inscriptions.activites_id_activite
                            left JOIN utilisateurs ON inscriptions.utilisateurs_id_utilisateur=utilisateurs.id_utilisateur
                            where inscriptions.statut_inscription='pay' AND gestions.idgestions='2';";//change 2 to user sign id(gestion id)
                            afficher_utisateur_activitie_actuel($conn,$sql_tr,0); //0 retouner page animateur
                        ?>
                      
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" data-dismiss="modal">Quitter</button>

                    </div>
                </div>
            </div>
        </article>

    </section>
    <footer class="bg-secondary my-2">
        <div class="text-center text-white">
            
            <p>&copy;2019</p>
        </div>
    </footer>

</body>
</html>