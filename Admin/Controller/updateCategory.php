<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] !== "Admin"){
    die("Unauthorized");
}

require_once("../../Common/DatabaseConnection.php");

$id = $_POST['id'];
$name = trim($_POST['name']);

if($name === ""){
    die("Category name required");
}

$sql = "UPDATE categories SET name=? WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->execute([$name, $id]);

header("Location: ../View/manageCategories.php");
exit;
?>
