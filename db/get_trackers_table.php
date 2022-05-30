<?php
require "dbh.php";
session_start();

$sql = "SELECT * FROM folders WHERE foldername IN (SELECT foldername FROM user_folder WHERE userid = ".$_SESSION['userid'].")";
$result = $conn->query($sql);
$response = "";

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $sql2 = "SELECT * FROM trackers WHERE foldername = '".$row['foldername']."'";
        $result2 = $conn->query($sql2);   
        if ($result2->num_rows > 0) {     
            while($row2 = $result2->fetch_assoc()) {
                $response = $response.$row2['serial_number']."/"
                    .$row2['trackername']."/"
                    .$row['foldername']."/"
                    ."0"."/"
                    .$row2['device']."/"
                    .$row2['firmware']."/"
                    .$row2['operator'].",";
                // onclick="fill_configuration_form('.$row2['serial_number'].'); document.getElementById(\'config_form\').style.display=\'block\';">
            }
            $response = substr_replace($response ,"", -1);
        }
    }
}
echo $response;
$conn->close();

/* 
<tr onclick="document.getElementById('config_form').style.display='block';">
    <td>Alfreds Futterkiste</td>
    <td>Maria Anders</td>
    <td>Germany</td>
    <td>Alfreds Futterkiste</td>
    <td>Maria Anders</td>
    <td>Germany</td>
</tr>
*/