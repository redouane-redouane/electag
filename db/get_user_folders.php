<?php
require "dbh.php";
session_start();
$userid = $_POST["userid"];

$sql = "SELECT * FROM user_folder WHERE userid = ".$userid." ORDER BY foldername DESC";
$result = $conn->query($sql);
$response = "";
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $response = $response.$row['foldername'].",";
    }
    substr_replace($string ,"", -1);
    echo $response;
}
$conn->close();

/* 
<tr>
    <td>Alfreds Futterkiste</td>
    <td>Maria Anders</td>
    <td>Germany</td>
    <td>Alfreds Futterkiste</td>
</tr>
*/