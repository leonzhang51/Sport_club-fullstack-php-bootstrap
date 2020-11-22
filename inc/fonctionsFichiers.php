<?php

/**
 * @file fonctionsfichiers.php.
 * @author Leon Zhang @& .
 * @version 1.0.
 * @date 30 janvier 2019.
 * @brief ensemble des fonctions utilisées par le site.
*/











/**
 * @brief       Identifie le type d'erreur de connexion 
 * @param  conn Contexte de connexion.
 * @return Un message indiquant à la fois le code de l'erreur et la description associée.
 */

function errSQL($conn)
{
?>
<p>Erreur de requête :
    <?php echo mysqli_errno($conn)." – ".mysqli_error($conn) ?>
</p>
<?php 
}




/**
 * @brief  Liste les activités proposées dans une catégorie d'activité donnée.
 * @param  conn     Contexte de connexion.
 * @param  categorie    Catégorie d'activité.
 * @return Une liste sous forme de tableau avec pour têtes de colonne l'identifiant, le nom de l'activité et le nombre de places restantes.
 */



function listeActivites($conn, $categorie)
{
    $requeteListe = "SELECT id_activite, nom_activite, nombre_place_activite  FROM activites WHERE categorie_activite = '$categorie'";

    if ($resultRequete = mysqli_query($conn, $requeteListe, MYSQLI_STORE_RESULT))
    {
        $nbResultRequete = mysqli_num_rows($resultRequete);
        $listeActivites = array();
        if ($nbResultRequete)
        {
            mysqli_data_seek($resultRequete, 0);
            while ($row = mysqli_fetch_array($resultRequete, MYSQLI_ASSOC))
            {        
                $listeActivites []= $row;
            }
        }
    mysqli_free_result($resultRequete);
    return $listeActivites;     
    }
    else
    {
        errSQL($conn);
        exit;
    }
}


/**
 * @brief  Confirme que le gestionnaire identifié par les paramètres passées exite dans la base de données.
 * @param  conn             Contexte de connexion.
 * @param  identifiant      Courriel du gestionnaire.
 * @param  mot_de_passe     Mot de passe du gestionnaire
 * @param  role             Role du gestionnaire
 * @return Le nombre de lignes correspondant aux paramètres passés dans la fonction.
 */

function AuthentificationGestionnaire($conn, $identifiant, $mot_de_passe, $role)
{
    $req = "SELECT * FROM gestions
            WHERE courriel= '$identifiant' AND mot_de_passe = '$mot_de_passe' AND type='$role'";
    if ($result = mysqli_query($conn, $req))
    {
        return mysqli_num_rows($result);
    } 
    else
    {
        errSQL($conn);
        exit;
    }
}




/**
 * @brief  Confirme que le membre identifié par les paramètres passées exite dans la base de données.
 * @param  conn             Contexte de connexion.
 * @param  identifiant      Courriel du membre.
 * @param  mot_de_passe     Mot de passe du membre
 * @return Le nombre de lignes correspondant aux paramètres passés dans la fonction.
 */

function AuthentificationUtilisateur($conn, $identifiant, $mot_de_passe)
{
    $req = "SELECT * FROM utilisateurs
            WHERE courriel_utilisateur= ? AND mot_de_pass = SHA2(?,256)";

    $stmt = mysqli_prepare($conn, $req);
    
    mysqli_stmt_bind_param($stmt, "ss", $identifiant, $mot_de_passe);

    if (mysqli_stmt_execute($stmt))
    {
        $result = mysqli_stmt_get_result($stmt);
        return mysqli_num_rows($result);
    } 
    else
    {
        errSQL($conn);
        exit;
    }
}



/**
 * @brief  Liste les données associées à un gestionnaire.
 * @param  conn             Contexte de connexion.
 * @param  identifiant      Courriel du gestionnaire.
 * @return Une liste sous forme de tableau avec pour têtes de colonne l'identifiant, les nom, prénom, courriel, mot_de_passe et type du gestionnaire.
 */

function lireGestionnaire($conn, $identifiant) 
{

    $req = "SELECT * FROM gestions
            WHERE courriel ='$identifiant'";
    if ($resultRequete = mysqli_query($conn, $req, MYSQLI_STORE_RESULT))
    {
        $nbResultRequete = mysqli_num_rows($resultRequete);
        $infoAnimateur = array();
        if ($nbResultRequete)
        {
            mysqli_data_seek($resultRequete, 0);
            while ($row = mysqli_fetch_array($resultRequete, MYSQLI_ASSOC))
            {        
                $infoAnimateur []= $row;
            }
        }
    mysqli_free_result($resultRequete);
    return $infoAnimateur;     
    }
    else
    {
        errSQL($conn);
        exit;
    }
}



/**
 * @brief  Liste les données associées à un membre.
 * @param  conn             Contexte de connexion.
 * @param  identifiant      Courriel du membre.
 * @return Une liste sous forme de tableau avec pour têtes de colonne l'identifiant, les nom, prénom, courriel et le mot_de_passe du membre.
 */

function lireUtilisateur($conn, $identifiant) 
{
    $req = "SELECT * FROM utilisateurs
            WHERE courriel_utilisateur='$identifiant'";
    if ($resultRequete = mysqli_query($conn, $req, MYSQLI_STORE_RESULT))
    {
        $nbResultRequete = mysqli_num_rows($resultRequete);
        $infoMembre = array();
        if ($nbResultRequete)
        {
            mysqli_data_seek($resultRequete, 0);
            while ($row = mysqli_fetch_array($resultRequete, MYSQLI_ASSOC))
            {        
                $infoMembre []= $row;
            }
        }
    mysqli_free_result($resultRequete);
    return $infoMembre;     
    }
    else
    {
        errSQL($conn);
        exit;
    }
}




function lireRoleUtilisateur($conn,$identifiant,$mot_de_passe)
{
$req = "SELECT R.nom_role from utilisateurs as U Inner join roles as R on R.id_role = U.roles_id_role
where U.courriel_utilisateur = '$identifiant' and U.mot_pass = '$mot_de_passe'";
    if ($result = mysqli_query($conn, $req, MYSQLI_STORE_RESULT))
    {
        $nbResult = mysqli_num_rows($result);
        $roleUtilisateur = array();
        if ($nbResult) {
            mysqli_data_seek($result, 0);
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $roleUtilisateur = $row;
            }
        }
        mysqli_free_result($result);
        return $roleUtilisateur['nom_role'];
    } else {
        errSQL($conn);
        exit;
    }
}






/**
 * @brief  Insère les données passées en paramètres dans la base de données.
 * @param  conn             Contexte de connexion.
 * @param  nom              nom du membre.
 * @param  prenom           prenom du membre.
 * @param  email            Courriel du membre.
 * @param  password         mot de passe du membre.
 * @return Le nombre de lignes insérées dans la base de données.
 */

function inscriptionMembre($conn, $nom, $prenom, $email, $password) 
{
    $req = "INSERT INTO utilisateurs SET nom_utilisateur = ?, prenom_utilisateur = ?, courriel_utilisateur = ?, mot_de_pass=SHA2(?,256)";
    
    $stmt = mysqli_prepare($conn, $req);
    mysqli_stmt_bind_param($stmt, "ssss", $nom, $prenom, $email, $password);
    
    if (mysqli_stmt_execute($stmt))
    {    
        return mysqli_stmt_affected_rows($stmt);
    } 
    else
    {
        errSQL($conn);
        exit;
    }
}



/**
 * @brief  Indique la présence ou non du courriel passé en paramètre dans la base de données.
 * @param  conn             Contexte de connexion.
 * @param  courriel         Courriel du membre.
 * @return Le nombre de ligne comporant le courriel passé en paramètre.
 */

function verifCourriel($conn, $courriel)
{
    $req = "SELECT courriel_utilisateur FROM utilisateurs
            WHERE courriel_utilisateur='$courriel'";
    if ($result = mysqli_query($conn, $req))
    {
        return mysqli_num_rows($result);
    } 
    else
    {
        errSQL($conn);
        exit;
    }
}





/**
 * @brief  Indique si l'identifiant passé en paramètre est associé à l'identifiant de l'activité passée en paramètre.
 * @param  conn             Contexte de connexion.
 * @param  idUser           Identifiant du membre.
 * @param  idActivity       Identifiant de l'activité.
 * @return Le nombre de ligne comportant les paramètres passés dans la fonction.
 */

function verifInscription ($conn, $idUser, $idActivity )
{
    $req = "SELECT utilisateurs_id_utilisateur FROM inscriptions
            WHERE activites_id_activite='$idActivity' AND utilisateurs_id_utilisateur ='$idUser'";
    if ($result = mysqli_query($conn, $req))
    {
        return mysqli_num_rows($result);
    } 
    else
    {
        errSQL($conn);
        exit;
    }
}




/**
 * @brief  Insère les données passées en paramètres dans la base de données.
 * @param  conn             Contexte de connexion.
 * @param  idUser           Identifiant du membre.
 * @param  idActivity       Identifiant de l'activité.
 * @return Le nombre de ligne comportant les paramètres passés dans la fonction.
 */

function inscriptionActivite($conn, $idUser, $idActivity)
{
    
$req = "INSERT INTO inscriptions (utilisateurs_id_utilisateur, activites_id_activite, date_paiement_inscription, statut_inscription)    
VALUES ('$idUser', '$idActivity', NOW(), 'pending')";   
    if (mysqli_query($conn, $req)) 
    {
        if(mysqli_affected_rows($conn)==1)
        {
            $req = "UPDATE activites SET nombre_place_activite = nombre_place_activite - 1 WHERE id_activite = '$idActivity'";
            
            if (mysqli_query($conn, $req))
            {
                if(mysqli_affected_rows($conn)==1)
                {
                    
                return 1;    
                }
            }
            else
            {
                errSQL($conn);
                exit;
            }
        }
        else
        {
        return 0;    
        }
    } 
    else
    {
        errSQL($conn);
        exit;
    }
}




/**
 * @brief  Insère les données passées en paramètres dans la base de données.
 * @param  conn             Contexte de connexion.
 * @param  sql_tr           Requête Mysql.
 * @return Un nombre correspondant à la somme des lignes trouvées selon les paramètres passées dans la fonction.
 */


function afficher_nombre_utilisateur($conn,$sql_tr){
    $result = mysqli_query($conn, $sql_tr);
    $nombre;
    if (mysqli_num_rows($result) > 0) {
        
        while($row = mysqli_fetch_assoc($result)) {
            $nombre=$row["nom"];               
        }
        return $nombre;
    } else {
        echo "Aucun résultat n'a été trouvé selon les critères indiqués";
    }
    
    
}





/**
 * @brief  Affiche ceux des membres dont l'inscription est en attente de validation.
 * @param  conn             Contexte de connexion.
 * @param  sql_tr           Requête Mysql.
 * @param  page_ua_toggle   Numéro de page.
 * @return Un tableau listant ceux des membres dont l'inscription est en attente de validation.
 */

function operation_utisateur_pending($conn,$sql_tr,$page_ua_toggle){
    $result = mysqli_query($conn, $sql_tr);

    if (mysqli_num_rows($result) > 0) {
        echo "<table class='table'><tr><thead><th>id</th><th>nom</th><th>nom de activitie</th><th>categorie</th><th>statut</th><th colspan='2'>Action</th></thead><tbody>";
        while($row = mysqli_fetch_assoc($result)) {
            echo "<tr><td>" . $row["id"]. " </td><td>". $row["nom"]. " </td><td>". $row["nom_de_activitie"]. "</td><td>" . $row ["categorie"]
            . "</td><td>". $row["statut"]
            ."<td>
            <a  href='suppression.php?id=".$row["id"]."&page=".$page_ua_toggle."&nom=".$row["nom"]."&table_nom=inscriptions&user_id=id_inscription' type='button'  >Refuser</a>
            </td>"
            ."<td><a href='approuve.php?id=".$row["id"]."&page=".$page_ua_toggle."&nom=".$row["nom"]."'"." type='button'  >Approuver</a>
            
            </td></tr>";               
        }
    } else {
        echo "Aucun résultat n'a été trouvé selon les critères indiqués";
    }
    
    echo "</tbody></table>";
} 





/**
 * @brief  Affiche la liste des animateurs-moniteurs.
 * @param  conn             Contexte de connexion.
 * @param  sql_tr           Requête Mysql.
 * @param  page_ua_toggle   Numéro de page.
 * @return Un tableau listant les personnes excerçant à titre de moniteur-animateur.
 */

function afficher_animateur($conn,$sql_tr,$page_ua_toggle){
    $result = mysqli_query($conn, $sql_tr);

    if (mysqli_num_rows($result) > 0) {
        echo "<table class='table'><tr><thead><th>id</th><th>nom</th><th>prenom</th><th>courriel</th><th>mote_de_passe</th><th>type</th><th colspan='2'>operation</th></thead><tbody>";
        while($row = mysqli_fetch_assoc($result)) {
            echo "<tr><td>" . $row["id"]. " </td><td>". $row["nom"]. " </td><td>". $row["prenom"]. "</td><td>" . $row ["courriel"]
            . "</td><td>". $row["mot_de_passe"]. "</td><td>". $row["type"]
            ."<td><a href='modification_animateur.php?id=".$row["id"]."&page=".$page_ua_toggle."&nom=".$row['nom']."&table_nom=gestions' type='button'  >Modifier</a>"
            ."<td><a href='suppression.php?id=".$row["id"]."&page=".$page_ua_toggle."&nom=".$row['nom']."&table_nom=gestions&user_id=idgestions' type='button'  >Supprimer</a>
            </td></tr>";   
        }
    } else {
        echo "Aucun résultat n'a été trouvé selon les critères indiqués";
    }
    
    echo "</tbody></table>";
}  



/**
 * @brief  Insére les données passées en paramètres dans la table gestions de la base de données.
 * @param  conn             Contexte de connexion.
 * @param  nom              Nom du nouvel animateur
 * @param  prenom           Prenom du nouvel animateur.
 * @param  courriel         Courriel du nouvel animateur.
 * @param  password         Mot de passe du nouvel animateur.
 * @param  type             Role du nouvel animateur.
 * @return Le nombre de lignes insérées dans la base de données.
 */

function ajouter_animateur($conn,  $nom, $prenom, $courriel, $password, $type) {


    $sql = "INSERT INTO gestions (nom,prenom,courriel,mot_de_passe,type) 
    VALUES ('$nom','$prenom', '$courriel', '$password', '$type')";

    if (mysqli_query($conn, $sql)) {
        if(mysqli_affected_rows($conn)){
            $_SESSION["animateur"] = "dernière mise à jour: (Animateur) $nom $prenom Ajout effectué."; 
             
        }
        else{
            $_SESSION["animateur"] = "dernière mise à jour: (Animateur) $nom $prenom Ajout effectué."; 
        }
    } else {
        errSQL($conn);
        exit;
    }
}



/**
 * @brief  Affiche les activités sportives passées en paramètres.
 * @param  conn             Contexte de connexion.
 * @param  sql_tr           Requête MySql
 * @param  page_ua_toggle   Page de destination.
 * @return Un tableau listant les activités sportives passées en paramètre.
 */


function afficher_activities($conn,$sql_tr,$page_ua_toggle){
    $result = mysqli_query($conn, $sql_tr);

    if (mysqli_num_rows($result) > 0) {
        echo "<table class='table'><tr><thead><th>Identifiant activité</th><th>Nom</th><th>Catégorie</th><th>Nombre de places</th><th>Identifiant animateur</th><th colspan='2'>Action</th></thead><tbody>";
        while($row = mysqli_fetch_assoc($result)) {
            echo "<tr><td>" . $row["id"]. " </td><td>". $row["nom_activite"]. " </td><td>". $row["categorie_activite"]. "</td><td>" . $row ["nombre_place_activite"]
            . "</td><td>". $row["gestion_id"]
            ."<td><a href='modification_activitie.php?id=".$row["id"]."&page=".$page_ua_toggle."&nom=".$row["nom_activite"]."&table_nom=activites' type='button'  >Modifier</a>"
            ."<td><a href='suppression.php?id=".$row["id"]."&page=".$page_ua_toggle."&nom=".$row["nom_activite"]."&table_nom=activites&user_id=id_activite' type='button'  >Supprimer</a>
            </td></tr>";   
                        
        }
    } else {
        echo "Aucun résultat n'a été trouvé selon les critères indiqués";
    }
    
    echo "</tbody></table>";
}   






/**
 * @brief  Insère une nouvelle activité dans la table activité de la base de données.
 * @param  conn                         Contexte de connexion.
 * @param  nom_activite                 Nom de l'activité.
 * @param  categorie_activite           Catégorie de l'activité.
 * @param  nombre_place_activite        Places restantes.
 * @param  gestions_idgestions          Identifiant du moniteur en charge de cette activité.
 * @return Le nombre de lignes insérées.
 */

function ajouter_activitie($conn, $nom_activite , $categorie_activite, $nombre_place_activite,$gestions_idgestions) {

    
    $sql = "INSERT INTO activites (nom_activite , categorie_activite, nombre_place_activite,gestions_idgestions) 
    VALUES ('$nom_activite','$categorie_activite',  '$nombre_place_activite', '$gestions_idgestions')";
    $_SESSION["activitie"] =""; //supprimer session
    if (mysqli_query($conn, $sql)) {
        if(mysqli_affected_rows($conn)){
            
            $_SESSION["activitie"] = "dernière mise à jour: (ACTIVITÉ)$nom_activite Ajout effectué.";
            
        }
        else{
            $_SESSION["activitie"] = "dernière mise à jour: (ACTIVITÉ)$nom_activite Ajout non effectué.";//cookie disparaîtra dans 10 secondes
        }
    } else {
        errSQL($conn);
        exit;
    }
}



/**
 * @brief  Supprime l'activité passée en paramètre.
 * @param  conn             Contexte de connexion.
 * @param  sql              Requête MySql
 * @return Un message de confirmation ou d'erreur, le cas échéant.
 */

function supprimer_utilisateur_en_attendant($conn,$sql){
   
            if (mysqli_multi_query($conn, $sql))
            {
                echo "Suppression effectuée avec succés.";
                mysqli_close($conn); 
            } 
            else
            {
                echo "Une erreur s'est produite : " . mysqli_error($conn);
            }         
  
}



/**
 * @brief  Affiche le cartouche d'activité associé à l'identifiant du moniteur passé en paramètre.
 * @param  conn                 Contexte de connexion.
 * @param  categorie_img_id     Identifiant du moniteur
 * @return Le cartouche d'activité associé à l'identifiant.
 */

function afficher_card($categorie_img_id,$conn){
    $img_string;
    $card_string;
    $card_title;
    switch($categorie_img_id){
        case "2":
            $img_string="./images/card_yoga.jpg";
            $card_title="Yoga";
            $card_string="Cliquez sur \"Voir détails\" pour supprimer un membre inscrit.";
            break;
            
        case "3":
            $img_string="./images/card_musculation%20copie.jpg";
            $card_title="Musculation";
            $card_string="Cliquez sur \"Voir détails\" pour supprimer un membre inscrit.";
            break;
            
        case "4":
            $img_string="./images/card_natation.jpg";
            $card_title="Natation";
            $card_string="Cliquez sur \"Voir détails\" pour supprimer un membre inscrit.";
            break;
            
        case "5":
            $img_string="./images/card_tennis.jpg";
            $card_title="Tennis";
            $card_string="Cliquez sur \"Voir détails\" pour supprimer un membre inscrit.";
            break;
            
        case "6":
            $img_string="./images/card_basket.jpg";
            $card_title="Soccer";
            $card_string="Cliquez sur \"Voir détails\" pour supprimer un membre inscrit.";
            break;
            
        case "7":
            $img_string="./images/fitness.jpg";
            $card_title="Fitness";
            $card_string="Cliquez sur \"Voir détails\" pour supprimer un membre inscrit.";
            break;                        
    }
    $sql_tr="select activites.nombre_place_activite as nombre from activites
    INNER JOIN gestions ON activites.gestions_idgestions=gestions.idgestions
    WHERE gestions.idgestions='$categorie_img_id'";
    $result = mysqli_query($conn, $sql_tr);
    $nombre_reste;
    $nombre;
    $sql_tr1= "SELECT count(I.utilisateurs_id_utilisateur) as nom FROM
                inscriptions as I
                Inner join activites as A on I.activites_id_activite = A.id_activite
                where A.gestions_idgestions ='$categorie_img_id' and I.statut_inscription ='pay'";
    $nombre_reste=afficher_nombre_utilisateur($conn,$sql_tr1);
    if (mysqli_num_rows($result) > 0) {
        
        while($row = mysqli_fetch_assoc($result)) {
            $nombre=$row["nombre"]-$nombre_reste;               
        }
        
    } else {
        echo "Aucun résultat n'a été trouvé selon les critères indiqués";
    }
    echo"
            
                <div class='card bg-white border-dark'style='width: 18rem;'>
                    <img class='card-img-top' src='".$img_string."' alt='Card image soccer'>
                    <div class='card-body'>
                        <h5 class='card-title'>".$card_title."</h5>
                        <p class='card-text'>".$card_string."</p>
                        <p class='card-text'>".$nombre_reste." membres sont inscrits</p>
                        <button type='button' class='btn btn-danger' data-toggle='modal' data-target='#ajouter'>Voir détails</button>
                    </div>
                </div>";
}     


/**
 * @brief  Affiche les membres inscrits à l'activité d'un moniteur donné.
 * @param  conn                 Contexte de connexion.
 * @param  sql_tr               Requête Mysql
 * @return Le cartouche d'activité associé à l'identifiant.
 */

function afficher_utisateur_activitie_actuel($conn,$sql_tr,$page_ua_toggle){
    $result = mysqli_query($conn, $sql_tr);

    if (mysqli_num_rows($result) > 0) {
        echo "<table class='table'><tr><thead><th>Identifiant</th><th>Membre</th><th>Activité</th><th>Catégorie</th><th>Statut</th></thead><tbody>";
        while($row = mysqli_fetch_assoc($result)) {
            echo "<tr><td>" . $row["id"]. " </td><td>". $row["nom"]. " </td><td>". $row["nom_de_activitie"]. "</td><td>" . $row ["categorie"]
            . "</td><td>". $row["statut"]
            
            ."<td><a href='suppression.php?id=".$row["id"]."&page=".$page_ua_toggle."&table_nom=inscriptions&user_id=id_inscription' type='button'  >Supprimer</a>
            </td></tr>";   
                        
        }
    } else {
        echo "Aucun résultat n'a été trouvé selon les critères indiqués";
    }
    
    echo "</tbody></table>";
}  

/**
 * @brief  Affiche les animateurs répertoriés.
 * @param  conn                 Contexte de connexion.
 * @param  sql_tr               Requête Mysql
 * @return Le tableau des animateurs.
 */

function afficher_animateur_aa($conn,$sql_tr){
    $result = mysqli_query($conn, $sql_tr);

    if (mysqli_num_rows($result) > 0) {
        echo "<table class='table'><tr><thead><th>gestion_id</th><th>nom_activite</th><th>nom</th><th>prenom</th><th>categorie_activite</th></thead><tbody>";
        while($row = mysqli_fetch_assoc($result)) {
            echo "<tr><td>" . $row["gestion_id"]. " </td><td>". $row["nom_activite"]. " </td><td>". $row["nom"]. "</td><td>" . $row ["prenom"]
            . "</td><td>". $row["categorie_activite"]. "</td></tr>";   
                        
        }
    } else {
        echo "Aucun résultat n'a été trouvé selon les critères indiqués";
    }
    
    echo "</tbody></table>";
}  

?>
