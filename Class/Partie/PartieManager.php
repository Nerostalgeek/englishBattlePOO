<?php

class PartieManager
{
    private $_db; // Instance de PDO

    public function __construct($db)
    {
        $this->setDb($db);
    }

    public function add(Partie $partie)
    {


        $q = $this->_db->prepare('INSERT INTO partie (idJoueur, score) VALUES(:idJoueur, :score)');
        $q->bindValue(':idJoueur', $partie->idJoueur(), PDO::PARAM_INT);
        $q->bindValue(':score', 0);


        $q->execute();
        $partie->hydrate([
            'id' => $this->_db->lastInsertId(),
        ]);
    }

    public function delete(Partie $partie)
    {
        $this->_db->exec('DELETE FROM partie WHERE id = ' . $partie->id());
    }

    public function get($id)
    {
        $id = (int)$id;

        $q = $this->_db->query('SELECT id, idJoueur FROM partie WHERE id = ' . $id);
        $donnees = $q->fetch(PDO::FETCH_ASSOC);

        return new partie($donnees);
    }

    public function getList()
    {
        $partie = [];

        $q = $this->_db->query('SELECT id, idJoueur FROM partie');

        while ($donnees = $q->fetch(PDO::FETCH_ASSOC)) {
            $partie[] = new Partie($donnees);
        }

        return $partie;
    }

    public function update(Partie $partie)
    {
        $q = $this->_db->prepare('UPDATE partie SET score = :score WHERE id = :id');

        $q->bindValue(':id', $partie->id());
        $q->bindValue(':score', $partie->score());

        $q->execute();
    }

    public function setDb(PDO $db)
    {
        $this->_db = $db;
    }

    public function exists($info)
    {
        // Sinon, c'est qu'on veut vérifier que l'email existe ou pas.

        $q = $this->_db->prepare('SELECT COUNT(*) FROM partie WHERE id = :id');
        $q->execute([':id' => $info]);

        return (bool)$q->fetchColumn();
    }

}
