<?php
session_start();
include 'dbconn.php';
if (isset($_SESSION['username']) && isset($_SESSION['user']))  {
    $username12 = $_SESSION["username"];
    if (!isset($_POST['searchorder'])) {
        ?>
    <div class="section">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <h1 class="text-center text-warning">Order History</h1>
          </div>
        </div>
      </div>
    </div>
    <div class="section">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <form class="form-horizontal" role="form" action="/4400/orderhistory.php" method="post">
              <div class="form-group">
                <div class="col-sm-1">
                  <label for="searchorder" class="control-label">Order ID</label>
                </div>
                <div class="col-sm-8">
                  <input type="search" class="form-control" id="searchorder" name="searchorder">
                </div>
                  <input type='submit' class="btn btn-lg btn-primary" name='Submit' value='Search' />
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
                <form class="form-horizontal" role="form" action="orderdetail.php" method="post">
                <div class="form-group">
                <table class="table table-condensed table-striped">
                <thead>
                <tr>
                  <th>Select</th>
                  <th>Order_ID</th>
                  <th>Movie</th>
                  <th>Status</th>
                  <th>Total Cost</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $sql = "SELECT Order_ID, M_Title, O_Status, O_Cost 
                        FROM Orders AS a JOIN Showtime AS b ON a.Showtime_ID=b.Showtime_ID 
                        JOIN Movie AS c ON b.Movie_ID = c.Movie_ID 
                        WHERE a.Username = ?;";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('s', $username12);
                if($stmt->execute()) {
                  $result = $stmt->get_result();
                  echo $stmt->error;
                  $counter = 1;
                  while ($row = $result->fetch_assoc()) {

                    ?>
                    <tr>
                      <td>
                        <div class="radio">
                          <label>
                            <input type="radio"
                                   id="opt<?php echo $counter ?>"
                                   name="optradio"
                                   value="<?php echo $row["Order_ID"]?>">
                          </label>
                        </div>
                      </td>
                      <td><?php echo $row["Order_ID"] ?></td>
                      <td><?php echo $row["M_Title"] ?></td>
                      <td><?php echo $row["O_Status"] ?></td>
                      <td><?php echo $row["O_Cost"]?></td>
                    </tr>
                    <?php $counter = $counter + 1;
                  } ?>
                  </tbody>
                  </table>
                  <button type="submit" class="btn btn-primary btn-lg">
                    View Order Details
                  </button>
                  <a href="profile.php" class="btn btn-lg btn-primary" role="button">Back</a>
                  </div>
                  </form>
                    <?php }?>


          </div>
        </div>
      </div>
    </div>
    <div class="section">
      <div class="container">
        <div class="row">
        </div>
      </div>
    </div>

  <?php
} else {
    $orderid = $_POST['searchorder'];
        ?>
        <div class="section">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="text-center text-warning">Order History</h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="section">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <form class="form-horizontal" role="form" action="/4400/orderhistory.php" method="post">
                            <div class="form-group">
                                <div class="col-sm-1">
                                    <label for="searchorder" class="control-label">Order ID</label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="search" class="form-control" id="searchorder" name="searchorder">
                                </div>
                                <input type='submit' class="btn btn-lg btn-primary" name='Submit' value='Search' />
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
                        <form class="form-horizontal" role="form" action="/4400/orderdetail.php" method="post">
                            <div class="form-group">
                                <table class="table table-condensed table-striped">
                                    <thead>
                                    <tr>
                                        <th>Select</th>
                                        <th>Order_ID</th>
                                        <th>Movie</th>
                                        <th>Status</th>
                                        <th>Total Cost</th>
                                    </tr>
                                    </thead>
                                    <tbody>
        <?php
        $sql = "SELECT Order_ID, M_Title, O_Status, O_Cost 
                        FROM Orders AS a JOIN Showtime AS b ON a.Showtime_ID=b.Showtime_ID 
                        JOIN Movie AS c ON b.Movie_ID = c.Movie_ID 
                        WHERE a.Order_ID = ? AND a.Username = ?;";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ss', $orderid, $_SESSION['username']);
        if($stmt->execute()) {
            $result = $stmt->get_result();
            echo $stmt->error;
            $counter = 1;
            while ($row = $result->fetch_assoc()) {

                ?>
                <tr>
                    <td>
                        <div class="radio">
                            <label>
                                <input type="radio"
                                       id="opt<?php echo $counter ?>"
                                       name="optradio"
                                       value="<?php echo $row["Order_ID"] ?>">
                            </label>
                        </div>
                    </td>
                    <td><?php echo $row["Order_ID"] ?></td>
                    <td><?php echo $row["M_Title"] ?></td>
                    <td><?php echo $row["O_Status"] ?></td>
                    <td><?php echo $row["O_Cost"] ?></td>
                </tr>
                <?php $counter = $counter + 1;
            }
        } ?>
                                    </tbody>
                                </table>
                                <input type='submit' class="btn btn-lg btn-primary" name='Submit' value='Select' />
                                <a href="profile.php" class="btn btn-lg btn-primary" role="button">Back</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="section">
            <div class="container">
                <div class="row">
                </div>
            </div>
        </div>
                        <?php
    }
}