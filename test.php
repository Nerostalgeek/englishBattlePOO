<?php
require_once('Joueur.php');
require_once('JoueurManager.php');


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


$joueur = new Joueur([
    'email' => "dupont.andre@gmail.com",
    'nom' => 'Dupont',
    'prenom' => 'André',
    'motDePasse' => 'test',
    'idVille' => 41,
    'niveau' => "intermédiaire"
]);

$manager = new JoueurManager($db);
var_dump('manager', $manager);

$manager->add($joueur);