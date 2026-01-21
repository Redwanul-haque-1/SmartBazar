<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] !== "Seller"){
    die("Unauthorized");
}

require_once("../../Common/DatabaseConnection.php");

$seller_id = $_SESSION['user_id'];
$id = $_POST['id'];

// only delete own product
$sql = "DELETE FROM products WHERE id=? AND seller_id=?";
$stmt = $conn->prepare($sql);
$stmt->execute([$id,$seller_id]);

header("Location: ../View/products.php");
exit;
?>
