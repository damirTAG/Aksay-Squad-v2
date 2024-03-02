<?php
require_once 'vendor/autoload.php';
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

    public function authenticate($username, $password)
    {
        $statement = $this->pdo->prepare("SELECT * FROM users WHERE username = :username");
        $statement->bindValue(':username', $username);
        $statement->execute();

        $user = $statement->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Valid login
            return true;
        } else {
            // Invalid login
            return false;
        }
    }

    public function getNotes()
    {
        $statement = $this->pdo->prepare("SELECT * FROM quotes ORDER BY create_date DESC");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getFirstId()
    {
        $statement = $this->pdo->prepare("SELECT * FROM quotes ORDER BY create_date DESC LIMIT 1");
        $statement->execute();

        $firstNote = $statement->fetch(PDO::FETCH_ASSOC);
        $firstNoteId = isset($firstNote['id']) ? $firstNote['id'] : null;

        return ['first_note' => $firstNote, 'first_note_id' => $firstNoteId];
    }

    public function getUserWhoUpdated()
    {
        $statement = $this->pdo->prepare("SELECT * FROM users ORDER BY create_date DESC");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addNote($note)
    {
        $statement = $this->pdo->prepare("INSERT INTO quotes (title, description, create_date)
                                    VALUES (:title, :description, :date)");
        $statement->bindValue(':title', $note['title']);
        $statement->bindValue(':description', $note['description']);
        $statement->bindValue(':date', date('Y-m-d H:i:s'));
        $insertResult = $statement->execute();

        $firstNoteInfo = $this->getFirstId();
        $firstNoteId = $firstNoteInfo['first_note_id'];
        if ($insertResult) {
            $telegramBotToken = 'TOKEN_HERE';
            $telegramChannelId = '-1002124641896';

            $telegram = new \TelegramBot\Api\BotApi($telegramBotToken);

            $keyboard = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup(
                [
                    [
                        ['text' => 'Ссылка на цитату', 'url' => "https://aksaysquad.infinityfreeapp.com/quote?id={$firstNoteId}"]
                    ],
                    [
                        ['text' => 'Ссылка на сайт', 'url' => "https://aksaysquad.infinityfreeapp.com"]
                    ]
                ]
            );
            $messageText = "🆕 Новая цитата на сайте!\n🗣 Автор: {$note['title']}";
            $telegramChatIds = [-1002103361664]; // $telegramChatIds = [-1002124641896, -1001542765135, -1001559555304, 1002103361664]; | [-1002124641896, 1038468423];
            foreach ($telegramChatIds as $chatId) {
                $telegram->sendMessage($chatId, $messageText, null, false, null, $keyboard);
            }

        } else {
            error_log('Error inserting note into the database');
            return false;
        }
    }

    public function updateNote($id, $title, $description, $userId)
    {
        $statement = $this->pdo->prepare("UPDATE quotes SET title = :title, description = :description, updated_by = :userId, updated_at = NOW() WHERE id = :id");
        $statement->bindValue('id', $id);
        $statement->bindValue('title', $title);
        $statement->bindValue('description', $description);
        $statement->bindValue(':userId', $userId, PDO::PARAM_INT);
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

    public function getTotalResultsCount($searchQuery) {
        $searchQuery = '%' . $searchQuery . '%';
        $query = "SELECT COUNT(*) FROM quotes WHERE title LIKE :searchQuery OR description LIKE :searchQuery";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':searchQuery', $searchQuery, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function searchQuotesPaginated($query, $limit, $offset)
    {
        $searchParam = '%' . $query . '%';

        $statement = $this->pdo->prepare("SELECT * FROM quotes WHERE title LIKE :searchQuery OR id = :id LIMIT :limit OFFSET :offset");
        
        $statement->bindParam(':searchQuery', $searchParam, PDO::PARAM_STR);
        $statement->bindParam(':id', $query, PDO::PARAM_INT);
        $statement->bindParam(':limit', $limit, PDO::PARAM_INT);
        $statement->bindParam(':offset', $offset, PDO::PARAM_INT);

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function registerUser($username, $password, $email)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $statement = $this->pdo->prepare("INSERT INTO users (username, password, email)
                                    VALUES (:username, :password, :email)");
        $statement->bindValue('username', $username);
        $statement->bindValue('password', $hashedPassword);
        $statement->bindValue('email', $email);
        
        return $statement->execute();
    }

    public function loginUser($username, $password)
    {
        $statement = $this->pdo->prepare("SELECT * FROM users WHERE username = :username");
        $statement->bindValue('username', $username);
        $statement->execute();
        
        $user = $statement->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Valid login
            return $user;
        } else {
            // Invalid login
            return false;
        }
    }
}

return new Connection();
