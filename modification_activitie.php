<?php
/**
 * @file        modification_activitie.php.
 * @author      Leon Zhang .
 * @version     1.0.
 * @date        30 janvier 2019.
 * @brief       Page de @b modification d'activités.
 * @details     Cette page comporte un formulaire à remplir où figurent
                les champs nom, catégorie, nombre de places disponibles,
                et l'identifiant de l'animateur.
 */



require_once("inc/connectDB.php");
require_once("inc/sessionUtilisateur2.php");
require_once("inc/fonctionsFichiers.php");


        if (isset($_POST['envoi']))
        {
            $nom_activite = trim($_POST['nom_activite']); /** suppression des espaces au début et la fin de la variable.*/
            $categorie_activite = trim($_POST['categorie_activite']); /** suppression des espaces au début et la fin de la variable.*/
            $nombre_place_activite = trim($_POST['nombre_place_activite']); /** suppression des espaces au début et la fin de la variable.*/
            $gestions_idgestions = trim($_POST['gestions_idgestions']); /** suppression des espaces au début et la fin de la variable.*/
       

            $id = isset($_GET['id']) ? $_GET['id'] : "";
            $page = isset($_GET['page']) ? $_GET['page'] : "";
            $table_nom  = isset($_GET['table_nom ']) ? $_GET['table_nom '] : "";
            
            if($id!=="")
            {
                $req = "UPDATE activites SET nom_activite='$nom_activite',categorie_activite='$categorie_activite', nombre_place_activite='$nombre_place_activite',
                gestions_idgestions='$gestions_idgestions'".
                "WHERE id_activite ='$id'";
                
                if(mysqli_query($conn, $req))
                {
                    $retSQL ="Modification effectuée."; /** Message de retour. */
                }
                else
                {
                    $retSQL =$req;
                }
                
                $nom_activite =  $categorie_activite = $nombre_place_activite= $gestions_idgestions=    "";  /** Réinitialisation des variables. */
            }
            else
            {
                $retSQL ="Aucun identifiant n'a été trouvé pour cette requête."; /** Message de retour. */
            }
}

?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <?php require_once("head_gestion.php");?> <!-- head -->
    <title>Administrateur</title>
</head>


<body>

<script>
    $(document).ready(function(){       
   $('#myModal').modal('show');
    }); /** Affichage du module de modification à l'ouverture de la page. */
</script>
   
    <?php require_once("header_gestion.php");?> <!-- header -->


    <section class="confirmation text-center mt-4">
        <h1>Modification d'activité</h1>
        <h6 class="text-danger text-center m-5"><?php echo isset($retSQL) ? $retSQL : "&nbsp;" ?></h6>
       <div class="text-center">
            <button type="button" class="btn btn-danger text-center text-uppercase" data-toggle="modal" data-target="#myModal">Retour à la modification</button>
       </div>
       <div class="text-center mt-4">
            <a class="text-center" href="admin.php">Retour à la page d'administration</a>
       </div>
        <?php
            $id = isset($_GET['id']) ? $_GET['id'] : "";
            $page = isset($_GET['page']) ? $_GET['page'] : "";
            $table_nom  = isset($_GET['table_nom ']) ? $_GET['table_nom '] : "";
            $nom_activite =  $categorie_activite = $nombre_place_activite= $gestions_idgestions=""; 
            if($id!=="")
            {
                $sql = "SELECT * from activites where id_activite=".$id;
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) 
                {
                    while($row = mysqli_fetch_assoc($result))
                    {
                        $nom_activite=$row ["nom_activite"];
                        $categorie_activite= $row ["categorie_activite"];
                        $nombre_place_activite=$row ["nombre_place_activite"];
                        $gestions_idgestions=$row ["gestions_idgestions"];
                    }
                } 
                else
                {
                    $retSQL= "Opération non effectuée"; /** Message de retour en cas d'erreur. */
                }
            }
            else
            {
                $retSQL= "Aucun d'identifiant";  /** Message de retour en cas d'erreur. */
            }        
            
        ?>
        
        <div id="myModal" class="modal fade" role="dialog"><!-- Module d'affichage du formulaire de modification -->
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                <div class="modal-header rounded-0">
                    <button type="button" class="text-white close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body text-center">
                    <h1 class="text-center">Modification d'activité</h1>
                    <p class="text-danger"><?php echo isset($retSQL) ? $retSQL : "&nbsp;" ?></p> <!-- message de retour -->
                    <!-- formulaire pour modification-->
                    <form action="modification_activitie.php?id=<?php echo $id ?>&page=<?php echo $page ?>&table_nom=<?php echo $table_nom ?>" method="post"> 

                        <div class="form-group">
                            <label>Nom de l'activité</label>
                            <input class="modification" type="text" name="nom_activite" value="<?php echo isset($nom_activite) ? $nom_activite : "" ?>" required>
                            
                        </div>
                        <div class="form-group">
                            <label>Catégorie</label>
                            <input class="modification" type="text"   name="categorie_activite" value="<?php echo isset($categorie_activite) ? $categorie_activite : "" ?>" required>
                            
                        </div>
                        <div class="form-group">
                            <label>Places disponibles</label>
                            <input class="modification" type="text"   name="nombre_place_activite" value="<?php echo isset($nombre_place_activite) ? $nombre_place_activite : "" ?>" required>
                            
                        </div>
                        <div class="form-group">
                            <label>Identifiant de l'animateur</label>
                            <input class="modification" type="text" name="gestions_idgestions" value="<?php echo isset($gestions_idgestions) ? $gestions_idgestions : "" ?>" required>
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