<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] !== "Admin"){
    die("Unauthorized");
}

require_once("../../Common/DatabaseConnection.php");


// take all orders with customer name
$sql = "SELECT o.*, u.name AS customer
        FROM orders o
        LEFT JOIN users u ON o.customer_id = u.id
        ORDER BY o.id DESC";

$result = $conn->query($sql);

$orders = [];
while ($row = $result->fetch_assoc()) {
    $orders[] = $row;
}


?>

<!DOCTYPE html>
<html>
<head>
<title>All Orders</title>
<link rel="stylesheet" href="../public/css/styleManageUser.css">

</head>
<body>

<h2>All Orders</h2>

<h3>
<a href="adminDashboard.php">Back</a> |
<a href="../Controller/logout.php">Logout</a>
</h3>

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
