<?php
// On enregistre notre autoload.
function autoload($classname)
{
    require $classname . '.php';
}

spl_autoload_register('autoload');

$db = new PDO('mysql:host=localhost;dbname=englishBattle', 'root', 'root');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING); // On émet une alerte à chaque fois qu'une requête a échoué.

$manager = new JoueurManager($db);

if (isset($_POST['create']) && isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['email'])
    && isset($_POST['password']) && isset($_POST['Confirm Password'])
    && isset($_POST['ville']) && isset($_POST['niveau'])) // Si on a voulu créer un personnage.
{
    $joueur = new Joueur(['nom' => $_POST['nom']]); // On crée un nouveau personnage.

    if (!$joueur->nomValide()) {
        $message = 'Le nom choisi est invalide.';
        unset($joueur);
    }
    elseif ($manager->exists($joueur->email()))
    {
        $message = 'Cet Email est déjà pris.';
        unset($joueur);
    }
    else {
        $manager->add($joueur);
    }
} elseif (isset($_POST['login']) && isset($_POST['nom'])) // Si on a voulu utiliser un personnage.
{
    if ($manager->exists($_POST['nom'])) // Si celui-ci existe.
    {
        $joueur = $manager->get($_POST['nom']);
    } else {
        $message = 'Ce personnage n\'existe pas !'; // S'il n'existe pas, on affichera ce message.
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>TP : Mini jeu de combat</title>

    <meta charset="utf-8"/>
</head>
<body>
<p>Nombre de personnages créés : <?= $manager->count() ?></p>
<?php
if (isset($message)) // On a un message à afficher ?
    echo '<p>', $message, '</p>'; // Si oui, on l'affiche.
?>
<form action="" method="post">
    <p>
        Nom : <input type="text" name="nom" maxlength="50"/>
        <input type="submit" value="Créer ce personnage" name="creer"/>
        <input type="submit" value="Utiliser ce personnage" name="utiliser"/>
    </p>
</form>
</body>
</html>