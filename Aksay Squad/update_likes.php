<?php
$connection = require_once 'pdo.php';

if (isset($_POST['id']) && isset($_POST['action'])) {
    $id = $_POST['id'];
    $action = $_POST['action'];

    if ($action === 'like') {
        $sql = "UPDATE quotes SET likes = likes + 1 WHERE id = :id";
        $updatedCount = getUpdatedLikeCount($id, $connection);
    } elseif ($action === 'dislike') {
        $sql = "UPDATE quotes SET dislikes = dislikes + 1 WHERE id = :id";
        $updatedCount = getUpdatedDislikeCount($id, $connection);
    }

    // Use prepared statements to prevent SQL injection
    $stmt = $connection->pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    echo $updatedCount; // Return the updated count as plain text
}

function getUpdatedLikeCount($quoteId, $connection) {
    $sql = "SELECT likes FROM quotes WHERE id = :id";

    $stmt = $connection->pdo->prepare($sql);
    $stmt->bindParam(':id', $quoteId, PDO::PARAM_INT);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        return $result['likes'];
    } else {
        return 0;
    }
}

function getUpdatedDislikeCount($quoteId, $connection) {
    $sql = "SELECT dislikes FROM quotes WHERE id = :id";

    $stmt = $connection->pdo->prepare($sql);
    $stmt->bindParam(':id', $quoteId, PDO::PARAM_INT);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        return $result['dislikes'];
    } else {
        return 0;
    }
}

?>
