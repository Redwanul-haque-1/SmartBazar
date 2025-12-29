<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] !== "Customer"){
    die("Unauthorized");
}

$cart = $_SESSION['cart'] ?? [];
$total = 0;
?>

<!DOCTYPE html>
<html>
<head>
<title>My Cart</title>
<link rel="stylesheet" href="../css/style.css">
<style>
table{border-collapse:collapse}
td,th{padding:8px;border:1px solid #ccc}
img{width:60px;height:60px;object-fit:cover}
</style>
</head>
<body>

<h2>My Cart</h2>

<a href="shop.php">⬅ Continue Shopping</a> |
<a href="../Dashboard/customerDashboard.php">Dashboard</a>

<hr>

<?php if(empty($cart)): ?>
<p>Your cart is empty.</p>

<?php else: ?>

<table>
<tr>
<th>Image</th>
<th>Name</th>
<th>Price</th>
<th>Qty</th>
<th>Subtotal</th>
<th>Action</th>
</tr>

<?php foreach($cart as $id=>$item): 
$sub = $item['qty'] * $item['price'];
$total += $sub;
?>
<tr>
<td>
<?php if($item['image']): ?>
<img src="../uploads/<?= $item['image'] ?>">
<?php endif; ?>
</td>

<td><?= htmlspecialchars($item['name']) ?></td>
<td><?= $item['price'] ?></td>

<td>
<form action="../Controller/updateCart.php" method="POST">
  <input type="hidden" name="id" value="<?= $id ?>">
  <input type="number" name="qty" value="<?= $item['qty'] ?>" min="1">
  <button type="submit">Update</button>
</form>
</td>

<td><?= $sub ?></td>

<td>
<form action="../Controller/removeFromCart.php" method="POST">
  <input type="hidden" name="id" value="<?= $id ?>">
  <button type="submit">Remove</button>
</form>
</td>

</tr>
<?php endforeach; ?>

</table>

<h3>Total: <?= $total ?></h3>

<form action="../Controller/checkout.php" method="POST"
onsubmit="return confirm('Place order?');">
  <button type="submit">Checkout</button>
</form>

<?php endif; ?>

</body>
</html>
