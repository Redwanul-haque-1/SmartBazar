<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role']!=="Customer") die("Unauthorized");

require_once("../Model/DatabaseConnection.php");

$id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT name FROM users WHERE id=?");
$stmt->execute([$id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html><html><head>
<link rel="stylesheet" href="../css/style.css">
<title>Customer Dashboard</title></head>
<body>
<h2>Welcome, <?= htmlspecialchars($user['name']) ?></h2>
<ul>
<li><a href="../Customer/cart.php">Cart</a></li>
<li><a href="../Customer/reviews.php">Reviews</a></li>
<li><a href="../Customer/report.php">Report Product/Seller</a></li>
<li><a href="../Profile/profile.php">Profile</a></li>

</ul>
<a href="../Controller/logout.php">Logout</a>
</body></html>
