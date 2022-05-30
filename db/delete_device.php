<?php
require "dbh.php";
session_start();
// Takes raw data from the request
$serial_number = $_POST["serial_number"];

$sql = "DELETE FROM trackers WHERE serial_number=".$serial_number;
if ($conn->query($sql) == FALSE){
    echo $sql;
    echo "SQLERROR";
} else{
    $sql1 = "INSERT INTO logs (ip_address, username, action)
            VALUES ('".$_SESSION['ip_address']."', '".$_SESSION['username']."', 'delete device ".$serial_number."')";
    $conn->query($sql1);
}

$conn->close();