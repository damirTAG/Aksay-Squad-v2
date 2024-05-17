<?php
require '../../pdo.php';

header('Content-Type: application/json');

try {
    $connection = new Connection();
    $quotes = $connection->getNotes();

    echo json_encode($quotes);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>