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
        <div class="col-md-12 text-right">
          <a class="btn btn-primary alignright" href="/4400/logout.php">Logout</a>
        </div>
        <div class="section">
          <div class="container">
            <div class="row">
              <div class="col-md-6">
                <h1 class="text-warning"><?php echo $movieInfo['M_Title'] ?></h1>
                <div class="row">
                  <div class="col-md-12">
                    <table class="table"
                           style="color: white; border: none; border-collapse: collapse; padding: 0px; background-color: black;"
                           cellspacing="0" cellpadding="0">
                      <tbody>
                      <tr>
                        <td align="center">
                          <b>
                            <h2><?php echo substr($movieInfo['M_Release_Date'], 0, 11) ?></h2>
                          </b>
                        </td>
                      </tr>
                      <tr>
                        <td align="center"><?php echo $movieInfo['MPAA_Rating'].", ". $movieInfo['M_Duration'] ?></td>
                      </tr>
                      <tr>
                        <td align="center">
                          <?php
                              $stars = floatval($movieInfo['AVG(R_Rating)']);
                            while ($stars >= 1) {
                              echo "<i class=\"fa fa-star\" aria-hidden=\"true\"></i>";
                              $stars = $stars - 1;
                            }
                            if ($stars > 0) {
                              echo "<i class=\"fa fa-star-half-o\" aria-hidden=\"true\"></i>";
                            }
                          ?>
                        </td>
                      </tr>
                      <tr>
                        <td align="center"><?php echo $movieInfo['count'] ?> Review(s)</td>
                      </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <p></p>
                <p></p>
                <p></p>
              </div>
              <br>
              <br>
              <br>
              <br>
              <br>
              <div class="col-md-6">
                <div class="row"></div>
                <div class="row text-center">
                  <a class="btn btn-primary" href = "/4400/movieoverview.php<?php echo "/?id=". $movie_id; ?>">Overview</a>
                </div>
                <br>
                <div class="row text-center">
                  <a class="btn btn-primary" href = "/4400/review.php<?php echo "/?id=". $movie_id; ?>">Movie Review</a>
                </div>
                <br>
                <div class="row text-center">
                  <a class="btn btn-primary" href="/4400/choosetheater.php/?id=<?php echo $movie_id?>">Buy
                    Ticket</a>
                </div>
              </div>
            </div>
          </div>
        </div>


        </body>
        </html>
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
  <a href="/4400/login.html"> Please login here</a>
  </body>
  </html>
  <?php
}


