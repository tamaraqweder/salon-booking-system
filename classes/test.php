<?php

require "Database.php";
$database=new Database();

$pdo=$database->connect();

echo "database connected successfully";

?>