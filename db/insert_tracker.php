<?php
    require "dbh.php";
    // localhost/opa/db/insert_tracker.php?serial_number=12345&trackername=testtrack&apn=internet&ccid=12345&imsi=12345&operator=mobilis&device=2.0&firmware=1.73&bootloader=2.0
    $serial_number = $_GET["serial_number"];
    $trackername = $_GET["trackername"];
    $apn = $_GET["apn"];
    $ccid = $_GET["ccid"];
    $imsi = $_GET["imsi"];
    $operator = $_GET["operator"];
    $device = $_GET["device"];
    $firmware = $_GET["firmware"];
    $bootloader = $_GET["bootloader"];

    $sql = "INSERT INTO trackers(serial_number, foldername, trackername, apn, ccid, imsi, operator, device, firmware, bootloader) VALUES ($serial_number,'folder3','$trackername','$apn','$ccid',$imsi,'$operator',$device,$firmware,$bootloader)";
    if ($conn->query($sql) == FALSE){
	
	$sql2 = "SELECT * FROM trackers WHERE serial_number = ".$serial_number;
	$result = $conn->query($sql2);
	if($result->num_rows > 0){
		echo "device already exists in database";

		$sql = "DELETE FROM pending_cfg WHERE serial_number = $serial_number";
		$conn->query($sql);

		$sql = "INSERT INTO pending_cfg (serial_number,cfg_type) VALUES (".$serial_number.",'config')";
		if ($conn->query($sql) == FALSE){
			echo "could not add this config to pending configs";
		}
		$row = $result->fetch_assoc();
		$sql = "SELECT * FROM zones WHERE trackerid =".$row['trackerid'];
		$result = $conn->query($sql);
		if($result->num_rows > 0){
			while($row = $result->fetch_assoc()) {
				$sql = "INSERT INTO pending_cfg (serial_number,cfg_type,zonename) VALUES (".$serial_number.",'zone_add','".$row['zonename']."')";
				if ($conn->query($sql) == FALSE){
					echo "could not add this zone operation to pending configs";
				}
			}
		}
	}	
	else{
		echo "could not insert this tracker to database";
	}
    } else {
    	echo "tracker inserted successfully";
    }
    $conn->close();
?>
