<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== "Admin") {
    die("Unauthorized");
}

require_once("../../Common/DatabaseConnection.php");

$message = "";

if (isset($_POST['delete_review'])) {
    $review_id = intval($_POST['review_id']);

    $stmt = $conn->prepare("DELETE FROM reviews WHERE id = ?");
    $stmt->bind_param("i", $review_id);
    $stmt->execute();

    $message = " Review deleted successfully.";
}

if (isset($_POST['delete_report'])) {
    $report_id = intval($_POST['report_id']);

    $stmt = $conn->prepare("DELETE FROM reports WHERE id = ?");
    $stmt->bind_param("i", $report_id);
    $stmt->execute();

    $message = " Report deleted successfully.";
}

$users = [];
$userSql = "SELECT id, name, email, role, status FROM users ORDER BY role, status";
$res = $conn->query($userSql);
while ($row = $res->fetch_assoc()) {
    $users[] = $row;
}

$reviews = [];
$reviewSql = "
SELECT 
    r.id,
    r.rating,
    r.comment,
    r.created_at,
    u.name AS customer,
    p.name AS product
FROM reviews r
JOIN users u ON r.customer_id = u.id
JOIN products p ON r.product_id = p.id
ORDER BY r.id DESC
";
$res = $conn->query($reviewSql);
while ($row = $res->fetch_assoc()) {
    $reviews[] = $row;
}

$reports = [];
$reportSql = "
SELECT 
    r.id,
    r.reason,
    r.created_at,
    rb.name AS reported_by,
    p.name AS product,
    s.name AS seller
FROM reports r
LEFT JOIN users rb ON r.reported_by = rb.id
LEFT JOIN products p ON r.product_id = p.id
LEFT JOIN users s ON r.seller_id = s.id
ORDER BY r.id DESC
";
$res = $conn->query($reportSql);
while ($row = $res->fetch_assoc()) {
    $reports[] = $row;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin – Manage Users</title>
<link rel="stylesheet" href="../public/css/styleManageUser.css">

</head>
<body>

<h2>Admin Control Panel </h2>
<h3>
<a href="adminDashboard.php">Back</a> |
<a href="../Controller/logout.php">Logout</a>
</h3>
<?php if ($message): ?>
<div class="notice"><?= $message ?></div>
<?php endif; ?>

<div class="section">
<h3>User Management</h3>

<table>
<tr>
<th>ID</th>
<th>Name</th>
<th>Email</th>
<th>Role</th>
<th>Status</th>
<th>Action</th>
</tr>

<?php foreach ($users as $u): ?>
<tr>
<td><?= $u['id'] ?></td>
<td><?= htmlspecialchars($u['name']) ?></td>
<td><?= htmlspecialchars($u['email']) ?></td>
<td><?= $u['role'] ?></td>
<td><?= $u['status'] ?></td>
<td>

<?php if ($u['status'] !== "Approved"): ?>
<form action="../Controller/updateUserStatus.php" method="POST" style="display:inline">
<input type="hidden" name="id" value="<?= $u['id'] ?>">
<input type="hidden" name="status" value="Approved">
<button>Approve</button>
</form>
<?php endif; ?>

<?php if ($u['status'] !== "Blocked"): ?>
<form action="../Controller/updateUserStatus.php" method="POST" style="display:inline">
<input type="hidden" name="id" value="<?= $u['id'] ?>">
<input type="hidden" name="status" value="Blocked">
<button>Block</button>
</form>
<?php endif; ?>

</td>
</tr>
<?php endforeach; ?>
</table>
</div>

<div class="section">
<h3>All Reviews</h3>

<?php if (empty($reviews)): ?>
<p>No reviews found.</p>
<?php endif; ?>

<?php foreach ($reviews as $r): ?>
<div class="box">
<b>Customer:</b> <?= htmlspecialchars($r['customer']) ?><br>
<b>Product:</b> <?= htmlspecialchars($r['product']) ?><br>
⭐ <?= $r['rating'] ?>/5
<p><?= htmlspecialchars($r['comment']) ?></p>
<small><?= $r['created_at'] ?></small>

<form method="POST" onsubmit="return confirm('Delete this review?');">
<input type="hidden" name="review_id" value="<?= $r['id'] ?>">
<button name="delete_review">Delete Review</button>
</form>
</div>
<?php endforeach; ?>
</div>

<!-- REPORTS -->
<div class="section">
<h3>Reports</h3>

<?php if (empty($reports)): ?>
<p>No reports found.</p>
<?php endif; ?>

<?php foreach ($reports as $rp): ?>
<div class="box">
<b>Reported By:</b> <?= htmlspecialchars($rp['reported_by']) ?><br>

<?php if ($rp['product']): ?>
<b>Product:</b> <?= htmlspecialchars($rp['product']) ?><br>
<?php endif; ?>

<?php if ($rp['seller']): ?>
<b>Seller:</b> <?= htmlspecialchars($rp['seller']) ?><br>
<?php endif; ?>

<p><?= htmlspecialchars($rp['reason']) ?></p>

<form method="POST" onsubmit="return confirm('Delete this report?');">
<input type="hidden" name="report_id" value="<?= $rp['id'] ?>">
<button name="delete_report">Delete Report</button>
</form>
</div>
<?php endforeach; ?>
</div>

</body>
</html>
