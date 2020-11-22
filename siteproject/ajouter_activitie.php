<?php
/**
 * ajouter_activitie.php
 *
 * ajouter activitie pour page d'admin 
 *
 * @category   Gestion
 * @author     Leon zhang
 * @version    1.0
 * @link       "inc/connectDB.php","inc/fonctions.php"
 * @see        ajouter_activitie,afficher_animateur()
 * @global type $_POST['envoi'],$_POST['nom_activite'],$_POST['categorie_activite'],
 *              $_POST['nombre_place_activite'],$_POST['gestions_idgestions']
 * @return type non
 * date: Janvier 20 2019
 */

 //bibliothèque de fonctions de chargement et paramètres de connexion pour la base de données
require_once("inc/connectDB.php");
require_once("inc/fonctions.php");


// test retour de saisie du formulaire
// -----------------------------------        

if (isset($_POST['envoi'])) {
    
       // contrôles des champs saisis
       $nom_activite = trim($_POST['nom_activite']);
       $categorie_activite = trim($_POST['categorie_activite']);
       $nombre_place_activite = trim($_POST['nombre_place_activite']);
       $gestions_idgestions = trim($_POST['gestions_idgestions']);
      
       
       // ---------------------------
    // insertion dans la table activitie si aucune erreur
    // -----------------------------------------------
    
    
        if (ajouter_activitie($conn, $nom_activite , $categorie_activite, $nombre_place_activite,$gestions_idgestions) === 1) {
            $retSQL="Ajout effectué.";
               
        } else {
            $retSQL ="Ajout non effectué.";    
        }
        $nom_activite =  $categorie_activite = $nombre_place_activite= $gestions_idgestions=    ""; // réinit pour une nouvelle saisie
        
    
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Ajouter activitie">
    <title>Ajouter activitie</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <style>
        form{
            width:60%;
            margin:auto;
        }
       
    </style>
   
</head>
<body>
    <header>
        <!-- le menu -->
        <nav>
            <ul>
                <li><a href="admin.php">Retour</a></li>
                

            </ul>
        </nav>
    </header>
    <section>
        <h1 class="text-center">Ajouter activitie</h1>

        <!--formulaire pour ajouter activitie-->
        <p><?php echo isset($retSQL) ? $retSQL : "&nbsp;" ?></p> <!-- état de l'écriture dB -->
        <form action="ajouter_activitie.php" method="post">
                            <div class="form-group">
                                <label for="nom_activite">Nom</label>
                                <input type="text" class="form-control" name="nom_activite" value="" required>
                            </div>
                           
                            <div class="form-group">
                                <label for="prenom">categorie_activite</label>
                                <input type="text" class="form-control" name="categorie_activite" value="" required>
                            </div>
                            <div class="form-group">
                                <label for="programme">nombre place de activite</label>
                                <input type="text" class="form-control" name="nombre_place_activite" value="" required >
                            </div>
                            <div class="form-group">
                                <label for="adresse">Gestion id</label>
                                <input type="text" class="form-control" name="gestions_idgestions" value="" required>
                            </div>
                           
            
            
            <input type="submit" name="envoi" value="Envoyez"> 
        </form>
        <?php
        //obtenir des informations sur les animateurs à partir de la base de données 
                            $sql_tr= "SELECT idgestions as id,nom,prenom,courriel,mot_de_passe,type from gestions
                            WHERE type='animateur' ;";
                            afficher_animateur($conn,$sql_tr,1); //1 pour après fonctionnement retour page admin
                        ?>       
        <p><?php echo isset($retSQL) ? $retSQL : "&nbsp;" ?></p> <!-- état de l'écriture dB -->
    </section>
</body>
</html>	