<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== "Seller") {
    die("Unauthorized");
}

require_once("../../Common/DatabaseConnection.php");

$seller_id = $_SESSION['user_id'];

$catSql = "SELECT * FROM categories";
$resultCat = $conn->query($catSql);

$categories = [];
while ($row = $resultCat->fetch_assoc()) {
    $categories[] = $row;
}

$sql = "
SELECT 
    p.*,
    c.name AS category,
    AVG(r.rating) AS avg_rating,
    COUNT(r.id) AS review_count
    FROM products p
    LEFT JOIN categories c ON p.category_id = c.id
    LEFT JOIN reviews r ON p.id = r.product_id
    WHERE p.seller_id = ?
    GROUP BY p.id
    "
;

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $seller_id);
$stmt->execute();

$products = [];
$res = $stmt->get_result();
while ($row = $res->fetch_assoc()) {
    $products[] = $row;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>My Products</title>
<link rel="stylesheet" href="../public/css/styleSellerProducts.css">

</head>
<body>

<h2>Manage My Products</h2>

<a href="sellerDashboard.php">Back</a> |
<a href="../Controller/logout.php">Logout</a>

<hr>

<h3>Add New Product</h3>

<form action="../Controller/addProduct.php" method="POST" enctype="multipart/form-data">

<label>Product Name</label>
<input type="text" name="name" required>
<br>

<label>Description</label>
<textarea name="description"></textarea>
<br>

<label>Price</label>
<input type="number" step="0.01" name="price" required>
<br>

<label>Category</label>
<select name="category_id" required>
<option value="">Select Category</option>
<?php foreach($categories as $c): ?>
<option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['name']) ?></option>
<?php endforeach; ?>
</select>
<br>

<label>Image</label>
<input type="file" name="image" accept="image/*">
<br>

<button type="submit">Add Product</button>

</form>

<hr>

<h3>My Products</h3>

<table>
<tr>
<th>ID</th>
<th>Image</th>
<th>Name</th>
<th>Category</th>
<th>Price</th>
<th>Rating</th>
<th>Reviews</th>
<th>Action</th>
</tr>

<?php foreach($products as $p): ?>

<tr>
<td><?= $p['id'] ?></td>

<td>
<?php if($p['image']): ?>
<img src="../public/uploads/<?= $p['image'] ?>">
<?php endif; ?>
</td>

<td><?= htmlspecialchars($p['name']) ?></td>
<td><?= htmlspecialchars($p['category']) ?></td>
<td><?= $p['price'] ?></td>

<td>
<?= $p['avg_rating'] ? round($p['avg_rating'],1).' ⭐' : '—' ?>
</td>

<td>
<?= $p['review_count'] ?> review(s)
<?php if($p['review_count'] > 0): ?>
<br>
<button type="button" onclick="toggleReviews(<?= $p['id'] ?>)">
Show Reviews
</button>
<?php endif; ?>
</td>

<td>

<form action="../Controller/updateProduct.php" method="POST" enctype="multipart/form-data" style="margin-bottom:6px;">
<input type="hidden" name="id" value="<?= $p['id'] ?>">

<input type="text" name="name" value="<?= htmlspecialchars($p['name']) ?>" required>
<input type="number" step="0.01" name="price" value="<?= $p['price'] ?>" required>

<select name="category_id">
<?php foreach($categories as $c): ?>
<option value="<?= $c['id'] ?>" <?= $p['category_id']==$c['id']?'selected':'' ?>>
<?= htmlspecialchars($c['name']) ?>
</option>
<?php endforeach; ?>
</select>

<input type="file" name="image" accept="image/*">
<button type="submit">Update</button>
</form>

<form action="../Controller/deleteProduct.php" method="POST"
onsubmit="return confirm('Delete product?');">
<input type="hidden" name="id" value="<?= $p['id'] ?>">
<button type="submit">Delete</button>
</form>

</td>
</tr>

<?php if($p['review_count'] > 0): ?>
<tr id="reviews-<?= $p['id'] ?>" style="display:none;">
<td colspan="8">

<?php
$revSql = "
SELECT r.rating, r.comment, r.created_at, u.name
FROM reviews r
JOIN users u ON r.customer_id = u.id
WHERE r.product_id = ?
ORDER BY r.id DESC
";

$rv = $conn->prepare($revSql);
$rv->bind_param("i", $p['id']);
$rv->execute();
$rres = $rv->get_result();

while($r = $rres->fetch_assoc()):
?>
<div class="review-box">
<b><?= htmlspecialchars($r['name']) ?></b>
⭐ <?= $r['rating'] ?>/5
<p><?= htmlspecialchars($r['comment']) ?></p>
<small><?= $r['created_at'] ?></small>
</div>
<?php endwhile; ?>

</td>
</tr>
<?php endif; ?>

<?php endforeach; ?>

</table>

<script>
function toggleReviews(id){
    const row = document.getElementById("reviews-" + id);
    row.style.display = (row.style.display === "none") ? "table-row" : "none";
}
</script>

</body>
</html>
