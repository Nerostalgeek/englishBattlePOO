<?php

class Question

{
    private $_id;
    private $_idPartie;
    private $_idVerbe;
    private $_reponsePreterit;
    private $_reponseParticipePasse;
    private $_dateEnvoie;
    private $_dateReponse;

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

    public function idPartie()
    {
        return $this->_idPartie;
    }

    public function idVerbe()
    {
        return $this->_idVerbe;
    }

    public function reponsePreterit()
    {
        return $this->_reponsePreterit;
    }

    public function reponseParticipePasse()
    {
        return $this->_reponseParticipePasse;
    }

    public function dateEnvoie()
    {
        return $this->_dateEnvoie;
    }

    public function dateReponse()
    {
        return $this->_dateReponse;
    }


    public function setId($id)
    {
        // L'identifiant du Joueur sera, quoi qu'il arrive, un nombre entier.
        $this->_id = (int)$id;
    }

    public function setIdPartie($idPartie)
    {
        // L'identifiant du Joueur sera, quoi qu'il arrive, un nombre entier.
        $this->_idPartie = (int)$idPartie;
    }

    public function setIdVerbe($idVerbe)
    {
        // L'identifiant du Joueur sera, quoi qu'il arrive, un nombre entier.
        $this->_idVerbe = (int)$idVerbe;
    }

    public function setReponsePreterit($reponsePreterit)
    {
        // L'identifiant du Joueur sera, quoi qu'il arrive, un nombre entier.
        $this->_reponsePreterit = $reponsePreterit;
    }

    public function setReponseParticipePasse($reponseParticipe)
    {
        // L'identifiant du Joueur sera, quoi qu'il arrive, un nombre entier.
        $this->_reponseParticipePasse = $reponseParticipe;
    }

    public function setDateEnvoie($dateEnvoie)
    {
        // L'identifiant du Joueur sera, quoi qu'il arrive, un nombre entier.
        $this->_dateEnvoie = $dateEnvoie;
    }

    public function setDateReponse($dateReponse)
    {
        // L'identifiant du Joueur sera, quoi qu'il arrive, un nombre entier.
        $this->_dateReponse = $dateReponse;
    }
}
