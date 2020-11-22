<?php
    
/**
 * Fonction errSQL
 * Auteur : Leon
 * Date   : 
 * But    : afficher le message d'erreur de la dernière "query" SQL 
 * Arguments en entrée : $conn = contexte de connexion
 * Valeurs de retour   : aucune
 */
function errSQL($conn) {
    ?>
    <p>Erreur de requête : <?php echo mysqli_errno($conn)." – ".mysqli_error($conn) ?></p> 
    <?php 
}

/**
 * Fonction sqlListerFilms
 * Auteur : Leon
 * Date   : 
 * But    : Récupérer les films avec pour chaque film,  ses réalisateur, acteurs et genres  
 * Arguments en entrée : $conn = contexte de connexion
 * Valeurs de retour   : $liste = tableau des films
 */
function sqlListerFilms($conn) {

    $req = "SELECT U.film_id, U.film_titre, U.film_annee_sortie, U.film_duree,
                   R.realisateur_id, CONCAT (R.realisateur_nom, ' ', R.realisateur_prenom) AS realisateur,
                   A.acteur_id, CONCAT(A.acteur_nom, ' ', A.acteur_prenom) AS acteur,
                   G.genre_id, G.genre_nom
            FROM films as U
            INNER JOIN films_realisateurs AS FR ON FR.fr_fk_film_id = U.film_id
            INNER JOIN realisateurs       AS R  ON R.realisateur_id = FR.fr_fk_realisateur_id
            INNER JOIN films_acteurs      AS FA ON FA.fa_fk_film_id = U.film_id
            INNER JOIN acteurs            AS A  ON A.acteur_id      = FA.fa_fk_acteur_id 
            INNER JOIN films_genres       AS FG ON FG.fg_fk_film_id = U.film_id
            INNER JOIN genres             AS G  ON G.genre_id       = FG.fg_fk_genre_id
            ORDER BY film_id, realisateur_id, acteur_id, genre_id";

    if ($result = mysqli_query($conn, $req, MYSQLI_STORE_RESULT))
    {
        $nbResult = mysqli_num_rows($result);
        $liste = array();
        if ($nbResult) {
            mysqli_data_seek($result, 0);

            $film_id = "";
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                if ($film_id != $row['film_id']) {
                    if ($film_id !== "") {
                        $liste [] = array(
                                    'film_titre'        => $film_titre,
                                    'film_duree'        => $film_duree,
                                    'film_annee_sortie' =>  $film_annee_sortie,
                                    'realisateurs'      =>   $realisateurs,
                                    'acteurs'           =>  $acteurs,
                                    'genres'            =>  $genres
                                    );
                    }
                    $film_id           = $row['film_id'];
                    $film_titre        = $row['film_titre'];
                    $film_duree        = $row['film_duree'];
                    $film_annee_sortie = $row['film_annee_sortie']; 
                    $realisateurs      = [];
                    $acteurs           = [];
                    $genres            = [];
                }
                $realisateurs[$row['realisateur_id']] = $row['realisateur'];
                $acteurs     [$row['acteur_id']]      = $row['acteur'];
                $genres      [$row['genre_id']]       = $row['genre_nom'];
            }
            $liste [] = array(
                        'film_titre'        => $film_titre,
                        'film_duree'        => $film_duree,
                        'film_annee_sortie' =>  $film_annee_sortie,
                        'realisateurs'      =>   $realisateurs,
                        'acteurs'           =>  $acteurs,
                        'genres'            =>  $genres
                        );
        }
        mysqli_free_result($result);
        return $liste;
    } else {
        errSQL($conn);
        exit;
    }
}

/**
 * Fonction sqlListerGenres
 * Auteur : Leon
 * Date   : 
 * But    : Récupérer les genres avec le nombre de films rattachés  
 * Arguments en entrée : $conn = contexte de connexion
                         $recherche = chaîne de caractères pour la recherche de genres (optionnel)
                         $tri  = champ critère de tri (optionnel)
                         $sens = sens du tri, ASC ou DESC (optionnel)
 * Valeurs de retour   : $liste = tableau des lignes de la commande SELECT
 */
function sqlListerGenres($conn, $recherche = "", $tri = "genre_id", $sens = "ASC") {

    $req = "SELECT genre_id, genre_nom, count(fg_fk_film_id) as nb_films from genres AS G
            LEFT JOIN films_genres AS FG ON FG.fg_fk_genre_id = G.genre_id
            WHERE genre_nom LIKE \"%$recherche%\"
            GROUP BY G.genre_id
            ORDER BY $tri $sens";
    
    if ($result = mysqli_query($conn, $req, MYSQLI_STORE_RESULT)) {
        $nbResult = mysqli_num_rows($result);
        $liste = array();
        if ($nbResult) {
            mysqli_data_seek($result, 0);
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $liste[] = $row;
            }
        }
        mysqli_free_result($result);
        return $liste;
    } else {
        errSQL($conn);
        exit;
    }
}

/**
 * Fonction sqlLireGenre
 * Auteur : Leon
 * Date   : 
 * But    : Récupérer le genre par son identifiant clé primaire 
 * Arguments en entrée : $conn = contexte de connexion
 *                       $id   = clé primaire
 * Valeurs de retour   : $row  = ligne correspondant à la clé primaire
 *                               tableau vide si non trouvée     
 */
function sqlLireGenre($conn, $id) {

    $req = "SELECT * FROM genres WHERE genre_id=".$id;
    
    if ($result = mysqli_query($conn, $req)) {
        $nbResult = mysqli_num_rows($result);
        $row = array();
        if ($nbResult) {
            mysqli_data_seek($result, 0);
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        }
        mysqli_free_result($result);
        return $row;
    } else {
        errSQL($conn);
        exit;
    }
}

/** 
 * Fonction sqlAjouterGenre
 * Auteur : Leon
 * Date   : 
 * But    : ajouter une ligne dans la table genres  
 * Arguments en entrée : $conn = contexte de connexion
 *                       $genre_nom 
 * Valeurs de retour   : 1    si ajout effectuée
 *                       0    si aucun ajout
 */
function sqlAjouterGenre($conn, $genre_nom) {
    
    $req = "INSERT INTO genres SET genre_nom='$genre_nom'";

    if (mysqli_query($conn, $req)) {
        return mysqli_affected_rows($conn);
    } else {
        errSQL($conn);
        exit;
    }
}

/** 
 * Fonction sqlModifierGenre
 * Auteur : Leon
 * Date   : 
 * But    : modifier une ligne dans la table genres  
 * Arguments en entrée : $conn = contexte de connexion
                         $id   = clé primaire du genre à modifier
 *                       $genre_nom 
 * Valeurs de retour   : 1    si modification effectuée
 *                       0    si aucune modification
 */
function sqlModifierGenre($conn, $id, $genre_nom) {
    
    $req = "UPDATE genres SET genre_nom='$genre_nom' WHERE genre_id =".$id;
 
    if (mysqli_query($conn, $req)) {
        return mysqli_affected_rows($conn);
    } else {
        errSQL($conn);
        exit;
    }
}

/**
 * Fonction sqlSupprimerGenre
 * Auteur : Leon
 * Date   : 
 * But    : supprimer une ligne de la table genres  
 * Arguments en entrée : $conn = contexte de connexion
 *                       $id   = valeur de la clé primaire 
 * Valeurs de retour   : 1    si suppression effectuée
 *                       0    si aucune suppression
 */
function sqlSupprimerGenre($conn, $id) {
    
    $req = "DELETE FROM genres WHERE genre_id=".$id;

    if (mysqli_query($conn, $req)) {
        return mysqli_affected_rows($conn);
    } else {
        errSQL($conn);
        exit;
    }
}

?>