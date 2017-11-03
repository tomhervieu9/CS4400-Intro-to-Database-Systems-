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
      $theatre_name = $_POST['optradio'];
      $movie_id = $_GET["id"];
      $sql = "SELECT * FROM Movie WHERE Movie_ID = ?";
      $stmt = $conn->prepare($sql);
      $stmt -> bind_param('s', $movie_id);
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
            <h1 class="text-center text-warning">Select Time</h1>
          </div>
        </div>
      </div>
    </div>
    <div class="section">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <h1><?php echo $movieInfo['M_Title']?>
              <br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
              <br>
              <small>&nbsp;<?php echo $movieInfo['MPAA_Rating']?>, &nbsp;<?php echo $movieInfo['M_Duration']?>
              <br>
              <br>
              <div>
                <br>
              </div>
            </h1>
          </div>
          <div class="col-md-6 text-center">
            <h3 class="text-muted">
              <i>Select a movie time to buy tickets:</i>
            </h3>
            <i class="fa fa-3x fa-fw fa-ticket"></i>
            <h1 class="text-center"></h1>
          </div>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="row text-center">
        <div class="col-md-1">
          <a href="#"><i class="fa fa-5x fa-calendar-o text-primary"></i></a>
        </div>
        <div class="col-md-2">
          <h1>Dates</h1>
        </div>
        <div class="col-md-9">
          <form class="form-horizontal" role="form" action='/4400/ticket.php/?id=<?php echo $movie_id?>' method='post' accept-charset='UTF-8'>
            <div class="form-group">
              <div class="col-sm-2">
                <label class="control-label">Select Showing</label>
              </div>
              <div class="col-sm-10">
                <?php
                $sql = "select Theatre_ID from theatre where THTR_Name = ?;";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $theatre_name);
                $stmt->execute();
                $res = $stmt->get_result();
                while ($data = $res->fetch_assoc()) {
                  $tid = $data;
                }
                $tid = $tid['Theatre_ID'];
                ?>
                <input type='hidden' name='theatreid' id='theatreid' value='<?php echo $tid?>'/>
                <select class="form-control" name="showtime">
                  <?php
                $sql = "select Showtime_ID, date_format(S_Date, \"%W, %M %D, %Y\") as date from showtime where Theatre_ID = ? AND Movie_ID = ?;";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ss", $tid, $movie_id);
                $stmt->execute();
                $res = $stmt->get_result();
                if ($res->num_rows == 0) {
                  echo "No time slots with that movie and that theatre. Please try again";
                  echo "<a href=\"movie.php/?id=<?php echo $movie_id ?>\"
                         class=\"btn btn-lg btn-primary\" role=\"button\">Back</a>";
                } else {
                  while ($data = $res->fetch_assoc()) {
                    echo "<option value='" . $data['Showtime_ID'] . "'>" . $data['date'] . "</option>";
                  }
                  ?>
                  </select>
                  </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-6">
                      <button type="submit" class="btn btn-primary btn-lg">
                        Submit
                      </button>
                    </div>
                    <div class="col-sm-6">
                      <a href="movie.php/?id=<?php echo $movie_id ?>"
                         class="btn btn-lg btn-primary" role="button">Back</a>
                    </div>
                  </div>
                  </form>
                  </div>
                  </div>
                  </div>&gt;

                  </body></html>
                  <?php
                }
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
  <a href="/4400/login.html"> Please login here</a>
  </body>
  </html>
  <?php
}