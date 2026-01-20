<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] !== "Customer"){
    die("Unauthorized");
}

require_once("../../Common/DatabaseConnection.php");

$id = $_POST['id'];
$rating = max(1,min(5,$_POST['rating']));
$comment = trim($_POST['comment']);
$cid = $_SESSION['user_id'];

$sql = "UPDATE reviews SET rating=?, comment=? 
        WHERE id=? AND customer_id=?";
$stmt = $conn->prepare($sql);
$stmt->execute([$rating,$comment,$id,$cid]);

header("Location: ../View/shop.php");
exit;
?>
