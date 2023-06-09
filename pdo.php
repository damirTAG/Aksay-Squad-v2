<?php
// date_default_timezone_set("Asia/Oral");
// date_default_timezone_set("Asia/Almaty");
class Connection
{
    public $pdo = null;

    public function __construct()
    {
        try {
            $this->pdo = new PDO('mysql:server=localhost;dbname=notes', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"));
            
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
        } catch (PDOException $exception) {
            echo "ERROR: " . $exception->getMessage();
        }

    }

    public function getNotes()
    {
        $statement = $this->pdo->prepare("SELECT * FROM quotes ORDER BY create_date DESC");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addNote($note)
    {
        $statement = $this->pdo->prepare("INSERT INTO quotes (title, description, create_date)
                                    VALUES (:title, :description, :date)");
        $statement->bindValue('title', $note['title']);
        $statement->bindValue('description', $note['description']);
        $statement->bindValue('date', date('Y-m-d H:i:s'));
        return $statement->execute();
    }

    public function updateNote($id, $note)
    {
        $statement = $this->pdo->prepare("UPDATE quotes SET title = :title, description = :description WHERE id = :id");
        $statement->bindValue('id', $id);
        $statement->bindValue('title', $note['title']);
        $statement->bindValue('description', $note['description']);
        return $statement->execute();
    }

    public function removeNote($id)
    {
        $statement = $this->pdo->prepare("DELETE FROM quotes WHERE id = :id");
        $statement->bindValue('id', $id);
        return $statement->execute();
    }

    public function getNoteById($id)
    {
        $statement = $this->pdo->prepare("SELECT * FROM quotes WHERE id = :id");
        $statement->bindValue('id', $id);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
    //audio

    public function addAudioTitle($title)
    {
        $statement = $this->pdo->prepare("INSERT INTO audios (audio-title)
                                    VALUE (:title");
        $statement->bindValue('audio-title', $title['title']);
        return $statement->execute();
    }
    public function getAudioByTitle($title)
    {
        $statement = $this->pdo->prepare("SELECT * FROM audios WHERE title = :title");
        $statement->bindValue('audio-title', $audiottl);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function getAudioById($id)
    {
        $statement = $this->pdo->prepare("SELECT * FROM audios WHERE id = :id");
        $statement->bindValue('id', $id);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
}

return new Connection();
