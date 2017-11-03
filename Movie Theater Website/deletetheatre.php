<?php
session_start();

if (isset($_SESSION['username']) && isset($_SESSION['user']))  {
    ?>

    <?php include 'dbconn.php';
    $sql ="DELETE FROM Saves WHERE Theatre_ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $_POST["optradio"]);
    if($stmt->execute()) {
        header("location:mypreferredtheatre.php");
    } else {?><html>
    <body>
    <div class="alert alert-danger">
        <b> Could not perform action</b>
    </div>
    <br>
    <a href = "login.html"> Please Contact A System Administrator</a>
    </body>
    </html> <?php }
    ?>

    <?php
} else {
    ?>
    <html>
    <body>
    <div class="alert alert-danger">
        <b> not logged in (as a user)</b>
    </div>
    <br>
    <a href = "login.html"> Please login here</a>
    </body>
    </html> <?php } ?>