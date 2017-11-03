<?php
include 'dbconn.php';
session_start();
if (isset($_SESSION['username']) && isset($_SESSION['user'])) {
$movie_id = $_POST["movieid"];
$theatre_ID = $_POST["theatreid"];
$showtime_ID = $_POST["showtimeid"];
$childNum = $_POST['childnum'];
$adultNum = $_POST['adultnum'];
$seniorNum = $_POST['seniornum'];
$totalprice = $_POST['totalprice'];
    $totalprice = trim(str_replace('$','',$totalprice));
$cnum = $_POST['cnum'];
$sql = "SELECT *
            FROM Movie as a INNER JOIN Showtime as b ON a.Movie_ID = b.Movie_ID
            INNER JOIN theatre as c ON b.Theatre_ID = c.Theatre_ID 
            WHERE b.Showtime_ID = ?
            AND a.Movie_ID = ?
            AND c.Theatre_ID = ?;";
$stmt = $conn->prepare($sql);
$stmt->bind_param('sss',$showtime_ID, $movie_id,$theatre_ID);
if (!$stmt->execute()) {
    echo "error";
    echo $stmt->error;
    ?>
    <html>
    <body>
    <div class="alert alert-danger">
        <b>Movie with that id does not exist</b>
    </div>
    <br>
    <a href="nowplaying.php"> Please view now playing movies here</a>
    </body>
    </html>
    <?php
} else {
$res = $stmt->get_result();
$stmt->store_result();
if (mysqli_num_rows($res) == 0) {
    ?>
    <html>
    <body>
    <div class="alert alert-danger">
        <b>Movie with that id does not exist</b>
    </div>
    <br>
    <a href="nowplaying.php"> Please view now playing movies here</a>
    </body>
    </html>
    <?php
} else {
    while ($data = $res->fetch_assoc()) {
        $movieInfo = $data;
    }
    ?>

    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="text-center text-warning">Buy Ticket</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h1><?php echo $movieInfo["M_Title"] ?>
                        <br>
                        <small>&nbsp;<?php echo $movieInfo['MPAA_Rating'] ?>
                            ,<?php echo $movieInfo['M_Duration'] ?></small>
                        <br>
                        <small>&nbsp;<?php echo $movieInfo["S_Date"] ?></small>
                    </h1>
                </div>
                <div class="col-md-6">
                    <h1><?php echo $movieInfo["THTR_Name"] ?>
                        <small>
                            <br>
                            <br>&nbsp;<?php echo $movieInfo['THTR_Street'] . "<br>" . $movieInfo['THTR_City'] . " " . $movieInfo['THTR_State'] . ", " . $movieInfo['THTR_ZIP']; ?>
                        </small>
                    </h1>
                </div>
            </div>
        </div>
    </div>
    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>
                        ________________________________________________________________________________</h1>
                    <h1 class="text-left text-warning">Payment Information</h1>
                </div>
            </div>
        </div>
    </div>
    <?php
    $sql = "INSERT INTO Orders (Username, C_Num, Showtime_ID, O_Date, O_Cost, O_Status, O_Adult, O_Child, O_SENIOR) VALUES (?,?,?,?,?,?,0,?,?);";
    $stmt = $conn->prepare($sql);
    $datteee = date("Y-m-d");
    $stmt->bind_param("ssssssss", $_SESSION['username'], $cnum, $showtime_ID, $datteee, $totalprice, $adultNum, $childNum, $seniorNum);
    if (!$stmt->execute()) {
        echo "ERROR SOMETHING WENT WRONG";
    } else {

    ?>
    </h1></div></div></div></div>
    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-6"><h1 class="text-warning">Confirmation</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-6"><h2 contenteditable="true">Order ID</h2>
                </div>
                <?php
                $sql = "SELECT Order_ID FROM Orders WHERE Username = ? AND C_Num = ? AND Showtime_ID = ?;";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sss", $_SESSION['username'], $cnum, $showtime_ID);
                if (!$stmt->execute()) {
                    echo "wrong sid";
                } else {
                    $res = $stmt->get_result();
                    while ($data = $res->fetch_assoc()) {
                        $oid = $data;
                    }
                }
                ?>
                <div class="col-md-6"
                <h1><?php echo $oid['Order_ID'] ?></h1>
                </div>
    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-12"><h4>Thank for your
                        purchase! Please save order ID for your records.</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="section">
        <div class="container">
            <div class="row">
            </div>
        </div>
    </div></body></html>
    <?php
}}}} else {
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