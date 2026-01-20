<?php
session_start();

if(!isset($_SESSION['role']) || $_SESSION['role']!=="Customer"){
    die("Unauthorized");
}

require_once("../../Common/DatabaseConnection.php");

$id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT name FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();
$user = $result->fetch_assoc();

$sql = "SELECT p.*, c.name AS category, u.name AS seller
        FROM products p
        LEFT JOIN categories c ON p.category_id = c.id
        LEFT JOIN users u ON p.seller_id = u.id";

$result = $conn->query($sql);

$products = [];
while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}



?>
<!DOCTYPE html>
<html>
<head>
<title>Customer Dashboard</title>
<link rel="stylesheet" href="../public/css/styleCustomerDash1.css">



</head>
<body>

<h2>Welcome, <?= htmlspecialchars($user['name']) ?></h2>

<ul>
<li><a href="cart.php">Cart</a></li>
<li><a href="reviews.php">Reviews</a></li>
<li><a href="report.php">Report Product/Seller</a></li>
<li><a href="profile.php">Profile</a></li>
</ul>

<a href="../Controller/logout.php">Logout</a>

<hr>

<h2>Shop Products</h2>


<?php foreach($products as $p): ?>
<div class="card">

  <?php if($p['image']): ?>
    <img src="../../Seller/public/uploads/<?= $p['image'] ?>"><br>
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

  <!-- Add To Cart -->
  <form action="../Controller/addToCart.php" method="POST">
    <input type="hidden" name="id" value="<?= $p['id'] ?>">
    <input type="number" name="qty" value="1" min="1" required>
    <button type="submit">Add to Cart</button>
  </form>

  <br>

  <!-- Review / Report -->
  <a href="product.php?id=<?= $p['id'] ?>">Write Review / Report</a>

</div>
<?php endforeach; ?>

</body>
</html>
