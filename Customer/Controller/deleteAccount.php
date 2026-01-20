<?php
session_start();
if(!isset($_SESSION['user_id'])){
    die("Unauthorized");
}

require_once("../../Common/DatabaseConnection.php");

$id = $_SESSION['user_id'];

$sql = "DELETE FROM users WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->execute([$id]);

session_unset();
session_destroy();

header("Location: ../../Common/login.php");
exit;
?>
