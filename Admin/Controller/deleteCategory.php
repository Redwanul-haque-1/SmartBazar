<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] !== "Admin"){
    die("Unauthorized");
}

require_once("../../Common/DatabaseConnection.php");

$id = $_POST['id'];

$sql = "DELETE FROM categories WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->execute([$id]);

header("Location: ../View/manageCategories.php");
exit;
?>
