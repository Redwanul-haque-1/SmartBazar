<?php
session_start();
if (isset($_SESSION['role'])) {
    if ($_SESSION['role']=="Admin") header("Location: Dashboard/adminDashboard.php");
    if ($_SESSION['role']=="Seller") header("Location: Dashboard/sellerDashboard.php");
    if ($_SESSION['role']=="Customer") header("Location: Dashboard/customerDashboard.php");
}
?>
<!DOCTYPE html>
<html>
<head>
<title>SmartBazar</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>
<h1>Welcome to SmartBazar</h1>
<a href="Auth/login.php">Login</a> | <a href="Auth/signup.php">Register</a>
</body>
</html>
