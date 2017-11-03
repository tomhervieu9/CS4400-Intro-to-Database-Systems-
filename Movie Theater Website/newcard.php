<?php

include 'dbconn.php';
session_start();
if (isset($_SESSION['username']) && isset($_SESSION['user'])) {
    $cardName = $_POST['cardName'];
    $cardNumber = $_POST['cardNumber'];
    $expdate = $_POST['expdate'];
    $movie_id = $_POST["movieid"];
    $theatre_ID = $_POST["theatreid"];
    $showtime_ID = $_POST["showtimeid"];
    $childNum = $_POST['childnum'];
    $adultNum = $_POST['adultnum'];
    $seniorNum = $_POST['seniornum'];
    $totalprice = $_POST['totalprice'];
    $bstreet = $_POST['bstreet'];
    $bcity = $_POST['bcity'];
    $bstate = $_POST['bstate'];
    $bzip = $_POST['bzip'];
    if (isset($_POST['saveBox'])) {
        $save = 1;
    } else {
        $save = 0;
    }
    $sql = "INSERT INTO Payment_Info (B_Name, B_Street, B_City, B_State, B_ZIP, C_Num,  C_Exp_Date, C_Saved, Username) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssss", $cardName, $bstreet, $bcity, $bstate, $bzip, $cardNumber, $expdate, $save,  $_SESSION['username']);
    if ($stmt->execute()) {
        ?>
        <form name="name" id="name" method="post" action="/4400/confirmation.php" class="form-horizontal">
            <input type='hidden' name='cnum' id='childnum' value='<?php echo $cardNumber?>'/>
            <input type='hidden' name='childnum' id='childnum' value='<?php echo $childNum?>'/>
            <input type='hidden' name='adultnum' id='adultnum' value='<?php echo $adultNum?>'/>
            <input type='hidden' name='seniornum' id='seniornum' value='<?php echo $seniorNum?>'/>
            <input type='hidden' name='totalprice' id='totalprice' value='<?php echo $totalprice?>'/>
            <input type='hidden' name='theatreid' id='theatreid' value='<?php echo $theatre_ID?>'/>
            <input type='hidden' name='showtimeid' id='showtimeid' value='<?php echo $showtime_ID?>'/>
            <input type='hidden' name='movieid' id='movieid' value='<?php echo $movie_id?>'/>
        </form>
        <script type="text/javascript">
            document.getElementById('name').submit(); // SUBMIT FORM
        </script>
        <?php
    } else {
        echo "Something went wrong, please try again";
        echo "<b><a href='/4400/nowplaying.php'>Link to movies</a><b>";
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