<?php
session_start();
if(!isset($_SESSION['user_id'])){
    die("Unauthorized");
}

require_once("../Model/DatabaseConnection.php");

$id = $_SESSION['user_id'];

$name = $_POST['name'];
$phone = $_POST['phone'];
$address = $_POST['address'];
$gender = $_POST['gender'];
$dob = $_POST['dob'];

$image = null;

// old image first
$stmt = $conn->prepare("SELECT profile_image FROM users WHERE id=?");
$stmt->execute([$id]);
$old = $stmt->fetch(PDO::FETCH_ASSOC);
$image = $old['profile_image'];

// new upload?
if(!empty($_FILES['profile_image']['name'])){
    $file = $_FILES['profile_image'];
    if($file['size'] > 2000000) die("Image too large");

    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $image = time()."_".rand(100,999).".".$ext;

    move_uploaded_file($file['tmp_name'], "../uploads/".$image);
}

$sql = "UPDATE users SET 
name=?, phone=?, address=?, gender=?, dob=?, profile_image=?
WHERE id=?";

$stmt = $conn->prepare($sql);
$stmt->execute([$name,$phone,$address,$gender,$dob,$image,$id]);

header("Location: profile.php");
exit;
?>
