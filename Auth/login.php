<?php session_start(); ?>
<!DOCTYPE html>
<html><head>
<title>Login</title>
<link rel="stylesheet" href="../css/style.css">
</head>
<body>
<h2>Login</h2>
<form action="../Controller/loginValidation.php" method="POST">
<a href="../index.php">⬅ Back</a><br><br>
<label>Email</label>
<input type="email" name="email" required>

<label>Password</label>
<input type="password" name="password" required>

<button type="submit">Login</button>
</form>
<br>
<a href="signup.php">Create new account</a>

</body></html>
