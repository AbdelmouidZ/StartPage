<?php
session_start();
$connect = mysqli_connect($server, $login, $pwd, $db, $port);
if (!$connect) {
    die("Database connection failed: " . mysqli_connect_error());
}
mysqli_set_charset($connect, "utf8mb4");
?>