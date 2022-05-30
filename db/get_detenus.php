<?php
require "dbh.php";
session_start();

$sql = "SELECT * FROM detenus ORDER BY firstname DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row

    while($row = $result->fetch_assoc()) {
        echo '
        <tr>
            <td>'.$row['detenuid'].'</td>
            <td>'.ucfirst($row['firstname']).'</td>
            <td>'.strtoupper($row['lastname']).'</td>
            <td>'.$row['address'].'</td>
            <td>'.$row['duration'].'</td>
            <td>Not associated</td>
        </tr>
        ';
    }
} else {
    echo '
    <tr>
        <td>No</td>
        <td>detenus</td>
        <td>are</td>
        <td>available</td>
        <td>in</td>
        <td>database</td>
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