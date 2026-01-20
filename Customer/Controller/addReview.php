<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] !== "Customer"){
    die("Unauthorized");
}

require_once("../../Common/DatabaseConnection.php");

$cid = $_SESSION['user_id'];
$pid = $_POST['product_id'];
$rating = max(1,min(5,$_POST['rating']));
$comment = trim($_POST['comment']);

$sql = "INSERT INTO reviews(product_id,customer_id,rating,comment)
        VALUES(?,?,?,?)";
$stmt = $conn->prepare($sql);
$stmt->execute([$pid,$cid,$rating,$comment]);

header("Location: ../View/product.php?id=".$pid);
exit;
?>
