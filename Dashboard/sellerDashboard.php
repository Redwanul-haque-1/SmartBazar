<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role']!=="Seller") die("Unauthorized");

require_once("../Model/DatabaseConnection.php");

$id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT name FROM users WHERE id=?");
$stmt->execute([$id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html><html><head>
<link rel="stylesheet" href="../css/style.css">
<title>Seller Dashboard</title></head>
<body>
<h2>Welcome Seller, <?= htmlspecialchars($user['name']) ?></h2>
<ul>
<li><a href="../Seller/products.php">Manage Products</a></li>
<li><a href="../Seller/orders.php">View Orders</a></li>
<li><a href="../Seller/stats.php">Sales Stats</a></li>
<li><a href="../Profile/profile.php">Profile</a></li>

</ul>
<a href="../Controller/logout.php">Logout</a>
</body></html>
