<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] !== "Customer"){
    die("Unauthorized");
}

require_once("../../Common/DatabaseConnection.php");

$id = $_POST['id'];
$cid = $_SESSION['user_id'];

$sql = "DELETE FROM reviews WHERE id=? AND customer_id=?";
$stmt = $conn->prepare($sql);
$stmt->execute([$id,$cid]);

header("Location: ../View/shop.php");
exit;
?>
