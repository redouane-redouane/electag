<?php
require "dbh.php";
session_start();
// Takes raw data from the request
$foldername = $_POST["foldername"];
$parentfolder = $_POST["parentfolder"];
if($parentfolder == ""){
    $sql = "INSERT INTO folders (foldername, parentfolder) VALUES ('".$foldername."',null)";
}else{
    $sql = "INSERT INTO folders (foldername, parentfolder) VALUES ('".$foldername."','".$parentfolder."')";
}

if ($conn->query($sql) == FALSE){
    echo $sql;
    echo "SQLERROR";
} else{
    $sql1 = "INSERT INTO logs (ip_address, username, action)
            VALUES ('".$_SESSION['ip_address']."', '".$_SESSION['username']."', 'insert folder ".$foldername."')";
    $conn->query($sql1);
}
$conn->close();