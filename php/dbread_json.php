<?php
//phpinfo();
require('cvar.php');
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo "Connection failed<br/>";
    die("Connection failed: " . $conn->connect_error);
}
$sql = "select * from employee";
$result = $conn->query($sql);
$return_arr = array();

while($row = $result->fetch_assoc())
{
    array_push($return_arr,$row);
}
echo json_encode($return_arr);
$conn->close();
?>
