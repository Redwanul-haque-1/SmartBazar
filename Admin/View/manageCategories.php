<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] !== "Admin"){
    die("Unauthorized");
}

require_once("../../Common/DatabaseConnection.php");

// Fetch categories
$sql = "SELECT * FROM categories ORDER BY id DESC";
$stmt = $conn->query($sql);
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
<title>Manage Categories</title>
<link rel="stylesheet" href="../public/css/style.css">
<style>
table{border-collapse:collapse}
td,th{padding:8px;border:1px solid #ccc}
</style>
</head>
<body>

<h2>Category Management</h2>

<a href="adminDashboard.php">⬅ Back</a> |
<a href="../Controller/logout.php">Logout</a>

<hr>

<h3>Add New Category</h3>

<form action="../Controller/addCategory.php" method="POST">
  <label>Category Name</label>
  <input type="text" name="name" required>
  <button type="submit">Add</button>
</form>

<hr>

<h3>Existing Categories</h3>

<table>
<tr>
  <th>ID</th>
  <th>Name</th>
  <th>Action</th>
</tr>

<?php foreach($categories as $c): ?>
<tr>
<td><?= $c['id'] ?></td>
<td><?= htmlspecialchars($c['name']) ?></td>
<td>

<form action="../Controller/updateCategory.php" method="POST" style="display:inline;">
  <input type="hidden" name="id" value="<?= $c['id'] ?>">
  <input type="text" name="name" value="<?= htmlspecialchars($c['name']) ?>" required>
  <button type="submit">Update</button>
</form>

<form action="../Controller/deleteCategory.php" method="POST" style="display:inline;"
onsubmit="return confirm('Delete this category?');">
  <input type="hidden" name="id" value="<?= $c['id'] ?>">
  <button type="submit">Delete</button>
</form>

</td>
</tr>
<?php endforeach; ?>

</table>

</body>
</html>
