<?php
// debut session
session_start();
//connexion a la bdd
try {
    $bdd = new PDO('mysql:host=localhost;dbname=englishBattle;charset=utf8', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
$array = [];
$requete = $bdd->prepare('SELECT id, nom FROM ville WHERE nom LIKE :term ORDER BY nom LIMIT 0, 10'); // j'effectue ma requête SQL grâce au mot-clé LIKE


$term = $_GET['term'];
$requete->execute(array('term' =>  $term . '%'));


while ($donnee = $requete->fetch(PDO::FETCH_ASSOC)) // on effectue une boucle pour obtenir les données
{
    // array_push($array, $donnee['nom'], $donnee['id']);
    //$response[] = array("value" => $donnee['id'], "label" => $donnee['nom']);
    array_push($array, ["value" => $donnee['id'], "label" => $donnee['nom']]);
}


echo json_encode($array); // il n'y a plus qu'à convertir en JSON

?>