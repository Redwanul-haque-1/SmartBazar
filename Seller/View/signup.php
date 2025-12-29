<?php
session_start();

$isLoggedIn = $_SESSION["isLoggedIn"] ?? false;
if ($isLoggedIn) {
    Header("Location: dashboard.php");
}

$emailErr =  $_SESSION["emailErr"] ?? '';
$passErr = $_SESSION['passwordErr'] ??'';
$previousValues = $_SESSION['previousValues'] ??[];
$loginErr = $_SESSION["LoginErr"] ??"";


unset($_SESSION['previousValues']);
unset($_SESSION["LoginErr"]);

?>


<html>
    <head>
<script src="..\Controller\JS\checkEmail.js"> </script>
</head>
<body>


<form method="post" action="..\Controller\signUpValidation.php" enctype="multipart/form-data">
    <label>Name</label>
  <input type="text" name="name" required>

  <label>Email</label>
  <input type="email" name="email" required>

  <label>Password</label>
  <input type="password" id="password" name="password" required>

  <small id="passMsg" style="color:red;"></small>

  <label>Phone</label>
  <input type="text" name="phone">

  <label>Address</label>
  <textarea name="address"></textarea>

  <label>Gender</label>
  <select name="gender" required>
    <option>Male</option>
    <option>Female</option>
    <option>Other</option>
  </select>

  <label>Date of Birth</label>
  <input type="date" name="dob">

  <label>Profile Picture</label>
  <input type="file" name="profile_image" accept="image/*">

  <input type="hidden" name="role" value="Customer">

  <button type="submit">Register</button>

</form>
</body>
</html>