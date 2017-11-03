<?php
session_start();


if (isset($_SESSION['username']) && isset($_SESSION['manager'])) {
?>
<html><head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
        <script type="text/javascript" src="http://netdna.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
        <link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="http://pingendo.github.io/pingendo-bootstrap/themes/default/bootstrap.css" rel="stylesheet" type="text/css">
    </head><body>
        <div class="section">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="text-center text-warning">Choose Functionality</h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="section">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <ul class="lead nav nav-pills nav-stacked">
                            <li>
                                <a href="viewrevenuereport.php">View Revenue Report</a>
                            </li>
                            <li>
                                <a href="viewpopularmoviereport.php">View Popular Movie Report</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div><div class="section"><div class="container"><div class="row"><div class="col-md-12 text-center"><a class="btn btn-info btn-lg" href="logout.php">Logout</a></div></div></div></div>
    

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
    </html>
    <?php
} 