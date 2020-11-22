<?php
/**
 * teacher.php
 *
 * portail du système pour l'animateur
 *
 * @category   Gestion
 * @author     Leon zhang 
 * @version    1.0
 * @link       "inc/connectDB.php","inc/fonctions.php"
 * @see         supprimer_utilisateur_en_attendant,
 * @global type $varname Non.
 * @return type non
 * date: Janvier 20 2019
 */

 //bibliothèque de fonctions de chargement et paramètres de connexion pour la base de données
            require_once("inc/connectDB.php");
            
            require_once("inc/fonctions.php");


            if(($_GET['id'])!==null){
                $id=  $_GET['id'];
                $page= $_GET['page'];
                $table_nom=$_GET['table_nom'];
                $user_id=$_GET['user_id'];
            }
            if(isset($_POST["oui"]))    
            {
                if($id!=="")
                {
                    //supprimer dossir qui a la clé étrangère
                    $sql= "SET FOREIGN_KEY_CHECKS = 0;";   
                    $sql.= "Delete from ".$table_nom." where ".$user_id.'='.$id.";";
                    $sql.= "SET FOREIGN_KEY_CHECKS = 1;"; 

                    supprimer_utilisateur_en_attendant($conn,$sql);
                    if($page!=1){
                        header("location:teacher.php");
                    }
                    else{
                        header("location:admin.php");
                    }
                    
                    
                   
                }
                else
                {
                    echo "Aucun identifiant pour cet article";
                }
                
            }
            if(isset($_POST["non"])){
                if($page!=1){
                    header("location:teacher.php");
                }
                else{
                    header("location:admin.php");
                }
                
        }
               
             
            
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Suppression">
    <title>suppression</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

</head>


<body>
<header>
    <nav>
            <ul>
                <li><a href="teacher.php">Retour</a></li>
            
            </ul>
    </nav>
           
</header>
   <section>
        <h1>Supprimer un dossir</h1>
                <?php
        
                    echo "<p>Voulez-vous vraiment effacer l'article ayant l'identifiant suivant : ".$id."</p>";
                    echo "page is:  ".$page;
                ?>
        <form action="suppression.php?id=<?php echo $id ?>&page=<?php echo $page ?>&table_nom=<?php echo $table_nom ?>&user_id=<?php echo $user_id ?>"  method="post">
            <input class= "confirm" name="oui" type="submit" value="oui">
            <input class= "confirm" name="non" type="submit" value="non">
        </form>
   </section>

        


        
</body>
</html>
    
