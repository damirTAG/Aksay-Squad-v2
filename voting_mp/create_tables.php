<?php
include('voting.php');

// Table that stores the users who voted in current day
$sqlc[$obVot->votusers] = "CREATE TABLE `$obVot->votusers` (`nextv` INT(10), `voter` VARCHAR(35), `item` VARCHAR(200) NOT NULL DEFAULT '') CHARACTER SET utf8 COLLATE utf8_general_ci";

// Table to store items that are voted
$sqlc[$obVot->votitems] = "CREATE TABLE `$obVot->votitems` (`id` VARCHAR(200) PRIMARY KEY NOT NULL UNIQUE DEFAULT '', `v_plus` INT(10) NOT NULL DEFAULT 0, `v_minus` INT(10) NOT NULL DEFAULT 0) CHARACTER SET utf8 COLLATE utf8_general_ci";

// traverse the $sqlc array, and calls the method to create the tables
foreach($sqlc AS $tab=>$sql) {
  if($obVot->conn->sqlExec($sql) !== false) echo "<h4>The '$tab' table was created</h4>";
}