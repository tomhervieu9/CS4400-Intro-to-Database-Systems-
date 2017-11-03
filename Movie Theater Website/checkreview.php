<?php

include 'dbconn.php';
session_start();
if (isset($_SESSION['username']) && isset($_SESSION['user'])) {
    $comment = $_POST['comment'];
    $movie_id = $_GET["id"];
    $rating = $_POST['rating'];
    $title = $_POST['title2'];
    $uname = $_SESSION['username'];
    $sql = "INSERT INTO Review (Username, Movie_ID, R_Rating, R_Title, R_Comment) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt -> bind_param('ssdss', $uname, $movie_id, $rating, $title, $comment);
    if (!$stmt->execute()) {
        echo "error";
        echo $stmt->error;
        echo $conn->error;
    } else {
        header("location: /4400/nowplaying.php");
    }
} else {
    ?>
    <html>
    <body>
    <div class="alert alert-danger">
        <b> not logged in (as a user)</b>
    </div>
    <br>
    <a href="/4400/login.html"> Please login here</a>
    </body>
    </html>
    <?php
}