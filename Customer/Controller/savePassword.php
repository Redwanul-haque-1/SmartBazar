<?php
session_start();
if(!isset($_SESSION['user_id'])){
    die("Unauthorized");
}

require_once("../../Common/DatabaseConnection.php");

$id = $_SESSION['user_id'];

$old = $_POST['old'];
$new = $_POST['new'];

if(strlen($new) < 8){
    die("Password must be at least 8 characters.<br><a href='../View/changePassword.php'>Back</a>");
}


$sql = "SELECT password_pass FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);  
$stmt->execute();

$result = $stmt->get_result();
$user = $result->fetch_assoc();

/* CHECK OLD PASSWORD */
if ($old !== $user['password_pass']){
        die("Old password incorrect.<br><a href='../View/changePassword.php'>Back</a>");
}

$newPass = $new;

$up = $conn->prepare("UPDATE users SET password_pass = ? WHERE id = ?");
$up->bind_param("si", $newPass, $id);
$up->execute();




echo "Password updated successfully. <a href='../View/profile.php'>Back</a>";
?>
