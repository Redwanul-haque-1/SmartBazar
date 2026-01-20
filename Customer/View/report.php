<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] !== "Customer"){
    die("Unauthorized");
}

require_once("../../Common/DatabaseConnection.php");

$cid = $_SESSION['user_id'];

// getting reports
$sql = "
SELECT r.*, p.name AS product, u.name AS seller
FROM reports r
LEFT JOIN products p ON r.product_id = p.id
LEFT JOIN users u ON r.seller_id = u.id
WHERE r.reported_by = ?
ORDER BY r.id DESC
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $cid);  
$stmt->execute();

$result = $stmt->get_result();

$reports = [];
while ($row = $result->fetch_assoc()) {
    $reports[] = $row;
}



?>

<!DOCTYPE html>
<html>
<head>
<title>My Reports</title>
<link rel="stylesheet" href="../css/style.css">
<style>
table{border-collapse:collapse}
td,th{padding:8px;border:1px solid #ccc}
</style>
</head>
<body>

<h2>Reports I Have Submitted</h2>

<a href="customerDashboard.php">Back</a> |
<a href="../Controller/logout.php">Logout</a>

<hr>

<p><b>Note:</b> You can report a product or seller from the product details page.</p>

<?php if(empty($reports)): ?>

<p>You haven't reported anything yet.</p>

<?php else: ?>

<table>
<tr>
 <th>Product</th>
 <th>Seller</th>
 <th>Reason</th>
 <th>Date</th>
</tr>

<?php foreach($reports as $r): ?>
<tr>
<td><?= htmlspecialchars($r['product'] ?? '-') ?></td>
<td><?= htmlspecialchars($r['seller'] ?? '-') ?></td>
<td><?= htmlspecialchars($r['reason']) ?></td>
<td><?= $r['created_at'] ?></td>
</tr>
<?php endforeach; ?>

</table>

<?php endif; ?>

</body>
</html>
