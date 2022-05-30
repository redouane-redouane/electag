<?php
require "dbh.php";
session_start();

$sql = "SELECT * FROM logs ORDER BY date DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row

    while($row = $result->fetch_assoc()) {
        echo '
        <tr>
            <td>'.$row['ip_address'].'</td>
            <td>'.$row['username'].'</td>
            <td>'.$row['date'].'</td>
            <td>'.$row['action'].'</td>
        </tr>
        ';
    }
} else {
    echo '
    <tr>
        <td>No</td>
        <td>logs</td>
        <td>are</td>
        <td>available</td>
    </tr>    
    ';
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