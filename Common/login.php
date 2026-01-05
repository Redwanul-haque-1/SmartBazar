<?php session_start(); ?>

<?php if(isset($_GET['msg']) && $_GET['msg']=="session_expired") { ?>
   <p class="alert">Your session expired. Please login again.</p>
<?php } ?>

<!DOCTYPE html>
<html>
<head>
<title>Login</title>
<link rel="stylesheet" href="../Admin/public/css/style.css">
</head>

<body>

<div class="login-box">

<h2>Login</h2>

<form action="loginValidation.php" method="POST">

<a class="back" href="index.php">⬅ Back</a><br><br>

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
