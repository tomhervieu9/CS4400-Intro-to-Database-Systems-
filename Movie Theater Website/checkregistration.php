<?php

include 'dbconn.php';

// username and password sent from form
$myusername=$_POST['inputUsername'];
$mypassword=$_POST['inputPassword'];
$myemail = $_POST['inputEmail'];
$mgrpassword = $_POST['MgrPassword'];

session_start();
if (strlen($mgrpassword) != 0) {
    $sql = "SELECT * FROM system_info WHERE M_Password = ?";
    $stmt = $conn->prepare($sql);
    $stmt -> bind_param('s', $mgrpassword);
    if (!$stmt->execute()) {
        echo '<div class="alert alert-danger">';
        echo "Failed manager password";
        echo '</div>';
        echo "<a href=register.html> Click here to try again </a>";
    } else {
        $res = $stmt->get_result();
        $count = $res->num_rows;
    } if ($count == 1) {
        $sql = "INSERT INTO user (Username,Password,Email) VALUES (?, ?, ?)";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("sss", $myusername,$mypassword,$myemail);
            if (!$stmt->execute()) {
                echo '<div class="alert alert-danger">';
                echo "Error adding you to db";
                echo '</div>';
                echo "<a href=register.html> Click here to try again </a>";
            }
        }
        $sql = "INSERT INTO cs4400_Team_21.Manager (Username) VALUES (?)";
        $stmt = $conn->prepare($sql);
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("s", $myusername);
            if (!$stmt->execute()) {
                echo '<div class="alert alert-danger">';
                echo "Error adding you to db";
                echo '</div>';
                echo $conn->error;
                echo "<a href=register.html> Click here to try again </a>";
            } else {
                echo "Succesfully added you as manager!";
                echo "<a href=login.html> Click here to login </a>";
            }
        }
    } else {
        echo '<div class="alert alert-danger">';
        echo "Wrong manager password";
        echo '</div>';
        echo "<a href=register.html> Click here to try again </a>";
    }
} else {
    $sql = "INSERT INTO user (Username,Password,Email) VALUES (?, ?, ?)";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sss", $myusername,$mypassword,$myemail);
        if (!$stmt->execute()) {
            echo '<div class="alert alert-danger">';
            echo "Error adding you to db";
            echo '</div>';
            echo $conn->error;
            echo "<a href=register.html> Click here to try again </a>";
        } else {
            echo "Succesfully registered you!";
            echo "<a href=login.html> Click here to login </a>";
        }
    } else {
        echo '<div class="alert alert-danger">';
        echo "database config error, try again";
        echo '</div>';
        echo $conn->error;
        echo "<a href=register.html> Click here to try again </a>";
    }
}
