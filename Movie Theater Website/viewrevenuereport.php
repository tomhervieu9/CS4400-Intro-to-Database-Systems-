<?php
session_start();



if (isset($_SESSION['username']) && isset($_SESSION['manager']))  {
?>


        <div class="section">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="text-center text-warning">View Revenue Report</h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="section text-left">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Month</th>
                                    <th>Revenue</th>
                                </tr>
                            </thead>
                            <tbody>
                    <?php
                        include 'dbconn.php';
                        $sql = "SELECT MonthName(O_Date) as Month,SUM(O_Cost) as Total_Cost FROM Orders WHERE DATE_SUB(LAST_DAY(O_Date), INTERVAL 3 MONTH) <= O_Date GROUP BY Month ORDER BY Month(O_Date);";
                        $result = $conn->query($sql);

                            while($row = $result->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?php echo $row['Month']?></td>
                                    <td>$<?php echo $row['Total_Cost']?></td>
                                </tr>
                            <?php  }
                        $conn->close();   ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div><div class="section"><div class="container"><div class="row"><div class="col-md-12 text-center"><a class="btn btn-info btn-lg">Back</a></div></div></div></div>
    

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