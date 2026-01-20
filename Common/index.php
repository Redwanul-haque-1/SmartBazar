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
<link rel="stylesheet" href="CSS/style.css">
</head>
<body>
<div class = "center-box">
<h1>SmartBazar</h1>
<h2>One platform. Many markets.</h2>
<a href="login.php">Login</a> | <a href="signup.php">Register</a>
</div>
</body>
</html>
