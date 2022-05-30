<?php
require "dbh.php";
session_start();

$sql = "SELECT * FROM trackers ORDER BY trackerid DESC";
$response = "";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $response = $response.$row['serial_number']."/"
                    .$row['trackername']."/"
                    .$row['foldername'].",";       
    }
    $response = substr_replace($response ,"", -1);
}
echo $response;
$conn->close();

/* 
<tr>
    <td>Alfreds Futterkiste</td>
    <td>Maria Anders</td>
    <td>Germany</td>
    <td>Alfreds Futterkiste</td>
</tr>
*/