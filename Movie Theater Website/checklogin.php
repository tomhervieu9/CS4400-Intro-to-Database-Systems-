<?php

include 'dbconn.php';

// username and password sent from form
$myusername=$_POST['username'];
$mypassword=$_POST['password'];


$sql = "SELECT * FROM User WHERE Username= ? AND Password= ?";
$stmt = $conn->prepare($sql);
$stmt -> bind_param('ss', $myusername, $mypassword);
$count = 0;
if (!$stmt->execute()) {
    echo "error";
    echo $stmt->error;
} else {
    $stmt->store_result();
    $count =  $stmt->num_rows;
}

// If result matched $myusername and $mypassword, table row must be 1 row

if($count==1){
    session_start();
    $_SESSION['username'] = $myusername;
    $sql = "SELECT * FROM Manager WHERE Username = ?;";
    $stmt = $conn->prepare($sql);
    echo $stmt->errno;
    $stmt -> bind_param('s', $myusername);
    if (!$stmt->execute()) {
        echo "error";
        echo $stmt->error;
        $_SESSION['user'] = "user";
        header("location: nowplaying.php");
    } else {
        echo "here3";
        echo $stmt->errno;
        $stmt->store_result();
        echo $stmt->errno;
        $count =  $stmt->num_rows;
        if ($count != 0) {
            $_SESSION['manager'] = "manager";
            echo "here1";
            header("location: choosefunctionality.php");
        } else {
            $_SESSION['user'] = "user";
            echo "here2";
            header("location: nowplaying.php");
        }
    }
}
else {
    echo $conn->error;
    echo "Wrong Username or Password";
}