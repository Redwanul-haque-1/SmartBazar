<?php session_start(); ?>


<!DOCTYPE html>
<html>
<head>
<title>Login</title>
<link rel="stylesheet" href="CSS/styleL.css">
</head>

<body>

<div class="login-box">

<?php if(isset($_GET['msg']) && $_GET['msg']=="session_expired") { ?>
   <p class="alert">Your session expired. Please login again.</p>
<?php } ?>

<h2>Login</h2>

<form action="loginValidation.php" method="POST">

<a class="back" href="index.php" style: > Back</a><br><br>

<label>Email</label>
<input type="email" name="email" required>

<label>Password</label>
<input type="password" name="password" required>

<button class="btn primary" type="submit">Login</button>

</form>

<br>

<a class="link" href="signup.php">Create new account</a>

</div>

</body>
</html>
