<?php
require "dbh.php";
session_start();
// Takes raw data from the request
$cfgid = $_GET["cfgid"];

$sql = "DELETE FROM pending_cfg WHERE cfgid=".$cfgid;
if ($conn->query($sql) == FALSE){
    echo "could not delete this config from database";
} else{
    echo "config deleted successfully";	
}

$conn->close();
