<?php
require "dbh.php";
session_start();
// Takes raw data from the request
$firstname = $_POST["firstname"];
$lastname = $_POST["lastname"];
$address = $_POST["address"];
$duration = $_POST["duration"];

$sql = "INSERT INTO detenus (firstname, lastname, duration, address) VALUES ('".$firstname."','".$lastname."',".$duration.",'".$address."')";

if ($conn->query($sql) == FALSE){
    echo $sql;
    echo "SQLERROR";
} else{
    $sql1 = "INSERT INTO logs (ip_address, username, action)
            VALUES ('".$_SESSION['ip_address']."', '".$_SESSION['username']."', 'insert detenu ".$firstname."')";
    $conn->query($sql1);
}
$conn->close();