<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    die("Unauthorized");
}

require_once("../../Common/DatabaseConnection.php");

$id = $_SESSION['user_id'];

$name    = $_POST['name'];
$email = $_POST['email'];
$phone   = $_POST['phone'];
$address = $_POST['address'];
$gender  = $_POST['gender'];
$dob     = $_POST['dob'];

$image = null;

$stmt = $conn->prepare("SELECT profile_image FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();
$old = $result->fetch_assoc();
$image = $old['profile_image'];

if (!empty($_FILES['profile_image']['name'])) {
    $file = $_FILES['profile_image'];

    if ($file['size'] > 2000000) {
        die("Image too large");
    }

    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $image = time() . "_" . rand(100,999) . "." . $ext;

    move_uploaded_file($file['tmp_name'], "../public/uploads/" . $image);
}

// check duplicate email (excluding current user)
$check = $conn->prepare(
  "SELECT id FROM users WHERE email = ? AND id != ?"
);
$check->bind_param("si", $email, $id);
$check->execute();

$res = $check->get_result();
if ($res->num_rows > 0) {
    die("Email already exists. <a href='../View/editProfile.php'> Back</a>");
}



$sql = "UPDATE users SET 
name=?, email=?, phone=?, address=?, gender=?, dob=?, profile_image=?
WHERE id=?";

$stmt = $conn->prepare($sql);
$stmt->bind_param(
    "sssssssi",
    $name,
    $email,
    $phone,
    $address,
    $gender,
    $dob,
    $image,
    $id
);


$stmt->execute();

header("Location: ../View/profile.php");
exit;
?>

