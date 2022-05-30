<?php

//Connect to data base
$servername = "localhost";
$username = "urdse";
$password = "electag";
$dbname = "opaDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
