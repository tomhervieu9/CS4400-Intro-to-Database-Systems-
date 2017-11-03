<?php
include 'dbconn.php';
$sql = "SELECT Username, Password, Email FROM user";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
// output data of each row
while($row = $result->fetch_assoc()) {
echo "id: " . $row["Username"]. " - Password: " . $row["Password"]. " " . $row["Email"]. "<br>";
}
} else {
echo "0 results";
}
$conn->close();
?>