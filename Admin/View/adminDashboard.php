<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role']!=="Admin") die("Unauthorized");
?>
<!DOCTYPE html><html><head>
<link rel="stylesheet" href="../css/style.css">
<title>Admin Dashboard</title></head>
<body>
<h2>Welcome Admin, <?php echo $_SESSION['name']; ?></h2>
<ul>
<li><a href="../Admin/manageUsers.php">Manage Users</a></li>
<li><a href="../Admin/manageCategories.php">Manage Categories</a></li>
<li><a href="../Admin/viewOrders.php">View All Orders</a></li>
<li><a href="profile.php">Profile</a></li>

</ul>
<a href="../Controller/logout.php">Logout</a>
</body></html>
