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
<link rel="stylesheet" href="../public/css/style.css">
</head>
<body>

<h2>Change Password</h2>

<a href="profile.php">⬅ Back</a>

<hr>

<form action="savePassword.php" method="POST">

<label>Current Password</label>
<input type="password" name="old" required>

<label>New Password (min 8 chars)</label>
<input type="password" name="new" required>

<button type="submit">Update Password</button>

</form>

</body>
</html>
