<?php
require "dbh.php";
session_start();
// Takes raw data from the request
$serial_number = $_POST["serial_number"];
$phone_number = $_POST["phone_number"];
$pin_code = $_POST["pin_code"];
$time_zone = $_POST["time_zone"];

$battery_20 = $_POST["battery_20"];
$battery_10 = $_POST["battery_10"];
$battery_threshold = $_POST["battery_threshold"];

$mode = $_POST["mode"];
if($mode == 0){
    $sleeping_hours = $_POST["sleeping_hours"];
    $sleeping_minutes = $_POST["sleeping_minutes"];
    $activation_delay = $_POST["activation_delay"];
    $gsm_permanent = $_POST["gsm_permanent"];
}
$frequency = $_POST["frequency"];
$wait = $_POST["wait"];
$threshold = $_POST["threshold"];
$stop = $_POST["stop"];
$alert = $_POST["alert"];

if($mode == "0")
    $sql = "UPDATE trackers SET phone_number=".$phone_number.", pin_code=".$pin_code
        .", time_zone='".$time_zone."', low_battery=".$battery_20
        .", empty_battery=".$battery_10.", battery_threshold=".$battery_threshold
        .", mode=".$mode.", sleeping_hours=".$sleeping_hours
        .", sleeping_minutes=".$sleeping_minutes.", activation_delay=".$activation_delay
        .", gsm_active=".$gsm_permanent.", frequency=".$frequency
        .", wait=".$wait.", threshold=".$threshold
        .", stop=".$stop.", alert=".$alert
        ." WHERE serial_number = ".$serial_number;
else
    $sql = "UPDATE trackers SET phone_number=".$phone_number.", pin_code=".$pin_code
        .", time_zone='".$time_zone."', low_battery=".$battery_20
        .", empty_battery=".$battery_10.", battery_threshold=".$battery_threshold
        .", mode=".$mode.", frequency=".$frequency
        .", wait=".$wait.", threshold=".$threshold
        .", stop=".$stop.", alert=".$alert
        ." WHERE serial_number = ".$serial_number;

echo $sql;
if ($conn->query($sql) == FALSE){
    echo $sql;
    echo "could not edit this tracker in data base";
}else{
    $sql = "DELETE FROM pending_cfg WHERE cfg_type = 'config' AND serial_number=".$serial_number;
    $conn->query($sql);
    $sql = "INSERT INTO pending_cfg (serial_number,cfg_type) VALUES (".$serial_number.",'config')";
    if ($conn->query($sql) == FALSE){
        echo $sql;
        echo "could not add this config to pending configs";
    }
}
$conn->close();