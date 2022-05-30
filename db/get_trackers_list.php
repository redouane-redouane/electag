<?php
require "dbh.php";
session_start();

$sql = "SELECT * FROM folders WHERE foldername IN (SELECT foldername FROM user_folder WHERE userid = ".$_SESSION['userid'].")";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row

    while($row = $result->fetch_assoc()) {
	$response = $response.$row['foldername'].":";
        $sql2 = "SELECT * FROM trackers WHERE foldername = '".$row['foldername']."'";
        $result2 = $conn->query($sql2);   
        if ($result2->num_rows > 0) {     
		while($row2 = $result2->fetch_assoc()) {
			$response = $response.$row2['trackerid'].'/'
	                                    .$row2['foldername'].'/'
	                                        .$row2['serial_number'].'/'
	                                    .$row2['trackername'].'/'
	                                        .$row2['apn'].'/'
	                                    .$row2['ccid'].'/'
	                                        .$row2['phone_number'].'/'
	                                    .$row2['imsi'].'/'
	                                        .$row2['pin_code'].'/'
	                                    .$row2['operator'].'/'
	                                        .$row2['device'].'/'
	                                    .$row2['firmware'].'/'
	                                        .$row2['bootloader'].'/'
	                                    .$row2['time_zone'].'/'
	                                        .$row2['low_battery'].'/'
	                                    .$row2['empty_battery'].'/'
	                                        .$row2['battery_threshold'].'/'
	                                    .$row2['alert'].'/'
	                                        .$row2['mode'].'/'
	                                    .$row2['sleeping_hours'].'/'
	                                        .$row2['sleeping_minutes'].'/'
	                                    .$row2['activation_delay'].'/'
	                                        .$row2['gsm_active'].'/'
	                                    .$row2['frequency'].'/'
	                                        .$row2['wait'].'/'
	                                    .$row2['threshold'].'/'
	                                        .$row2['stop'].',';
	        }
	        $response = substr_replace($response ,"", -1);
	}
	$response = $response.";";
	}
        $response = substr_replace($response ,"", -1);
}
echo $response;
$conn->close();

/* 
<div class="sub-dropdown">
    <a> directory 1 >> </a>
    <div class="sub-dropdown-content">
        <a href="#">SubLink 1</a>
        <a href="#">SubLink 2</a>
        <a href="#">SubLink 3</a>
    </div>
</div>
*/
