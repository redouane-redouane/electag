<?php
require "dbh.php";
session_start();
// Takes raw data from the request
$serial_number = $_POST["serial_number"];
$zonename = $_POST["zonename"];
$lat1 = $_POST["lat1"];
$lng1 = $_POST["lng1"];
$lat2 = $_POST["lat2"];
$lng2 = $_POST["lng2"];
$lat3 = $_POST["lat3"];
$lng3 = $_POST["lng3"];
$lat4 = $_POST["lat4"];
$lng4 = $_POST["lng4"];
$start = $_POST["start"];
$end = $_POST["end"];

// check that the tracker exists in database
$sql = "SELECT * FROM trackers WHERE serial_number=".$serial_number;
$result = $conn->query($sql);
if ($result->num_rows > 0){
    $row = $result->fetch_assoc();

    // check that the number of zones is less than 4 so we can add a 4th zone
    $sql2 = "SELECT * FROM zones WHERE trackerid =".$row['trackerid'];
    $result2 = $conn->query($sql2);
    if($result2->num_rows < 4){
	// insert the zone in db
    	$sql = "INSERT INTO zones (trackerid, zonename, lat1, lng1, lat2, lng2, lat3, lng3, lat4, lng4, start_time, end_time) VALUES (".$row['trackerid'].",'".$zonename."',".$lat1.",".$lng1.",".$lat2.",".$lng2.",".$lat3.",".$lng3.",".$lat4.",".$lng4.",".$start.",".$end.")";
    	if ($conn->query($sql) == FALSE){
        	echo $sql;
        	echo "SQLERROR";
    	} else{
        	$sql = "INSERT INTO logs (ip_address, username, action)
                	VALUES ('".$_SESSION['ip_address']."', '".$_SESSION['username']."', 'insert zone ".$zonename."')";
        	if($conn->query($sql) == FALSE){
        	    echo $sql2;
        	    echo "could not add this zone operation to logs";
        	}
        	$sql = "INSERT INTO pending_cfg (serial_number,cfg_type,zonename) VALUES (".$serial_number.",'zone_add','".$zonename."')";
        	echo $sql;
        	if ($conn->query($sql) == FALSE){
        	    echo $sql;
        	    echo "could not add this zone operation to pending configs";
        	}
    	}
    } else{
	    echo "cannot add more than 4 zones for each tracker";
    }
}

$conn->close();
