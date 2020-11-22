<?php
/**
 * @file        modification_animateur.php.
 * @author      Leon Zhang .
 * @version     1.0.
 * @date        30 janvier 2019.
 * @brief       Page de @b modification d'animateur.
 * @details     Cette page comporte un formulaire à remplir où figurent
 *              les champs nom, prénom, courriel et mot de passe de l'animateur.
 */

require_once("inc/connectDB.php");
require_once("inc/sessionUtilisateur2.php");
require_once("inc/fonctionsFichiers.php");


    if (isset($_POST['envoi']))
    {

        $nom = trim($_POST['nom']);
        $prenom = trim($_POST['prenom']);
        $courriel = trim($_POST['courriel']);
        $password = trim($_POST['password']);
        $type = trim($_POST['type']);

            $id = isset($_GET['id']) ? $_GET['id'] : "";
            $page = isset($_GET['page']) ? $_GET['page'] : "";
            $table_nom  = isset($_GET['table_nom ']) ? $_GET['table_nom '] : "";
        if($id!=="")
        {
                $req = "UPDATE gestions"." SET nom='$nom', prenom='$prenom', courriel='$courriel',
                mot_de_passe='$password',type='$type'".
                "WHERE idgestions ='$id'";
            
                if(mysqli_query($conn, $req))
                {
                    $retSQL ="L'animateur $prenom $nom a été modifié."; /** Message de retour. */
                }
                else
                {
                    $retSQL ="L'animateur $prenom $nom n'a pas été modifié."; /** Message de retour en cas d'erreur. */
                }
                $nom = $prenom = $courriel = $password = $type = ""; /** Réinitialisation des variables. */
        }
        else
        {
            $retSQL ="Aucun identifiant n'a été trouvé pour cette requête.";
        }
    }

?>



<!DOCTYPE html>
<html lang="fr">

<head>
    <?php require_once("head_gestion.php");?> <!-- head -->
    <title>Modification d'animateur</title>
</head>

<body>
<script>
    $(document).ready(function(){       
   $('#myModal').modal('show');
    }); /** Affichage du module de modification à l'ouverture de la page. */
</script>
   
      <?php require_once("header_gestion.php");?> <!-- header -->


    <section class=" confirmation text-center mt-4">
        <h1>Modification d'animateur</h1>
        <h6 class="text-danger text-center m-5"><?php echo isset($retSQL) ? $retSQL : "&nbsp;" ?></h6> <!-- message de retour-->
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
            $nom =  $prenom = $courriel= $password= $type=   "";
            if($id!=="")
            {
                $sql = "SELECT * from gestions where idgestions=".$id;
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) 
                {
                
                    while($row = mysqli_fetch_assoc($result))
                    {
                        $nom=$row ["nom"];
                        $prenom= $row ["prenom"];
                        $courriel=$row ["courriel"];
                        $password=$row ["mot_de_passe"];
                    }
                } 
                else
                {
                    echo "Aucun résultat"; /** Message de retour en cas d'erreur. */
                }
            }
            else
            {
                echo "Aucun d'identifiant pour cet article"; /** Message de retour en cas d'erreur. */
            }        
            
        ?>
        
        
        <div id="myModal" class="modal fade" role="dialog"><!-- Module d'affichage du formulaire de modification -->
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                <div class="modal-header rounded-0">
                    <button type="button" class=" text-white close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body text-center">
                <h1 class="text-center">Modification d'animateur</h1> 
                <p class="text-danger"><?php echo isset($retSQL) ? $retSQL : "&nbsp;" ?></p> <!-- message de retour -->
                    <!-- formulaire pour modification-->
                    <form action="modification_animateur.php?id=<?php echo $id ?>&page=<?php echo $page ?>&table_nom=<?php echo $table_nom ?>" method="post">
                        <div class="form-group">
                            <label>Nom</label>
                            <input class="modification" type="text" name="nom" value="<?php echo isset($nom) ? $nom : "" ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Prénom</label>
                            <input class="modification" type="text"   name="prenom" value="<?php echo isset($prenom) ? $prenom : "" ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Courriel</label>
                            <input class="modification" type="text"   name="courriel" value="<?php echo isset($courriel) ? $courriel : "" ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Mot de passe</label>
                            <input class="modification" type="text"   name="password" value="<?php echo isset($password) ? $password : "" ?>" required>
                        </div>
                        <div class="form-group">
                            <label></label>
                            <input class="modification" type="hidden"   name="type" value="2" required>
                        </div>       
                                

                        <input type="submit" class="mb-4 btn bg-danger text-white text-uppercase" name="envoi" value="Envoyer"> 
                    </form>
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