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
  $sql = "SELECT * FROM MOVIE WHERE Movie_ID = ?;";
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
<html><head>
    <link href="css/movieoverview.css" rel="stylesheet" type="text/css">
  </head><body>
    <div class="container">
      <div class="row">
        <div class="col-md-8">
          <h1 class="text-warning"><?php echo $movieInfo['M_Title'] ?></h1>
          <p>
            <i>Synopsis</i>
            <br>
            <?php echo $movieInfo['M_Synopsis'] ?>
        </div>
      </div>
    </div>
    <div class="section">
      <div class="container">
        <div class="row">
          <div class="col-md-4">
            <h1>
              <i>Cast</i>
            </h1>
            <p></p>
            <ul>
              <?php
              $sql = "SELECT (Cast_Name) FROM cs4400_team_21.cast WHERE Movie_ID = ?;";
              $stmt = $conn->prepare($sql);
              $stmt -> bind_param('s', $movie_id);
              if ($stmt->execute()) {
                $res = $stmt->get_result();
                $stmt->store_result();
                if (mysqli_num_rows($res) != 0) {
                  while ($data = $res->fetch_assoc()) {
                    echo "<li>".$data['Cast_Name']."</li>";
                  }
                }
              }
              ?>
            </ul>
            <p></p>
          </div>
          <div class="col-md-4">
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <a class="btn btn-primary" href="/4400/movie.php/?id=<?php echo $movie_id ?>">Back</a>
          </div>
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
  <a href="login.html"> Please login here</a>
  </body>
  </html>
  <?php
}