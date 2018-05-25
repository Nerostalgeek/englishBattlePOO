<?php
/**
 * Created by PhpStorm.
 * User: nestezet
 * Date: 24/05/2018
 * Time: 21:24
 */

class Verbe
{

    private $_id;
    private $_baseVerbale;
    private $_preterit;
    private $_participePasse;
    private $_traduction;

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
                $this->$method($value);
            }
        }
    }

    public function id()
    {
        return $this->_id;
    }

    public function baseVerbale()
    {
        return $this->_baseVerbale;
    }

    public function preterit()
    {
        return $this->_preterit;
    }

    public function participePasse()
    {
        return $this->_participePasse;
    }

    public function traduction()
    {
        return $this->_traduction;
    }


    public function setId($id)
    {
        // L'identifiant du Joueur sera, quoi qu'il arrive, un nombre entier.
        $this->_id = (int)$id;
    }

    public function setBaseVerbale($baseVerbale)
    {
        $this->_baseVerbale = $baseVerbale;
    }

    public function setPreterit($preterit)
    {
        // L'identifiant du Joueur sera, quoi qu'il arrive, un nombre entier.
        $this->_preterit = $preterit;
    }

    public function setParticipePasse($participePasse)
    {
        // L'identifiant du Joueur sera, quoi qu'il arrive, un nombre entier.
        $this->_participepasse = $participePasse;
    }

    public function setTraduction($traduction)
    {
        // L'identifiant du Joueur sera, quoi qu'il arrive, un nombre entier.
        $this->_traduction = $traduction;
    }


}