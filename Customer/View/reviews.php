<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] !== "Customer"){
    die("Unauthorized");
}

require_once("../../Common/DatabaseConnection.php");

$cid = $_SESSION['user_id'];

// reviews
$sql = "
SELECT r.*, p.name 
FROM reviews r
JOIN products p ON r.product_id = p.id
WHERE r.customer_id = ?
ORDER BY r.id DESC
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $cid); 
$stmt->execute();

$result = $stmt->get_result();

$reviews = [];
while ($row = $result->fetch_assoc()) {
    $reviews[] = $row;
}



?>

<!DOCTYPE html>
<html>
<head>
<title>My Reviews</title>

<style>
table{border-collapse:collapse}
td,th{padding:8px;border:1px solid #ccc}
</style>
</head>
<body>

<h2>My Reviews</h2>

<a href="customerDashboard.php">Back</a> |
<a href="../Controller/logout.php">Logout</a>

<hr>

<?php if(empty($reviews)): ?>

<p>You haven’t submitted any reviews yet.</p>

<?php else: ?>

<table>
<tr>
 <th>Product</th>
 <th>Rating</th>
 <th>Comment</th>
 <th>Action</th>
</tr>

<?php foreach($reviews as $r): ?>
<tr>
<td><?= htmlspecialchars($r['name']) ?></td>
<td><?= $r['rating'] ?>/5</td>
<td><?= htmlspecialchars($r['comment']) ?></td>
<td>

<a href="product.php?id=<?= $r['product_id'] ?>">Edit</a>

</td>
</tr>
<?php endforeach; ?>

</table>

<?php endif; ?>

</body>
</html>
