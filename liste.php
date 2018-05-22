<?php
// debut session
session_start();
//connexion a la bdd
try {
    $bdd = new PDO('mysql:host=localhost;dbname=englishBattle;charset=utf8', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

$requete = $bdd->prepare('SELECT * FROM ville WHERE nom LIKE :term ORDER BY nom LIMIT 10'); // j'effectue ma requête SQL grâce au mot-clé LIKE


$array = array(); // on créé le tableau
$arrayId = [];



$term = $_GET['term'];
$requete->execute(array('term' => '%' . $term . '%'));



while ($donnee = $requete->fetch()) // on effectue une boucle pour obtenir les données
{



    array_push($array, $donnee['nom'], $donnee['id']);
    array_push($arrayId, $donnee['id']);



}



$fp = fopen('idListe.php', 'w');
fwrite($fp, print_r($arrayId, TRUE));
fclose($fp);
echo json_encode($array); // il n'y a plus qu'à convertir en JSON

?>