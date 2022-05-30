<?php
require "dbh.php";
session_start();

$sql = "SELECT * FROM users ORDER BY username ASC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row

    while($row = $result->fetch_assoc()) {
        echo '
        <option value="'.$row['userid'].'">
            '.ucfirst($row['firstname']).'  '.
            strtoupper($row['lastname']).'
        </option>
        ';
    }
} else {
    echo '
    <option>
        No users
    </option>  
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