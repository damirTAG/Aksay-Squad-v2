<?php
require '../pdo.php';

header('Content-Type: application/json');

// Function to extract query parameters from URL
function getQuoteIdFromUrl($url) {
    $urlComponents = parse_url($url);
    if (isset($urlComponents['query'])) {
        parse_str($urlComponents['query'], $queryParams);
        if (isset($queryParams['id'])) {
            return intval($queryParams['id']);
        }
    }
    return null;
}

$url = isset($_GET['url']) ? $_GET['url'] : '';

if (!empty($url)) {
    $quoteId = getQuoteIdFromUrl($url);

    if ($quoteId !== null) {
        try {
            $connection = new Connection();
            $quote = $connection->getNoteById($quoteId);

            if ($quote) {
                echo json_encode($quote);
            } else {
                echo json_encode(['error' => 'Quote not found']);
            }
        } catch (Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
    } else {
        echo json_encode(['error' => 'Invalid URL or ID not found in URL']);
    }
} else {
    echo json_encode(['error' => 'No URL provided']);
}
?>
