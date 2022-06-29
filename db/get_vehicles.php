<?php
require "dbh.php";
session_start();

$sql = "SELECT * FROM vehicles ORDER BY brand ASC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row

    while($row = $result->fetch_assoc()) {
        echo '
        <tr>
            <td>'.$row['vehicleid'].'</td>
            <td>'.strtoupper($row['brand']).'</td>
            <td>'.ucfirst($row['name']).'</td>
            <td>'.strtoupper($row['plate']).'</td>
            <td>'.ucfirst($row['color']).'</td>
            <td><button>edit this vehicle</button></td>
            <td><button>delete this vehicle</button></td>
        </tr>
        ';
    }
} else {
    echo '
    <tr>
        <td>No</td>
        <td>vehicles</td>
        <td>currently</td>
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