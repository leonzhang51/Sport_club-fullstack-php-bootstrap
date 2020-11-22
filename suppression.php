<?php
/**
 * @file        suppression.php.
 * @author      Leon Zhang .
 * @version     1.0.
 * @date        30 janvier 2019.
 * @brief       Page de @b suppression d'un dossier.
 * @details     Cette page comporte 2 boutons, oui et non, permettant
 *              de confirmer ou annuler la requête de suppression.
 */
           


            require_once("inc/connectDB.php");
//            require_once("inc/sessionUtilisateur2.php");
            require_once("inc/fonctionsFichiers.php");
    

           if(($_GET['id'])!==null)
           {
                $id=  $_GET['id'];
                $page= $_GET['page'];
                $table_nom=$_GET['table_nom'];
                $user_id=$_GET['user_id'];
                $nom=$_GET['nom'];
            }
            if(isset($_POST["oui"]))    
            {
                if($id!=="")
                {
                    $sql= "SET FOREIGN_KEY_CHECKS = 0;";   
                    $sql.= "Delete from ".$table_nom." where ".$user_id.'='.$id.";";
                    $sql.= "SET FOREIGN_KEY_CHECKS = 1;"; 

                    supprimer_utilisateur_en_attendant($conn,$sql);
                    if($page!=1)
                    {
                        echo "<script type='text/javascript'>
                        var test=confirm('Article suppression avec succès'); 
                        if(test==true){
                            window.open('teacher.php','_self');
                        }    
                        </script>";
                    }
                    else
                    {
                        echo "<script type='text/javascript'>
                        var test=confirm('Article suppression avec succès'); 
                        if(test==true){
                            window.open('admin.php','_self');
                        }    
                        </script>";
                    }
                }
                else
                {
                    echo "Aucun identifiant n'a été trouvé"; /** Message de retour en cas d'erreur. */
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
    <?php require_once("head_gestion.php");?> <!-- head -->
    <title>Page de Suppression</title>
</head>


<body>
<?php require_once("header_gestion.php");?> <!-- header -->
  
  
   <section class="confirmation text-center mt-5">
        <h1>Confirmation de suppression</h1>
                <?php
                    echo "<p>Voulez-vous vraiment effectuer la suppression du dossier ayant l'identifiant suivant : ".$nom."</p>";
                ?>
        <form action="suppression.php?id=<?php echo $id ?>&page=<?php echo $page ?>&table_nom=<?php echo $table_nom ?>&user_id=<?php echo $user_id ?>"  method="post">
            <input class="confirm btn btn-danger" name="oui" type="submit" value="oui">
            <input class="confirm btn btn-default" name="non" type="submit" value="non">
        </form>
   </section>
    
    
    <?php require_once("footer_gestion.php");?> <!-- footer -->
        
</body>
</html>
    
