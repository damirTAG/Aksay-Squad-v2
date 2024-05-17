<?php
require '../../pdo.php';

header('Content-Type: application/json');

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    try {
        $connection = new Connection();
        $quote = $connection->getNoteById($id);

        if ($quote) {
            echo json_encode($quote);
        } else {
            echo json_encode(['error' => 'Quote not found']);
        }
    } catch (Exception $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Invalid ID']);
}
?>