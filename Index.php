<?php

require_once('joueur/Joueur.php');
require_once('joueur/JoueurManager.php');


// Afficher les erreurs à l'écran
ini_set('display_errors', 1);
// Afficher les erreurs et les avertissements
// Reporte toutes les erreurs PHP (Voir l'historique des modifications)
error_reporting(E_ALL);

try {
    $db = new PDO('mysql:host=127.0.0.1;dbname=englishBattle', 'root', 'root');
    var_dump("connected to mysql by pdo", $db);
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
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
            <li>LogIn</li>
            <li>SignUp</li>
        </ul>
        <div class="resp-tabs-container hor_1">
            <div class="w3_agile_login">
                <form action="#" method="post" class="agile_form">
                    <p>Email</p>
                    <input type="email" name="username" required="required"/>
                    <p>Password</p>
                    <input type="password" name="username" required="required" class="password"/>
                    <input type="submit" value="LogIn" class="agileinfo" name="login"/>
                </form>
                <div class="login_w3ls">
                    <a href="#">Forgot Password</a>
                </div>

            </div>
            <div class="agile_its_registration">
                <form action="#" method="post" class="agile_form">
                    <p>Nom</p>
                    <input type="text" name="nom" required="required"/>
                    <p>Prénom</p>
                    <input type="text" name="prenom" required="required"/>
                    <p>Email</p>
                    <input type="email" name="email" required="required"/>
                    <p>Password</p>
                    <input type="password" name="motDePasse" id="password1" required="required">
                    <p>Confirm Password</p>
                    <input type="password" name="Confirm Password" id="password2" required="required">

                    <label for="ville">Ville</label>
                    <input type="text" name="idVille" required="required" id="recherche"/>

                    <p>Niveau</p>
                    <select id="niveau">
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

