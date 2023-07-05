<?php 
// Database configuration 
$dbHost     = "localhost"; 
$dbUsername = "root"; 
$dbPassword = ""; 
$dbName     = "notes"; 
 


// Create database connection 
$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName); 
mysqli_query($db, "SET CHARACTER SET 'utf8'");
// Check connection 
if ($db->connect_error) { 
    die("Connection failed: " . $db->connect_error); 
}