<?php
include 'dbconn.php';
session_start();
if (isset($_SESSION['username']) && isset($_SESSION['user'])) {
$movie_id = $_POST["movieid"];
$theatre_ID = $_POST["theatreid"];
$showtime_ID = $_POST["showtimeid"];
  $childNum = $_POST['child'];
  $adultNum = $_POST['adult'];
  $seniorNum = $_POST['senior'];
  $totalprice = $_POST['totalcost'];
  if (!isset($_POST['adultCheckbox'])) {
    $adultNum = 0;
  }
  if (!isset($_POST['childCheckbox'])) {
    $childNum = 0;
  }
  if (!isset($_POST['seniorCheckbox'])) {
    $seniorNum = 0;
  }
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
            <h1><?php echo $movieInfo["M_Title"]?>
              <br>
              <small>&nbsp;<?php echo $movieInfo['MPAA_Rating']?>,<?php echo $movieInfo['M_Duration']?></small>
              <br>
              <small>&nbsp;<?php echo $movieInfo["S_Date"]?></small>
            </h1>
          </div>
          <div class="col-md-6">
            <h1><?php echo $movieInfo["THTR_Name"]?>
              <small>
                <br>
                <br>&nbsp;<?php echo $movieInfo['THTR_Street']."<br>".$movieInfo['THTR_City']." ".$movieInfo['THTR_State'].", ".$movieInfo['THTR_ZIP'];?></small>
            </h1>
          </div>
        </div>
      </div>
    </div>
    <div class="section">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <h1>________________________________________________________________________________</h1>
            <h1 class="text-left text-warning">Payment Information</h1>
          </div>
        </div>
      </div>
    </div>
    <div class="section">
      <div class="container">
        <div class="row">
          <div class="col-md-4">
            <h4>Use a saved card</h4>
          </div>
          <div class="col-md-4">
            <form class="form-horizontal" action="confirmation.php" method="post">
            <select class="form-control" name="ccard">
                <?php
                $sql = "SELECT C_Num FROM Payment_Info WHERE Username = ? and C_Saved =1;";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $_SESSION['username']);
                if ($stmt->execute()) {
                  $res = $stmt-> get_result();
                  while ($row = $res->fetch_assoc()) {
                    ?>
                    <option name ="cnum" value="<?php echo $row['C_Num'] ?>"> <?php echo substr($row['C_Num'], -4)?></option>
                    <?php
                  }
                }
                }
                $conn->close();   ?>

                <option> 1234 </option>
              </select>
            </div>
          </div>
          <input type='hidden' name='childnum' id='childnum' value='<?php echo $childNum?>'/>
          <input type='hidden' name='adultnum' id='adultnum' value='<?php echo $adultNum?>'/>
          <input type='hidden' name='seniornum' id='seniornum' value='<?php echo $seniorNum?>'/>
          <input type='hidden' name='totalprice' id='totalprice' value='<?php echo $totalprice?>'/>
          <input type='hidden' name='theatreid' id='theatreid' value='<?php echo $theatre_ID?>'/>
          <input type='hidden' name='showtimeid' id='showtimeid' value='<?php echo $showtime_ID?>'/>
          <input type='hidden' name='movieid' id='movieid' value='<?php echo $movie_id?>'/>
          <div class="col-md-4">
            <input type='submit' class="btn btn-lg btn-primary" name='Submit' value='Buy Ticket' />
          </div>
        </form>
        </div>
      </div>
    </div>
    <div class="section">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <h2>
              <b>Use a new card</b>
            </h2>
          </div>
        </div>
      </div>
    </div>
    <div class="section">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <form class="form-horizontal" role="form" action="newcard.php" method="post">
              <div class="form-group">
                <div class="col-sm-2">
                  <label for="cardName" class="control-label">Name on Card</label>
                </div>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="cardName" placeholder="Name" name="cardName">
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-2">
                  <label for="cardNumber" class="control-label">Card Number</label>
                </div>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="cardNumber" placeholder="XXXX-XXXX-XXXX-XXXX" name="cardNumber">
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-2">
                  <label for="cvv" class="control-label">CVV</label>
                </div>
                <div class="col-sm-10">
                  <input type="password" class="form-control" id="cvv" placeholder="XXX">
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-2">
                  <label for="bstreet" class="control-label">Billing Street</label>
                </div>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="bstreet" placeholder="Street" name="bstreet">
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-2">
                  <label for="bcity" class="control-label">Billing City</label>
                </div>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="bcity" placeholder="City" name="bcity">
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-2">
                  <label for="bstate" class="control-label">Billing State</label>
                </div>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="bstate" placeholder="State" name="bstate">
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-2">
                  <label for="bzip" class="control-label">Billing Zip</label>
                </div>
                <div class="col-sm-10">
                  <input type="number" class="form-control" id="bzip" placeholder="Zip Code" name="bzip">
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-2">
                  <label for="expdate" class="control-label">Expiration Date</label>
                </div>
                <div class="col-sm-10">
                  <input type="date" class="form-control" id="expdate" placeholder="XX/XXXX" name="expdate">
                </div>
                <a href="#"><i class="fa fa-3x fa-fw fa-calendar"></i></a>
              </div>
              <div class="radio">
                <label>
                  <input type="checkbox" id="saveBox" name="saveBox">  Save this card for later use </input>
                </label>
                <input type='hidden' name='childnum' id='childnum' value='<?php echo $childNum?>'/>
                <input type='hidden' name='adultnum' id='adultnum' value='<?php echo $adultNum?>'/>
                <input type='hidden' name='seniornum' id='seniornum' value='<?php echo $seniorNum?>'/>
                <input type='hidden' name='totalprice' id='totalprice' value='<?php echo $totalprice?>'/>
                <input type='hidden' name='theatreid' id='theatreid' value='<?php echo $theatre_ID?>'/>
                <input type='hidden' name='showtimeid' id='showtimeid' value='<?php echo $showtime_ID?>'/>
                <input type='hidden' name='movieid' id='movieid' value='<?php echo $movie_id?>'/>
                <input type='submit' class="btn btn-lg btn-primary" name='Submit' value='Submit' />
              </div></form>
          </div>
        </div>
      </div>
    </div>


</body></html>
  <?php
}

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