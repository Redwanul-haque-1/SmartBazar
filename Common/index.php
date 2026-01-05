<?php
session_start();
if (isset($_SESSION['role'])) {
    if ($_SESSION['role']=="Admin") header("Location: ../Admin/View/adminDashboard.php");
    if ($_SESSION['role']=="Seller") header("Location: ../Seller/View/sellerDashboard.php");
    if ($_SESSION['role']=="Customer") header("Location: ../Customer/View/customerDashboard.php");
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
<a href="login.php">Login</a> | <a href="signup.php">Register</a>
</body>
</html>
