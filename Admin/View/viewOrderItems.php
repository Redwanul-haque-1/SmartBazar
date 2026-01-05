<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] !== "Admin"){
    die("Unauthorized");
}

require_once("../../Common/DatabaseConnection.php");

$order_id = $_GET['id'];

$sql = "SELECT oi.*, p.name 
        FROM order_items oi
        LEFT JOIN products p ON oi.product_id=p.id
        WHERE order_id=?";

$stmt = $conn->prepare($sql);
$stmt->execute([$order_id]);
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
<title>Order Items</title>
<link rel="stylesheet" href="../css/style.css">
<style>
table{border-collapse:collapse}
td,th{padding:8px;border:1px solid #ccc}
</style>
</head>
<body>

<h2>Order #<?= $order_id ?> Items</h2>

<a href="viewOrders.php">⬅ Back to Orders</a>

<hr>

<table>
<tr>
 <th>Product</th>
 <th>Price</th>
 <th>Quantity</th>
 <th>Subtotal</th>
</tr>

<?php foreach($items as $i): ?>
<tr>
<td><?= htmlspecialchars($i['name']) ?></td>
<td><?= $i['price'] ?></td>
<td><?= $i['quantity'] ?></td>
<td><?= $i['price'] * $i['quantity'] ?></td>
</tr>
<?php endforeach; ?>

</table>

</body>
</html>
