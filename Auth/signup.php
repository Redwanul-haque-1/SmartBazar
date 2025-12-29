<?php session_start(); ?>
<!DOCTYPE html>
<html><head>
<title>Register</title>
<link rel="stylesheet" href="../css/style.css">
<script src="../js/password.js" defer></script>
</head>
<body>
<h2>Register</h2>
<form action="../Controller/signUpValidation.php" method="POST" enctype="multipart/form-data">
<a href="../index.php">⬅ Back</a><br><br>
<label>Name</label>
<input type="text" name="name" required>

<label>Email</label>
<input type="email" name="email" required>

<label>Password</label>
<input type="password" id="password" name="password" required>
<small id="passMsg" style="color:red;"></small>
<br>
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

<label>User Type</label>
<select name="role" required>
<option value="Customer">Customer</option>
<option value="Seller">Seller</option>
<option value="Admin">Admin</option>
</select>

<button type="submit">Register</button>
</form>
<br>
<a href="login.php">Already have an account?</a>
</body></html>
