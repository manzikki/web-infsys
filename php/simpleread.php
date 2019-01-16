<?php
$servername = "localhost";
$username = "xxxxxxxxx";
$password = "yyyyyyyyy";
$dbname = "zzzzzzzzz";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT * from employee";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "Name: " . $row["fname"]. " " . $row["lname"]. "<br>\n";
    }
} else {
    echo "0 results";
}
$conn->close();
?>
