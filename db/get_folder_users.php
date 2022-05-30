<?php
require "dbh.php";
session_start();
$foldername = $_POST["foldername"];

$sql = "SELECT * FROM user_folder WHERE foldername = '".$foldername."'";
$result = $conn->query($sql);
$response = "selected:";
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $response = $response.$row['userid'];
    }
}
$sql = "SELECT * FROM users";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $response = $response.','.$row['userid'].':'.$row['firstname'].':'.$row['lastname'];
    }
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