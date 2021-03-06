<?php
require('Class/Joueur/Joueur.php');
require('Class/Joueur/JoueurManager.php');
require('Class/Partie/Partie.php');
require('Class/Partie/PartieManager.php');
require('Class/Verbe/Verbe.php');
require('Class/Verbe/VerbeManager.php');
session_start(); // On appelle session_start() APRÈS avoir enregistré l'autoload.
if (isset($_SESSION['user_id'])) {
    header('Location: ./game.php');
}
$db = new PDO('mysql:host=127.0.0.1;dbname=englishBattle', 'root', 'root');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING); // On émet une alerte à chaque fois qu'une requête a échoué.

$manager = new JoueurManager($db);
$partieManager = new PartieManager($db);


 if (isset($_POST['logIn'])) // Si on a voulu utiliser un Joueur.
{
    $joueur = new Joueur(['email' => $_POST['username'], 'password' => $_POST['password']]);
    if ($manager->login($joueur->email(), $joueur->password())) // Si celui-ci existe.
    {
        $_SESSION['email'] = $_POST['username'];
        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];
            $partie = new Partie(['idJoueur' => $userId]);
            $partieManager->add($partie);
            $verbeManager = new VerbeManager($db);
            $verbes = $verbeManager->getList();
            $_SESSION['verbe'] = $verbes;
            $_SESSION['currentVerbe'] = 0;

            $_SESSION['partieId'] = $partie->id();
            $_SESSION['dateEnvoi'] = time();
            header('Location: ./game.php');

        }

    } else {
        $message = 'Ce Joueur n\'existe pas !'; // S'il n'existe pas, on affichera ce message.
    }

}
?>

<!DOCTYPE html>
<html>
<head>
    <title>English Battle Game</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <!-- //Bootstrap-Theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- //Custom-theme -->
    <link href="css/style.css" rel="stylesheet" type="text/css" media="all"/>
    <!--// Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Courgette|Montserrat:400,700" rel="stylesheet">
    <link href="//fonts.googleapis.com/css?family=Questrial" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
</head>
<body>
    <div class="container-fluid p-0">
        <div class="row no-gutters">
            <div class="col-lg-6">
                <img src="img/london-half.jpg" class="img-fluid home-side-image" />
                <div class="home-side-titles">
                    <h1>English Battle</h1>
                    <h2 class="pt-2">Let's test your english level !</h2>
                </div>
                <div class="powered-by">Par Anna & Nicolas</div>
            </div>
            <div class="col-lg-6 d-flex justify-content-center align-items-center hp-form p-3">
                <div>
                    <h3>Se connecter</h3>
                    <h4>Entrez vos données d'identification</h4>
                    <form action="#" method="post" name="login">
                      <div class="form-row">
                          <div class="col-12 col-lg-6">
                            <label for="email" class="sr-only">Email</label>
                            <div class="input-group shadow-input align-items-center bg-white mb-3">
                                <input type="email" class="form-control form-control-lg border-0 custom-form" name="username" required="required" placeholder="Entrez votre email">
                                <i class="fas fa-user form-icon"></i> 
                            </div>
                          </div>
                          <div class="col-12 col-lg-6">
                            <label for="password" class="sr-only">Mot de passe</label>
                            <div class="input-group shadow-input align-items-center bg-white mb-3">
                                <input type="password" class="form-control form-control-lg border-0 custom-form" required="required" placeholder="Entrez votre mot de passe" name="password">
                                <i class="fas fa-lock form-icon"></i> 
                            </div>
                          </div>
                        </div>
                      <button type="submit" value="login" name="logIn" class="btn btn-blue btn-block custom-btn">Je me connecte !</button>
                      <small class="form-text">Pas encore de compte ? <strong><a href="signup.php" class="text-blue">Je m'inscris !</a></strong></small>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
    <script src="js/jquery-3.3.1.min.js"></script>
    <script type="application/x-javascript"> addEventListener("load", function () {
            setTimeout(hideURLbar, 0);
        }, false);

        function hideURLbar() {
            window.scrollTo(0, 1);
        } </script>
    <script
            src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
            integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
            crossorigin="anonymous"></script>

<script type="text/javascript">
    window.onload = function () {
        document.getElementById("password1").onchange = validatePassword;
        document.getElementById("password2").onchange = validatePassword;
    }

    function validatePassword() {
        var pass2 = document.getElementById("password2").value;
        var pass1 = document.getElementById("password1").value;
        if (pass1 !== pass2)
            document.getElementById("password2").setCustomValidity("Passwords Don't Match");
        else
            document.getElementById("password2").setCustomValidity('');
        //empty string means no validation error
    }
</script>
</body>
</html> 