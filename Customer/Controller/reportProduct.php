<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] !== "Customer"){
    die("Unauthorized");
}

require_once("../../Common/DatabaseConnection.php");

$by = $_SESSION['user_id'];
$pid = $_POST['product_id'];
$reason = trim($_POST['reason']);

$sql = "INSERT INTO reports(reported_by,product_id,reason)
        VALUES(?,?,?)";
$stmt = $conn->prepare($sql);
$stmt->execute([$by,$pid,$reason]);

echo "Product reported successfully. <a href='../View/shop.php'>Back</a>";
?>
