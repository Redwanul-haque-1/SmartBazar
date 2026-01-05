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
    die("Password must be at least 8 characters.<br><a href='changePassword.php'>⬅Back</a>");
}


$sql = "SELECT password_hash FROM users WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->execute([$id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

//if(!password_verify($old, $user['password_hash']))
if($old !== $user['password_hash'])
{
    die("Old password incorrect.<br><a href='changePassword.php'>⬅Back</a>");
}

//$newHash = password_hash($new, PASSWORD_DEFAULT);
$newHash = $new;

$up = $conn->prepare("UPDATE users SET password_hash=? WHERE id=?");
$up->execute([$newHash,$id]);

echo "Password updated successfully. <a href='profile.php'>⬅Back</a>";
?>
