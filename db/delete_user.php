<?php
require "dbh.php";
session_start();
// Takes raw data from the request
$username = $_POST["username"];

$sql = "DELETE FROM users WHERE username='".$username."'";
if ($conn->query($sql) == FALSE){
    echo $sql;
    echo "SQLERROR";
} else{
    $sql1 = "INSERT INTO logs (ip_address, username, action)
            VALUES ('".$_SESSION['ip_address']."', '".$_SESSION['username']."', 'delete user ".$username."')";
    $conn->query($sql1);
}

$conn->close();