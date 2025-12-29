<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] !== "Customer"){
    die("Unauthorized");
}

require_once("../Model/DatabaseConnection.php");

$sql = "SELECT p.*, c.name AS category, u.name AS seller
        FROM products p
        LEFT JOIN categories c ON p.category_id=c.id
        LEFT JOIN users u ON p.seller_id=u.id";

$stmt = $conn->query($sql);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
<title>Shop</title>
<link rel="stylesheet" href="../css/style.css">
<style>
.card{border:1px solid #ccc;padding:10px;margin:10px;display:inline-block;width:250px}
img{width:120px;height:120px;object-fit:cover}
</style>
</head>
<body>

<h2>Shop Products</h2>

<a href="../Dashboard/customerDashboard.php">⬅ Back</a> | 
<a href="cart.php">🛒 View Cart</a> | 
<a href="../Controller/logout.php">Logout</a>

<hr>

<?php foreach($products as $p): ?>
<div class="card">

  <?php if($p['image']): ?>
    <img src="../uploads/<?= $p['image'] ?>"><br>
  <?php endif; ?>

  <b><?= htmlspecialchars($p['name']) ?></b><br>

  Category: <?= htmlspecialchars($p['category']) ?><br>

  <b>Seller:</b> <?= htmlspecialchars($p['seller']) ?><br>

  <b>Price:</b> <?= $p['price'] ?><br>

  <b>Description:</b>
  <div style="max-width:220px;">
    <?= nl2br(htmlspecialchars($p['description'])) ?>
  </div>

  <br>

  <!-- ADD TO CART -->
  <form action="../Controller/addToCart.php" method="POST">
    <input type="hidden" name="id" value="<?= $p['id'] ?>">
    <input type="number" name="qty" value="1" min="1" required>
    <button type="submit">Add to Cart</button>
  </form>

  <br>

  <!-- REVIEW / REPORT -->
  <a href="product.php?id=<?= $p['id'] ?>">Write Review / Report</a>

</div>
<?php endforeach; ?>



</body>
</html>
