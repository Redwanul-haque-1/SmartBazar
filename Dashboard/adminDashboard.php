<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role']!=="Admin") die("Unauthorized");

require_once("../Model/DatabaseConnection.php");

$id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT name FROM users WHERE id=?");
$stmt->execute([$id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html><html><head>
<link rel="stylesheet" href="../css/style.css">
<title>Admin Dashboard</title></head>
<body>
<h2>Welcome Admin, <?= htmlspecialchars($user['name']) ?></h2>
<ul>
<li><a href="../Admin/manageUsers.php">Manage Users</a></li>
<li><a href="../Admin/manageCategories.php">Manage Categories</a></li>
<li><a href="../Admin/viewOrders.php">View All Orders</a></li>
<li><a href="../Profile/profile.php">Profile</a></li>

</ul>
<a href="../Controller/logout.php">Logout</a>
</body></html>
