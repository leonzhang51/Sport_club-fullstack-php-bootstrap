<?php

/**
 * @file        inscription.php.
 * @author      Leon Zhang.
 * @version     1.0.
 * @date        30 janvier 2019.
 * @brief       Page d'@b inscription du site.
 * @details     Cette page comporte une formulaire d'inscription au club.
 *              Chaque champs est contrôlé par un programme javascript afin
 *              afin que les entrée saises soient conformes aux formats
 *              requis. Une fois que l'utilisateur envoie son formulaire,
 *              chaque champs est validé par le serveur. Si les données répondent
 *              aux exigences requises, l'utilisateur voit s'afficher une page
 *              de confirmation l'invitant à revenir en page d'accueil pour
 *              passer en revue les activités proposés.
 */




require_once("inc/connectDB.php");/** Connexion à la base de données.*/
require_once("inc/fonctionsFichiers.php");/** Start session.*/
require_once("inc/sessionUtilisateur.php");  /** Fichier contenant les fonctions.*/


$prenom=""; /** déclaration de variable vide.*/
$nom=""; /** déclaration de variable vide.*/
$email=""; /** déclaration de variable vide.*/
$password=""; /** déclaration de variable vide.*/
$erreurSaisie=""; /** déclaration de variable vide.*/
$messageConfirmation=""; /** déclaration de variable vide.*/
$messageRefus=""; /** déclaration de variable vide.*/

if(isset($_POST['envoi']))
{
    if(isset($_POST['prenom']) && isset($_POST['nom']) && isset($_POST['email']) && isset($_POST['password'])) 
    {
        $prenom = trim($_POST['prenom']); /** Retirer les espaces vides avant et après le mot saisi.*/
        if (!preg_match('/^[a-z -àéèêô]+$/i', $prenom)) /** Test de conformité à l'expression régulière.*/
        {
            $erreurSaisie .= "Le prenom saisi n'est pas au bon format.<br>";
        }
        
        $nom = trim($_POST['nom']); /** Retirer les espaces vides avant et après le mot saisi.*/
        if (!preg_match('/^[a-z àéèêô]+$/i', $nom)) /** Test de conformité à l'expression régulière.*/
        {
            $erreurSaisie .= "Le nom saisi n'est pas au bon format.<br>";
        }
        
        
        $email = trim($_POST['email']);
        if (!preg_match('/[^@]+@[^\.]+\..+$/', $email))
        {
            $erreurSaisie .= "Le courriel saisi n'est pas au bon format.<br>";
        }
        
        $validEmail=verifCourriel($conn, $email);
        if($validEmail>0)
        {
            $erreurSaisie .= "Le courriel saisi existe déjà.<br>";
        }
        
        
        $password = trim($_POST['password']);
        if (!preg_match('/^[A-Za-z]{1,8}\d$/', $password))
        {
            $erreurSaisie .= "Le mot de passe saisi n'est pas au bon format.<br>";
        }
       
    }
    
    if ($erreurSaisie == "")
    {
        if (inscriptionMembre($conn, $nom, $prenom, $email, $password) === 1)
        {
            $messageConfirmation="Bienvenue. Vous êtes désormais membre de NDG Le Club.";
            $email="";
            $password="";
            $erreurSaisie="";
            $messageRefus="";
        } 
        else
        {
            $messageRefus ="Désolé, il semble que votre inscription soit impossible.";    
        }
    }
//    mysqli_close($conn);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once("head.php");?> <!-- head -->
    <title>Inscription</title>
</head>

<body>

<header>
    <?php require_once("header.php");?> <!-- header -->
</header> 

    <?php if($messageConfirmation =="") : ?>
     
     
    <div class="card border-0 img-fluid inscription rounded-0">
        <div class="card-img-overlay inscription mx-auto rounded-0">
            <h2 class="card-title card-title-inscription text-center">FORMULAIRE D'INSCRIPTION</h2>
            <form class="formulaire-inscription" action="inscription.php" method="post">
               
                <div class="form-row">
               
                    <?php if($erreurSaisie !="") : ?>
                    <div class="form-group offset-sm-3 col-sm-6 offset-lg-4 col-lg-4 offset-md-3 col-md-6 " >
                      
                       <p class="form-control" id="message-erreur-bis2"> <i class="fas fa-exclamation-triangle"></i><?php echo $erreurSaisie ?> </p>
                    </div>
                    <?php endif; ?>
                    
                    <div class="form-group offset-sm-3 col-sm-6 offset-lg-4 col-lg-4 offset-md-3 col-md-6 " >
                       <p class="form-control" id="message-erreur-bis" ></p>
                    </div>
                    
                    <div class="form-group offset-sm-3 col-sm-6 offset-lg-4 col-lg-4 offset-md-3 col-md-6" >
                        <input type="text" class="form-control" name="prenom" id="prenom" placeholder="Prénom " value="<?=$prenom?>"autofocus >
                    </div>
                    <div class="form-group offset-sm-3 col-sm-6 offset-lg-4 col-lg-4 offset-md-3 col-md-6">
                        <input type="text" class="form-control" name="nom" id="nom" placeholder="Nom" value="<?=$nom?>">
                    </div>
                    <div class="form-group  offset-sm-3 col-sm-6 offset-lg-4 col-lg-4 offset-md-3 col-md-6">
                        <input type="email" class="form-control" name="email" id="email" placeholder="Courriel (ex.john2@test.com)" value="<?=$email?>">
                    </div>
                    <div class="form-group  offset-sm-3 col-sm-6 offset-lg-4 col-lg-4 offset-md-3 col-md-6">
                        <input type="text" class="form-control" name="password" id="password" placeholder="Mot de passe (8 lettres max. suivi d'un chiffre max)" value="<?=$password?>">
                    </div>
                </div>
                <button type="button" name="envoi" id="envoyer" class="btn envoyer text-white">Envoyer</button>
                
            </form>
        </div>
    </div>
    
    <?php else : ?>
<div class="jumbotron m-0">
  <h1 class="display-4">Salut <?=$prenom?> <?=$nom?> !</h1>
  <p class="lead">Félicitations, ta demande d'inscription nous a bien été transmise. Tu devrais recevoir un courriel de confirmation sous peu, le temps que ta demande soit traitée par nos équipes.</p>
  <p class="lead">Merci à toi et à bientôt !</p>
  <hr class="my-4">
  <p>Tu peux d'ores et déjà parcourir notre offre d'activités sportives en te rendant sur notre page d'accueil et d'inscrire à celles qui te plaisent dès aujourd'hui.</p>
  <p class="lead">
    <a class="btn text-white btn-sm" href="index.php" role="button">Voir les activités</a>
  </p>
</div>

<div class="container-fluid m-0 intervalle">
  
  <img src="images/adult-athlete-barbell-685530.jpg" alt="">

</div>
      <div class="card img-fluid aside">
            <img class="card-img-top" src="images/soccer.jpg" alt="yoga image" style="width:100%">
            <div class="card-img-overlay  col-sm-12 col-md-12 col-lg-12 mx-auto">
                <h2 class="card-title text-center ">Inscrivez-vous à notre infolettre</h2>
                <p class="text-center">Soyez tout de suite informé des dernières nouvelles du club.</p>
                <div class="input-group">
                    <input type="text" class="form-control " placeholder="Votre courriel" aria-label="Recipient's username" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <span class="input-group-text border-0 text-white" id="basic-addon2">S'abonner</span>
                    </div>
                </div>
            </div>
        </div>
<?php endif; ?>
 
  
    
    

    <footer>
        <?php require_once("footer.php");?> <!-- footer -->
    </footer>





    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script>
    
        var validCourriel = /[^@]+@[^\.]+\..+$/; // expression régulière courriel //
        var validMotPass =/^[A-Za-z]{1,8}\d$/; // expression régulière mot de passe //
        var validPrenom =/^[a-z -àéèêô]+$/i; // expression régulière prénom //
        var validNom =/^[a-z àéèêô]+$/i; // expression régulière mot de passe //
        var messageErreur="";
        
        var boolNom=false;
        var boolPrenom=false;
        var boolMail=false;
        var boolPassWord=false;

        
        
        $(document).ready(function()
        {
            $('#envoyer').click(function()
            {
                var prenom = $('#prenom').val();
                var nom = $('#nom').val();
                var email = $('#email').val();
                var password = $('#password').val();
                messageErreur="";

                if (prenom == "")
                {
                    messageErreur +="Le prénom n'a pas été saisi. <br>" 
                }
                else if (prenom!= "")
                {
                    if (!validPrenom.test(prenom))
                    {
                        messageErreur += "Le prénom saisi n'est pas au bon format.<br>" 
                    } 
                    else
                    {
                        boolPrenom=true;
                    }
                }
                
                
                if (nom == "")
                {
                    messageErreur += "Le nom n'a pas été saisi.<br>" 
                }
                else if (nom!= "")
                {
                    if (!validNom.test(nom))
                    {
                        messageErreur += "Le nom saisi n'est pas au bon format.<br>"; 
                    } 
                    else
                    {
                        boolNom=true;
                    }
                }
                
                if (email == "")
                {
                    messageErreur += "Le courriel n'a pas été saisi.<br>" 
                }
                else if (email!= "")
                {
                    if (!validCourriel.test(email))
                    {
                        messageErreur += "Le courriel saisi n'est pas au bon format.<br>" 
                    } 
                    else
                    {
                        boolMail=true;
                    }
                }
                
                if (password == "")
                {
                    messageErreur += "Le mot de passe n'a pas été saisi.<br>" 
                }
                else if (password!= "")
                {
                    if (!validMotPass.test(password))
                    {
                    messageErreur += "Le mot de passe n'est pas au bon format.<br>" 
                    } 
                    else
                    {
                        boolPassWord=true;
                    }
                }
                
                
                if(messageErreur !="")
                {
                $('#message-erreur-bis').css({"display": "block","background-color": "#ffacac"}); 
                $('#message-erreur-bis').html(messageErreur);
                }
                
                if (boolNom && boolPrenom && boolPassWord && boolMail)
                {
                    $('#envoyer').attr('type', 'submit');
                }
                
            });
            

        });
        
        
        

    </script>
    
    
    
    
    
    
    
    
    
    
    
    
    
    
</body>

</html>























