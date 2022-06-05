<?php
// http://localhost/opa/db/insert_target.php?sn=12345&aquisition=2022-01-30%2014:15:35&action=marche&accuracy=5&speed=10&geotype=gps&cbattery=25&gps=2&csq=30&zone=1&lat=35.0&lon=-0.6
require "dbh.php";
session_start();
// collect value of input field

$data = explode(',', $_GET["data"]);
$serial_number = $data[0];

$aquisition = new datetime($data[1]);
$aquisition = $aquisition->format('Y-m-d H:i:s');
$action = $data[2];
$accuracy = $data[3];
$speed = $data[4];
$geotype = $data[5];
$cbattery = $data[6];
$gps = $data[7];
$csq = $data[8];
$zone = $data[9];
if($zone == 'noDefinedZone'){
	$zone = "null";
} else{
	$sql = "SELECT * FROM zones WHERE zonename = '$zone'";
    	$result = $conn->query($sql);
    	if ($result->num_rows == 0)
		$zone = "null"; 
}
$entry = $data[10];
$exit = $data[11];
$lat = $data[12];
$lon = $data[13];

if($csq == 99){
    $csq = 0;
} elseif($csq < 8){
    $csq = 25;
} elseif($csq < 16){
    $csq = 50;
} elseif($csq < 24){
    $csq = 75;
} elseif($csq < 32){
    $csq = 100;
}

switch ($gps) {
    case '2':
        $gps = '2D';
        break;
    case '3':
        $gps = '3D';
        break;
    default:
        $gps = 'pas de signal';
}
if($zone != "null"){
	$sql = "INSERT INTO targets(tracker, aquisition, action, accuracy, speed,geotype, cbattery, gps, csq, zone, lat, lng, zone_entry, zone_exit)"
	        ."VALUES ( (SELECT trackerid FROM trackers WHERE serial_number = $serial_number),"
		."'$aquisition', '$action', $accuracy, $speed, '$geotype', $cbattery, '$gps', $csq, '$zone', $lat, $lon, $entry, $exit)";
} else{

	$sql = "INSERT INTO targets(tracker, aquisition, action, accuracy, speed,geotype, cbattery, gps, csq, zone, lat, lng, zone_entry, zone_exit)"
        	."VALUES ( (SELECT trackerid FROM trackers WHERE serial_number = $serial_number),"
        	."'$aquisition', '$action', $accuracy, $speed, '$geotype', $cbattery, '$gps', $csq, $zone, $lat, $lon, $entry, $exit)";
}
if ($conn->query($sql) == FALSE){
    echo "Insert error";
} else {
    $sql = "SELECT * FROM pending_cfg WHERE serial_number =".$serial_number." ORDER BY cfgid ASC";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        if($row = $result->fetch_assoc()){
	    $cfgid = $row['cfgid'];
            switch ($row['cfg_type']) {
                case 'config':
                    $sql = "SELECT * FROM trackers WHERE serial_number = $serial_number";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        if($row = $result->fetch_assoc()){
                            echo 'cfg.tracker,'.$cfgid.",".$row['phone_number'].",".$row['pin_code']. ","
                            .$row['time_zone'].",".$row['low_battery'].","
                            .$row['empty_battery'].",".$row['battery_threshold'].","
                            .$row['mode'].",".$row['frequency'].","
                            .$row['wait'].",".$row['threshold'].","
                            .$row['stop'].",".$row['alert'].","
			    .$row['sleeping_hours'].",".$row['sleeping_minutes'].","
		            .$row['activation_delay'].",".$row['gsm_active'];
                        }
                    }
                    break;
                
                case 'zone_add':
                    $sql = "SELECT * FROM zones WHERE zonename ='".$row['zonename']."'";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        if($row = $result->fetch_assoc()){
                            echo 'cfg.zone.add,'.$cfgid.",".$row['zonename'].","
                            .$row['lat1']. ",".$row['lng1'].","
                            .$row['lat2'].",".$row['lng2'].","
                            .$row['lat3'].",".$row['lng3'].","
                            .$row['lat4'].",".$row['lng4'].","
                            .$row['start_time'].",".$row['end_time'];
                        }
                    }
                    break;

                case 'zone_delete':
                    echo 'cfg.zone.del,'.$cfgid.",".$row['zonename'];
                    break;
            
                default:
                    break;
            }
        }
    }
    else{
	    echo "target inserted and there is no pending config";
    }
}
$conn->close();
