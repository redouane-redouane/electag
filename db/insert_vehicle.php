<?php
require "dbh.php";
session_start();
// Takes raw data from the request
$brand = $_POST["brand"];
$name = $_POST["name"];
$color = $_POST["color"];
$plate = $_POST["plate"];

$sql = "INSERT INTO vehicles (brand, name, plate, color) VALUES ('".$brand."','".$name."','".$plate."','".$color."')";

if ($conn->query($sql) == FALSE){
    echo $sql;
    echo "SQLERROR";
} else{
    $sql1 = "INSERT INTO logs (ip_address, username, action)
            VALUES ('".$_SESSION['ip_address']."', '".$_SESSION['username']."', 'insert vehicle ".$name."')";
    $conn->query($sql1);
}
$conn->close();