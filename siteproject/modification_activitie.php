

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
 * @see        mysqli_query(), mysqli_num_rows(),mysqli_fetch_assoc()
 * @global type $_POST['envoi'],$_POST['nom_activite'],$_POST['categorie_activite'],$_POST['nombre_place_activite']
 *              $_POST['gestions_idgestions'],GET['id'],$_GET['page'],$_GET['table_nom ']
 * @return type non
 * date: Janvier 20 2019
 */

 //bibliothèque de fonctions de chargement et paramètres de connexion pour la base de données
require_once("inc/connectDB.php");

require_once("inc/fonctions.php");


if (isset($_POST['envoi']))
{
    
        $nom_activite = trim($_POST['nom_activite']);
       $categorie_activite = trim($_POST['categorie_activite']);
       $nombre_place_activite = trim($_POST['nombre_place_activite']);
       $gestions_idgestions = trim($_POST['gestions_idgestions']);
       

        $id = isset($_GET['id']) ? $_GET['id'] : "";
        $page = isset($_GET['page']) ? $_GET['page'] : "";
        $table_nom  = isset($_GET['table_nom ']) ? $_GET['table_nom '] : "";
        //action de changer valuer de activitie
        if($id!=="")
        {
        
            $req = "UPDATE activites"." SET nom_activite='$nom_activite',categorie_activite='$categorie_activite', nombre_place_activite='$nombre_place_activite',
            gestions_idgestions='$gestions_idgestions'".
            "WHERE id_activite ='$id'";
            if(mysqli_query($conn, $req))
            {
                $retSQL ="Modification effectuée.";
            }
            else{
                $retSQL =$req;
                
            }
            $nom_activite =  $categorie_activite = $nombre_place_activite= $gestions_idgestions=    "";  // réinit pour une nouvelle saisie
            
    
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
    <meta charset="UTF-8">
    <meta name="description" content="Modifier un article">
    <title>Modifier un article</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

</head>
<body>
<!-- le menu -->
    <header>
        
        <nav>
            <ul>
                <li><a href="admin.php">Retour</a></li>
                <li><a href="ajouter.php">Ajouter </a></li>

            </ul>
        </nav>
    </header>
    

    <section>
        <h1>Modification d'article</h1>
        <p><?php echo isset($retSQL) ? $retSQL : "&nbsp;" ?></p> <!-- statut pour écrire la base de données -->
        <?php
            $id = isset($_GET['id']) ? $_GET['id'] : "";
            $page = isset($_GET['page']) ? $_GET['page'] : "";
            $table_nom  = isset($_GET['table_nom ']) ? $_GET['table_nom '] : "";
            $nom_activite =  $categorie_activite = $nombre_place_activite= $gestions_idgestions=    ""; 
            if($id!=="")
            {
                $sql = "SELECT * from activites where id_activite=".$id;
                $result = mysqli_query($conn, $sql);
                //obtenir les données de la base de données
                if (mysqli_num_rows($result) > 0) 
                {
                    
                    echo "<table class='table'><tr><thead><th>id_activite</th><th>nom_activite</th><th>categorie_activite</th><th>nombre_place_activite</th>
                    <th>gestions_idgestions</th></thead><tbody>";
                    while($row = mysqli_fetch_assoc($result))
                    {
                        echo "<tr><td>" . $row ["id_activite"]
                        . " </td><td>" . $row ["nom_activite"]
                        . "</td><td>" . $row ["categorie_activite"]
                        . "</td><td>". $row ["nombre_place_activite"]
                        ."</td><td>". $row ["gestions_idgestions"]
                        ."</td><tr>";
                        //afficher valuer de element
                        $nom_activite=$row ["nom_activite"];
                        $categorie_activite= $row ["categorie_activite"];
                        $nombre_place_activite=$row ["nombre_place_activite"];
                        $gestions_idgestions=$row ["gestions_idgestions"];
                    }
                    echo "</tbody></table>";
                } 
                else
                {
                    echo "Aucun résultat";
                }
            }
            else
            {
                echo "Aucun d'identifiant pour cet article";
            }        
            
        ?>
        
        <!-- formulaire pour modification-->
        <form action="modification_activitie.php?id=<?php echo $id ?>&page=<?php echo $page ?>&table_nom=<?php echo $table_nom ?>" method="post">

            <div class="form-group">
                <label>nom_activite</label>
                <input class="modification" type="text" name="nom_activite" value="<?php echo isset($nom_activite) ? $nom_activite : "" ?>" required>
                
            </div>
            <div class="form-group">
                <label>categorie_activite</label>
                <input class="modification" type="text"   name="categorie_activite" value="<?php echo isset($categorie_activite) ? $categorie_activite : "" ?>" required>
                
            </div>
            <div class="form-group">
                <label>nombre_place_activite</label>
                <input class="modification" type="text"   name="nombre_place_activite" value="<?php echo isset($nombre_place_activite) ? $nombre_place_activite : "" ?>" required>
                
            </div>
            <div class="form-group">
                <label>gestions_idgestions</label>
                <input class="modification" type="text"   name="gestions_idgestions" value="<?php echo isset($gestions_idgestions) ? $gestions_idgestions : "" ?>" required>
                
            </div>
            
                    

            <input type="submit" name="envoi" value="Envoyez"> 
        </form>
    </section>
</body>
</html>	