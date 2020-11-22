<?php
/**
 * ajouter_animateur.php
 *
 * fournir une fonction d'ajout d'animateur pour l'administrateur de la page
 *
 * @category   Gestion
 * @author     Leon zhang 
 * @version    1.0
 * @link       "inc/connectDB.php","inc/fonctions.php","ajouter_animateur.php"
 * @see        ajouter_animateur()
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
       $nom = trim($_POST['nom']);
       $prenom = trim($_POST['prenom']);
       $courriel = trim($_POST['courriel']);
       $password = trim($_POST['password']);
       $type = trim($_POST['type']);
       
       // ---------------------------
    // insertion dans la table genres si aucune erreur
    // -----------------------------------------------
    
    
        if (ajouter_animateur($conn, $nom, $prenom, $courriel, $password, $type) === 1) {
            $retSQL="Ajout effectué.";
               
        } else {
            $retSQL ="Ajout non effectué.";    
        }
        $nom =  $prenom = $courriel= $password= $type=   ""; // réinit pour une nouvelle saisie
        
    
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Ajouter animateur">
    <title>Ajouter animateur</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    
   
</head>
<body>
<!-- le menu-->
    <header>
        
        <nav>
            <ul>
                <li><a href="admin.php">Retour</a></li>
                

            </ul>
        </nav>
    </header>
    <section>
        <h1>Ajouter animateur</h1>

        
        <p><?php echo isset($retSQL) ? $retSQL : "&nbsp;" ?></p> <!-- état de l'écriture dB -->
        <!--formulaire pour ajouter animateur-->
        <form action="ajouter_animateur.php" method="post">
                            <div class="form-group">
                                <label for="nom">Nom</label>
                                <input type="text" class="form-control" name="nom" value="" required>
                            </div>
                           
                            <div class="form-group">
                                <label for="prenom">Prenom</label>
                                <input type="text" class="form-control" name="prenom" value="" required>
                            </div>
                            <div class="form-group">
                                <label for="programme">Courriel</label>
                                <input type="text" class="form-control" name="courriel" value="" required >
                            </div>
                            <div class="form-group">
                                <label for="adresse">Mot_de_passe</label>
                                <input type="text" class="form-control" name="password" value="" required>
                            </div>
                            <div class="form-group">
                                <label for="tel">Type</label>
                                <input type="text" class="form-control" name="type" value="animateur" required >
                            </div>
            
            
            <input type="submit" name="envoi" value="Envoyez"> 
        </form>
        <p><?php echo isset($retSQL) ? $retSQL : "&nbsp;" ?></p> <!-- état de l'écriture dB -->
    </section>
</body>
</html>	