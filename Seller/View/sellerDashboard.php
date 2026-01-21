<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== "Seller") {
    die("Unauthorized");
}

require_once("../../Common/DatabaseConnection.php");

$id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT name FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();
$user = $result->fetch_assoc();


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

$stmt2 = $conn->prepare($sql);
$stmt2->bind_param("i", $seller_id);
$stmt2->execute();

$result2 = $stmt2->get_result();
$stats = $result2->fetch_assoc();

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

$stmt3 = $conn->prepare($sql2);
$stmt3->bind_param("i", $seller_id);
$stmt3->execute();

$result3 = $stmt3->get_result();

$products = [];
while ($row = $result3->fetch_assoc()) {
    $products[] = $row;
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Seller Dashboard</title>
<link rel="stylesheet" href="../public/css/styleSellerDash.css">


</head>
<body>

<div class = "sellerDash">
<h2>Welcome Seller, <?= htmlspecialchars($user['name']) ?></h2>

<ul>
<li><a href="products.php">Manage Products</a></li>
<li><a href="orders.php">View Orders</a></li>
<li><a href="stats.php">Sales Stats</a></li>
<li><a href="profile.php">Profile</a></li>
</ul>

<a href="../Controller/logout.php">Logout</a>

<hr>

<h2>Sales Statistics</h2>

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

</div>
</body>
</html>
