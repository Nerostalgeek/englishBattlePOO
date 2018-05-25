<?php
require('Class/Joueur/Joueur.php');
require('Class/Joueur/JoueurManager.php');
require('Class/Partie/Partie.php');
require('Class/Partie/PartieManager.php');
require('Class/Question/Question.php');
require('Class/Question/QuestionManager.php');
require('Class/Verbe/Verbe.php');
require('Class/Verbe/VerbeManager.php');
session_start();

$db = new PDO('mysql:host=127.0.0.1;dbname=englishBattle', 'root', 'root');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING); // On émet une alerte à chaque fois qu'une requête a échoué.
if (isset($_SESSION['user_id']) && isset($_SESSION['partieId'])) {
    $manager = new VerbeManager($db);
    print_r( $_SESSION['verbe'] = $manager->getList());

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
    <!--// js -->
    <link rel="stylesheet" type="text/css" href="css/easy-responsive-tabs.css "/>
    <link href="//fonts.googleapis.com/css?family=Questrial" rel="stylesheet">
</head>
<body class="bg agileinfo">
<h1 class="agile_head text-center"> <?php echo "coucou " . var_dump("SESSION => =>", $_SESSION['email']);?></h1>
<div class="w3layouts_main wrap">
    <!--Horizontal Tab-->
    <div id="parentHorizontalTab_agile">
        <div class="resp-tabs-container hor_1">
            <div class="w3_agile_login">
                <form action="#" method="post" class="agile_form" name="question">
                    <p>Base verbale</p>
                    <label>
                        <input type="text" name="base" required="required" value="BASE" disabled/>
                    </label>
                    <p>Preterit</p>
                    <label>
                        <input type="text" name="preterit" required="required"/>
                    </label>
                    <p>Participe passé</p>
                    <label>
                        <input type="text" name="participe" required="required"/>
                    </label>
                    <input type="submit" value="Envoyer" class="agileinfo" name="logIn"/>
                </form>

            </div>
    <!-- //Horizontal Tab -->
</div>
<div class="agileits_w3layouts_copyright text-center">
    <p>© 2018 English Battle Inc. All rights reserved </p>
</div>
<!--tabs-->
<script src="js/easyResponsiveTabs.js"></script>
<!--//tabs-->
</body>
</html>


