<?php
/**
 * Created by PhpStorm.
 * User: nestezet
 * Date: 24/05/2018
 * Time: 21:34
 */

class VerbeManager
{

    private $_db; // Instance de PDO

    public function __construct($db)
    {
        $this->setDb($db);
    }


    public function get($id)
    {
        $id = (int)$id;

        $q = $this->_db->query('SELECT id, baseVerbale, preterit, participePasse, traduction FROM verbe WHERE id = ' . $id);
        $donnees = $q->fetch(PDO::FETCH_ASSOC);

        return new Verbe($donnees);
    }

    public function getList()
    {
        $verbe = [];

        $q = $this->_db->query('SELECT * FROM verbe ORDER BY RAND()');

        while ($donnees = $q->fetch(PDO::FETCH_ASSOC)) {
            $verbe[] = new Verbe($donnees);
        }
        return $verbe;

    }

    function checkAnswer($preterit, $participe)
    {
        $query = $this->_db->prepare('SELECT * FROM verbe WHERE preterit = :preterit AND participePasse = :participePasse');

        $query->execute([':preterit' => $preterit, ':participePasse' => $participe]);
        $query->fetch(PDO::FETCH_ASSOC);
        $count = $query->rowCount();

        if ($count == 1) {
            return true;
        }
        return false;
    }

    public function setDb(PDO $db)
    {
        $this->_db = $db;
    }
}
