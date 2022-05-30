<?php
require "dbh.php";
session_start();
// Takes raw data from the request
$foldername = $_POST["foldername"];

$sql = "DELETE FROM folders WHERE foldername='".$foldername."'";
if ($conn->query($sql) == FALSE){
    echo $sql;
    echo "SQLERROR";
} else{
    $sql1 = "INSERT INTO logs (ip_address, username, action)
            VALUES ('".$_SESSION['ip_address']."', '".$_SESSION['username']."', 'delete folder ".$foldername."')";
    $conn->query($sql1);
}

$conn->close();