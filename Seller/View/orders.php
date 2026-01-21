<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] !== "Seller"){
    die("Unauthorized");
}

require_once("../../Common/DatabaseConnection.php");

$seller_id = $_SESSION['user_id'];

$sql = "
SELECT 
    o.id AS order_id,
    o.total,
    o.status,
    o.created_at,
    u.name AS customer,
    p.name AS product,
    oi.quantity,
    oi.price
FROM orders o
JOIN order_items oi ON o.id = oi.order_id
JOIN products p ON oi.product_id = p.id
JOIN users u ON o.customer_id = u.id
WHERE p.seller_id = ?
ORDER BY o.id DESC
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $seller_id);
$stmt->execute();

$result = $stmt->get_result();

$orders = [];

while ($r = $result->fetch_assoc()) {
    $orders[$r['order_id']]['info'] = [
        'customer'   => $r['customer'],
        'status'     => $r['status'],
        'created_at' => $r['created_at']
    ];
    $orders[$r['order_id']]['items'][] = $r;
}


?>

<!DOCTYPE html>
<html>
<head>
<title>My Orders</title>
<style>
table{border-collapse:collapse}
td,th{padding:8px;border:1px solid #ccc}
</style>
</head>
<body>

<h2>Orders Received</h2>

<a href="sellerDashboard.php"> Back</a> |
<a href="../Controller/logout.php">Logout</a>

<hr>

<?php if(empty($orders)): ?>
<p>No orders yet.</p>

<?php else: ?>

<?php foreach($orders as $id=>$order): ?>

<h3>Order #<?= $id ?></h3>
Customer: <b><?= htmlspecialchars($order['info']['customer']) ?></b><br>
Status: <?= $order['info']['status'] ?><br>
Date: <?= $order['info']['created_at'] ?><br>

<table>
<tr>
 <th>Product</th>
 <th>Price</th>
 <th>Qty</th>
 <th>Subtotal</th>
</tr>

<?php 
$total = 0;
foreach($order['items'] as $it): 
 $sub = $it['price'] * $it['quantity'];
 $total += $sub;
?>
<tr>
<td><?= htmlspecialchars($it['product']) ?></td>
<td><?= $it['price'] ?></td>
<td><?= $it['quantity'] ?></td>
<td><?= $sub ?></td>
</tr>
<?php endforeach; ?>

<tr>
<td colspan="3"><b>Total (Your products only):</b></td>
<td><b><?= $total ?></b></td>
</tr>

</table>
<hr>

<?php endforeach; ?>

<?php endif; ?>

</body>
</html>
