
<?php 
session_start();

$isLoggedIn = $_SESSION["isLoggedIn"] ?? false;
if (!$isLoggedIn) {
    Header("Location: ../../Common/login.php");
}

$email = $_SESSION["email"] ??"";

?>

<html>

<body>
    <h1>This is dashboard</h1>
    <h2>Welcome <?php echo $email;?></h2>
    <!-- <img src="../uploads/blue.png" /> -->
    <a href="..\Controller\logout.php">Logout</a>
</body>
</html><?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role']!=="Customer") die("Unauthorized");
?>
<!DOCTYPE html><html><head>
<link rel="stylesheet" href="../public/css/style.css">
<title>Customer Dashboard</title></head>
<body>
<h2>Welcome, <?php echo $_SESSION['name']; ?></h2>
<ul>
<li><a href="../Customer/cart.php">Cart</a></li>
<li><a href="../Customer/reviews.php">Reviews</a></li>
<li><a href="../Customer/report.php">Report Product/Seller</a></li>
<li><a href="../Profile/profile.php">Profile</a></li>

</ul>
<a href="../Controller/logout.php">Logout</a>
</body></html>
