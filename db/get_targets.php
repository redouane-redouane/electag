<?php
require "dbh.php";
session_start();
// Takes raw data from the request

//Make sure that it is a POST request.
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

$trackerids = '';
foreach ($decoded as $key => $val) {
    $trackerids = $trackerids.$val.',';
}
$trackerids = substr($trackerids, 0, -1);

$sql = "SELECT * FROM targets WHERE targetid IN (SELECT MAX(targetid) FROM targets WHERE tracker IN (".$trackerids.") GROUP BY tracker);";
$result = $conn->query($sql);

exit(json_encode($result->fetch_all()));
