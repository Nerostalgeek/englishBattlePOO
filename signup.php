<?php
require('Class/Joueur/Joueur.php');
require('Class/Joueur/JoueurManager.php');
require('Class/Partie/Partie.php');
require('Class/Partie/PartieManager.php');
session_start(); // On appelle session_start() APRÈS avoir enregistré l'autoload.

$db = new PDO('mysql:host=127.0.0.1;dbname=englishBattle', 'root', 'root');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING); // On émet une alerte à chaque fois qu'une requête a échoué.

$manager = new JoueurManager($db);
$partieManager = new PartieManager($db);

if (isset($_POST['create'])) // Si on a voulu créer un Joueur.
{

    $joueur = new Joueur(['nom' => $_POST['nom'], 'prenom' => $_POST['prenom'], 'email' => $_POST['email'],
        'password' => $_POST['password'], 'idVille' => intval($_POST['ville']), 'niveau' => $_POST['niveau']]);

    if ($manager->exists($joueur->email())) {
        var_dump($message = 'Cet Email est déjà pris.');
        unset($joueur);
    } else {
        // On crée un nouveau Joueur.
        $_SESSION['id'] = $joueur->id();
        var_dump("SESSION ID CREATE", $_SESSION['id']);
        $_SESSION['email'] = $_POST['username'];
        $_SESSION['prenom'] = $_POST['prenom'];
        $manager->add($joueur);

    }
} elseif (isset($_POST['logIn'])) // Si on a voulu utiliser un Joueur.
{
    $joueur = new Joueur(['email' => $_POST['username'], 'password' => $_POST['password']]);
    if ($manager->login($joueur->email(), $joueur->password())) // Si celui-ci existe.
    {
        $_SESSION['email'] = $_POST['username'];
        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];
            $partie = new Partie(['idJoueur' => $userId]);
            $partieManager->add($partie);
              $_SESSION['partieId'] = $partie->id();
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
					<h3>S'inscrire</h3>
					<h4>Entrez vos données d'identification</h4>
					<form action="#" method="post" name="subscribe">
						<div class="form-row">
						  <div class="col-12 col-lg-6">
						  	<label for="nom" class="sr-only">Nom</label>
						  	<div class="input-group shadow-input align-items-center bg-white mb-3">
							    <input type="text" class="form-control form-control-lg border-0 custom-form" name="nom" required="required" placeholder="Entrez votre nom">
							    <i class="fas fa-user form-icon"></i> 
							</div>
						  </div>
						  <div class="col-12 col-lg-6">
						  	<label for="prenom" class="sr-only">Prénom</label>
						  	<div class="input-group shadow-input align-items-center bg-white mb-3">
							    <input type="text" class="form-control form-control-lg border-0 custom-form" name="prenom" required="required" placeholder="Entrez votre prénom">
							    <i class="fas fa-user form-icon"></i> 
							</div>
						  </div>
						</div>
					  <div class="form-group">
					    <label for="email" class="sr-only">Email</label>
					    <div class="input-group shadow-input align-items-center bg-white">
						    <input type="email" class="form-control form-control-lg border-0 custom-form" name="email" required="required" placeholder="Entrez votre email">
						    <i class="fas fa-envelope form-icon"></i> 
						</div>
					  </div>
					  <div class="form-row">
						  <div class="col-12 col-lg-6">
						  	<label for="password" class="sr-only">Mot de passe</label>
						  	<div class="input-group shadow-input align-items-center bg-white mb-3">
							    <input type="password" class="form-control form-control-lg border-0 custom-form" name="password" id="password1" required="required" placeholder="Entrez votre mot de passe">
							    <i class="fas fa-lock form-icon"></i> 
							</div>
						  </div>
						  <div class="col-12 col-lg-6">
						  	<label for="password" class="sr-only">Confirmation de mot de passe</label>
						  	<div class="input-group shadow-input align-items-center bg-white mb-3">
							    <input type="password" class="form-control form-control-lg border-0 custom-form" name="Confirm Password" id="password2" required="required" placeholder="Confirmation de mot de passe">
							    <i class="fas fa-lock form-icon"></i> 
							</div>
						  </div>
						</div>
						<div class="form-group">
					    <label for="ville" class="sr-only">Ville</label>
					    <div class="input-group shadow-input align-items-center bg-white">
						    <input type="text" class="form-control form-control-lg border-0 custom-form" name="ville" required="required" id="recherche" placeholder="Entrez votre ville">
						    <i class="fas fa-globe form-icon"></i> 
						</div>
					  </div>
					  <div class="form-group">
					    <label for="niveau" class="sr-only">Niveau</label>
					    <select class="input-group shadow-input custom-select bg-white" name="niveau" id="niveau">
							<option selected>Choisissez votre niveau...</option>
							<option value="débutant">Débutant</option>
							<option value="intermediaire">Intermédiaire</option>
							<option value="expert">Confirmé</option>
						</select>
					  </div>
					  <button type="submit" value="Signup" name="create" class="btn btn-blue btn-block custom-btn">Je m'inscris !</button>
					  <small class="form-text">Déjà inscrit ? <strong><a href="index.php" class="text-blue">Je me connecte !</a></strong></small>
					</form>
				</div>
			</div>
		</div>
	</div>

	<!-- JS -->
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
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
    <script>
        $(function () {
            $("#recherche").autocomplete({
                source: "liste.php",
                minLength: 3
            });
        });
    </script>
    <script type="text/javascript">
    $(document).ready(function () {
        //Horizontal Tab
        $('#parentHorizontalTab_agile').easyResponsiveTabs({
            type: 'default', //Types: default, vertical, accordion
            width: 'auto', //auto or any width like 600px
            fit: true, // 100% fit in a container
            tabidentify: 'hor_1', // The tab groups identifier
            activate: function (event) { // Callback function if tab is switched
                var $tab = $(this);
                var $info = $('#nested-tabInfo');
                var $name = $('span', $info);
                $name.text($tab.text());
                $info.show();
            }
        });
    });
</script>
<script type="text/javascript">
    window.onload = function () {
        document.getElementById("password1").onchange = validatePassword;
        document.getElementById("password2").onchange = validatePassword;
    }

    function validatePassword() {
        var pass2 = document.getElementById("password2").value;
        var pass1 = document.getElementById("password1").value;
        if (pass1 != pass2)
            document.getElementById("password2").setCustomValidity("Passwords Don't Match");
        else
            document.getElementById("password2").setCustomValidity('');
        //empty string means no validation error
    }
</script>
</body>
</html> 