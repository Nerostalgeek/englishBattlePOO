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


if (isset($_POST['create'])) // Si on a voulu créer un Joueur.
{

    $joueur = new Joueur(['nom' => $_POST['nom'], 'prenom' => $_POST['prenom'], 'email' => $_POST['email'],
        'password' => $_POST['password'], 'idVille' => intval($_POST['ville']), 'niveau' => $_POST['niveau']]);

    if ($manager->exists($joueur->email())) {
        var_dump($message = 'Cet Email est déjà pris.');
        unset($joueur);

    } else {

        $_SESSION['email'] = $_POST['username'];
        $_SESSION['prenom'] = $_POST['prenom'];
        $manager->add($joueur);
        // On crée un nouveau Joueur.
        $_SESSION['user_id'] = $joueur->id();
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
    <title>English Battle</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <script type="application/x-javascript"> addEventListener("load", function () {
            setTimeout(hideURLbar, 0);
        }, false);

        function hideURLbar() {
            window.scrollTo(0, 1);
        } </script>
    <!-- //Bootstrap-Theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- //Custom-theme -->
    <link href="css/style.css" rel="stylesheet" type="text/css" media="all"/>
    <!--// Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Courgette|Montserrat:400,700" rel="stylesheet">
    <link href="//fonts.googleapis.com/css?family=Questrial" rel="stylesheet">
    <!-- JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
    <script src="js/jquery-3.3.1.min.js"></script>
    <script
            src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
            integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
            crossorigin="anonymous"></script>
    <script>
        $(function () {

            // Single Select
            $("#recherche").autocomplete({
                source: function (request, response) {
                    // Fetch data
                    $.ajax({
                        url: "liste.php",
                        type: 'post',
                        dataType: "json",
                        data: {
                            search: request.term
                        },
                        success: function (data) {
                            response(data);
                        }
                    });
                },
                select: function (event, ui) {
                    // Set selection
                    console.log('UI => => ', ui);
                    $('#autocomplete').val(ui.item.label); // display the selected text
                    $('#idVille').val(ui.item.value); // save selected id to input
                    return false;
                }
            });
        });

    </script>
    <!--// js -->
    <link rel="stylesheet" type="text/css" href="css/easy-responsive-tabs.css "/>
    <link href="//fonts.googleapis.com/css?family=Questrial" rel="stylesheet">
</head>
<body>
    <div class="london-bg container-fluid">
        <div class="container blur-box">
            <h1 class="main-title text-center">English Battle</h1>
            <h2 class="subtitle text-center">Let's test your English Level !</h2>
        </div>
    </div>
    <div class="d-flex">
        <div class="col-md-4 text-center d-none d-md-block p-0 blue-bg p-5 d-flex align-items-center">
            <h3>We are English Battle !</h3>
            <img src="./images/english-flag.jpg" class="img-fluid mt-3 mb-3" alt="english flag"/>
            <p class="mt-5 text-left">Venez découvrir un jeu éducatif, grâce auquel les verbes irréguliers n'auront plus de secrets pour vous ! Niveau débutant, intermédiaire ou confirmé, venez tester vos connaissances et améliorez vote anglais tout en vous amusant!</p>
        </div>
        <div class="col-md-8 d-flex align-items-center">
            <div class="p-5">
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item mr-3">
                    <a class="nav-link active" id="pills-login-tab" data-toggle="pill" href="#pills-login" role="tab" aria-controls="pills-login" aria-selected="true">Se connecter</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">S'inscrire</a>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active pt-4" id="pills-login" role="tabpanel" aria-labelledby="pills-login-tab">
                    <form action="#" method="post" name="login">
                        <div class="form-group mb-4">
                            <label for="email">Adresse Email</label>
                            <input type="email" class="form-control form-control-lg" name="username" required="required" placeholder="Entrez votre adresse email"/>
                        </div>
                        <div class="form-group">
                            <label for="password">Mot de passe</label>
                            <input type="password" class="form-control form-control-lg" name="password" required="required" placeholder="Entrez votre adresse email"/>
                        </div>
                            <button type="submit" value="login" name="logIn" class="btn btn-red btn-lg mt-4">Submit</button>
                    </form>
                </div>
                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                    <form action="#" method="post" name="subscribe">
                        <div class="form-group mb-4">
                            <label for="nom">Nom</label>
                            <input type="text" class="form-control form-control-lg" name="nom" required="required" placeholder="Entrez votre nom"/>
                        </div>
                        <div class="form-group mb-4">
                        <label for="prenom">Prénom</label>
                            <input type="text" class="form-control form-control-lg" name="prenom" required="required" placeholder="Entrez votre prénom"/>
                        </div>
                        <div class="form-group mb-4">
                        <label for="email">Email</label>
                            <input type="email" class="form-control form-control-lg" name="email" required="required" placeholder="Entrez votre email"/>
                        </div>
                        <div class="form-group mb-4">
                        <label for="password">Mot de passe</label>
                            <input type="password" class="form-control form-control-lg" name="password" id="password1" required="required" placeholder="Entrez votre mot de passe">
                        </div>
                        <div class="form-group mb-4">
                        <label for="password">Confirmation de mot de passe</label>
                            <input type="password" class="form-control form-control-lg" name="Confirm Password" id="password2" required="required" placeholder="Confirmez votre mot de passe">
                        </div>
                        <div class="form-group mb-4">
                        <label for="ville">Ville</label>
                        <input type="text" class="form-control form-control-lg" name="ville" required="required" id="recherche" placeholder="Choisissez votre ville"/>
                        </div>
                        <div class="form-group mb-4">
                        <label for="niveau">Niveau</label>
                        <select class="form-control form-control-lg" name="niveau" id="niveau">
                            <option value="débutant">Débutant</option>
                            <option value="intermédiaire" selected>Intermédiaire</option>
                            <option value="expert">Expert</option>
                        </select>
                        </div>
                        <button type="submit" value="login" name="logIn" class="btn btn-red btn-lg mt-4">Submit</button>
                    </form> 
                </div>
            </div>
        </div>
        </div>
    </div>
    <footer class="blue-bg text-center p-3">English Battle | &copy; 2018 | Anna & Nicolas</footer>
<!--tabs-->
<script src="js/easyResponsiveTabs.js"></script>
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
        if (pass1 !== pass2)
            document.getElementById("password2").setCustomValidity("Passwords Don't Match");
        else
            document.getElementById("password2").setCustomValidity('');
        //empty string means no validation error
    }

</script>
<!--//tabs-->
</body>
</html>


