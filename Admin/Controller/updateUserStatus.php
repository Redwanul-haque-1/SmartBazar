<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] !== "Admin"){
    die("Unauthorized");
}

require_once("../../Common/DatabaseConnection.php");

$id = $_POST['id'];
$status = $_POST['status'];

$allowed = ["Pending","Approved","Blocked"];
if(!in_array($status,$allowed)){
    die("Invalid status value");
}

$sql = "UPDATE users SET status=? WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->execute([$status,$id]);

header("Location: ../View/manageUsers.php");
exit;
?>
