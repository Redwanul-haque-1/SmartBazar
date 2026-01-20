<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] !== "Admin"){
    die("Unauthorized");
}

require_once("../../Common/DatabaseConnection.php");

$name = trim($_POST['name']);

if($name === ""){
    die("Category name required");
}

$sql = "INSERT INTO categories(name) VALUES(?)";
$stmt = $conn->prepare($sql);
$stmt->execute([$name]);

header("Location: ../View/manageCategories.php");
exit;
?>
