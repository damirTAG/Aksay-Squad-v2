<?php
require '../pdo.php';

header('Content-Type: application/json');

$query = isset($_GET['query']) ? $_GET['query'] : '';
$count = isset($_GET['count']) ? intval($_GET['count']) : 10;
$offset = 0;

if (!empty($query)) {
    try {
        $connection = new Connection();
        $quotes = $connection->searchQuotesPaginated($query, $count, $offset);

        echo json_encode($quotes);
    } catch (Exception $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'No search query provided']);
}
?>