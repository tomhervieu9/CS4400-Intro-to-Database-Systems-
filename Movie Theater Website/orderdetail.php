<?php
session_start();

if (isset($_SESSION['username']) && isset($_SESSION['user']))  {
$username12 = $_SESSION["username"]; ?>



    <div class="section">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <h1 class="text-center text-warning">Order Details</h1>
          </div>
        </div>
      </div>
    </div>
    <div class="section">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
           <?php
            include 'dbconn.php';
            $sql = "SELECT Order_ID, M_Title, O_Status, O_Cost 
                        FROM Orders AS a JOIN Showtime AS b ON a.Showtime_ID=b.Showtime_ID 
                        JOIN Movie AS c ON b.Movie_ID = c.Movie_ID 
                        WHERE Order_ID = ?;";
                    $stmt = $conn->prepare($sql);
                    $orderID = $_POST['optradio'];
                    $stmt->bind_param('s', $orderID);
                    if($stmt->execute()) {
                      $result = $stmt->get_result();
                      echo $stmt->error;
                      $counter = 1;
                      while ($row = $result->fetch_assoc()) {


      ?>
            <h1 contenteditable="true"><?php echo$row["M_Title"]?>
              <br>
              <br>
            </h1>
          </div>
          <div class="col-md-6">
                <br>
            </h1>
          </div>
        </div>
      </div>
    </div>
    <div class="section">
      <div class="container">
        <div class="row">
          <div class="col-md-6"></div>
          <div class="col-md-6 text-left">
            <h3 class="text-left">1 adult ticket: $11.54</h3>
          </div>
        </div>
      </div>
    </div><div class="section"><div class="container"><div class="row"><div class="col-md-6"><a class="btn btn-lg btn-primary">Cancel This Order</a></div><div class="col-md-2"><a class="btn btn-lg btn-primary">Back</a></div></div></div></div>


</body></html>

  <?php
}}} else {
  ?>
  <html>
  <body>
  <div class="alert alert-danger">
    <b> not logged in (as a manager)</b>
  </div>
  <br>
  <a href = "login.html"> Please login here</a>
  </body>
  </html> <?php } ?>