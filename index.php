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
    <title>English Battle</title>
    <!-- custom-theme -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <script type="application/x-javascript"> addEventListener("load", function () {
            setTimeout(hideURLbar, 0);
        }, false);

        function hideURLbar() {
            window.scrollTo(0, 1);
        } </script>
    <!-- //custom-theme -->
    <link href="css/style.css" rel="stylesheet" type="text/css" media="all"/>
    <!-- js -->
    <script src="js/jquery-3.3.1.min.js"></script>
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
    <!--// js -->
    <link rel="stylesheet" type="text/css" href="css/easy-responsive-tabs.css "/>
    <link href="//fonts.googleapis.com/css?family=Questrial" rel="stylesheet">
</head>
<body class="bg agileinfo">
<h1 class="agile_head text-center"> English Battle</h1>
<div class="w3layouts_main wrap">
    <!--Horizontal Tab-->
    <div id="parentHorizontalTab_agile">
        <ul class="resp-tabs-list hor_1">
            <li>Log in</li>
            <li>Sign up</li>
        </ul>
        <div class="resp-tabs-container hor_1">
            <div class="w3_agile_login">
                <form action="#" method="post" class="agile_form" name="login">
                    <p>Email</p>
                    <label>
                        <input type="email" name="username" required="required"/>
                    </label>
                    <p>Password</p>
                    <label>
                        <input type="password" name="password" required="required" class="password"/>
                    </label>
                    <input type="submit" value="login" class="agileinfo" name="logIn"/>
                </form>

            </div>
            <div class="agile_its_registration">
                <form action="#" method="post" class="agile_form" name="subscribe">
                    <p>Nom</p>
                    <label>
                        <input type="text" name="nom" required="required"/>
                    </label>
                    <p>Prénom</p>
                    <label>
                        <input type="text" name="prenom" required="required"/>
                    </label>
                    <p>Email</p>
                    <label>
                        <input type="email" name="email" required="required"/>
                    </label>
                    <p>Password</p>
                    <label>
                        <input type="password" name="password" id="password1" required="required">
                    </label>
                    <p>Confirm Password</p>
                    <label>
                        <input type="password" name="Confirm Password" id="password2" required="required">
                    </label>
                    <p>Ville</p>
                    <label for="recherche"></label><input type="text" name="ville" required="required" id="recherche"/>
                    <p>Niveau</p>
                    <label for="niveau"></label>
                    <select name="niveau" id="niveau">
                        <option value="débutant">Débutant</option>
                        <option value="intermédiaire" selected>Intermédiaire</option>
                        <option value="expert">Expert</option>
                    </select>
                    <input type="submit" value="Signup" name="create"/>
                </form>
            </div>
        </div>
    </div>
    <!-- //Horizontal Tab -->
</div>
<div class="agileits_w3layouts_copyright text-center">
    <p>© 2018 English Battle Inc. All rights reserved | Design by Jouclard</p>
</div>
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
        if (pass1 != pass2)
            document.getElementById("password2").setCustomValidity("Passwords Don't Match");
        else
            document.getElementById("password2").setCustomValidity('');
        //empty string means no validation error
    }

</script>
<!--//tabs-->
</body>
</html>


