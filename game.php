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
if (!isset($_SESSION['user_id'])) {
    header('Location: ./index.php');
}
$db = new PDO('mysql:host=127.0.0.1;dbname=englishBattle', 'root', 'root');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING); // On émet une alerte à chaque fois qu'une requête a échoué.
if (!in_array($_POST['nonce'], $_SESSION['posts'])) {
    // It is the first time. We add it to the list of "seen" nonces.
    $_SESSION['posts'][] = $_POST['nonce'];

    if (isset($_SESSION['user_id']) && isset($_SESSION['partieId'])) {

        $questionManager = new QuestionManager($db);

        if (isset($_POST['envoyer']) && isset($_SESSION['verbe'])) {

            $verbeMananager = new VerbeManager($db);
            $dateEnvoi = $_SESSION['dateEnvoi'];

            if ($verbeMananager->checkAnswer($_POST['preterit'], $_POST['participePasse'], $dateEnvoi, time())) {
                $score = $_SESSION['currentVerbe'];

                $dateReponse = time();

                $question = new Question([
                    'idPartie' => $_SESSION['partieId'],
                    'idVerbe' => $_SESSION['verbe'][$_SESSION['currentVerbe']]->id(),
                    'reponsePreterit' => $_POST['preterit'],
                    'reponseParticipePasse' => $_POST['participePasse'],
                    'dateEnvoi' => $dateEnvoi,
                    'dateReponse' => $dateReponse
                ]);

                $questionManager->add($question);

                $_SESSION['currentVerbe'] += 1;

            } else {
                $partieManager = new PartieManager($db);
                $partie = new Partie(['id' => $_SESSION['partieId'], 'idJoueur' => $_SESSION['user_id'], 'score' => $_SESSION['currentVerbe']]);
                $partieManager->update($partie);
                $_SESSION['currentVerbe'] = 0;
            }
        }
    }
} else {
    print '<div class="errormessage">Please do not resubmit.</div>';
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
                <div id="logout"><a href="logout.php" role="button" class="btn btn-light text-blue rounded-0">Se déconnecter</a></div>
                <div class="home-side-titles">
                    <h2> A vous de jouer <?php echo $_SESSION['email']; ?> !</h2>
                    <h1>Verbe : <?php echo $_SESSION['verbe'][$_SESSION['currentVerbe']]->baseVerbale() ?> (<?php echo $_SESSION['verbe'][$_SESSION['currentVerbe']]->traduction() ?>)</h1>
                    <form action="#" method="post" name="question">
                    <input type="hidden" name="nonce" value="<?php echo uniqid(); ?>"/>
                    <label class="text-white">Preterit</label>
                    <div class="input-group shadow-input align-items-center bg-white mb-3">
                        <input type="text" name="preterit" required="required" class="form-control form-control-lg border-0 custom-form"/>
                    </div>
                    <label class="text-white">Participe passé</label>
                    <div class="input-group shadow-input align-items-center bg-white mb-3">
                        <input type="text" name="participePasse" required="required" class="form-control form-control-lg border-0 custom-form"/>
                    </div>
                    <button type="submit" value="Envoyer" id="submit" name="envoyer" class="btn btn-blue btn-block custom-btn">Envoyer !</button>
                </form>
                </div>
            </div>
            <div class="col-lg-6 d-flex justify-content-center align-items-center">
                <p id="demo"></p>
            </div>
        </div>
    </div>
    <!-- JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
            integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
            integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
            crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
            integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
            crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
            integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
    <script src="js/jquery-3.3.1.min.js"></script>
    <script>
                // Set the date we're counting down to
                var countDownDate = new Date("Sep 5, 2018 15:37:25").getTime();

                // Update the count down every 1 second
                var x = setInterval(function() {

                  // Get todays date and time
                  var now = new Date().getTime();

                  // Find the distance between now an the count down date
                  var distance = countDownDate - now;

                  // Time calculations for days, hours, minutes and seconds
                  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                  var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                  // Display the result in the element with id="demo"
                  document.getElementById("demo").innerHTML = days + "d " + hours + "h "
                  + minutes + "m " + seconds + "s ";

                  // If the count down is finished, write some text
                  if (distance < 0) {
                    clearInterval(x);
                    document.getElementById("demo").innerHTML = "EXPIRED";
                  }
                }, 1000);
                </script>
</body>
</html>


