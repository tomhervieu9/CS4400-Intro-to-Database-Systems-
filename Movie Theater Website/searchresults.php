<?php
include 'dbconn.php';
session_start();
if (isset($_SESSION['username']) && isset($_SESSION['user'])) {
  $movie_id = $_POST['movieid'];
?>
    <div class="section">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <h1 class="text-warning">Results</h1>
          </div>
        </div>
      </div>
    </div>
    <div class="section">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <form class="form-horizontal" role="form" action="selecttime.php/?id=<?php echo $movie_id ?>" method="post">
              <div class="form-group">
                <div class="col-sm-10">
                  <input type='hidden' name='movieid' id='movieid' value='<?php echo $movie_id?>'/>
                  <?php
                  $searchi = $_POST['searchinput'];
                  $searchi = '%'.$searchi.'%';
                  $sql = "SELECT * FROM theatre WHERE THTR_Name LIKE ? OR THTR_Street LIKE ? OR THTR_City LIKE ? OR THTR_ZIP LIKE ? OR THTR_State LIKE ?;";
                  $stmt = $conn->prepare($sql);
                  $stmt-> bind_param("sssss", $searchi, $searchi, $searchi, $searchi, $searchi);
                  if ($stmt->execute()) {
                    $res = $stmt->get_result();
                    $counter = 1;
                    while ($data = $res->fetch_assoc()) {
                      ?><div class="radio">
                    <label class="radio">
                      <input type="radio" id="opt<?php echo $counter?>" name="optradio" value="<?php echo $data["THTR_Name"]?>">
                      <?php echo $data['THTR_Name']."<br>".$data['THTR_Street']."<br>".$data['THTR_City']." ".$data['THTR_State'].", ".$data['THTR_ZIP']. "</label>";
                      echo "</div>";
                      echo "<hr color = \"black\">";
                      $counter = $counter + 1;
                    }
                  }
                  ?>
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-10">
                  <button type="submit" class="btn btn-default">Select</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  

</body></html>
  <?php

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