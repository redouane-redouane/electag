<?php
require "dbh.php";
session_start();
// Takes raw data from the request
$groupname = $_POST["groupname"];
$parentgroup = $_POST["parentgroup"];
if($parentgroup == ""){
    $sql = "INSERT INTO groups (groupname, parentgroup) VALUES ('".$groupname."',null)";
}else{
    $sql = "INSERT INTO groups (groupname, parentgroup) VALUES ('".$groupname."','".$parentgroup."')";
}

if ($conn->query($sql) == FALSE){
    echo $sql;
    echo "SQLERROR";
} else{
    $sql1 = "INSERT INTO logs (ip_address, username, action)
            VALUES ('".$_SESSION['ip_address']."', '".$_SESSION['username']."', 'insert group ".$groupname."')";
    $conn->query($sql1);
}
$conn->close();
/* //Make sure that it is a POST request.
if(strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') != 0){
    throw new Exception('Request method must be POST!');
}

//Make sure that the content type of the POST request has been set to application/json
$contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
if(strcasecmp($contentType, 'application/json') != 0){
    throw new Exception('Content type must be: application/json');
}

//Receive the RAW post data.
$content = trim(file_get_contents("php://input"));

//Attempt to decode the incoming RAW post data from JSON.
$decoded = json_decode($content, true);

//If json_decode failed, the JSON is invalid.
if(!is_array($decoded)){
    throw new Exception('Received content contained invalid JSON!');
}

$jsonIterator = new RecursiveIteratorIterator(
    new RecursiveArrayIterator($decoded),
    RecursiveIteratorIterator::SELF_FIRST);

foreach ($jsonIterator as $key => $val) {
    if(!is_array($val) and $key == "groupname") {
        $groupname = $val;
    }
    if(!is_array($val) and $key == "parentgroup") {
        $parentgroup = $val;
    }
}

// $sql = "SELECT aquisition, reception, action, accuracy, speed, geotype, cbattery, gps, csq, zone, lat, lng FROM targets WHERE tracker = ".$trackerid." ORDER BY aquisition DESC;";
$sql = "INSERT INTO groups (groupname, parentgroup) VALUES (".$groupname.",".$parentgroup.")";
$result = $conn->query($sql);

exit(json_encode($result)); */