<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] !== "Admin"){
    die("Unauthorized");
}

require_once("../../Common/DatabaseConnection.php");

/*(MySQLi) */
$sql = "SELECT * FROM categories ORDER BY id DESC";
$result = $conn->query($sql);

$categories = [];
while ($row = $result->fetch_assoc()) {
    $categories[] = $row;
}





?>

<!DOCTYPE html>
<html>
<head>
<title>Manage Categories</title>
<link rel="stylesheet" href="../public/css/styleManageUser.css">

</head>
<body>

<h2>Category Management</h2>

<h3>
<a href="adminDashboard.php"> Back</a> |
<a href="../Controller/logout.php">Logout</a>
</h3>


<h3>Add New Category</h3>
<br>
<form action="../Controller/addCategory.php" method="POST">
  <label style = "font-size: 20px;">Category Name:  </label>
  <input type="text" name="name" style = "font-size: 20px;" required>
  <button type="submit">Add</button>
</form>
<br>
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
  <input type="text" name="name" style = "font-size: 20px;" value="<?= htmlspecialchars($c['name']) ?>" required>
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
