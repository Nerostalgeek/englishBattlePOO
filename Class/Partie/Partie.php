<?php
/**
 * Created by PhpStorm.
 * User: nestezet
 * Date: 22/05/2018
 * Time: 22:39
 */

class Partie

{
    private $_id;
    private $_idJoueur;
    private $_score;

    public function __construct(array $donnees)
    {
        $this->hydrate($donnees);
    }

// Un tableau de données doit être passé à la fonction (d'où le préfixe « array »).
    public function hydrate(array $donnees)
    {
        foreach ($donnees as $key => $value) {
            // On récupère le nom du setter correspondant à l'attribut.
            $method = 'set' . ucfirst($key);
            // Si le setter correspondant existe.

            if (method_exists($this, $method)) {
                // On appelle le setter.
                //var_dump("in baby",$this->$method($value));
                $this->$method($value);
            }
        }
    }

    public function id()
    {
        return $this->_id;
    }

    public function idJoueur()
    {
        return $this->_idJoueur;
    }

    public function score()
    {
        return $this->_score;
    }


    public function setId($id)
    {
        // L'identifiant du Joueur sera, quoi qu'il arrive, un nombre entier.
        $this->_id = (int)$id;
    }

    public function setIdJoueur($idJoueur)
    {
        // L'identifiant du Joueur sera, quoi qu'il arrive, un nombre entier.
        $this->_idJoueur = (int)$idJoueur;
    }

    public function setScore($score)
    {
        session_start();
        $_SESSION['score'] = 0;
        // L'identifiant du Joueur sera, quoi qu'il arrive, un nombre entier.
        $this->_score = (int)$score;
    }


}
