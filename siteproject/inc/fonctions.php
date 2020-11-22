<?php
    



function errSQL($conn)
{
    ?>
<p>Erreur de requête :
    <?php echo mysqli_errno($conn)." – ".mysqli_error($conn) ?>
</p>
<?php 
}







/**
 * Fonction afficher_nombre_utilisateur_en_attendant
 * Auteur : Leon Zhang, 
 * Date   : 20 janvier 2019
 * But    : Affiche nombre de utilisateur en attente d'approuver
 * Arguments en entrée : $conn : contexte de connexion.
      *                   $sql_tr: requête
 * Valeurs de retour   : nombre de utilisateur.
 */

function afficher_nombre_utilisateur($conn,$sql_tr){
    $result = mysqli_query($conn, $sql_tr);
    $nombre;
    if (mysqli_num_rows($result) > 0) {
        // données de sortie de chaque ligne
        
        while($row = mysqli_fetch_assoc($result)) {
            $nombre=$row["nom"];               
        }
        return $nombre;
    } else {
        echo "Aucun résultat n'a été trouvé selon les critères indiqués";
    }
    
    
}
/**
 * Fonction afficher_activitie_card_de_animateur
 * Auteur : Leon Zhang, 
 * Date   : 20 janvier 2019
 * But    : Affiche card de activitie
 * Arguments en entrée : $conn : contexte de connexion.
                         $sql_tr: requête
 * Valeurs de retour   : html ficher de card.
 */
function afficher_card($categorie_img_id,$conn){
    $img_string;
    $card_string;
    $card_title;
    switch($categorie_img_id){
        case "1":
            $img_string="./img/yoga.jpg";
            $card_title="Yoga";
            $card_string="Pith supporting text below as natural lead-in to additional content.";
            break;
        case "2":
            $img_string="./img/gymnatique.jpg";
            $card_title="Gymnatique";
            $card_string="Pith supporting text below as natural lead-in to additional content.";
            break;
        case "3":
            $img_string="./img/natation.jpg";
            $card_title="Natation";
            $card_string="Pith supporting text below as natural lead-in to additional content.";
            break;
            case "4":
            $img_string="./img/tennis.jpg";
            $card_title="Tennis";
            $card_string="Pith supporting text below as natural lead-in to additional content.";
            break;
            case "5":
            $img_string="./img/soccer.jpg";
            $card_title="Soccer";
            $card_string="Pith supporting text below as natural lead-in to additional content.";
            break;
            case "6":
            $img_string="./img/Bandminton.jpg";
            $card_title="Bandminton";
            $card_string="Pith supporting text below as natural lead-in to additional content.";
            break;                        
    }
    $sql_tr="select activites.nombre_place_activite as nombre from activites
    INNER JOIN gestions ON activites.gestions_idgestions=gestions.idgestions
    WHERE gestions.idgestions='2';"; ////change 2 to user sign id(gestion id)
    $result = mysqli_query($conn, $sql_tr);
    $nombre_reste;
    $nombre;
    $sql_tr1= "SELECT COUNT(utilisateurs.nom_utilisateur) as nom from gestions
                        INNER JOIN activites ON gestions.idgestions=activites.gestions_idgestions
                        INNER JOIN inscriptions ON activites.id_activite=inscriptions.activites_id_activite
                        INNER JOIN utilisateurs ON inscriptions.utilisateurs_id_utilisateur=utilisateurs.id_utilisateur
                        where inscriptions.statut_inscription='pay' AND gestions.idgestions='2';";////change 2 to user sign id(gestion id)
    $nombre_reste=afficher_nombre_utilisateur($conn,$sql_tr1);
    if (mysqli_num_rows($result) > 0) {
        // données de sortie de chaque ligne
        
        while($row = mysqli_fetch_assoc($result)) {
            $nombre=$row["nombre"]-$nombre_reste;               
        }
        
    } else {
        echo "Aucun résultat n'a été trouvé selon les critères indiqués";
    }
    echo"
            
                <div class='card bg-white 'style='width: 18rem;'>
                    <img class='card-img-top' src='".$img_string."' alt='Card image soccer'>
                    <div class='card-body'>
                        <h5 class='card-title'>".$card_title."</h5>
                        <p class='card-text'>".$card_string."</p>
                        <p class='card-text'> il reste ". $nombre." postes</p>
                        <button type='button' class='btn btn-danger' data-toggle='modal' data-target='#ajouter'> En savoir plus</button>
                    </div>
                
                </div>
            
    ";


}     
/**
 * Fonction operation_utilisateur_pending
 * Auteur : Leon Zhang, 
 * Date   : 20 janvier 2019
 * But    : Affiche tout de utilisateur en attente d'approuver
 * Arguments en entrée : $conn : contexte de connexion.
                         $sql_tr: requête
 * Valeurs de retour   : non.
 */

function operation_utisateur_pending($conn,$sql_tr,$page_ua_toggle){
    $result = mysqli_query($conn, $sql_tr);

    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        echo "<table class='table'><tr><thead><th>id</th><th>nom</th><th>nom de activitie</th><th>categorie</th><th>statut</th><th colspan='2'>Action</th></thead><tbody>";
        while($row = mysqli_fetch_assoc($result)) {
            echo "<tr><td>" . $row["id"]. " </td><td>". $row["nom"]. " </td><td>". $row["nom_de_activitie"]. "</td><td>" . $row ["categorie"]
            . "</td><td>". $row["statut"]
//                        <td><a href='info_user.php?id=". $row["produit_id"]."'"." >Détaillée</a></td>
            ."<td>
            <a  href='suppression.php?id=".$row["id"]."&page=".$page_ua_toggle."&table_nom=inscriptions&user_id=id_inscription' type='button'  >Refuser</a>
            </td>"
            ."<td><a href='approuve.php?id=".$row["id"]."&page=".$page_ua_toggle."'"." type='button'  >Approuver</a>
            
            </td></tr>";               
        }
    } else {
        echo "Aucun résultat n'a été trouvé selon les critères indiqués";
    }
    
    echo "</tbody></table>";
}  

/**
 * Fonction afficher_utilisateur_en_activitie_actuel
 * Auteur : Leon Zhang, 
 * Date   : 20 janvier 2019
 * But    : Affiche tout de utilisateur en attente d'approuver
 * Arguments en entrée : $conn : contexte de connexion.
                         $sql_tr: requête
 * Valeurs de retour   : non.
 */

function afficher_utisateur_activitie_actuel($conn,$sql_tr,$page_ua_toggle){
    $result = mysqli_query($conn, $sql_tr);

    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        echo "<table class='table'><tr><thead><th>id</th><th>nom</th><th>nom de activitie</th><th>categorie</th><th>statut</th></thead><tbody>";
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
 * Fonction supprimer_utilisateur_en_attendant
 * Auteur : Leon Zhang, 
 * Date   : 20 janvier 2019
 * But    : supprimer un utilisateur en attente d'approuver
 * Arguments en entrée : $conn : contexte de connexion.
                         $sql_tr: requête
 * Valeurs de retour   : non.
 */
function supprimer_utilisateur_en_attendant($conn,$sql){
   
            if (mysqli_multi_query($conn, $sql))
            {
                echo "Article supprimé avec succès";
                mysqli_close($conn); 
                 
            } 
            else
            {
                echo "Erreur lors de la suppression de l'article: " . mysqli_error($conn);
            }         
  
}

/**
 * Fonction afficher_animateur
 * Auteur : Leon Zhang, 
 * Date   : 20 janvier 2019
 * But    : Affiche tout de animateur
 * Arguments en entrée : $conn : contexte de connexion.
                         $sql_tr: requête
 * Valeurs de retour   : non.
 */

function afficher_animateur($conn,$sql_tr,$page_ua_toggle){
    $result = mysqli_query($conn, $sql_tr);

    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        echo "<table class='table'><tr><thead><th>id</th><th>nom</th><th>prenom</th><th>courriel</th><th>mote_de_passe</th><th>type</th><th colspan='2'>operation</th></thead><tbody>";
        while($row = mysqli_fetch_assoc($result)) {
            echo "<tr><td>" . $row["id"]. " </td><td>". $row["nom"]. " </td><td>". $row["prenom"]. "</td><td>" . $row ["courriel"]
            . "</td><td>". $row["mot_de_passe"]. "</td><td>". $row["type"]
            ."<td><a href='modification_animateur.php?id=".$row["id"]."&page=".$page_ua_toggle."&table_nom=gestions' type='button'  >Modifier</a>"
            ."<td><a href='suppression.php?id=".$row["id"]."&page=".$page_ua_toggle."&table_nom=gestions&user_id=idgestions' type='button'  >Supprimer</a>
            </td></tr>";   
                        
        }
    } else {
        echo "Aucun résultat n'a été trouvé selon les critères indiqués";
    }
    
    echo "</tbody></table>";
}  
/**
 * Fonction ajouter_animateur
 * Auteur : Leon Zhang,  
 * Date   : 24 janvier 2019
 * But    : Ajoute animateur dans la table gestions.
 * Arguments en entrée : $conn : contexte de connexion et tous les attributs du produits en question saisi par l'administrateur.
                         
 * Valeurs de retour   : aucune.
 */

function ajouter_animateur($conn,  $nom, $prenom, $courriel, $password, $type) {


    $sql = "INSERT INTO gestions (nom,prenom,courriel,mot_de_passe,type) 
    VALUES ('$nom','$prenom', '$courriel', '$password', '$type')";

    if (mysqli_query($conn, $sql)) {
        return mysqli_affected_rows($conn);
    } else {
        errSQL($conn);
        exit;
    }
}

/**
 * Fonction afficher_animateur
 * Auteur : Leon Zhang, 
 * Date   : 20 janvier 2019
 * But    : Affiche tout de animateur
 * Arguments en entrée : $conn : contexte de connexion.
                         $sql_tr: requête
 * Valeurs de retour   : non.
 */

function afficher_activities($conn,$sql_tr,$page_ua_toggle){
    $result = mysqli_query($conn, $sql_tr);

    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        echo "<table class='table'><tr><thead><th>id</th><th>nom_activite</th><th>categorie_activite</th><th>nombre place de activite</th><th>Gestion id</th><th colspan='2'>operation</th></thead><tbody>";
        while($row = mysqli_fetch_assoc($result)) {
            echo "<tr><td>" . $row["id"]. " </td><td>". $row["nom_activite"]. " </td><td>". $row["categorie_activite"]. "</td><td>" . $row ["nombre_place_activite"]
            . "</td><td>". $row["gestion_id"]
            ."<td><a href='modification_activitie.php?id=".$row["id"]."&page=".$page_ua_toggle."&table_nom=activites' type='button'  >Modifier</a>"
            ."<td><a href='suppression.php?id=".$row["id"]."&page=".$page_ua_toggle."&table_nom=activites&user_id=id_activite' type='button'  >Supprimer</a>
            </td></tr>";   
                        
        }
    } else {
        echo "Aucun résultat n'a été trouvé selon les critères indiqués";
    }
    
    echo "</tbody></table>";
}   
/**
 * Fonction ajouter_activitie
 * Auteur : Leon Zhang,  
 * Date   : 24 janvier 2019
 * But    : Ajoute activitie dans la table activities.
 * Arguments en entrée : $conn : contexte de connexion et tous les attributs du produits en question saisi par l'administrateur.
                         
 * Valeurs de retour   : aucune.
 */

function ajouter_activitie($conn, $nom_activite , $categorie_activite, $nombre_place_activite,$gestions_idgestions) {


    $sql = "INSERT INTO activites (nom_activite , categorie_activite, nombre_place_activite,gestions_idgestions) 
    VALUES ('$nom_activite','$categorie_activite',  '$nombre_place_activite', '$gestions_idgestions')";

    if (mysqli_query($conn, $sql)) {
        return mysqli_affected_rows($conn);
    } else {
        errSQL($conn);
        exit;
    }
}





?>
