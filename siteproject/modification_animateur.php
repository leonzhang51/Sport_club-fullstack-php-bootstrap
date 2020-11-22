

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
    
        $nom = trim($_POST['nom']);
       $prenom = trim($_POST['prenom']);
       $courriel = trim($_POST['courriel']);
       $password = trim($_POST['password']);
       $type = trim($_POST['type']);

        $id = isset($_GET['id']) ? $_GET['id'] : "";
        $page = isset($_GET['page']) ? $_GET['page'] : "";
        $table_nom  = isset($_GET['table_nom ']) ? $_GET['table_nom '] : "";
        //action de changer valuer de activitie
    if($id!=="")
    {
        
            $req = "UPDATE gestions"." SET nom='$nom', prenom='$prenom', courriel='$courriel',
            mot_de_passe='$password',type='$type'".
            "WHERE idgestions ='$id'";
            if(mysqli_query($conn, $req))
            {
                $retSQL ="Modification effectuée.";
            }
            else{
                $retSQL =$req;
                
            }
            $nom =  $prenom = $courriel= $password= $type=   ""; // réinit pour une nouvelle saisie
            
    
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
<!-- le menu-->
    <header>
        
        <nav>
            <ul>
                <li><a href="admin.php">Retour</a></li>
                <li><a href="ajouter.php">Ajouter </a></li>

            </ul>
        </nav>
    </header>
    

    <section>
        <h1>Modification d'animateur</h1>
        <p><?php echo isset($retSQL) ? $retSQL : "&nbsp;" ?></p> <!-- statut pour écrire la base de données -->
        <?php
            $id = isset($_GET['id']) ? $_GET['id'] : "";
            $page = isset($_GET['page']) ? $_GET['page'] : "";
            $table_nom  = isset($_GET['table_nom ']) ? $_GET['table_nom '] : "";
            $nom =  $prenom = $courriel= $password= $type=   "";
            if($id!=="")
            {
                $sql = "SELECT * from gestions where idgestions=".$id;
                $result = mysqli_query($conn, $sql);
                //obtenir les données de la base de données
                if (mysqli_num_rows($result) > 0) 
                {
                    
                    echo "<table class='table'><tr><thead><th>id</th><th>nom</th><th>prenom</th><th>courriel</th>
                    <th>mot_de_passe</th><th>type</th></thead><tbody>";
                    while($row = mysqli_fetch_assoc($result))
                    {
                        echo "<tr><td>" . $row ["idgestions"]
                        . " </td><td>" . $row ["nom"]
                        . "</td><td>" . $row ["prenom"]
                        . "</td><td>". $row ["courriel"]
                        ."</td><td>". $row ["mot_de_passe"]
                        ."</td><td>". $row ["type"]
                        ."</td><tr>";
                        //afficher valuer de element
                        $nom=$row ["nom"];
                        $prenom= $row ["prenom"];
                        $courriel=$row ["courriel"];
                        $password=$row ["mot_de_passe"];
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
        <form action="modification_animateur.php?id=<?php echo $id ?>&page=<?php echo $page ?>&table_nom=<?php echo $table_nom ?>" method="post">
<!--            <h3>Modification</h3>-->
            <div class="form-group">
                <label>Nom</label>
                <input class="modification" type="text" name="nom" value="<?php echo isset($nom) ? $nom : "" ?>" required>
                
            </div>
            <div class="form-group">
                <label>Prenom</label>
                <input class="modification" type="text"   name="prenom" value="<?php echo isset($prenom) ? $prenom : "" ?>" required>
                
            </div>
            <div class="form-group">
                <label>Courriel</label>
                <input class="modification" type="text"   name="courriel" value="<?php echo isset($courriel) ? $courriel : "" ?>" required>
                
            </div>
            <div class="form-group">
                <label>Password</label>
                <input class="modification" type="text"   name="password" value="<?php echo isset($password) ? $password : "" ?>" required>
                
            </div>
            <div class="form-group">
                <label>Type de Utilisateur</label>
                <input class="modification" type="text"   name="type" value="animateur" required>
                
            </div>       
                    

            <input type="submit" name="envoi" value="Envoyez"> 
        </form>
    </section>
</body>
</html>	