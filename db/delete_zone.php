<?php
require "dbh.php";
session_start();
// Takes raw data from the request
$zoneid = $_POST["zoneid"];
$serial_number = $_POST["serial_number"];

$sql = "SELECT * FROM zones WHERE zoneid=".$zoneid;
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $zonename = $row["zonename"];
    }
}

$sql = "DELETE FROM zones WHERE zoneid=".$zoneid;
if ($conn->query($sql) == FALSE){
    echo $sql;
    echo "could not delete this zone from database";
} else{
    $sql = "DELETE FROM pending_cfg WHERE zonename='".$zonename."'";
    if ($conn->query($sql) == FALSE){
        echo $sql;
        echo "could not delete this zone from database";
    }
    $sql = "INSERT INTO logs (ip_address, username, action)
            VALUES ('".$_SESSION['ip_address']."', '".$_SESSION['username']."', 'delete zone ".$zoneid."')";
    if($conn->query($sql) == FALSE){
        echo $sql;
        echo "could not add this zone operation to logs";
    }
    $sql = "INSERT INTO pending_cfg (serial_number,cfg_type,zonename) VALUES (".$serial_number.",'zone_delete','".$zonename."')";
    echo $sql;
    if ($conn->query($sql) == FALSE){
        echo $sql;
        echo "could not add this zone operation to pending configs";
    }
}

$conn->close();