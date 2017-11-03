<?php
session_start();

if (isset($_SESSION['username']) && isset($_SESSION['manager']))  {
?>


    <div class="section">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <h1 class="text-center text-warning">View Popular Movie Report</h1>
          </div>
        </div>
      </div>
    </div>
    <div class="section">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Month</th>
                  <th>Movie</th>
                  <th># of Orders</th>
                </tr>
              </thead>
              <tbody>
              <?php
                  include 'dbconn.php';
                  $sql = "(SELECT MonthName(a.O_Date) as Month, c.M_Title as Movie, Count(b.Movie_ID) AS Num_Orders 
                              FROM Orders a INNER JOIN Showtime b ON  a.Showtime_ID = b.Showtime_ID
                              INNER JOIN Movie c ON c.Movie_ID = b.Movie_ID 
                              WHERE a.O_Date BETWEEN  DATE_SUB(DATE_SUB(CURDATE(), INTERVAL DAYOFMONTH(CURDATE())-1 DAY),INTERVAL 2 MONTH) AND DATE_SUB(LAST_DAY(CURDATE()), INTERVAL 2 MONTH)
                              GROUP BY Month, MOVIE
                              ORDER BY Num_Orders DESC
                              LIMIT 3) 
                           UNION
                          (SELECT MonthName(a.O_Date) as Month, c.M_Title as Movie, Count(b.Movie_ID) AS Num_Orders 
                              FROM Orders a INNER JOIN Showtime b ON  a.Showtime_ID = b.Showtime_ID
                              INNER JOIN Movie c ON c.Movie_ID = b.Movie_ID 
                              WHERE a.O_Date BETWEEN  DATE_SUB(DATE_SUB(CURDATE(), INTERVAL DAYOFMONTH(CURDATE())-1 DAY),INTERVAL 1 MONTH) AND DATE_SUB(LAST_DAY(CURDATE()), INTERVAL 1 MONTH)
                              GROUP BY Month, MOVIE
                              ORDER BY Num_Orders DESC
                              LIMIT 3) 
                           UNION
                          (SELECT MonthName(a.O_Date) as Month, c.M_Title as Movie, Count(b.Movie_ID) AS Num_Orders 
                            FROM Orders a INNER JOIN Showtime b ON  a.Showtime_ID = b.Showtime_ID
                            INNER JOIN Movie c ON c.Movie_ID = b.Movie_ID 
                            WHERE a.O_Date BETWEEN  DATE_SUB(DATE_SUB(CURDATE(), INTERVAL DAYOFMONTH(CURDATE())-1 DAY),INTERVAL 0 MONTH) AND DATE_SUB(LAST_DAY(CURDATE()), INTERVAL 0 MONTH)
                            GROUP BY Month, MOVIE
                            ORDER BY Num_Orders DESC
                            LIMIT 3) ";
                  $result = $conn->query($sql);
                      while($row = $result->fetch_assoc()) {
                      ?>
                <tr>
                  <td><?php echo $row['Month']?></td>
                  <td><?php echo $row['Movie']?></td>
                  <td><?php echo $row['Num_Orders']?></td>
                </tr>
                      <?php  }
                        $conn->close();   ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div><div class="section text-center"><div class="container"><div class="row"><div class="col-md-12"><a class="btn btn-info btn-lg">Back</a></div></div></div></div>
  

</body></html>

  <?php
} else {
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