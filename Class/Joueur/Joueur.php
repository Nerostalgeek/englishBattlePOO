<?php

class Joueur
{
    private $_id;
    private $_nom;
    private $_prenom;
    private $_password;
    private $_email;
    private $_ville;
    private $_niveau;


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

    public function nom()
    {
        return $this->_nom;
    }

    public function prenom()
    {
        return $this->_prenom;
    }

    public function password()
    {
        return $this->_password;
    }

    public function email()
    {
        return $this->_email;
    }

    public function idVille()
    {
        return $this->_ville;
    }

    public function niveau()
    {
        return $this->_niveau;
    }


    public function setId($id)
    {
        // L'identifiant du Joueur sera, quoi qu'il arrive, un nombre entier.
        $this->_id = (int)$id;
    }

    public function setNom($nom)
    {
        // On vérifie qu'il s'agit bien d'une chaîne de caractères.
        // Dont la longueur est inférieure à 30 caractères.
        if (is_string($nom) && strlen($nom) <= 30) {
            $this->_nom = $nom;
        }
    }

    public function setPrenom($prenom)
    {
        // On vérifie que le prenom comprend moins de 30 caractères, là aussi.
        if (is_string($prenom) && strlen($prenom) <= 30) {
            $this->_prenom = $prenom;
        }
    }

    public function setPassword($password)
    {
        // On vérifie que le password comprend moins de 30 caractères, là aussi.

            $this->_password = $password;

    }

    public function setEmail($email)
    {
// Vérifie si la chaine ressemble à un email
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->_email = $email;
        } else {
            var_dump('Cet email a un format non adapté.');
        }
    }

    public function setIdVille($ville)
    {
        // On vérifie que le prenom comprend moins de 30 caractères, là aussi.
        if ($ville) {
            trim($this->_ville = $ville, '"');
        } else {
            var_dump('probleme ville');
        }
    }

    public function setNiveau($niveau)
    {

// On vérifie que l'expérience est comprise entre 0 et 100.
        if ($niveau === "débutant" || $niveau === "intermédiaire" || $niveau === "expert") {
            $this->_niveau = $niveau;
        }
    }

    public function emailValide()
    {
        return !empty($this->_email);
    }
}