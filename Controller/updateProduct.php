<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] !== "Seller"){
    die("Unauthorized");
}

require_once("../Model/DatabaseConnection.php");

$seller_id = $_SESSION['user_id'];

$id = $_POST['id'];
$name = trim($_POST['name']);
$price = $_POST['price'];
$category_id = $_POST['category_id'];

if($name === "" || $price === ""){
    die("Name & Price required");
}

// verify ownership
$check = $conn->prepare("SELECT image FROM products WHERE id=? AND seller_id=?");
$check->execute([$id,$seller_id]);
$product = $check->fetch(PDO::FETCH_ASSOC);

if(!$product) die("Unauthorized product update");

$image = $product['image'];

// new upload?
if(!empty($_FILES['image']['name'])){
    $file = $_FILES['image'];
    if($file['size'] > 2000000) die("Image too large");

    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $image = time()."_".rand(100,999).".".$ext;

    move_uploaded_file($file['tmp_name'], "../uploads/".$image);
}

$sql = "UPDATE products 
        SET name=?, price=?, category_id=?, image=? 
        WHERE id=? AND seller_id=?";
$stmt = $conn->prepare($sql);
$stmt->execute([$name,$price,$category_id,$image,$id,$seller_id]);

header("Location: ../Seller/products.php");
exit;
?>
