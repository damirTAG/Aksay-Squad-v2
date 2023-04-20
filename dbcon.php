<!-- //dbcon.php -->
<?php
$conn = new mysqli('localhost','root','','notes');
if ($conn->connect_error) {
    die('Error : ('. $conn->connect_errno .') '. $conn->connect_error);
}
?>