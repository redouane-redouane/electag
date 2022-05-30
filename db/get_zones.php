<?php
require "dbh.php";
session_start();

$serial_number = $_POST["serial_number"];

$sql = "SELECT * FROM trackers WHERE serial_number=".$serial_number;

$result = $conn->query($sql);
$response = "";
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $sql = "SELECT * FROM zones WHERE trackerid=".$row["trackerid"];
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $response = $response.$row["zoneid"]."/".$row["zonename"]
                        ."/".$row["start_time"]."/".$row["end_time"]."/".$row["trackerid"]
                        ."/".$row["lat1"]."/".$row["lng1"]."/".$row["lat2"]."/".$row["lng2"]
                        ."/".$row["lat3"]."/".$row["lng3"]."/".$row["lat4"]."/".$row["lng4"].",";       
        }
        $response = substr_replace($response ,"", -1);
    } 
}
echo $response;
$conn->close();