<?php
require "dbh.php";

//Receive the RAW post data.
$content = '{"tracker_2":2,"tracker_1":1}';

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

$sql = "SELECT * FROM targets WHERE tracker IN (".$trackerids.") GROUP BY tracker ORDER BY aquisition;";
$result = $conn->query($sql);

exit(json_encode($result->fetch_all()));