<?php
session_start();
include 'dbconn.php';
$myUsername = $_SESSION['username'];
$sql = "SELECT Order_ID, O_Date, O_Cost, O_Status FROM Orders WHERE Username = '$myUsername'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
// output data of each row
while($row = $result->fetch_assoc()) {
echo "id: " . $row["Username"]. " - Password: " . $row["Password"]. " " . $row["Email"]. "<br>";
}

} else {
echo "0 results";
}

header("location:movie.php");

$conn->close();
?>