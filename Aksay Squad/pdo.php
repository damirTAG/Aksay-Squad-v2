<?php
date_default_timezone_set("Asia/Almaty");
class Connection
{
    public $pdo = null;

    public function __construct()
    {
        try {
            $this->pdo = new PDO('mysql:host=localhost;dbname=notes', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"));
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
    public function getAudio()
    {
        $statement = $this->pdo->prepare("SELECT * FROM audios ORDER BY uploaded_on DESC");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    // public function addAudioTitle($title)
    // {
    //     $statement = $this->pdo->prepare("INSERT INTO audios (audio-title)
    //                                 VALUE (:title");
    //     $statement->bindValue('audio-title', $title['title']);
    //     return $statement->execute();
    // }
    public function getAudioByTitle($names)
    {
        $statement = $this->pdo->prepare("SELECT * FROM audios WHERE names = :names");
        $statement->bindValue('names', $names);
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

    public function getTotalQuotesCount()
    {
        $statement = $this->pdo->prepare("SELECT COUNT(*) FROM quotes");
        $statement->execute();
        return $statement->fetchColumn();
    }

    public function getNotesPaginated($limit, $offset)
    {
        $statement = $this->pdo->prepare("SELECT * FROM quotes ORDER BY create_date DESC LIMIT :limit OFFSET :offset");
        $statement->bindValue('limit', $limit, PDO::PARAM_INT);
        $statement->bindValue('offset', $offset, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}

return new Connection();
