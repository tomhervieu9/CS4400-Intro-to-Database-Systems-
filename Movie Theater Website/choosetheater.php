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
    ?>
    <div class="section">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <h1 class="text-warning">Choose Theater</h1>
          </div>
        </div>
      </div>
    </div>
    <div class="section">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <form class="form-horizontal" role="form" action="/4400/selecttime.php/?id=<?php echo $movie_id ?>"
                  method="post">
              <div class="form-group">
                <input type='hidden' name='movieid' id='movieid' value='<?php echo $movie_id?>'/>
                <label class="control-label" for="saved">Saved Theaters</label>
                <select class="form-control" name="optradio">
                  <?php
                  $sql = "SELECT THTR_Name FROM theatre natural join saves WHERE Username = ?;";
                  $stmt = $conn->prepare($sql);
                  $stmt->bind_param("s", $_SESSION['username']);
                  $stmt->execute();
                  $res = $stmt->get_result();
                  while ($data = $res->fetch_assoc()) {
                    echo "<option> " . $data['THTR_Name'] . "</option>";
                  }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <button type="submit" class="btn btn-primary btn-lg">Select
                </button>
              </div>
          </div>
          </form>
        </div>
      </div>
    </div>
    </div>
    <div class="section">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <form id='searchr' class="form-signin" action='/4400/searchresults.php'
                  method='post' accept-charset='UTF-8'>
              <fieldset>
                <input type='hidden' name='movieid' id='movieid' value='<?php echo $movie_id?>'/>

                <label for='searchinput'>Name/State/Zip/State:</label>
                <input type='text' class="form-control" name='searchinput'
                       id='searchinput' maxlength="50"/>
                <input type='submit' class="btn btn-lg btn-primary"
                       name='Submit' value='Submit'/>
              </fieldset>
            </form>
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
  </html>
  <?php
}