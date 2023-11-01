<?php

$host = 'localhost';
$db = 'notes';
$user = 'root';
$pass = '';
$charset = 'utf8';

$dsn = "mysql:server=$host;dbname=$db;charset=$charset";
$opt = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

$pdo = new PDO($dsn, $user, $pass, $opt);
