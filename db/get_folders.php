<?php
require "dbh.php";
session_start();

$sql = "SELECT * FROM folders ORDER BY foldername ASC";
$result = $conn->query($sql);
$response = "";
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $response = $response.$row['foldername']."/"
                    .$row['parentfolder'].",";       
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