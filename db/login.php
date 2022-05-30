<?php
if(isset($_POST['login-submit'])){
    require "dbh.php";

    $username = $_POST['username'];
    $password = $_POST['password'];

    if(empty($username) || empty($password)){
        header("Location: ../index.php?error=empty%20fiels");
        exit();    
    } else{
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("Location: ../index.php?error=sql%20error");
            exit();
        } else{
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if($row = mysqli_fetch_assoc($result)){
                $passwordCheck = password_verify($password, $row['password']);
                if($passwordCheck == true){
                    session_start();
                    $_SESSION['userid'] = $row['userid'];
                    $_SESSION['username'] = $row['username'];

                    //whether ip is from the share internet  
                    if(!empty($_SERVER['HTTP_CLIENT_IP'])) {  
                        $_SESSION['ip_address'] = $_SERVER['HTTP_CLIENT_IP'];  
                    }  
                    //whether ip is from the proxy  
                    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  
                        $_SESSION['ip_address'] = $_SERVER['HTTP_X_FORWARDED_FOR'];  
                    }  
                    //whether ip is from the remote address  
                    else{  
                        $_SESSION['ip_address'] = $_SERVER['REMOTE_ADDR'];  
                    }

                    $sql1 = "INSERT INTO logs (ip_address, username, action)
                            VALUES ('".$_SESSION['ip_address']."', '".$_SESSION['username']."', 'login')";
                    $conn->query($sql1);
                    $conn->close();
                    
                    header("Location: ../index.php#map");
                    exit();
                } else{
                    header("Location: ../index.php?error=wrong%20password");
                    exit();
                }
            } else{
                header("Location: ../index.php?error=wrong%20username");
                exit();
            }
        }
    }
} else{
    header("Location: ../index.php?error=illegal");
    exit();
}