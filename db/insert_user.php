<?php
require "dbh.php";
session_start();
// Takes raw data from the request
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$email = $_POST['email']; 
$username = $_POST['username']; 
$group = $_POST['group']; 
$password = $_POST['password']; 
$password_confirm = $_POST['password_confirm'];

if($password !== $password_confirm){
    $conn->close();
    exit();
}
$hashedPwd = password_hash($password, PASSWORD_DEFAULT);
$sql = "INSERT INTO users (firstname, lastname, email, username, groupname, password) VALUES ('".$firstname."','".$lastname."','".$email."','".$username."','".$group."','".$hashedPwd."')";

if ($conn->query($sql) == FALSE){
    echo $sql;
    echo "SQLERROR";
} else{
    $sql1 = "INSERT INTO logs (ip_address, username, action)
            VALUES ('".$_SESSION['ip_address']."', '".$_SESSION['username']."', 'insert user ".$username."')";
    $conn->query($sql1);
}
$conn->close();