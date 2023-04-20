<?php

function debug($data)
{
    echo "<pre>" . print_r($data, 1) . "</pre>";
}

function get_count($table): int
{
    global $pdo;
    $res = $pdo->query("SELECT COUNT(*) FROM {$table}");
    return $res->fetchColumn();
}

function get_countries($start, $per_page): array
{
    global $pdo;
    $res = $pdo->query("SELECT * FROM notes LIMIT $start, $per_page");
    return $res->fetchAll();
}

function get_cities($start, $per_page): array
{
    global $pdo;
    $res = $pdo->query("SELECT * FROM notes LIMIT $start, $per_page");
    return $res->fetchAll();
}
