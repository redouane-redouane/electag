<?php
require 'dbh.php';
session_start();

$sql = "INSERT INTO logs (ip_address, username, action)
        VALUES ('".$_SESSION['ip_address']."', '".$_SESSION['username']."', 'logout')";
$conn->query($sql);
$conn->close();

session_unset();
session_destroy();
header("Location: ../index.php");