<?php
/**
 * @file        deconnexion.php.
 * @author      Leon Zhang .
 * @version     1.0.
 * @date        30 janvier 2019.
 * @brief       Page de @b deconnexion du site.
 * @details     Cette page comporte un programme qui détruit toutes
 *              les variables de session ainsi que la session elle-même
 *              avant de rediriger l'utilisateur vers la page d'accueil.
 */


session_start();
unset($_SESSION['identifiant_utilisateur']); /** destruction de la variable de Session. */
unset($_SESSION['identifiant_admin']); /** destruction de la variable de Session. */
unset($_SESSION['identifiant_teacher']); /** destruction de la variable de Session. */
unset ($_SESSION['categorie']); /** destruction de la variable de Session. */
session_destroy();
header('Location: index.php'); 
?>