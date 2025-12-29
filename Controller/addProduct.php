<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] !== "Seller"){
    die("Unauthorized");
}

require_once("../Model/DatabaseConnection.php");

$seller_id = $_SESSION['user_id'];

$name = trim($_POST['name']);
$description = trim($_POST['description']);
$price = $_POST['price'];
$category_id = $_POST['category_id'] ?: null;

if($name === "" || $price === ""){
    die("Name & Price required");
}

// image upload
$image = null;
if(!empty($_FILES['image']['name'])){
    $file = $_FILES['image'];
    if($file['size'] > 2000000) die("Image too large");

    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $image = time()."_".rand(100,999).".".$ext;

    move_uploaded_file($file['tmp_name'], "../uploads/".$image);
}

$sql = "INSERT INTO products (seller_id,category_id,name,description,price,image)
        VALUES (?,?,?,?,?,?)";
$stmt = $conn->prepare($sql);
$stmt->execute([$seller_id,$category_id,$name,$description,$price,$image]);

header("Location: ../Seller/products.php");
exit;
?>
