<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] !== "Admin"){
    die("Unauthorized");
}

require_once("../Model/DatabaseConnection.php");

$id = $_POST['id'];

$sql = "DELETE FROM users WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->execute([$id]);

header("Location: ../Admin/manageUsers.php");
exit;
?>
