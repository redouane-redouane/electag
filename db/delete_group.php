<?php
require "dbh.php";
session_start();
// Takes raw data from the request
$groupname = $_POST["groupname"];

$sql = "DELETE FROM groups WHERE groupname='".$groupname."'";
if ($conn->query($sql) == FALSE){
    echo $sql;
    echo "SQLERROR";
} else{
    $sql1 = "INSERT INTO logs (ip_address, username, action)
            VALUES ('".$_SESSION['ip_address']."', '".$_SESSION['username']."', 'delete group ".$groupname."')";
    $conn->query($sql1);
}

$conn->close();