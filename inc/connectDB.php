<?php

/**
 * @file        connectDB.php.
 * @author      Leon Zhang 
 * @version     1.0.
 * @date        30 janvier 2019.
 * @brief       Programme de @b connexion à la base de données.
 * @details     En cas d'erreur, le programme affiche un message
 *              d'erreur comportant un code d'erreur et une indication
 *              sur le source de l'erreur.
 */


require_once("paramConnectDB.php"); /** paramètres de connexion à la base de données.*/
$conn = mysqli_connect(HOST, USER, PASSWORD, DBNAME);

if (!$conn)
{
?>
   <p>Erreur de connexion :
      <?php echo mysqli_connect_errno()." – ".utf8_encode(mysqli_connect_error()) ?>
   </p> 
<?php 
   exit;
}
mysqli_set_charset($conn, "utf8");
