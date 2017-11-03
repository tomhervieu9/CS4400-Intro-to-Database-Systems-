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
    $sql = "SELECT Movie_ID, M_Title, M_Duration, M_Synopsis, MPAA_Rating, M_Release_Date, AVG(R_Rating), count(*) AS count FROM Movie NATURAL JOIN Review WHERE Movie_ID = ? GROUP BY Movie_ID";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $movie_id);
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
                <div class="page-header">
                  <h1 class="text-warning"><?php echo $movieInfo['M_Title'] ?>
                    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                    &nbsp; &nbsp; &nbsp;&nbsp;
                    <small>Average
                      Rating: <?php echo substr($movieInfo['AVG(R_Rating)'], 0, 3) ?></small>
                  </h1>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <a class="btn btn-block btn-primary"
                   href="/4400/leavereview.php/?id=<?php echo $movie_id ?>">Give
                  Review</a>
              </div>
            </div>
          </div>
        </div>
        <div class="section">
        <div class="container">
        <div class="row">
        <div class="col-md-12">
        <?php
        $sql = "SELECT R_Title, R_Rating, R_Comment FROM cs4400_team_21.review where Movie_ID = ?;";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $movie_id);
        if ($stmt->execute()) {
          $res = $stmt->get_result();
          $stmt->store_result();
          if (mysqli_num_rows($res) != 0) {
            while ($data = $res->fetch_assoc()) {
              ?>
              <table class="table table-bordered">
                <thead>
                <tr></tr>
                </thead>
                <tbody>
                <tr>
                  <td>Title: <?php echo $data['R_Title']; ?> </td>
                </tr>
                <tr>
                  <td>Rating: <?php echo $data['R_Rating']; ?></td>
                </tr>
                <tr>
                  <td>Comment: <?php echo $data['R_Comment']; ?> </td>
                </tbody>
              </table>
              <br>
              <?php
            }
            ?>
            </div>
            </div>
            </div>
            </div>


            </body></html>
            <?php
          }
        }
      }
    }
  }
}else {
  ?>
  <html>
  <body>
  <div class="alert alert-danger">
    <b> not logged in (as a user)</b>
  </div>
  <br>
  <a href="login.html"> Please login here</a>
  </body>
  </html>
  <?php
}