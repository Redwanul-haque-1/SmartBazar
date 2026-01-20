<?php
session_start();

if(!isset($_SESSION['role']) || $_SESSION['role']!=="Admin"){
    die("Unauthorized");
}

require_once("../../Common/DatabaseConnection.php");

$id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT name FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();
$user = $result->fetch_assoc();

$sql = "SELECT * FROM users ORDER BY id ASC";
$result = $conn->query($sql);

$users = [];
while ($row = $result->fetch_assoc()) {
    $users[] = $row;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Dashboard</title>
<link rel="stylesheet" href="../public/css/styleAdminDash.css">


</head>

<body>

<div class = "adminDash">

<h2>Welcome Admin, <?= htmlspecialchars($user['name']) ?></h2>

<ul>
<li><a href="manageUsers.php">Manage Users</a></li>
<li><a href="manageCategories.php">Manage Categories</a></li>
<li><a href="viewOrders.php">View All Orders</a></li>
<li><a href="profile.php">Profile</a></li>
</ul>


<a href="../Controller/logout.php">Logout</a>



<h2>User Management</h2>

<table>
<tr>
  <th>ID</th>
  <th>Name</th>
  <th>Email</th>
  <th>Role</th>
  <th>Status</th>
  <th>Action</th>
</tr>

<?php foreach($users as $u): ?>
<tr>

<td><?= $u['id'] ?></td>
<td><?= htmlspecialchars($u['name']) ?></td>
<td><?= htmlspecialchars($u['email']) ?></td>
<td><?= $u['role'] ?></td>

<td>
<span class="badge <?= strtolower($u['status']) ?>">
<?= $u['status'] ?>
</span>
</td>

<td>

<?php if($u['status'] !== "Approved"): ?>
<form action="../Controller/updateUserStatus.php" method="POST" style="display:inline;">
<input type="hidden" name="id" value="<?= $u['id'] ?>">
<input type="hidden" name="status" value="Approved" >
<button type="submit" style="font-size: 20px;" >Approve</button>
</form>
<?php endif; ?>

<?php if($u['status'] !== "Blocked"): ?>
<form action="../Controller/updateUserStatus.php" method="POST" style="display:inline;">
<input type="hidden" name="id" value="<?= $u['id'] ?>">
<input type="hidden" name="status" value="Blocked">
<button type="submit" style="font-size: 20px;">Block</button>
</form>
<?php endif; ?>

<?php if($u['status'] !== "Pending"): ?>
<form action="../Controller/updateUserStatus.php" method="POST" style="display:inline;">
<input type="hidden" name="id" value="<?= $u['id'] ?>">
<input type="hidden" name="status" value="Pending">
<button type="submit" style="font-size: 20px;" >Set Pending</button>
</form>
<?php endif; ?>

<form action="../Controller/deleteUser.php" method="POST" style="display:inline;"
onsubmit="return confirm('Delete this user?');">
<input type="hidden" name="id" value="<?= $u['id'] ?>">
<button type="submit" style="font-size: 20px;" >Delete</button>
</form>

</td>
</tr>
<?php endforeach; ?>

</table>
</div>
</body>
</html>
