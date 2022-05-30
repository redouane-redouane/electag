<?php
require "dbh.php";
session_start();
$type = $_POST["type"];

if($type == "balise"){
    $sql = "SELECT * FROM vehicles WHERE association IS NULL ORDER BY name DESC";
    $result = $conn->query($sql);
    $response = "";
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $response = $response.$row['vehicleid']." ".$row['brand']." ".$row['name'].",";
        }
        substr_replace($string ,"", -1);
        echo $response;
    }
} else if($type == "bracelet"){
    $sql = "SELECT * FROM detenus WHERE association IS NULL ORDER BY detenuid DESC";
    $result = $conn->query($sql);
    $response = "";
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $response = $response.$row['detenuid']." ".$row['firstname']." ".$row['lastname'].",";
        }
        substr_replace($string ,"", -1);
        echo $response;
    }
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