<?php
include 'dbconn.php';
$counter = 0;
session_start();
if (isset($_SESSION['username']) && isset($_SESSION['user'])) {
?>
<html><head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script type="text/javascript" src="http://netdna.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="css/homecss" rel="stylesheet" type="text/css">
  </head><body>
    <div class="section">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <a class="btn btn-primary" href="profile.php">Profile</a>
          </div>

          <div class="col-md-6 text-right">
            <a class="btn btn-primary alignright" href="logout.php">Logout</a>
          </div>
        </div><div class="row"><div class="col-md-12">
            <div class="page-header">
              <h1 class="text-center">Now Playing</h1>
            </div>
          </div></div>
        <div class="row"><div class="col-md-2"></div><div class="col-md-8"><table class="center-table table table-condensed table-striped" align="center">
              <thead>
                <tr></tr>
              </thead>
              <tbody>
                <tr>
                    <?php
                    $sql = "SELECT M_Title, Movie_ID FROM Movie WHERE Now_Playing = 1;";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            if ($counter < 2) {
                                echo "<td align=\"center\">";
                                echo "<a class=\"active btn btn-block btn-default\" href = \"movie.php/?id=" . $row['Movie_ID'] . "\">" . $row['M_Title'] . "</a>";
                                echo "</td>";
                                $counter = $counter + 1;
                            } else {
                                $counter = 1;
                                echo "</tr>";
                                echo "<tr>";
                                echo "<td align=\"center\">";
                                echo "<a class=\"active btn btn-block btn-default\" href = \"movie.php/?id=" . $row['Movie_ID'] . "\">" . $row['M_Title'] . "</a>";
                                echo "</td>";
                            }
                        }
                        if ($counter == 1) {
                            echo "</tr>";
                        }
                    }
                    ?>
              </tbody>
            </table></div></div><div class="row text-center">
          <div class="col-md-7 text-center">

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