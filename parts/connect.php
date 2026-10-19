<?php
$server = "localhost";
$db = "webpage";
$login = "root";
$pwd = "";
$port = 3306;

$connect = mysqli_connect($server, $login, $pwd, $db, $port);

if (!$connect) {
    die("Database connection failed: " . mysqli_connect_error());
}

mysqli_set_charset($connect, "utf8mb4");
?>