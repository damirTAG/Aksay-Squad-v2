<?php
date_default_timezone_set("Asia/Oral");
date_default_timezone_set("Asia/Almaty");
/** @var Connection $connection */
$connection = require_once 'pdo.php';

// Validate note object;

$id = $_POST['id'] ?? '';
if ($id){
    $connection->updateNote($id, $_POST);
} else {
    $connection->addNote($_POST);
}

header('Location: index.php');
