<?php
session_start();
include 'dbconn.php';

// username information


if (isset($_SESSION['username']) && isset($_SESSION['user']))  {
$username12 = $_SESSION["username"];
?>
    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h1 class="text-warning">My Preferred Theatre</h1>
                    <br>
                    <br>
                </div>
            </div>
        </div>
    </div>
    <div class="section">
    <div class="container">
    <div class="row">
    <div class="col-md-12">
    <form class="form-horizontal" role="form" action="deletetheatre.php" method="post">
    <div class="form-group">
    <table class="table table-condensed table-striped">
    <thead>
    <tr>
        <th>Select</th>
        <th>Theatre</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $sql = "SELECT * FROM Saves NATURAL JOIN Theatre WHERE Username = ?;";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $username12);
    if($stmt->execute()) {
        $result = $stmt->get_result();
        echo $stmt->error;
        $counter = 1;
        while ($row = $result->fetch_assoc()) {

            ?>
            <tr>
                <td>
                    <div class="radio">
                        <label>
                            <input type="radio"
                                   id="opt<?php echo $counter ?>"
                                   name="optradio"
                                   value="<?php echo $row["Theatre_ID"]?>">
                        </label>
                    </div>
                </td>
                <td><?php echo $row["THTR_Name"] ?></td>
            </tr>
            <?php $counter = $counter + 1;
        }
        $conn->close(); ?>
        </tbody>
        </table>
        <button type="submit" class="btn btn-primary btn-lg">
            Delete
        </button>
        <a href="profile.php" class="btn btn-lg btn-primary" role="button">Back</a>
        </div>
        </form>
        </div>
        <div class="form-group"></div>
        <div class="form-group"></div>
        </div>
        </div>
        </div>


        </body></html>

    <?php }
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