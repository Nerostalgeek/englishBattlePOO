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


        $q = $this->_db->prepare('INSERT INTO Joueur(email, nom, prenom, password, idVille, niveau) VALUES(:email, :nom, :prenom, :password, :idVille, :niveau)');
        $q->bindValue(':email', $joueur->email());
        $q->bindValue(':nom', $joueur->nom());
        $q->bindValue(':prenom', $joueur->prenom());
        $q->bindValue(':password', $joueur->password());
        $q->bindValue(':idVille', $joueur->idVille(), PDO::PARAM_INT);
        $q->bindValue(':niveau', $joueur->niveau());

        $q->execute();
        $joueur->hydrate([
            'id' => $this->_db->lastInsertId(),
        ]);
    }

    public function delete(Joueur $joueur)
    {
        $this->_db->exec('DELETE FROM Joueur WHERE id = ' . $joueur->id());
    }

    public function get($info)
    {

        if (is_int($info)) {
            $q = $this->_db->query('SELECT id, nom, degats FROM personnages WHERE id = ' . $info);
            $donnees = $q->fetch(PDO::FETCH_ASSOC);

            return new Joueur($donnees);
        } else {
            $q = $this->_db->prepare('SELECT id, email, nom, prenom, password, idVille, niveau FROM Joueur WHERE email = ' . $info);
            $q->execute([':nom' => $info]);

            return new Joueur($q->fetch(PDO::FETCH_ASSOC));
        }
    }

    public function getList()
    {
        $Joueur = [];

        $q = $this->_db->query('SELECT id, email, nom, prenom, password, idVille, niveau FROM Joueur ORDER BY nom');

        while ($donnees = $q->fetch(PDO::FETCH_ASSOC)) {
            $Joueur[] = new Joueur($donnees);
        }

        return $Joueur;
    }

    public function update(Joueur $joueur)
    {
        $q = $this->_db->prepare('UPDATE Joueur SET email = :email, nom = :nom, prenom = :prenom, password = :password,  idVille = :idVille, niveau = :niveau WHERE id = :id');

        $q->bindValue(':email', $joueur->email());
        $q->bindValue(':nom', $joueur->nom());
        $q->bindValue(':prenom', $joueur->prenom());
        $q->bindValue(':password', $joueur->password());
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
        // Sinon, c'est qu'on veut vérifier que l'email existe ou pas.

        $q = $this->_db->prepare('SELECT COUNT(*) FROM Joueur WHERE email = :email');
        $q->execute([':email' => $info]);

        return (bool)$q->fetchColumn();
    }

    public function checkIdSession($email)
    {
        $Joueur = [];

        $q = $this->_db->query('SELECT id, email, nom, prenom, password, idVille, niveau FROM Joueur WHERE email = ' . $email);

        while ($donnees = $q->fetch(PDO::FETCH_ASSOC)) {
            $Joueur[] = new Joueur($donnees);
        }

        return new Joueur($donnees);
    }

    function login($username, $password)
    {
        // Sinon, c'est qu'on veut vérifier que l'email existe ou pas.

        $query = $this->_db->prepare('SELECT * FROM Joueur WHERE email = :email AND password = :password');

        $query->execute([':email' => $username, ':password' => $password]);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        $count = $query->rowCount();

        if ($count == 1) {
            session_start();
            $_SESSION['user_id'] = $result['id'];
            return true;
        }

    }
}
