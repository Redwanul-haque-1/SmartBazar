<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] !== "Customer"){
    die("Unauthorized");
}

require_once("../../Common/DatabaseConnection.php");

$product_id = $_GET['id'];
$customer_id = $_SESSION['user_id'];

$sql = "SELECT p.*, u.name AS seller
        FROM products p
        LEFT JOIN users u ON p.seller_id = u.id
        WHERE p.id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $product_id);
$stmt->execute();

$result = $stmt->get_result();
$product = $result->fetch_assoc();

if (!$product) {
    die("Product not found");
}

$rsql = "SELECT r.*, u.name 
         FROM reviews r 
         LEFT JOIN users u ON r.customer_id = u.id
         WHERE product_id = ?";

$rst = $conn->prepare($rsql);
$rst->bind_param("i", $product_id);
$rst->execute();

$rresult = $rst->get_result();

$reviews = [];
while ($row = $rresult->fetch_assoc()) {
    $reviews[] = $row;
}

/* FETCH REVIEW */
$my = $conn->prepare(
    "SELECT * FROM reviews WHERE product_id = ? AND customer_id = ?"
);
$my->bind_param("ii", $product_id, $customer_id);
$my->execute();

$myResult = $my->get_result();
$myReview = $myResult->fetch_assoc();

?>




<!DOCTYPE html>
<html>
<head>
<title>Product</title>
<style>
.card{border:1px solid #ccc;padding:10px;width:400px}
</style>
</head>
<body>

<a href="shop.php">Back to Shop</a> | 
<a href="../Controller/logout.php">Logout</a>

<h2><?= htmlspecialchars($product['name']) ?></h2>

<div class="card">
  <?php if($product['image']): ?>
    <img src="../../Seller/public/uploads/<?= $product['image'] ?>" width="200"><br>
  <?php endif; ?>

  <b>Seller:</b> <?= htmlspecialchars($product['seller']) ?><br>
  <b>Price:</b> <?= $product['price'] ?><br>
  <b>Description:</b>
  <p><?= htmlspecialchars($product['description']) ?></p>

  <form action="../Controller/reportProduct.php" method="POST" style="display:inline;">
    <input type="hidden" name="product_id" value="<?= $product_id ?>">
    <textarea name="reason" placeholder="Why report this product?" required></textarea>
    <button type="submit">Report Product</button>
  </form>

  <form action="../Controller/reportSeller.php" method="POST" style="display:inline;">
    <input type="hidden" name="seller_id" value="<?= $product['seller_id'] ?>">
    <textarea name="reason" placeholder="Why report seller?" required></textarea>
    <button type="submit">Report Seller</button>
  </form>

</div>

<hr>

<h3>My Review</h3>

<?php if(!$myReview): ?>

<form action="../Controller/addReview.php" method="POST">
  <input type="hidden" name="product_id" value="<?= $product_id ?>">

  <label>Rating (1-5)</label>
  <input type="number" name="rating" min="1" max="5" required>

  <label>Comment</label>
  <textarea name="comment"></textarea>

  <button type="submit">Submit Review</button>
</form>

<?php else: ?>

<form action="../Controller/updateReview.php" method="POST">
  <input type="hidden" name="id" value="<?= $myReview['id'] ?>">

  <label>Rating</label>
  <input type="number" name="rating" min="1" max="5" value="<?= $myReview['rating'] ?>" required>

  <label>Comment</label>
  <textarea name="comment"><?= htmlspecialchars($myReview['comment']) ?></textarea>

  <button type="submit">Update Review</button>
</form>

<form action="../Controller/deleteReview.php" method="POST"
onsubmit="return confirm('Delete your review?');">
  <input type="hidden" name="id" value="<?= $myReview['id'] ?>">
  <button type="submit">Delete Review</button>
</form>

<?php endif; ?>

<hr>

<h3>All Reviews</h3>

<?php foreach($reviews as $r): ?>
<div class="card">
  <b><?= htmlspecialchars($r['name']) ?></b><br>
  ⭐ <?= $r['rating'] ?>/5<br>
  <p><?= htmlspecialchars($r['comment']) ?></p>
</div>
<?php endforeach; ?>

</body>
</html>
