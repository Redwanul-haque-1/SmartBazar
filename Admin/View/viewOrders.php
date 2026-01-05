<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] !== "Admin"){
    die("Unauthorized");
}

require_once("../../Common/DatabaseConnection.php");

// Fetch all orders with customer name
$sql = "SELECT o.*, u.name AS customer
        FROM orders o
        LEFT JOIN users u ON o.customer_id = u.id
        ORDER BY o.id DESC";

$stmt = $conn->query($sql);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
<title>All Orders</title>
<link rel="stylesheet" href="../public/css/style.css">
<style>
table{border-collapse:collapse}
td,th{padding:8px;border:1px solid #ccc}
</style>
</head>
<body>

<h2>All Orders</h2>

<a href="adminDashboard.php">⬅ Back</a> |
<a href="../Controller/logout.php">Logout</a>

<hr>

<table>
<tr>
  <th>Order ID</th>
  <th>Customer</th>
  <th>Total</th>
  <th>Status</th>
  <th>Date</th>
  <th>Details</th>
</tr>

<?php foreach($orders as $o): ?>
<tr>
<td><?= $o['id'] ?></td>
<td><?= htmlspecialchars($o['customer']) ?></td>
<td><?= $o['total'] ?></td>
<td><?= $o['status'] ?></td>
<td><?= $o['created_at'] ?></td>

<td>
  <a href="viewOrderItems.php?id=<?= $o['id'] ?>">View Items</a>
</td>
</tr>
<?php endforeach; ?>

</table>

</body>
</html>
