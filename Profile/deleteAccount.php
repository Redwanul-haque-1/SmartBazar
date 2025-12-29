<?php
session_start();
if(!isset($_SESSION['user_id'])){
    die("Unauthorized");
}

require_once("../Model/DatabaseConnection.php");

$id = $_SESSION['user_id'];

// Delete user account
$sql = "DELETE FROM users WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->execute([$id]);

// destroy session
session_unset();
session_destroy();

// redirect to login page
header("Location: ../Auth/login.php");
exit;
?>
