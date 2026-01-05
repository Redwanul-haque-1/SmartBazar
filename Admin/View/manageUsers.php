<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] !== "Admin"){
    die("Unauthorized");
}

require_once("../../Common/DatabaseConnection.php");

// Fetch users
$sql = "SELECT id,name,email,role,status FROM users ORDER BY role, status";
$stmt = $conn->query($sql);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
<title>Manage Users</title>
<link rel="stylesheet" href="../public/css/style.css">
<style>
table {border-collapse: collapse;}
td,th{padding:8px;border:1px solid #ccc;}
/* .badge{padding:3px 8px;border-radius:6px}
.pending{background:#ffdd57}
.approved{background:#9ae6b4}
.blocked{background:#feb2b2} */
</style>
</head>
<body>

<h2>User Management</h2>
<a href="adminDashboard.php">⬅ Back</a> |
<a href="../Controller/logout.php">Logout</a>

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
  <span class="badge 
    <?= strtolower($u['status']) ?>">
    <?= $u['status'] ?>
  </span>
</td>

<td>

<?php if($u['status'] !== "Approved"): ?>
  <form action="../Controller/updateUserStatus.php" method="POST" style="display:inline;">
     <input type="hidden" name="id" value="<?= $u['id'] ?>">
     <input type="hidden" name="status" value="Approved">
     <button type="submit">Approve</button>
  </form>
<?php endif; ?>

<?php if($u['status'] !== "Blocked"): ?>
  <form action="../Controller/updateUserStatus.php" method="POST" style="display:inline;">
     <input type="hidden" name="id" value="<?= $u['id'] ?>">
     <input type="hidden" name="status" value="Blocked">
     <button type="submit">Block</button>
  </form>
<?php endif; ?>

<?php if($u['status'] !== "Pending"): ?>
  <form action="../Controller/updateUserStatus.php" method="POST" style="display:inline;">
     <input type="hidden" name="id" value="<?= $u['id'] ?>">
     <input type="hidden" name="status" value="Pending">
     <button type="submit">Set Pending</button>
  </form>
<?php endif; ?>

<form action="../Controller/deleteUser.php" method="POST" style="display:inline;"
onsubmit="return confirm('Delete this user?');">
  <input type="hidden" name="id" value="<?= $u['id'] ?>">
  <button type="submit">Delete</button>
</form>

</td>
</tr>
<?php endforeach; ?>

</table>

</body>
</html>
