<?php
require "dbh.php";
session_start();
// Takes raw data from the request
$userid = $_POST["userid"];
$foldername = $_POST["foldername"];

$sql = "SELECT * FROM user_folder WHERE foldername = '".$foldername."'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    if($userid == ""){
        $sql = "DELETE FROM user_folder WHERE foldername = '".$foldername."'";
    }else{
        $sql = "UPDATE user_folder SET userid = ".$userid.", foldername = '".$foldername."' WHERE foldername = '".$foldername."'";
    }
} else{
    $sql = "INSERT INTO user_folder (userid, foldername) VALUES (".$userid.", '".$foldername."')";
}

if ($conn->query($sql) == FALSE){
    echo $sql;
    echo "SQLERROR";
} else{
    $sql1 = "INSERT INTO logs (ip_address, username, action)
            VALUES ('".$_SESSION['ip_address']."', '".$_SESSION['username']."', 'insert user_folder ".$userid." ".$foldername."')";
    $conn->query($sql1);
}
$conn->close();