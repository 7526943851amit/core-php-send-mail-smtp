<?php
$servername = "localhost";
$username = "root";
$password = "";
$db="dietplan";

$conn = new mysqli($servername, $username, $password, $db);
echo $conn;
die();
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
?>