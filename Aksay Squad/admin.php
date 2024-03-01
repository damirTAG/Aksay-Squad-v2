<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
date_default_timezone_set("Asia/Almaty");
$connection = require_once 'pdo.php';

if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_destroy();
    header('Location: admin.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_quote'])) {
        $title = $_POST['title'];
        $description = $_POST['description'];

        $connection->addNote($title, $description);
    }

    if (isset($_POST['update_quote'])) {
        $id = $_POST['quote_id'];
        $title = $_POST['title'];
        $description = $_POST['description'];

        $WhoUsername = isset($_SESSION['username']) ? $_SESSION['username'] : null;

        if ($WhoUsername !== null) {
            $connection->updateNote($id, $title, $description, $WhoUsername);
        } else {
            echo "Error: User not properly authenticated.";
        }

        $connection->updateNote($id, $title, $description, $WhoUsername);
    }

    if (isset($_POST['delete_quote'])) {
        $id = $_POST['quote_id'];

        $connection->removeNote($id);
    }

    if (isset($_POST['update_note'])) {
        $noteId = $_POST['note_id'];
        $newTitle = $_POST['new_title'];
        $newDescription = $_POST['new_description'];
        $WhoUsername = isset($_SESSION['username']) ? $_SESSION['username'] : null;

        if ($WhoUsername !== null) {
            $connection->updateNote($noteId, $newTitle, $newDescription, $WhoUsername);
        } else {
            echo "Error: User not properly authenticated.";
        }
    }
}

if (isset($_SESSION['admin']) && $_SESSION['admin'] === true) {
    $username = isset($_SESSION['username']) ? $_SESSION['username'] : null;

    if ($username) {
        // $userId = $connection->getUserIdByUsername($username);

        $notesPerPage = 17;
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $totalQuotesCount = $connection->getTotalQuotesCount();
        $totalPages = ceil($totalQuotesCount / $notesPerPage);
        $offset = ($currentPage - 1) * $notesPerPage;
        $quotes = $connection->getNotes();
                
        $searchQuery = isset($_GET['search']) ? $_GET['search'] : '';

        if (!empty($searchQuery)) {
            $quotes = $connection->searchQuotesPaginated($searchQuery, $notesPerPage, $offset);
        } else {
            $quotes = $connection->getNotesPaginated($notesPerPage, $offset);
        }
        require_once 'templates/admin_template.php';
    } else {
        // Handle the case where $_SESSION['username'] is not set
        // This might indicate a session issue or user not properly authenticated
        echo "Error: User not properly authenticated.";
    }
} else {
    // User is not logged in, show the login form
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];

        if ($connection->authenticate($username, $password)) {
            $_SESSION['admin'] = true;
            $_SESSION['username'] = $username;
            header('Location: admin.php');
            exit();
        } else {
            $error = "Invalid username or password";
        }
    }

    // Show the login form
    echo "<h2>Login</h2>";
    if (isset($error)) {
        echo "<p style='color: red;'>$error</p>";
    }
    echo "
    <form method='post' action=''>
        <label for='username'>Username:</label>
        <input type='text' id='username' name='username' required><br>
        
        <label for='password'>Password:</label>
        <input type='password' id='password' name='password' required><br>
        
        <button type='submit'>Login</button>
    </form>";
}
?>
