

<?php


$host = "localhost";
$dbname = "smartbazar";
$username = "root";
$password = "";

// MySQLi connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
