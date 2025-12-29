<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] !== "Seller"){
    die("Unauthorized");
}

require_once("../Model/DatabaseConnection.php");

$seller_id = $_SESSION['user_id'];

// fetch categories
$catSql = "SELECT * FROM categories";
$catStmt = $conn->query($catSql);
$categories = $catStmt->fetchAll(PDO::FETCH_ASSOC);

// fetch seller products
$sql = "SELECT p.*, c.name AS category 
        FROM products p 
        LEFT JOIN categories c ON p.category_id=c.id
        WHERE p.seller_id=?";
$stmt = $conn->prepare($sql);
$stmt->execute([$seller_id]);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
<title>My Products</title>
<link rel="stylesheet" href="../css/style.css">
<style>
table{border-collapse:collapse}
td,th{padding:8px;border:1px solid #ccc}
img{width:60px;height:60px;object-fit:cover}
</style>
</head>
<body>

<h2>Manage My Products</h2>

<a href="../Dashboard/sellerDashboard.php">⬅ Back</a> |
<a href="../Controller/logout.php">Logout</a>

<hr>

<h3>Add New Product</h3>

<form action="../Controller/addProduct.php" method="POST" enctype="multipart/form-data">

<label>Product Name</label>
<input type="text" name="name" required>

<label>Description</label>
<textarea name="description"></textarea>

<label>Price</label>
<input type="number" step="0.01" name="price" required>

<label>Category</label>
<select name="category_id">
<option value="">Select Category</option>
<?php foreach($categories as $c): ?>
<option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['name']) ?></option>
<?php endforeach; ?>
</select>

<label>Image</label>
<input type="file" name="image" accept="image/*">

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
<th>Action</th>
</tr>

<?php foreach($products as $p): ?>
<tr>
<td><?= $p['id'] ?></td>
<td>
  <?php if($p['image']): ?>
  <img src="../uploads/<?= $p['image'] ?>">
  <?php endif; ?>
</td>
<td><?= htmlspecialchars($p['name']) ?></td>
<td><?= htmlspecialchars($p['category']) ?></td>
<td><?= $p['price'] ?></td>

<td>

<!-- UPDATE -->
<form action="../Controller/updateProduct.php" method="POST" enctype="multipart/form-data" style="display:block;margin-bottom:6px;">
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

<!-- DELETE -->
<form action="../Controller/deleteProduct.php" method="POST"
style="display:inline;" onsubmit="return confirm('Delete product?');">
  <input type="hidden" name="id" value="<?= $p['id'] ?>">
  <button type="submit">Delete</button>
</form>

</td>
</tr>
<?php endforeach; ?>

</table>

</body>
</html>
