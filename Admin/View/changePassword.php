<?php
session_start();
if(!isset($_SESSION['user_id'])){
    die("Unauthorized");
}

?>
<!DOCTYPE html>
<html>
<head>
<title>Change Password</title>
<link rel="stylesheet" href="../public/css/styleEditProfile.css">
</head>
<body>

<div class ="edit-profile-box">
<h2>Change Password</h2>

<a href="profile.php">Back</a>



<form action="../Controller/savePassword.php" method="POST">

<label>Current Password</label>
<input type="password" name="old" required>
<br>

<label>New Password (min 8 chars)</label>
<input type="password" name="new" required>
<br>

<button type="submit">Update Password</button>
<br>
</form>

</div>
</body>
</html>
