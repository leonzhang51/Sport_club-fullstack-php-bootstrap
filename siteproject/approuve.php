<?php
/**
 * approuve.php
 *
 * approuver ou refuser la demande du client
 *
 * @category   Gestion
 * @author     Leon zhang
 * @version    1.0
 * @link       "inc/connectDB.php","inc/fonctions.php","suppression.php"
 * @see        mysqli_query(),mysqli_close()
 * @global type $_GET['id'],$_GET['page'],$_POST["oui"],$_POST["non"]
 * @return type non
 * date: Janvier 20 2019
 */

 //bibliothèque de fonctions de chargement et paramètres de connexion pour la base de données
            require_once("inc/connectDB.php");
            
            require_once("inc/fonctions.php");


            if(($_GET['id'])!==null){
                $id=  $_GET['id']; //obtinir element id
                $page = $_GET['page'];//page id pour retourner page(0 pour teacher 1 pour admin)
            }
            //approuver la demande du client
            if(isset($_POST["oui"]))    
            {
                if($id!=="")
                {
                    $sql="UPDATE inscriptions SET statut_inscription = 'pay' WHERE id_inscription = ".$id.";";
                    
                    if (mysqli_query($conn, $sql))
                    {
                        echo "Article changer avec succès";
                        mysqli_close($conn);
                        if($page!=1){
                            header("location:teacher.php");
                        }
                        else{
                            header("location:admin.php");//sauter à page de admin
                        }
                        
                    } 
                    else
                    {
                        echo "Erreur lors de la suppression de l'article: " . mysqli_error($conn);
                    }  
                }
                else
                {
                    echo "Aucun identifiant pour cet article";
                }
            }
            if(isset($_POST["non"])){
                if($page!=1){
                    header("location:teacher.php");//sauter à page de teacher
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
    <meta name="description" content="Liste des films">
    <title>Approuve</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

</head>


<body>
<header>
<!-- le menu -->
    <nav>
            <ul>
                <li><a href="teacher.php">Retour</a></li>
            
            </ul>
    </nav>
           
</header>
           
        <section>
            <h1>Approuve un request</h1>
            <?php
    
                echo "<p>Voulez-vous vraiment effacer l'article ayant l'identifiant suivant : ".$id."</p>";
            ?>
            <form action="approuve.php?id=<?php echo $id ?>&page=<?php echo $page ?>"  method="post">
                <input class= "confirm" name="oui" type="submit" value="oui">
                <input class= "confirm" name="non" type="submit" value="non">
            </form>
        </section>
        


        
</body>
</html>
    
