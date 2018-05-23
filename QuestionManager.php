<?php

class QuestionManager
{
    private $_db; // Instance de PDO

    public function __construct($db)
    {
        $this->setDb($db);
    }

    public function add(Question $question)
    {


        $q = $this->_db->prepare('INSERT INTO question (idPartie, idVerbe, reponsePreterit, reponseParticipePasse, dateEnvoie, dateReponse) VALUES(:idPartie, :idVerbe, :reponsePreterit, :reponseParticipePasse, :dateEnvoie, :dateReponse)');
        $q->bindValue(':idPartie', $question->idPartie());
        $q->bindValue(':idVerbe', $question->idVerbe());
        $q->bindValue(':reponsePreterit', $question->reponsePreterit());
        $q->bindValue(':reponseParticipePasse', $question->reponseParticipe());
        $q->bindValue(':dateEnvoie', $question->dateEnvoie());
        $q->bindValue(':dateReponse', $question->dateReponse());


        $q->execute();
        $question->hydrate([
            'id' => $this->_db->lastInsertId(),
        ]);
        var_dump("INTO ADD =>", $question);
    }

    public function delete(Question $question)
    {
        $this->_db->exec('DELETE FROM question WHERE id = ' . $question->id());
    }

    public function get($id)
    {
        $id = (int)$id;

        $q = $this->_db->query('SELECT id, email, nom, prenom, password, idVille, niveau FROM question WHERE id = ' . $id);
        $donnees = $q->fetch(PDO::FETCH_ASSOC);

        return new Question($donnees);
    }

    public function getList()
    {
        $question = [];

        $q = $this->_db->query('SELECT id, idJoueur FROM question');

        while ($donnees = $q->fetch(PDO::FETCH_ASSOC)) {
            $question[] = new question($donnees);
        }

        return $question;
    }

    public function update(Question $question)
    {
        $q = $this->_db->prepare('UPDATE question SET bestScore = :bestScore WHERE id = :id');

        $q->bindValue(':bestScore', $question->bestScore());

        $q->execute();
    }

    public function setDb(PDO $db)
    {
        $this->_db = $db;
    }

    public function exists($info)
    {
        // Sinon, c'est qu'on veut vérifier que l'email existe ou pas.

        $q = $this->_db->prepare('SELECT COUNT(*) FROM question WHERE id = :id');
        $q->execute([':id' => $info]);

        return (bool)$q->fetchColumn();
    }

}
