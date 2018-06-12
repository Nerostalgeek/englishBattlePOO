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

    function checkAnswer($preterit, $participe, $dateReponse, $dateEnvoi)
    {
        if ($dateReponse === $dateEnvoi + 11) {
            print '<div class="timeUpMessage">Vous avez dépassé les 10 secondes pour répondre à la question.</div>';
            $_SESSION['currentVerbe'] = 0;
        }
        $query = $this->_db->prepare('SELECT * FROM verbe WHERE preterit = :preterit AND participePasse = :participePasse');

        $query->execute([':preterit' => $preterit, ':participePasse' => $participe]);
        $query->fetch(PDO::FETCH_ASSOC);
        $count = $query->rowCount();

        if ($count == 1) {
            return true;
        }

    }

    public function setDb(PDO $db)
    {
        $this->_db = $db;
    }
}
