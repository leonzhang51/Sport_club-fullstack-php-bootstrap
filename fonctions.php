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
 * Auteur : Leon Zhang
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
 * Auteur : Leon Zhang
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
 * Auteur : Leon Zhang
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
            WHERE utilisateur_courriel=? AND utilisateur_mot_de_passe = SHA2(?,256)";
    
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
 * Auteur : Leon Zhang
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
 * Auteur : Leon Zhang
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
 * Auteur : Leon Zhang
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
 * Auteur : Leon Zhang
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
 * Auteur : Leon Zhang
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
 * Auteur : Leon Zhang
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
 * Auteur : Leon Zhang
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
 * Auteur : Leon Zhang
 * Date   : 14 décembre 2018
 * But    : Affiche tous les items en catalogue avec toutes leurs caractéristiques.
 * Arguments en entrée : $conn : contexte de connexion.
    *                     $sql_tr: requête
 * Valeurs de retour   : aucune.
 */

function afficher_produit($conn,$sql_tr){
                $result = mysqli_query($conn, $sql_tr);

                if (mysqli_num_rows($result) > 0) {
                    // output data of each row
                    echo "<table><tr><th>id</th><th>nom</th><th>quantities</th><th>prix</th><th>description</th><th>categorie</th><th>marque</th><th colspan='3'>Action</th>";
                    while($row = mysqli_fetch_assoc($result)) {
                        echo "<tr><td>" . $row["produit_id"]. " </td><td>". $row["produit_nom"]. "</td><td>" . $row ["produit_quantite"]
                        . "</td><td>". $row["produit_prix"]. "</td><td>". $row["produit_description"]
                        ."</td><td>". $row["categorie_nom"]."</td><td>". $row["marque_nom"]
                        ."</td>"
//                        <td><a href='info_user.php?id=". $row["produit_id"]."'"." >Détaillée</a></td>
                        ."</td><td><a href='suppression.php?id=". $row["produit_id"]."'"." >Supprimer</a></td>"
                        ."</td><td><a href='modification.php?id=". $row["produit_id"]."'"." >Modifier</a></td></tr>";               
                    }
                } else {
                    echo "Aucun résultat n'a été trouvé selon les critères indiqués";
                }
            }   
    

/**
 * Fonction afficher_produit_topvendre (les produits les vendeurs)
 * Auteur : Leon Zhang
 * Date   : 14 décembre 2018
 * But    : Affiche les produits les plus vendeurs.
 * Arguments en entrée : $conn : contexte de connexion.
 *                        $sql_tr: requête
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
 * Auteur : Leon Zhang
 * Date   : 14 décembre 2018
 * But    : Affiche la liste de 10 meilleurs cLeonnts.
 * Arguments en entrée : $conn : contexte de connexion.
 *                        $sql_tr: requête
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
 * Auteur : Leon Zhang 
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
 * Auteur : Leon Zhang 
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
 * Auteur : Leon Zhang 
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

/**
 * Fonction afficher_month
 * Auteur : Leon Zhang 
 * Date   : 14 décembre 2018
 * But    : Afficher le mois sélectionné par l'administrateur.
 * Arguments en entrée : $mois          
 * Valeurs de retour   : mois sélectionné.
 */


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










?>
