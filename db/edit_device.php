<?php
require "dbh.php";
session_start();
// Takes raw data from the request
$serial_number = $_POST["serial_number"];
$device_type = $_POST["device_type"];
$device_name = $_POST["device_name"];
$folder_name = $_POST["folder_name"];

$sql = "UPDATE trackers SET type='".$device_type."', trackername='".$device_name."', foldername='".$folder_name."' WHERE serial_number = ".$serial_number;

if ($conn->query($sql) == FALSE){
    echo $sql;
    echo "SQLERROR";
}
$conn->close();