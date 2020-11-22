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
 * Fonction lireUtilisateurs
 * Auteur : Leon Zhang & 
 * Date : 14 décembre 2018
 * But : Récupère le type de l'utilisateur
 * Arguments en entrée : $conn = contexte de connexion
 * Valeurs de retour : le type de l'utilisateur
 */

function lireUtilisateurs($conn,$identifiant)
{
$req = "SELECT utilisateur_type FROM utilisateurs where utilisateur_courriel='$identifiant'";
    if ($result = mysqli_query($conn, $req, MYSQLI_STORE_RESULT))
    {
        $nbResult = mysqli_num_rows($result);
        $tableUtilisateurs = array();
        if ($nbResult) {
            mysqli_data_seek($result, 0);
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $tableUtilisateurs = $row;
            }
        }
        mysqli_free_result($result);
        return $tableUtilisateurs['utilisateur_type'];
    } else {
        errSQL($conn);
        exit;
    }
}

/**
 * Fonction verifCourriel
 * Auteur : Leon Zhang & 
 * Date : 14 décembre 2018
 * But : Vérifie que le courriel saisi par l'utilisateur se trouve dans la table utilisateur.
 * Arguments en entrée : $conn = contexte de connexion; $courriel = courreil saisi par l'usager.
 * Valeurs de retour : 1 si le courriel a été trouvé; 0 s'il ne s'y trouve pas.
 */



function verifCourriel($conn, $courriel)
{
    $req = "SELECT '$courriel' FROM utilisateurs
            WHERE utilisateur_courriel='$courriel'";

    if ($result = mysqli_query($conn, $req)) {
        return mysqli_num_rows($result);
    } else {
        errSQL($conn);
        exit;
    }
}


/**
 * Fonction AuthentificationUtilisateur
 * Auteur : Leon Zhang, 
 * Date   : 14 décembre 2018
 * But    : contrôler l'authentification de l'utilisateur dans la table utilisateurs
 * Arguments en entrée : $conn = contexte de connexion
 *                       $identifiant
 *                       $mot_de_passe
 * Valeurs de retour   : 1 si utilisateur avec $identifiant et $mot_de_passe trouvé 
 */

function AuthentificationUtilisateur($conn, $identifiant, $mot_de_passe)
{
    $req = "SELECT * FROM utilisateurs
            WHERE utilisateur_courriel=? AND utilisateur_mot_de_passe = SHA2(?,256) ";
    
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
 * Fonction listeDesItems
 * Auteur : Leon Zhang, 
 * Date   : 14 décembre 2018
 * But    : Récupérer tous les items en catalogue avec toutes leurs caractéristiques.
 * Arguments en entrée : $conn.
 * Valeurs de retour   : listeDesItems = tableau des items
 */

function listeDesItems($conn)
{
    $requeteListe = "SELECT P.produit_id, P.produit_nom, P.produit_quantite, P.produit_prix, P.produit_description, C.categorie_nom, M.marque_nom from produits as P 
    inner join categories as C ON P.categorie_categorie_id= C.categorie_id
    inner join marques AS M ON M.marque_id = P.marques_marque_id order by C.categorie_nom";
    /*inner join marques AS M ON M.marque_id = P.marques_marque_id order by P.produit_nom";  changer a order by categorie*/
    if ($resultRequete = mysqli_query($conn, $requeteListe, MYSQLI_STORE_RESULT))
    {
        $nbResultRequete = mysqli_num_rows($resultRequete);
        $listeItems = array();
        if ($nbResultRequete)
        {
            mysqli_data_seek($resultRequete, 0);
            while ($row = mysqli_fetch_array($resultRequete, MYSQLI_ASSOC))
            {        
                $listeItems []= $row;
            }
        }
    mysqli_free_result($resultRequete);
    return $listeItems;     
    }
    else
    {
        errSQL($conn);
        exit;
    }
}

/**
 * Fonction lireConfirmationCommande
 * Auteur : Leon Zhang, 
 * Date   : 14 décembre 2018
 * But    : Récupérer tous les items sélectionné par le cLeonnt en vue de passer une commande.
 * Arguments en entrée : $conn : contexte de connexion
                         $id: identifiant de l'article
 * Valeurs de retour   : $ConfirmationCommande = liste des items sélectionnés
 */

function lireConfirmationCommande($conn, $id)
{
$requeteListe = "select P.produit_nom, P.produit_id, P.produit_description, C.categorie_nom, M.marque_nom, P.produit_prix
from produits AS P
Inner join categories As C  ON C.categorie_id = P.categorie_categorie_id
Inner join marques AS M ON M.marque_id= P.marques_marque_id
where P.produit_id = '$id'";
    if ($resultRequete = mysqli_query($conn, $requeteListe, MYSQLI_STORE_RESULT))
    {
        $nbResultRequete = mysqli_num_rows($resultRequete);
        $ConfirmationCommande = array();
        if ($nbResultRequete)
        {
             while ($row = mysqli_fetch_array($resultRequete, MYSQLI_ASSOC))
            {        
                $ConfirmationCommande =$row;
            }
        }
    mysqli_free_result($resultRequete);
   
    return $ConfirmationCommande;     
    }
    else
    {
        errSQL($conn);
        exit;
    }
}

/**
 * Fonction insertionCommande
 * Auteur : Leon Zhang, 
 * Date   : 14 décembre 2018
 * But    : Ajoute la commande du cLeonnt à la table "commandes".
 * Arguments en entrée : $conn : contexte de connexion
                         $identifiant ; courriel du cLeonnt.
 * Valeurs de retour   : aucune.
 */

function insertionCommande($conn, $identifiant)
{
    
$req = "INSERT INTO commandes (commande_id, commande_date, utilisateurs_utilisateur_id)    
VALUES (NULL, NOW(), (select utilisateur_id from utilisateurs WHERE utilisateur_courriel ='$identifiant'))";   
    if (mysqli_query($conn, $req)) {
        return mysqli_affected_rows($conn);
    } 
    else
    {
        errSQL($conn);
        exit;
    }
}

/**
 * Fonction insertionLigneCommande
 * Auteur : Leon Zhang, 
 * Date   : 14 décembre 2018
 * But    : Ajoute les clés primaires et la quantité relatives à la commande passée par le cLeonnt.
 * Arguments en entrée : $conn : contexte de connexion
                         $id : identifiant de la commande du cLeonnt.
                         $id : identifiant de la commande du cLeonnt.
 * Valeurs de retour   : aucune.
 */
    
function insertionLigneCommande($conn, $id, $qty)
{
    
    $req= "INSERT INTO commandes_produits (commandes_commande_id, produits_produit_id, produit_quantite)
    VALUES ((SELECT commande_id from commandes order by commande_id desc limit 1), '$id', '$qty')";
      if (mysqli_query($conn, $req))
      {
        return mysqli_affected_rows($conn);
    } else {
        errSQL($conn);
        exit;
    }
}

/**
 * Fonction updateTableQuantite
 * Auteur : Leon Zhang, 
 * Date   : 14 décembre 2018
 * But    : Met à jour le stock disponible des articles restants après confirmation de la commande.
 * Arguments en entrée : $conn : contexte de connexion
                         $id : identifiant de l'article.
                         $qty : quantité d'articles commandés par le cLeonnt.
 * Valeurs de retour   : aucune.
 */
    
function updateTableQuantite($conn, $id, $qty)
{
   
    $req= "UPDATE produits SET produit_quantite = produit_quantite - '$qty' where produit_id= '$id'";
      if (mysqli_query($conn, $req))
      {
        return mysqli_affected_rows($conn);
    } else {
        errSQL($conn);
        exit;
    }
}    

/**
 * Fonction updateTableQuantite
 * Auteur : Leon Zhang, 
 * Date   : 14 décembre 2018
 * But    : Met à jour le stock disponible des articles restants après confirmation de la commande.
 * Arguments en entrée : $conn : contexte de connexion
                         $id : identifiant de l'article.
                         $qty : quantité d'articles commandés par le cLeonnt.
 * Valeurs de retour   : aucune.
 */

function quantitedisponible($conn, $id)
{
  
    $req="select produit_quantite from produits where produit_id= '$id'";
    if ($resultRequete = mysqli_query($conn, $req, MYSQLI_STORE_RESULT))
    {
        $nbResultRequete = mysqli_num_rows($resultRequete);
        $quantiteDispo = array();
        if ($nbResultRequete)
        {
             while ($row = mysqli_fetch_array($resultRequete, MYSQLI_ASSOC))
            {        
                $quantiteDispo =$row;
            }
        }
    
    mysqli_free_result($resultRequete);
    return $quantiteDispo;     
    }
    else
    {
        errSQL($conn);
        exit;
    }
}

/**
 * Fonction updateTableQuantite
 * Auteur : Leon Zhang, 
 * Date   : 14 décembre 2018
 * But    : Insère les informations saisies par le cLeonnt sur le formulaire d'inscription
 * Arguments en entrée : $conn : contexte de connexion
                         $nom : nom saisi par le cLeonnt.
                         $prenom : $prenom saisi par le cLeonnt.
                         $courriel : $courriel saisi par le cLeonnt.
                         $password : $password saisi par le cLeonnt.
                         $usertype : 'user' par defaut(autosai).
 * Valeurs de retour   : 1.
 */
   
function inscriptionCLeonnt($conn, $nom, $prenom, $courriel, $password, $usertype) 
{
    $req = "INSERT INTO utilisateurs SET utilisateur_nom = ?, utilisateur_prenom = ?, utilisateur_courriel = ?,utilisateur_mot_de_passe=SHA2(?,256), utilisateur_type = ?";
    
    $stmt = mysqli_prepare($conn, $req);
    mysqli_stmt_bind_param($stmt, "sssss", $nom, $prenom, $courriel, $password, $usertype);
    
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
 * Fonction afficher_produit
 * Auteur : Leon Zhang, 
 * Date   : 14 décembre 2018
 * But    : Affiche tous les items en catalogue avec toutes leurs caractéristiques.
 * Arguments en entrée : $conn : contexte de connexion.
                         $sql_tr: requête
 * Valeurs de retour   : aucune.
 */

function afficher_produit($conn,$sql_tr){
                $result = mysqli_query($conn, $sql_tr);

                if (mysqli_num_rows($result) > 0) {
                    // output data of each row
                    echo "<table class='table'><tr><thead><th>id</th><th>nom</th><th>prenom</th><th>courriel</th><th>mot_passe</th><th>role_id</th><th colspan='2'>Action</th></thead><tbody>";
                    while($row = mysqli_fetch_assoc($result)) {
                        echo "<tr><td>" . $row["id_utilisateur"]. " </td><td>". $row["nom_utilisateur"]. "</td><td>" . $row ["prenom_utilisateur"]
                        . "</td><td>". $row["courriel_utilisateur"]. "</td><td>". $row["mot_de_pass"]
//                        <td><a href='info_user.php?id=". $row["produit_id"]."'"." >Détaillée</a></td>
                        ."<td>
                        <a type='button' class='btn btn-secondary' data-toggle='modal' data-target='#ajouter'>Modifier</a>
                        </td>"
                        ."<td><a href='teacher.php?id=".$row["id_utilisateur"]."'"." data-emp-id='".$row["id_utilisateur"]."'"." type='button' class='btn btn-danger' data-toggle='modal' data-target='#ajouter'>Supprimer</a>
                        </td></tr>";               
                    }
                } else {
                    echo "Aucun résultat n'a été trouvé selon les critères indiqués";
                }
                
                echo "</tbody></table>";
            }   
    

/**
 * Fonction afficher_produit_topvendre (les produits les vendeurs)
 * Auteur : Leon Zhang, 
 * Date   : 14 décembre 2018
 * But    : Affiche les produits les plus vendeurs.
 * Arguments en entrée : $conn : contexte de connexion.
                         $sql_tr: requête
 * Valeurs de retour   : aucune.
 */

function afficher_produit_topvendre($conn,$sql_tr)
{
                $result = mysqli_query($conn, $sql_tr);
                if (mysqli_num_rows($result) > 0)
                {
                    $row = mysqli_fetch_assoc($result);
                    $step=$row["step"];
                }
                $sql_tr="SELECT * FROM
                (SELECT P.produit_id, P.produit_nom, SUM(CP.produit_quantite) as quantite from produits as P
                INNER JOIN commandes_produits as CP WHERE P.produit_id = CP.produits_produit_id
                GROUP BY produit_nom 
                ORDER by quantite DESC) as P1
                limit $step";
                $result = mysqli_query($conn, $sql_tr);
                if (mysqli_num_rows($result) > 0) {
                    echo "<table><tr><th>produit_id</th><th>produit_nom</th><th>quantite</th></tr>";
                    while($row = mysqli_fetch_assoc($result)) {
                            echo "<tr><td>".$row["produit_id"]."</td><td>".$row["produit_nom"]."</td><td>".$row["quantite"]."</td><tr>";
                    }
                    echo "</table>";
                }else {
                    echo "Aucun résultat n'a été trouvé selon les critères indiqués";
                }
            }
/**
 * Fonction afficher_meilleur_acheteur (les meilleurs cLeonnts)
 * Auteur : Leon Zhang, 
 * Date   : 14 décembre 2018
 * But    : Affiche la liste de 10 meilleurs cLeonnts.
 * Arguments en entrée : $conn : contexte de connexion.
                         $sql_tr: requête
 * Valeurs de retour   : aucune (affichage).
 */
          function afficher_meilleur_acheteur($conn,$sql_tr)
            {
                $result = mysqli_query($conn, $sql_tr);
                if (mysqli_num_rows($result) > 0) {
                    echo "<table><tr><th>id</th><th>nom</th><th>quantite</th></tr>";
                    while($row = mysqli_fetch_assoc($result)) {
                            echo "<tr><td>".$row["id"]."</td><td>".$row["nom"]."</td><td>".$row["quantite"]."</td><tr>";
                    }
                    echo "</table>";
                }else {
                    echo "Aucun résultat n'a été trouvé selon les critères indiqués";
                }
            }

/**
 * Fonction sqlAjouter
 * Auteur : Leon Zhang,  
 * Date   : 14 décembre 2018
 * But    : Ajoute les produits dans la table produits.
 * Arguments en entrée : $conn : contexte de connexion et tous les attributs du produits en question saisi par l'administrateur.
                         
 * Valeurs de retour   : aucune.
 */

            function sqlAjouter($conn, $produit_nom, $produit_quantite, $produit_prix, $produit_description, $categorie_categorie_id, $marques_marque_id) {


                $sql = "INSERT INTO produits (produit_nom,produit_quantite,produit_prix,
                produit_description,categorie_categorie_id,marques_marque_id) 
                VALUES ('$produit_nom','$produit_quantite', '$produit_prix', '$produit_description', '$categorie_categorie_id','$marques_marque_id')";

                if (mysqli_query($conn, $sql)) {
                    return mysqli_affected_rows($conn);
                } else {
                    errSQL($conn);
                    exit;
                }
            }

/**
 * Fonction afficher_ordre
 * Auteur : Leon Zhang,  
 * Date   : 14 décembre 2018
 * But    : Afficher les ordre par nom de cLeonnt et quantite de ordre.
 * Arguments en entrée : $conn : contexte de connexion et tous les attributs du produits en question saisi par l'administrateur.
 *                       $sql_tr: Sql query et $mois:current month pour choisir donnee                         
 * Valeurs de retour   : aucune.
 */
            function afficher_ordre($conn,$sql_tr,$mois){
                $result = mysqli_query($conn, $sql_tr);

                if (mysqli_num_rows($result) > 0) {
                    // output data of each row
                    echo "<table><tr><th>nom</th><th>quantite</th><th>Action</th>";
                    while($row = mysqli_fetch_assoc($result)) {
                        echo "<tr><td>" .$row["nom"]. "</td><td>" . $row ["quantite"]
                        ."</td><td><a href='info_user.php?id=".$row["nom"]."&month=".$mois."'"." >Détails</a></td></tr>"; 
                                      
                    }
                } else {
                    echo "Aucun résultat n'a été trouvé selon les critères indiqués";
                }
            } 

/**
 * Fonction afficher_ordre
 * Auteur : Leon Zhang,  
 * Date   : 14 décembre 2018
 * But    : Afficher le detail information de ordre par nom de cLeonnt.
 * Arguments en entrée : $conn : contexte de connexion et tous les attributs du produits en question saisi par l'administrateur.
 *                       $sql_tr: Sql query                         
 * Valeurs de retour   : aucune.
 */
            function afficher_order_detail($conn,$sql_tr){
                $result = mysqli_query($conn, $sql_tr);
                if (mysqli_num_rows($result) > 0) {
                    // output data of each row
                    echo "<table><tr><th>Identifiant commande</th><th>CLeonnt</th><th>Produit</th><th>Date de commande</th><th>Quantité</th><th>Prix</th><th>Catégorie
                    </th><th>Marque</th>";
                    while($row = mysqli_fetch_assoc($result)) {
                        
                        echo "<tr><td>" . $row ["commandesID"]
                        . " </td><td>" . $row ["nom"]
                        . "</td><td>" . $row ["produit_nom"]
                        . "</td><td>". $row ["date1"]
                        ."</td><td>". $row ["quantite"]
                        . "</td><td>".$row ["prix"]
                        . "</td><td>".$row ["categorie"]
                        . "</td><td>".$row ["marque_nom"]
                        ."</td><tr>";
                    }
                    echo "</table>";
                } else {
                    echo "0 results";
                }
            }
            function afficher_month($mois){
                switch($mois){
                    case "1":
                        return "Janvier";
                        break;
                    case "2":
                        return "Février";
                        break;
                    case "3":
                        return "Mars";
                        break;
                        case "4":
                        return "Avril";
                        break;
                        case "5":
                        return "Mai";
                        break;
                        case "6":
                        return "Juin";
                        break;
                        case "7":
                        return "Juillet";
                        break;
                        case "8":
                        return "Août";
                        break;
                        case "9":
                        return "Septembre";
                        break;
                        case "10":
                        return "Octobre";
                        break;
                        case "11":
                        return "Novembre";
                        break;
                        case "12":
                        return "Décembre";
                        break;
                        
                }
            }  


/**
 * Fonction afficher_nombre_utilisateur_en_attendant
 * Auteur : Leon Zhang, 
 * Date   : 20 janvier 2019
 * But    : Affiche nombre de utilisateur en attente d'approuver
 * Arguments en entrée : $conn : contexte de connexion.
                         $sql_tr: requête
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
        echo "<table class='table'><tr><thead><th>nom</th><th>nom de activitie</th><th>categorie</th><th>statut</th><th colspan='2'>Action</th></thead><tbody>";
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
