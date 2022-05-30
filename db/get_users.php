<?php
require "dbh.php";
session_start();

$sql = "SELECT * FROM users ORDER BY username DESC";
$result = $conn->query($sql);
$response = "";
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $response = $response.ucfirst($row['firstname'])."/"
                    .strtoupper($row['lastname'])."/"
                    .$row["email"]."/"
                    .$row["username"]."/"
                    .$row["groupname"]."/"
                    .$row["userid"].",";       
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