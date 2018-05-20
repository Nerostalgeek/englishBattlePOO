<?php

class JoueurManager
{
    private $_db; // Instance de PDO

    public function __construct($db)
    {
        $this->setDb($db);
    }

    public function add(Joueur $joueur)
    {


        $q = $this->_db->prepare('INSERT INTO joueur(email, nom, prenom, motDePasse, idVille, niveau) VALUES(:email, :nom, :prenom, :motDePasse, :idVille, :niveau)');
        $q->bindValue(':email', $joueur->email());
        $q->bindValue(':nom', $joueur->nom());
        $q->bindValue(':prenom', $joueur->prenom());
        $q->bindValue(':motDePasse', $joueur->motDePasse());
        $q->bindValue(':idVille', $joueur->idVille(), PDO::PARAM_INT);
        $q->bindValue(':niveau', $joueur->niveau());

        $q->execute();
        $joueur->hydrate([
            'id' => $this->_db->lastInsertId(),
        ]);
    }

    public function delete(Joueur $joueur)
    {
        $this->_db->exec('DELETE FROM joueur WHERE id = ' . $joueur->id());
    }

    public function get($id)
    {
        $id = (int)$id;

        $q = $this->_db->query('SELECT id, email, nom, prenom, motDePasse, idVille, niveau FROM joueur WHERE id = ' . $id);
        $donnees = $q->fetch(PDO::FETCH_ASSOC);

        return new Joueur($donnees);
    }

    public function getList()
    {
        $Joueur = [];

        $q = $this->_db->query('SELECT id, email, nom, prenom, motDePasse, idVille, niveau FROM joueur ORDER BY nom');

        while ($donnees = $q->fetch(PDO::FETCH_ASSOC)) {
            $Joueur[] = new Joueur($donnees);
        }

        return $Joueur;
    }

    public function update(Joueur $joueur)
    {
        $q = $this->_db->prepare('UPDATE joueur SET email = :email, nom = :nom, prenom = :prenom, motDePasse = :motDePasse,  idVille = :idVille, niveau = :niveau WHERE id = :id');

        $q->bindValue(':email', $joueur->email());
        $q->bindValue(':nom', $joueur->nom());
        $q->bindValue(':prenom', $joueur->prenom());
        $q->bindValue(':motDePasse', $joueur->motDePasse());
        $q->bindValue(':idVille', $joueur->idVille(), PDO::PARAM_INT);
        $q->bindValue(':niveau', $joueur->niveau());
        $q->bindValue(':id', $joueur->id(), PDO::PARAM_INT);

        $q->execute();
    }

    public function setDb(PDO $db)
    {
        $this->_db = $db;
    }

    public function exists($info)
    {
        if (is_int($info)) // On veut voir si tel joueur ayant pour id $info existe.
        {
            return (bool) $this->_db->query('SELECT COUNT(*) FROM joueur WHERE id = '.$info)->fetchColumn();
        }

        // Sinon, c'est qu'on veut vérifier que l'email existe ou pas.

        $q = $this->_db->prepare('SELECT COUNT(*) FROM joueur WHERE email = :email');
        $q->execute([':email' => $info]);

        return (bool) $q->fetchColumn();
    }

    public function autoComplete() {
        /* veillez bien à vous connecter à votre base de données */

        $term = $_GET['term'];

        $requete = $this->_db->prepare('SELECT * FROM ville WHERE nom LIKE :term'); // j'effectue ma requête SQL grâce au mot-clé LIKE
        $requete->execute(array('term' => '%'.$term.'%'));

        $array = array(); // on créé le tableau

        while($donnee = $requete->fetch()) // on effectue une boucle pour obtenir les données
        {
            array_push($array, $donnee['ville'], $donnee['id']); // et on ajoute celles-ci à notre tableau
        }

        echo json_encode($array); // il n'y a plus qu'à convertir en JSON

    }

}
