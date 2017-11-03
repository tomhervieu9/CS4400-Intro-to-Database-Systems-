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
    $sql = "SELECT M_Title FROM Movie WHERE Movie_ID = ?";
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
            <h1 class="text-warning"><?php echo $movieInfo['M_Title'] ?></h1>
          </div>
        </div>
      </div>
    </div>
    <div class="section">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
              <form id='aForm' class="form-horizontal" action='/4400/checkreview.php/?id=<?php echo $movie_id ?>' method='post' accept-charset='UTF-8'>
                <fieldset >
                  <legend>Login</legend>
                  <input type='hidden' name='submitted' id='submitted' value='1'/>
                    <div class="col-sm-2">
                      <label class="control-label">Rating</label>
                    </div>
                    <div class="col-sm-10">
                      <select class="form-control" form="aForm" name="rating">
                        <option>5</option>
                        <option>4</option>
                        <option>3</option>
                        <option>2</option>
                        <option>1</option>
                      </select>
                    </div>
                  <div class="col-sm-2">
                  <label for='title' >Title:</label>
                  </div>
                  <div class="col-sm-10">
                  <input type='text' class="form-control" name='title2' id='title'  maxlength="50" placeholder="Title"/>
                  </div>

                  <div class="form-group">
                    <div class="col-sm-2">
                      <label for="comment" class="control-label">Comment</label>
                    </div>
                    <div class="col-sm-10">
                      <textarea name="comment" id="comment" form="aForm" class="form-control"></textarea>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" class="btn btn-primary btn-lg">Submit</button>
                      <a href="review.php/?id=<?php echo $movie_id ?>" class="btn btn-lg btn-primary" role="button">Back</a>
                    </div>
                  </div>

                </fieldset>
            </form>
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
  <a href="/4400/login.html"> Please login here</a>
  </body>
  </html>
  <?php
}