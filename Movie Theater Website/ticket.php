<?php
include 'dbconn.php';
session_start();
if (isset($_SESSION['username']) && isset($_SESSION['user'])) {
  if ($_GET["id"] === "" || $_GET["id"] === false || $_GET["id"] === null) {
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
    $movie_id = $_GET["id"];
    $theatre_ID = $_POST["theatreid"];
    $showtime_ID = $_POST["showtime"];
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

        <head>
          <script type="text/javascript">
            <!--
            function total(frm)
            {
              var tot = 0;
              for (var i = 0; i < frm.elements.length; i++) {
                if (frm.elements[i].type == "checkbox") {
                  if (frm.elements[i].checked) tot +=
                      Number(frm.elements[i].value) * Number(frm.elements[i-1].value);
                }
              }
              document.getElementById("totalDiv").value = "$" + tot.toFixed(2);
            }
            //-->
          </script>
        </head>
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
                <h2>
                  <b><?php echo $movieInfo['M_Title']?></b>
                </h2>
                <p>
                  <i><?php echo $movieInfo['MPAA_Rating']?>,<?php echo $movieInfo['M_Duration']?></i>
                </p>
                <p>
                  <b><?php echo $movieInfo["S_Date"]?></b>
                </p>
              </div>
              <div class="col-md-6">
                <h2>
                  <b><?php echo $movieInfo["THTR_Name"]?></b>
                </h2>
                <p><?php echo $movieInfo['THTR_Street']."<br>".$movieInfo['THTR_City']." ".$movieInfo['THTR_State'].", ".$movieInfo['THTR_ZIP'];?>
                  </p>
              </div>
            </div>
          </div>
        </div>
        <div class="section">
          <div class="container">
            <div class="row">
              <div class="col-md-12">
                <hr color="black">
              </div>
            </div>
          </div>
        </div>
        <div class="section">
          <div class="container">
            <div class="row">
              <div class="col-md-12">
               <form class="form-horizontal" role="form"  method="post" action="/4400/paymentinformation.php">
              <div class="form-group">
                <h1 class="text-warning">How many tickets?</h1>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <table class="table">
                  <thead>
                  <tr></tr>
                  </thead>
                  <tbody>
                  <?php
                  include 'dbconn.php';
                  $sql = "SELECT Base_Price, Senior_Disc, Child_Disc FROM System_Info;";
                  $result = $conn->query($sql);
                  while($row = $result->fetch_assoc()) {
                        $data = $row;
                  }
                  $child_price = $data['Base_Price'] * $data['Child_Disc'];
                  $senior_price = $data['Base_Price'] * $data['Senior_Disc'];
                  ?>
                <tr>
                    <td>Adult Matineee</td>
                    <td>
                      <select class="form-control" id="select2" name="adult">
                        <option value="0">0</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                      </select>
                    </td>
                    <td><input type="checkbox" name="adultCheckbox" value="<?php echo $data["Base_Price"]?>" onclick="total(this.form);" /> <b><?php echo "$".$data["Base_Price"]?></b></td>
                  </tr>
                  <tr>
                    <td>Senior</td>
                    <td>
                      <select class="form-control" id="select2" name="senior">
                        <option value="0">0</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                      </select>
                    </td>
                    <td><input type="checkbox" name="seniorCheckbox" value="<?php echo $senior_price?>" onclick="total(this.form);" /> <b><?php echo "$".number_format($senior_price, 2)?></b></td>
                  </tr>
                  <tr>
                    <td>Child</td>
                    <td>
                      <select class="form-control" id="select2" name="child">
                        <option value="0">0</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                      </select>
                    </td>
                    <td><input type="checkbox" name="childCheckbox" value="<?php echo $child_price?>" onclick="total(this.form);" /> <b><?php echo "$".number_format($child_price, 2)?></b></td>
                  </tr>
                  </tbody>
                </table>
              </div>
              <div class="col-md-6"></div>
            </div>
              <input type="text" class="form-control" readonly id="totalDiv" value = "$0.00" name="totalcost"></input>
              <input type='hidden' name='movieid' id='movieid' value='<?php echo $movie_id?>'/>
              <input type='hidden' name='theatreid' id='theatreid' value='<?php echo $theatre_ID?>'/>
              <input type='hidden' name='showtimeid' id='showtimeid' value='<?php echo $showtime_ID?>'/>
              <input type='submit' class="btn btn-lg btn-primary btn-block" name='Submit' value='Submit' />
              </form>
          </div>
        </div>
        </div>


        </body></html>
        <?php
      }
    }

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