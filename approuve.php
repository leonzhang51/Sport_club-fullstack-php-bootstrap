<?php
/**
 * @file        approuve.php.
 * @author      Leon Zhang .
 * @version     1.0.
 * @date        30 janvier 2019.
 * @brief       Page de @b confirmation de requête côté gestion du site.
 * @details     Cette page comporte 2 boutons, oui et non, permettant
 *              de confirmer la requête envoyée.
 */


            require_once("inc/connectDB.php");
//            require_once("inc/sessionUtilisateur2.php");
//            require_once("inc/sessionUtilisateur3.php");
            require_once("inc/fonctionsFichiers.php");


            if (($_GET['id']) !== null)
            {
                $id = $_GET['id'];  /** id du dossier.*/
                $page = $_GET['page'];  /** id de la page.*/
                $nom=$_GET['nom']; /*nom de item*/
            }


            if (isset($_POST["oui"]))
            {
                if ($id !== "") {
                    $sql = "UPDATE inscriptions SET statut_inscription = 'pay' WHERE id_inscription = " . $id . ";";

                    if (mysqli_query($conn, $sql))
                    {
                        echo "Article changer avec succès";
                        mysqli_close($conn);
                        if ($page != 1)
                        {
                            echo "<script type='text/javascript'>
                            var test=confirm('Changement enregistré avec succès'); 
                            if(test==true){
                                window.open('teacher.php','_self'); 
                            }    
                            </script>"; 
                        }
                        else
                        {
                            echo "<script type='text/javascript'>
                            var test=confirm('Changement enregistré avec succès'); 
                            if(test==true){
                                window.open('admin.php','_self');
                            }    
                            </script>";
                        }
                    } 
                    else
                    {
                        echo "Une erreur s'est produite : " . mysqli_error($conn);
                    }
                } 
                else
                {
                    echo "Aucun identifiant pour cet article";
                }
            }
            if (isset($_POST["non"]))
            {
                if ($page != 1)
                {
                    header("location:teacher.php");
                } 
                else
                {
                    header("location:admin.php");
                }
            }

             
            
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <?php require_once("head_gestion.php");?> <!-- head -->
    <title>Page de confirmation</title>
</head>


<body>
    <?php require_once("header_gestion.php");?> <!-- header -->


    <section class="confirmation text-center mt-4">
        <h1>Confirmation de la demande</h1>
        <?php
                echo "<p>Voulez-vous confirmer l'inscription du membre ayant l'identifiant suivant : ".$nom."</p>";
            ?>
        <form action="approuve.php?id=<?php echo $id ?>&page=<?php echo $page ?>" method="post">
            <input class="confirm btn btn-danger" name="oui" type="submit" value="oui">
            <input class="confirm btn btn-default" name="non" type="submit" value="non">
        </form>
    </section>

    <?php require_once("footer_gestion.php");?> <!-- footer -->

</body>
</html>