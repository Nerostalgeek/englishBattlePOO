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
            $verbe[] = $donnees;
        }
        return json_encode($verbe);

    }

    public function setDb(PDO $db)
    {
        $this->_db = $db;
    }
}
