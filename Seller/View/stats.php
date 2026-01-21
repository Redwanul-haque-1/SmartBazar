<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] !== "Seller"){
    die("Unauthorized");
}

require_once("../../Common/DatabaseConnection.php");

$seller_id = $_SESSION['user_id'];


$sql = "
SELECT 
    COUNT(DISTINCT o.id) AS total_orders,
    SUM(oi.quantity) AS total_quantity,
    SUM(oi.price * oi.quantity) AS total_earnings
FROM orders o
JOIN order_items oi ON o.id = oi.order_id
JOIN products p ON oi.product_id = p.id
WHERE p.seller_id = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $seller_id);
$stmt->execute();

$result = $stmt->get_result();
$stats = $result->fetch_assoc();

$sql2 = "
SELECT 
    p.name,
    SUM(oi.quantity) AS qty_sold,
    SUM(oi.price * oi.quantity) AS product_earning
FROM order_items oi
JOIN products p ON oi.product_id = p.id
WHERE p.seller_id = ?
GROUP BY p.id
ORDER BY product_earning DESC
";

$stmt2 = $conn->prepare($sql2);
$stmt2->bind_param("i", $seller_id);
$stmt2->execute();

$result2 = $stmt2->get_result();

$products = [];
while ($row = $result2->fetch_assoc()) {
    $products[] = $row;
}
?>





<!DOCTYPE html>
<html>
<head>
<title>Sales Stats</title>
<link rel="stylesheet" href="../css/style.css">
<style>
.box{border:1px solid #ccc;padding:10px;margin:10px;display:inline-block}
table{border-collapse:collapse}
td,th{padding:8px;border:1px solid #ccc}
</style>
</head>
<body>

<h2>Sales Statistics</h2>

<a href="sellerDashboard.php"> Back</a> |
<a href="../Controller/logout.php">Logout</a>

<hr>

<div class="box">
<b>Total Orders:</b><br>
<?= $stats['total_orders'] ?: 0 ?>
</div>

<div class="box">
<b>Total Items Sold:</b><br>
<?= $stats['total_quantity'] ?: 0 ?>
</div>

<div class="box">
<b>Total Earnings:</b><br>
<?= $stats['total_earnings'] ?: 0 ?>
</div>

<hr>

<h3>Product-wise Earnings</h3>

<?php if(empty($products)): ?>

<p>No sales yet.</p>

<?php else: ?>

<table>
<tr>
 <th>Product</th>
 <th>Quantity Sold</th>
 <th>Earnings</th>
</tr>

<?php foreach($products as $p): ?>
<tr>
<td><?= htmlspecialchars($p['name']) ?></td>
<td><?= $p['qty_sold'] ?></td>
<td><?= $p['product_earning'] ?></td>
</tr>
<?php endforeach; ?>

</table>

<?php endif; ?>

</body>
</html>
